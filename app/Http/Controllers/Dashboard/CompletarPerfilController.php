<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Aluno;
use App\Models\Turma;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Controller para o usuário aluno completar o perfil com os dados que faltam após o registro
 */
class CompletarPerfilController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Formulário para completar perfil
     *
     * @return void
     */
    public function completarPefil()
    {
        $this->seTemDados();

        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.alunos.completar_perfil', compact('turmas'));
    }

    /**
     * Salvar dados no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function salvarDados(Request $request)
    {
        $this->seTemDados();

        // Validações
        $request->validate([
            'turma' => ['required', 'exists:turmas,id'],
            'telefone' => ['required', 'celular_com_ddd'],
            'dt_nascimento' => ['required', 'date'],
            'sexo' => ['required', 'in:masculino,feminino'],
        ], [], [
            'dt_nascimento' => 'data de nascimento'
        ]);

        $aluno = Aluno::create([
            'user_id' => auth()->user()->id,
            'telefone' => $request->telefone,
            'turma_id' => $request->turma,
            'sexo' => $request->sexo,
            'dt_nascimento' => $request->dt_nascimento,
        ]);

        return redirect()->route('home')->with('session_sucesso', 'Seu cadastro foi concluído.');
    }

    /**
     * Verificar se o aluno já tem dados cadastrados
     *
     * @return void
     */
    public function seTemDados()
    {
        if (auth()->user()->user_profile == 'aluno' && auth()->user()->aluno != null)
            abort(403);
    }
}
