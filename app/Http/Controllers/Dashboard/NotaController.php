<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Nota;
use App\Models\Aluno;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Exports\NotasExport;
use Illuminate\Http\Request;
use App\Models\EscolaPeriodo;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class NotaController extends Controller
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
                'minhasNotas'
            ]]
        );
        $this->middleware(['auth', 'completar.perfil']);
    }

    /**
     * Lista de notas do aluno que tá logado
     *
     * @return void
     */
    public function minhasNotas()
    {
        $this->authorize('aluno');
        $periodos = EscolaPeriodo::orderby('nome', 'asc')->get();
        $notas = Nota::where('aluno_id', auth()->user()->aluno->id)->orderBy('created_at', 'desc')->get()->groupBy('disciplina_id');

        return view('dashboard.pages.notas.minhas_notas', compact('periodos', 'notas'));
    }

    /**
     * Página inicial de notas, contém um formulário para consultar notas
     *
     * @return void
     */
    public function index()
    {
        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        $disciplinas = Disciplina::orderBy('nome', 'asc')->get();
        return view('dashboard.pages.notas.notas', compact('turmas', 'disciplinas'));
    }

    /**
     * Fazer a consulta das notas após formulário que visualiza no método "index()"
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function consultarNotasTurma(Request $request)
    {
        // Validação
        $validator = Validator::make($request->all(), [
            'turma' => ['required', 'exists:turmas,id'],
            'disciplina' => ['required', 'exists:disciplinas,id'],
        ]);

        if ($validator->fails())
            return redirect()
                ->route('notas.consultar-notas')
                ->withErrors($validator)
                ->withInput();

        $notas = Nota::where('turma_id', $request->turma)->where('disciplina_id', $request->disciplina)
            ->orderBy('created_at', 'desc')->get();

        $turma = Turma::find($request->turma);
        $disciplina = Disciplina::find($request->disciplina);
        $periodos = EscolaPeriodo::orderby('nome', 'asc')->get();

        // Obter os professores responsáveis pela aplicação da nota se tiver
        // Grupo de registros de cada professor
        $professoresResponsaveisPelaAplicacao = Nota::where('turma_id', $turma->id)->where('disciplina_id', $disciplina->id)
            ->get()->groupBy('professor_id', 'asc');

        return view('dashboard.pages.notas.notas_da_turma', compact('turma', 'disciplina', 'periodos', 'notas', 'professoresResponsaveisPelaAplicacao'));
    }

    /**
     * Exportar notas dos alunos em um arquivo excel
     *
     * @param  \App\Models\Turma $turma
     * @param  \App\Models\Disciplina $disciplina
     * @return void
     */
    public function exportarNotasExcel(Turma $turma, Disciplina $disciplina)
    {
        return Excel::download(new NotasExport($turma, $disciplina), "notas.xlsx");
    }

    /**
     * Selecionar informações para o professor aplicar notas
     *
     * @return void
     */
    public function aplicarNotas()
    {
        $this->authorize('professor');

        $turmas = Turma::orderBy('turno', 'asc')->orderBy('nome', 'asc')->get();
        $disciplinas = Disciplina::orderBy('nome', 'asc')->get();
        $periodos = EscolaPeriodo::orderBy('nome', 'asc')->get();
        return view('dashboard.pages.notas.aplicar_notas', compact('turmas', 'disciplinas', 'periodos'));
    }

    /**
     * Formulário com lista de alunos para o professor aplicar notas
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function aplicarNotasAlunos(Request $request)
    {
        $this->authorize('professor');

        // Validação
        $validator = Validator::make($request->all(), [
            'turma' => ['required', 'exists:turmas,id'],
            'disciplina' => ['required', 'exists:disciplinas,id'],
            'periodo' => ['required', 'exists:escola_periodos,id'],
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('notas.aplicar-notas')
                ->withErrors($validator)
                ->withInput();
        }

        $turma = Turma::find($request->turma);
        $disciplina = Disciplina::find($request->disciplina);
        $periodo = EscolaPeriodo::find($request->periodo);
        // Obter os professores responsáveis pela aplicação da nota se tiver
        // Grupo de registros de cada professor
        $professoresResponsaveisPelaAplicacao = Nota::where('turma_id', $turma->id)
            ->where('disciplina_id', $disciplina->id)
            ->where('escola_periodo_id', $periodo->id)
            ->get()
            ->groupBy('professor_id', 'asc');

        return view('dashboard.pages.notas.aplicar_notas_alunos', compact('turma', 'disciplina', 'periodo', 'professoresResponsaveisPelaAplicacao'));
    }

    /**
     * Salvar nota do aluno no banco de dados
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function salvarNotaAluno(Request $request)
    {

        $this->authorize('professor');

        // Substituir "," por "." para ser um número valido
        $request['nota'] = str_replace(',', '.', $request->nota);

        // Validação
        $request->validate([
            'nota' => ['required', 'numeric', 'max:10'],
            'turma_id' => ['required', 'exists:turmas,id'],
            'disciplina_id' => ['required', 'exists:disciplinas,id'],
            'escola_periodo_id' => ['required', 'exists:escola_periodos,id'],
            'aluno_id' => ['required', 'exists:alunos,id'],
        ]);

        // Obter nota do aluno se tiver
        $alunoNota = Nota::where('aluno_id', $request->aluno_id)
            ->where('disciplina_id', $request->disciplina_id)
            ->where('turma_id', $request->turma_id)
            ->where('escola_periodo_id', $request->escola_periodo_id)
            ->first();

        // Se já exister uma nota para o aluno, atualiza o registro com a nova nota
        if ($alunoNota) {
            $nota = $alunoNota->fill($request->all());
            $nota->professor_id = auth()->user()->professor->id;
            $nota->save();
        } else {
            $nota = (new Nota)->fill($request->all());
            $nota->professor_id = auth()->user()->professor->id;
            $nota->save();
        }

        return redirect()->back()->with('session_sucesso', 'A nota foi aplicada.');
    }
}
