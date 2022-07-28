<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use App\Models\Turma;
use App\Models\Professor;
use App\Models\Disciplina;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AlocacaoProfessorTurma;
use App\Models\AlocacaoProfessorDisciplina;

class ProfessorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:sec_academica']);
    }

    /**
     * Listar professores
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $professores = Professor::orderBy('created_at', 'desc');

        // Buscar professor
        if ($request->q) {
            $professores->whereHas('user', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . $request->q . '%');
            });
        }
        $professores = $professores->paginate(10);

        // $professores = Professor::orderBy('created_at', 'desc')->paginate(2);
        return view('dashboard.pages.professores.professores', compact('professores'));
    }

    /**
     * Formulário para cadastro de professor
     *
     * @return void
     */
    public function cadastrar()
    {
        $disciplinas = Disciplina::orderBy('nome', 'asc')->get();
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.professores.cadastrar_professor', compact('disciplinas', 'turmas'));
    }

    /**
     * Armazenar dados do cadastro do professor no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function cadastrarStore(Request $request)
    {

        $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'telefone' => ['required', 'celular_com_ddd'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_profile' => 'professor'
        ]);

        $professor = Professor::create([
            'telefone' => $request->telefone,
            'user_id' => $user->id,
        ]);

        // alocar professor para disciplinas
        if ($request->disciplinas)
            foreach ($request->disciplinas as $disciplina_id) {
                AlocacaoProfessorDisciplina::create([
                    'professor_id' => $professor->id,
                    'disciplina_id' => $disciplina_id,
                ]);
            }

        // alocar professor para turmas
        if ($request->turmas)
            foreach ($request->turmas as $turma_id) {
                AlocacaoProfessorTurma::create([
                    'professor_id' => $professor->id,
                    'turma_id' => $turma_id,
                ]);
            }

        return redirect()->back()->with('session_sucesso', 'O cadastro do professor foi realizado.');
    }

    /**
     * Formulário para editar dados do professor
     *
     * @param  \App\Models\Professor $professor
     * @return void
     */
    public function editar(Professor $professor)
    {
        $disciplinas = Disciplina::orderBy('nome', 'asc')->get();
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.professores.editar_professor', compact('professor', 'disciplinas', 'turmas'));
    }

    /**
     * Atualizar os dados do prorfessor no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Professor $professor
     * @return void
     */
    public function atualizar(Request $request, Professor $professor)
    {
        $request->validate([
            'nome' => ['required', 'string', 'min:3', 'max:255'],
            'telefone' => ['required', 'celular_com_ddd'],

            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $professor->user->id],
        ]);

        $professor->user->name = $request->nome;
        $professor->user->email = $request->email;
        $professor->user->save();

        $professor->telefone = $request->telefone;
        $professor->save();

        // alocar professor para disciplinas
        foreach ($professor->disciplinas as $disciplina) {
            $disciplina->delete();
        }
        if ($request->disciplinas) {
            foreach ($request->disciplinas as $disciplina_id) {
                AlocacaoProfessorDisciplina::create([
                    'professor_id' => $professor->id,
                    'disciplina_id' => $disciplina_id,
                ]);
            }
        }

        // Alocar professor para turmas
        foreach ($professor->turmas as $turma) {
            $turma->delete();
        }
        if ($request->turmas) {
            foreach ($request->turmas as $turma_id) {
                AlocacaoProfessorTurma::create([
                    'professor_id' => $professor->id,
                    'turma_id' => $turma_id,
                ]);
            }
        }

        return redirect()->back()->with('session_sucesso', 'O dados do professor foram editados.');
    }

    /**
     * Modificar Senha
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Professor $professor
     * @return void
     */
    public function modificarSenha(Request $request, Professor $professor)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $professor->user->password = bcrypt($request->password);
        $professor->user->save();

        return redirect()->back()->with('session_sucesso', 'A senha do professor foi modificada.');
    }

    /**
     * Confirmar a remoção do registro do professor
     *
     * @param  mixed $professor
     * @return void
     */
    public function confirmarDeletar(Professor $professor)
    {
        return view('dashboard.pages.professores.deletar_professor', compact('professor'));
    }

    /**
     * Deletar usuário professor do bando de dados
     *
     * @param  \App\Models\Professor $professor
     * @return void
     */
    public function deletar(Professor $professor)
    {
        $professor->user->delete();
        return redirect()->route('professores.index')->with('session_sucesso', 'A registro do professor foi deletado.');
    }
}
