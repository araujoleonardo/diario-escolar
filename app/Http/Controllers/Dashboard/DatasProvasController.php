<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\DatasProvas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DatasProvasController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'completar.perfil']);
    }

    /**
     * Formulário para selecionar turma e disciplina
     *
     * @return void
     */
    public function index()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        $disciplinas = Disciplina::orderBy('nome', 'asc')->get();
        return view('dashboard.pages.datas_provas.selecionar_turma_disciplina', compact('turmas', 'disciplinas'));
    }

    /**
     * Visualizar datas de provas após o formulário
     *
     * @param  mixed $request
     * @return void
     */
    public function visualizarDatasProvas(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'turma' => ['required', 'exists:turmas,id'],
            'disciplina' => ['required', 'exists:disciplinas,id'],
        ]);

        if ($validator->fails())
            return redirect()
                ->route('datas-de-provas.selecionar-turma-disciplina')
                ->withErrors($validator)
                ->withInput();

        $turma = Turma::find($request->turma);
        $disciplina = Disciplina::find($request->disciplina);
        $datasProvas = DatasProvas::where('turma_id', $request->turma)->where('disciplina_id', $request->disciplina)
            ->orderBy('data', 'asc')->get();

        return view('dashboard.pages.datas_provas.visualizar_data', compact('turma', 'disciplina', 'datasProvas'));
    }

    /**
     * Adicionar data de prova
     *
     * @param  mixed $turma
     * @param  mixed $disciplina
     * @return void
     */
    public function adicionar(Turma $turma, Disciplina $disciplina)
    {
        $this->authorize('sec_academica_e_professor');
        return view('dashboard.pages.datas_provas.adicionar', compact('turma', 'disciplina'));
    }

    /**
     * Armazenar dados da prova no banco de dados
     *
     * @param  mixed $request
     * @param  mixed $turma
     * @param  mixed $disciplina
     * @return void
     */
    public function store(Request $request, Turma $turma, Disciplina $disciplina)
    {
        $this->authorize('sec_academica_e_professor');

        $request->validate([
            'data' => ['required', 'date'],
            'dia' => ['required', 'max:255'],
            'horario' =>  ['required', 'date_format:H:i'],
        ]);

        $prova = (new DatasProvas)->fill($request->all());
        $prova->turma_id = $turma->id;
        $prova->disciplina_id = $disciplina->id;
        $prova->save();

        return redirect()->route('datas-de-provas.visualizar', ['turma' => $turma->id, 'disciplina' => $disciplina->id])->with('session_sucesso', 'Data de prova adicionada.');
    }

    /**
     * Deletar registro de prova
     *
     * @param  mixed $datas_provas
     * @return void
     */
    public function delete(DatasProvas $datas_prova)
    {
        $this->authorize('sec_academica_e_professor');

        $datas_prova->delete();
        return redirect()->back()->with('session_sucesso', 'Data de prova removida.');
    }
}
