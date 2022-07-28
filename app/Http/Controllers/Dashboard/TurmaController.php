<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Turma;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class TurmaController extends Controller
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
     * Lista de todas as turmas cadastradas
     *
     * @return void
     */
    public function index()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->paginate(10);
        return view('dashboard.pages.turmas.turmas', compact('turmas'));
    }

    /**
     * Formulário para add turma
     *
     * @return void
     */
    public function adicionar()
    {
        return view('dashboard.pages.turmas.adicionar_turma');
    }

    /**
     * Salvar dados da turma no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function adicionarStore(Request $request)
    {
        $request->validate([
            'nome' => [
                'required',
                'max:255',
                // validação para o nome da turma e turno não ser o mesmo
                Rule::unique('turmas')->where(function ($query) use ($request) {
                    return $query
                        ->where('nome', $request->nome)
                        ->where('turno', $request->turno);
                }),
            ],
            'turno' => ['required', 'in:manhã,tarde,noite'],
        ], [
            'nome.unique' => 'Já existe um cadastro com esse mesmo nome da turma e turno.'
        ]);

        $turma = (new Turma)->fill($request->all());
        $turma->save();

        return redirect()->back()->with('session_sucesso', 'A turma foi adicionada.');
    }

    /**
     * Formulário para editar turma
     *
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function editar(Turma $turma)
    {
        return view('dashboard.pages.turmas.editar_turma', compact('turma'));
    }

    /**
     * Atualizar dados da turma no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function atualizar(Request $request, Turma $turma)
    {
        $request->validate([
            'nome' => [
                'required',
                'max:255',
                // validação para o nome da turma e turno não ser o mesmo
                Rule::unique('turmas')->where(function ($query) use ($request, $turma) {
                    return $query
                        ->where('id', '!=', $turma->id)
                        ->where('nome', $request->nome)
                        ->where('turno', $request->turno);
                }),
            ],
            'turno' => ['required', 'in:manhã,tarde,noite'],
        ], [
            'nome.unique' => 'Já existe um cadastro com esse mesmo nome da turma e turno.'
        ]);

        $turma->nome = $request->nome;
        $turma->turno = $request->turno;
        $turma->save();

        return redirect()->back()->with('session_sucesso', 'A turma foi editada.');
    }

    /**
     * Confirmar a remoção do registro da turma
     *
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function confirmarDeletar(Turma $turma)
    {
        return view('dashboard.pages.turmas.deletar_turma', compact('turma'));
    }

    /**
     * Deletar turma do bando de dados
     *
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function deletar(Turma $turma)
    {
        $turma->delete();
        return redirect()->route('turmas.index')->with('session_sucesso', 'A registro da turma foi deletado.');
    }
}
