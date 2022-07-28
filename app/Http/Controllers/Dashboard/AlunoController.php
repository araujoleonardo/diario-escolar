<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use App\Models\EscolaPeriodo;
use App\Http\Controllers\Controller;
use \PDF;

class AlunoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(
            ['auth', 'can:sec_academica_e_professor'],
            ['except' => [
                'visualizarFaltas',
                'exportarRelatorioFaltasAluno'
            ]]
        );
        $this->middleware(['auth', 'completar.perfil']);
    }

    /**
     * Lista de todos os alunos
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function index(Request $request)
    {

        // Dados dos alunos
        $alunos = Aluno::orderBy('created_at', 'desc');

        // Buscar aluno
        if ($request->nome) {
            $alunos->whereHas('user', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->nome . '%');
            });
        }
        $alunos = $alunos->paginate(10);
        return view('dashboard.pages.alunos.alunos', compact('alunos'));
    }

    /**
     * Formulário para cadastrar aluno
     *
     * @return void
     */
    public function cadastrar()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.alunos.cadastrar_aluno', compact('turmas'));
    }

    /**
     * Armazenar dados do cadastro no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function cadastrarStore(Request $request)
    {

        // Validações
        $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'turma' => ['required', 'exists:turmas,id'],
            'telefone' => ['required', 'celular_com_ddd'],
            'dt_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'in:masculino,feminino'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], [
            'dt_nascimento' => 'data de nascimento'
        ]);

        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_profile' => 'aluno'
        ]);

        $aluno = Aluno::create([
            'user_id' => $user->id,
            'telefone' => $request->telefone,
            'turma_id' => $request->turma,
            'sexo' => $request->sexo,
            'dt_nascimento' => $request->dt_nascimento,
        ]);

        return redirect()->back()->with('session_sucesso', 'O cadastro do aluno foi realizado.');
    }

    /**
     * Visualizar dados do aluno
     *
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function visualizar(Aluno $aluno)
    {
        return view('dashboard.pages.alunos.visualizar_aluno', compact('aluno'));
    }


    /**
     * Formulário para editar dados do aluno
     *
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function editar(Aluno $aluno)
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.alunos.editar_aluno', compact('aluno', 'turmas'));
    }


    /**
     * Atualizar os dados do aluno no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function atualizar(Request $request, Aluno $aluno)
    {
        $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'turma_id' => ['required', 'exists:turmas,id'],
            'telefone' => ['required', 'celular_com_ddd'],
            'dt_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'in:masculino,feminino'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $aluno->user->id],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], [
            'dt_nascimento' => 'data de nascimento',
            'turma_id'
        ]);

        $aluno->fill($request->all());
        $aluno->user->email = $request->email;
        $aluno->user->name = $request->nome;
        $aluno->user->save();
        $aluno->save();

        return redirect()->back()->with('session_sucesso', 'Os dados do aluno foi editado.');
    }

    /**
     * modificarSenha
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function modificarSenha(Request $request, Aluno $aluno)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $aluno->user->password = bcrypt($request->password);
        $aluno->user->save();

        return redirect()->back()->with('session_sucesso', 'A senha do aluno foi modificada.');
    }

    /**
     * Visualizar faltas do aluno
     *
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function visualizarFaltas(Aluno $aluno)
    {
        // Impedir que alunos visualize faltas de outros alunos
        if (auth()->user()->user_profile == 'aluno')
            if ($aluno->id != auth()->user()->aluno->id)
                abort(403);

        $periodos = EscolaPeriodo::orderby('data_inicio', 'asc')->get();
        return view('dashboard.pages.alunos.faltas_aluno', compact('periodos', 'aluno'));
    }

    /**
     * Exportar faltas do aluno em arquivo PDF
     *
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function exportarRelatorioFaltasAluno(Aluno $aluno)
    {
        // Impedir que alunos visualize faltas de outros alunos
        if (auth()->user()->user_profile == 'aluno')
            if ($aluno->id != auth()->user()->aluno->id)
                abort(403);

        $periodos = EscolaPeriodo::orderby('data_inicio', 'asc')->get();
        $pdf = PDF::loadView('dashboard.pages.alunos.faltas_aluno_pdf', compact('aluno', 'periodos'));
        return $pdf->download('Registro de Faltas - ' . $aluno->user->name . '.pdf');
        // return $aluno;
    }

    /**
     * Confirmar a remoção do registro do aluno
     *
     * @param  mixed $aluno
     * @return void
     */
    public function confirmarDeletar(Aluno $aluno)
    {
        return view('dashboard.pages.alunos.deletar_aluno', compact('aluno'));
    }

    /**
     * Deletar usuário aluno do bando de dados
     *
     * @param  \App\Models\Aluno $aluno
     * @return void
     */
    public function deletar(Aluno $aluno)
    {
        $aluno->user->delete();
        return redirect()->route('alunos.index')->with('session_sucesso', 'O registro do aluno foi deletado.');
    }
}
