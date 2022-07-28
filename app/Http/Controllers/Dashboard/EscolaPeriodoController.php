<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\EscolaPeriodo;
use Illuminate\Http\Request;

class EscolaPeriodoController extends Controller
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
     * Página para visualizar e cadastrar períodos
     *
     * @return void
     */
    public function index()
    {
        $periodos = EscolaPeriodo::orderBy('nome', 'asc')->paginate(10);
        return view('dashboard.pages.periodo_escolar.periodo_escolar', compact('periodos'));
    }

    /**
     * Armazenar dados do período escolar no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function periodoStore(Request $request)
    {
        $request->validate([
            'nome' => ['required', 'max:255', 'unique:escola_periodos,nome'],
            'data_inicio' => ['required', 'date'],
            'data_final' => ['required', 'date', 'after:data_inicio'],
        ], [], [
            'data_inicio' => 'data início'
        ]);

        $periodo = (new EscolaPeriodo)->fill($request->all());
        $periodo->save();

        return redirect()->back()->with('session_sucesso', 'O período foi registrado.');
    }

    /**
     * Editar período escolar
     *
     * @param  \App\Models\EscolaPeriodo $escolar_periodo
     * @return void
     */
    public function periodoEditar(EscolaPeriodo $escolar_periodo)
    {
        return view('dashboard.pages.periodo_escolar.editar_periodo', compact('escolar_periodo'));
    }

    /**
     * periodoAtualizar
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\EscolaPeriodo $escolar_periodo
     * @return void
     */
    public function periodoAtualizar(Request $request, EscolaPeriodo $escolar_periodo)
    {
        $request->validate([
            'nome' => ['required', 'max:255', 'unique:escola_periodos,nome,' . $escolar_periodo->id],
            'data_inicio' => ['required', 'date'],
            'data_final' => ['required', 'date', 'after:data_inicio'],
        ], [], [
            'data_inicio' => 'data início'
        ]);

        $escolar_periodo->fill($request->all());
        $escolar_periodo->save();

        return redirect()->back()->with('session_sucesso', 'O período foi editado.');
    }

    /**
     * Confirmar deletar período escolar
     *
     * @param  \App\Models\EscolaPeriodo $escolar_periodo
     * @return void
     */
    public function confirmarDeletar(EscolaPeriodo $escolar_periodo)
    {
        return view('dashboard.pages.periodo_escolar.deletar_periodo', compact('escolar_periodo'));
    }

    /**
     * Deletar período escolar
     *
     * @param  \App\Models\EscolaPeriodo $escolar_periodo
     * @return void
     */
    public function deletar(EscolaPeriodo $escolar_periodo)
    {
        $escolar_periodo->delete();
        return redirect()->route('periodo-escolar')->with('session_sucesso', 'O período foi deletado.');
    }
}
