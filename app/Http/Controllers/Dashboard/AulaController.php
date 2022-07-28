<?php

namespace App\Http\Controllers\Dashboard;

use Carbon\Carbon;
use App\Models\Aula;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

class AulaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'can:sec_academica_e_professor']);
    }

    /**
     * Selecionar turma para consultar aulas
     *
     * @return void
     */
    public function index()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.aulas.aulas', compact('turmas'));
    }

    /**
     * Forulário para o professor registrar aula
     *
     * @return void
     */
    public function registrarAula()
    {
        $this->authorize('professor');
        return view('dashboard.pages.aulas.registrar_aula');
    }

    /**
     * Salvar os dados da auta no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function registrarAulaStore(Request $request)
    {
        $this->authorize('professor');
        $request->validate([
            'turma_id' => ['required', 'exists:turmas,id'],
            'disciplina_id' =>  ['required', 'exists:disciplinas,id'],
            'horario_inicio' =>  ['required', 'date_format:H:i'],
            'horario_final' =>  ['required', 'date_format:H:i', 'after:horario_inicio'],
        ], [], [
            'turma_id' => 'turma',
            'disciplina_id' => 'disciplina',
            'horario_inicio' => 'horário de início',
            'horario_final' => 'horário final',
        ]);

        $aula = (new Aula)->fill($request->all());
        $aula->professor_id = auth()->user()->professor->id;
        $aula->save();

        return redirect()->route('faltas.registrar-chamada', $request->turma_id)->with('session_sucesso', 'Sua aula foi registrada.');
    }

    /**
     * Consultar Aulas
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function consultarAulas(Request $request)
    {
        if ($request->id == null) // Se o parâmetro id não for informado
            return redirect()->route('aulas.index')->with('session_erro', 'O identificador da turma não foi informado.');

        if (!Aula::where('turma_id', $request->id)->exists()) // Se não existe registros para o id informado
            return redirect()->route('aulas.index')->with('session_erro', 'Não existe registros para a turma informada.');

        $turma = Turma::find($request->id);
        $aulasDivididasPorData = Aula::where('turma_id', $request->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($query) {
                return $query->created_at->format('d/m/Y');
            });

        $aulasDivididasPorData = $this->paginate($aulasDivididasPorData, 10);

        return view('dashboard.pages.aulas.consultar_aulas', compact('turma', 'aulasDivididasPorData'));
    }

    /**
     * Paginate personalizado para utilizar com groupBy()
     *
     * @var array
     */
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, ['path' => LengthAwarePaginator::resolveCurrentPath(),]);
    }
}
