<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Disciplina;
use Illuminate\Http\Request;

class DisciplinaController extends Controller
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
     * Início da página com form para add disciplinas e listar as disciplinas
     *
     * @return void
     */
    public function index()
    {
        $disciplinas = Disciplina::orderBy('nome', 'asc')->paginate(10);
        return view('dashboard.pages.disciplinas.disciplinas', compact('disciplinas'));
    }

    /**
     * Armazenar dados da disciplina no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function disciplinaStore(Request $request)
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:disciplinas,nome'],
        ]);

        Disciplina::create([
            'nome' => $request->nome
        ]);

        return redirect()->back()->with('session_sucesso', 'A disciplina foi adicionada.');
    }

    /**
     * Formulário para editar disciplina
     *
     * @return void
     */
    public function editar(Disciplina $disciplina)
    {
        return view('dashboard.pages.disciplinas.editar_disciplina', compact('disciplina'));
    }

    /**
     * Atualizar dados da disciplina
     *
     * @param  mixed $request
     * @param  mixed $disciplina
     * @return void
     */
    public function disciplinaUpdate(Request $request, Disciplina $disciplina)
    {
        $request->validate([
            'nome' => ['required', 'string', 'max:255', 'unique:disciplinas,nome,' . $disciplina->id],
        ]);

        $disciplina->nome = $request->nome;
        $disciplina->save();

        return redirect()->route('disciplinas.index')->with('session_sucesso', 'A disciplina foi editada.');
    }

    /**
     * Confirmar Deletar
     *
     * @param  \App\Models\Disciplina $disciplina
     * @return void
     */
    public function confirmarDeletar(Disciplina $disciplina)
    {
        return view('dashboard.pages.disciplinas.deletar_disciplina', compact('disciplina'));
    }

    /**
     * Deletar disciplina
     *
     * @param  \App\Models\Disciplina $disciplina
     * @return void
     */
    public function deletar(Disciplina $disciplina)
    {
        $disciplina->delete();
        return redirect()->route('disciplinas.index')->with('session_sucesso', 'A disciplina foi deletada.');
    }
}
