<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Falta;
use App\Models\Turma;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use \PDF;


class FaltaController extends Controller
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
     * Formulário para consultar faltas
     *
     * @return void
     */
    public function index()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        return view('dashboard.pages.faltas.faltas', compact('turmas'));
    }

    /**
     * Formulário com lista de alunos para fazer chamado depois salvar as faltas no banco de dados no 
     * método registrarFaltasStore(..)
     * 
     * Esse método é executado após o usuário professor registrar uma aula
     *
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function registrarChamada(Turma $turma)
    {
        $this->authorize('professor');

        // Obter o registro de chamada se já tiver no banco de dados pra data atual
        $registroChamadaHoje =  Falta::where('turma_id', $turma->id)->whereDate('created_at', date('Y-m-d'))->first();

        return view('dashboard.pages.faltas.registrar_chamada', compact('turma', 'registroChamadaHoje'));
    }

    /**
     * Armazena as faltas no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Turma $turma
     * @return void
     */
    public function registrarFaltasStore(Request $request, Turma $turma)
    {
        $this->authorize('professor');

        // Se já existe um registro pra data atual, impedir o novo registro
        if (Falta::where('turma_id', $turma->id)->whereDate('created_at', date('Y-m-d'))->first()) {
            return redirect()->back()->with('session_erro', 'Já existe um registro de chamada pra hoje');
        }

        // Verificar se não foi selecionado nada
        if ($request->alunos == null) {
            return redirect()
                ->back()
                ->with('session_erro', 'Você esqueceu de selecionar as opções de presença.');
        }

        foreach ($turma->alunos as $key => $aluno) {
            // Verificar se todos os alunos fora selecionadas a presença para sim ou não
            if (!array_key_exists($aluno->id, $request->alunos)) {
                return redirect()
                    ->back()
                    ->with('session_erro', 'Você esqueceu de selecionar uma opção.')
                    ->withErrors([
                        'alunos' => $aluno->id,
                    ])->withInput();
            }
        }

        // Salvar faltas no banco de dados
        foreach ($request->alunos as $key => $presenca) {
            Falta::create([
                'turma_id' => $turma->id,
                'aluno_id' => $key, // A variável é o id do aluno que foi enviado no formulário com identificador do <input>
                'falta' => $presenca == 'não' ? true : false,
                'professor_id' => auth()->user()->professor->id
            ]);
        }

        return redirect()->route('faltas.consultar-faltas', ['turma' => $turma->id])->with('session_sucesso', 'Registro de chamada de alunos foi realizada.');
    }

    /**
     * Listar faltas passando uma requisição com o id da turma no atributo "turma"
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function consultarFaltas(Request $request)
    {

        // Verificar se o id é valido
        if ($request->turma == null || Turma::find($request->turma) == null) {
            return redirect()->route('faltas.index')->with('session_erro', 'Identificador da turma é inválido.');
        }

        $turma = Turma::find($request->turma)
            ->faltas()->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($query) {
                return $query->created_at->format('d/m/Y');
            });

        // Dados de registros de faltas da turma seleciondada
        $turma = $this->paginate($turma, 10);
        $turmaSelecionada = Turma::find($request->turma);

        // return $turma->first();

        return view('dashboard.pages.faltas.consultar_faltas', compact('turma', 'turmaSelecionada'));
    }

    /**
     * Visualizar dados da chamada da turma, passando o parâmetor {data}
     *
     * @param  \App\Models\Turma $turma
     * @param  string $data Ex: 2022-01-01
     * @return void
     */
    public function visualizarChamada(Turma $turma, String $data)
    {
        $registroDeChamada = $turma->faltas()->whereDate('created_at', $data)->get();
        return view('dashboard.pages.faltas.visualizar_chamada', compact('turma', 'data', 'registroDeChamada'));
    }

    /**
     * Exportar chamada com registro de presenças e faltas em um arquivo PDF
     *
     * @param  \App\Models\Turma $turma
     * @param  string $data
     * @return void
     */
    public function exportarChamadaPDF(Turma $turma, String $data)
    {
        $registroDeChamada = $turma->faltas()->whereDate('created_at', $data)->get();

        $pdf = PDF::loadView('dashboard.pages.faltas.exportar_chamada_pdf', compact('turma', 'data', 'registroDeChamada'));
        return $pdf->download('registro_de_chamada_' . date('d-m-Y', strtotime($data)) . '.pdf');
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
