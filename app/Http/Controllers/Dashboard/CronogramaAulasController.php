<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Turma;
use Illuminate\Http\Request;
use App\Models\CronogramaAulas;
use App\Http\Controllers\Controller;

class CronogramaAulasController extends Controller
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
     * Formulário para selecionar turma
     *
     * @return void
     */
    public function index()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.cronograma_aulas.selecionar_turma', compact('turmas'));
    }

    /**
     * Tabela com horário das aulas
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function cronogramaAulasTurma(Request $request)
    {
        $turma = Turma::find($request->id);

        if (!$turma)
            return redirect()->route('cronograma-de-aulas.selecionar-turma')->with('session_erro', 'Identificador da turma é invalido.');

        return view('dashboard.pages.cronograma_aulas.tabela_aulas', compact('turma'));
    }

    /**
     * Tabela para editar horário de disciplinas
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function editar(Request $request, Turma $turma)
    {
        $this->authorize('sec_academica_e_professor');
        return view('dashboard.pages.cronograma_aulas.editar', compact('turma'));
    }

    /**
     * Criar ou atualizar dados de aulas
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function criarOuAtualizar(Request $request, Turma $turma)
    {
        $this->authorize('sec_academica_e_professor');

        $request->validate([
            'turma_id' => ['required', 'exists:turmas,id'],
            'hora_inicio' =>  ['required', 'date_format:H:i'],
            'hora_final' =>  ['required', 'date_format:H:i', 'after:hora_inicio'],
            'segunda' => ['required', 'max:255'],
            'terca' => ['required', 'max:255'],
            'quarta' => ['required', 'max:255'],
            'quinta' => ['required', 'max:255'],
            'sexta' => ['required', 'max:255'],
        ], [], [
            'hora_inicio' => 'horário de início',
            'hora_final' => 'horário final',
            'terca' => 'terça',

        ]);

        $cronogramaAula = CronogramaAulas::find($request->cronograma_aula_id);

        // Se existe um registro, atualiza com os dados
        if ($cronogramaAula) {
            $cronogramaAula->fill($request->all());
        } else {
            $cronogramaAula = (new CronogramaAulas)->fill($request->all());
        }
        $cronogramaAula->save();

        return redirect()->back()->with('session_sucesso', 'O registro foi salvo.');
    }
}
