<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Aluno;
use App\Models\Falta;
use App\Models\Turma;
use App\Http\Controllers\Controller;

class DadosDoSistemaController extends Controller
{

    /**
     * Meses do ano
     *
     * @var array
     */
    public $mesPT = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

    /**
     * Dias da semana
     *
     * @var array
     */
    public $semanaPT = ['', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];

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
     * Visualzar dados do sistema em gráficos
     *
     * @return void
     */
    public function index()
    {
        return view('dashboard.pages.dados_sistema', [
            'cadastroDeAlunosAnoAtual' => $this->cadastroDeAlunosAnoAtual(),
            'faltasPresencasAnoAtual' => $this->faltasPresencasAnoAtual(),
            'faltasPresencasUltimoMes' => $this->faltasPresencasUltimoMes(),
            'faltasPresencasUltimosSeteDias' => $this->faltasPresencasUltimosSeteDias(),
            'alunosPorTurno' => $this->alunosPorTurno(),
            'alunosPorSexo' => $this->alunosPorSexo(),
            'alunosPorIdade' => $this->alunosPorIdade(),
        ]);
    }

    /**
     * Obter os dados de alunos cadastrados no ano atual
     *
     * @return void
     */
    public function cadastroDeAlunosAnoAtual()
    {

        $alunos = Aluno::orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($query) {
                return $query->created_at->format('m/Y');
            });

        $meses = [];
        $dados = [];

        // Meses de 1 de jan até o atual
        for ($i = 1; $i <= date('n'); $i++) {
            $meses[] = $this->mesPT[$i];
        }

        // Dados de alunos por mês
        for ($i = 0; $i < date('n'); $i++) {
            $keyAlunos = date('m', strtotime('- ' . $i . ' months')) . '/' . date('Y');
            $dados[] = isset($alunos[$keyAlunos]) ? $alunos[$keyAlunos]->count() : 0;
        }
        $resultado = [
            'meses' => $meses,
            'dados' => array_reverse($dados)
        ];

        return $resultado;
    }

    /**
     * Obter os dados de faltas e presenças de alunos no ano atual
     *
     * @return void
     */
    public function faltasPresencasAnoAtual()
    {

        $faltas = Falta::orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($query) {
                return $query->created_at->format('m/Y');
            });

        $meses = [];
        $dadosPresencas = [];
        $dadosFaltas = [];

        // Meses de 1 de jan até o atual
        for ($i = 1; $i <= date('n'); $i++) {
            $meses[] = $this->mesPT[$i];
        }

        // presencas de alunos por mês
        for ($i = 0; $i < date('n'); $i++) {
            $keyPresenca = date('m', strtotime('- ' . $i . ' months')) . '/' . date('Y');
            $dadosPresencas[] = isset($faltas[$keyPresenca]) ? $faltas[$keyPresenca]->where('falta', false)->count() : 0;
        }

        // faltas de alunos por mês
        for ($i = 0; $i < date('n'); $i++) {
            $keyFalta = date('m', strtotime('- ' . $i . ' months')) . '/' . date('Y');
            $dadosFaltas[] = isset($faltas[$keyFalta]) ? $faltas[$keyFalta]->where('falta', true)->count() : 0;
        }

        $resultado = [
            'meses' => $meses,
            'dadosPresencas' => array_reverse($dadosPresencas),
            'dadosFaltas' => array_reverse($dadosFaltas)
        ];

        return $resultado;
    }

    /**
     * Obter os dados de faltas e presenças de alunos no último mês
     *
     * @return void
     */
    public function faltasPresencasUltimoMes()
    {

        $dias = [];
        $dadosPresencas = [];
        $dadosFaltas = [];

        // dias de 1 até o último do mês anterior
        for ($i = 1; $i <= date('t', strtotime(' - 1 months')); $i++) {
            $dias[] = ($i < 10 ? '0' . $i : $i) . '/' . $this->mesPT[date('n', strtotime(' - 1 months'))];
        }

        // presencas de alunos por dia no último mês
        for ($i = 1; $i <= date('t', strtotime(' - 1 months')); $i++) {
            $date = date('Y-m-' . ($i < 10 ? '0' . $i : $i), strtotime('- 1 months'));
            $dadosPresencas[] = Falta::whereDate('created_at', $date)->where('falta', false)->count();
        }
        // faltas de alunos por dia no último mês
        for ($i = 1; $i <= date('t', strtotime(' - 1 months')); $i++) {
            $date = date('Y-m-' . ($i < 10 ? '0' . $i : $i), strtotime('- 1 months'));
            $dadosFaltas[] = Falta::whereDate('created_at', $date)->where('falta', true)->count();
        }

        $resultado = [
            'dias' => $dias,
            'dadosPresencas' => $dadosPresencas,
            'dadosFaltas' => $dadosFaltas,
        ];

        return $resultado;
    }

    /**
     * Obter os dados de faltas e presenças de alunos nos últimos 7 dias
     *
     * @return void
     */
    public function faltasPresencasUltimosSeteDias()
    {

        $dias = [];
        $dadosPresencas = [];
        $dadosFaltas = [];

        // dias da semana de o dia atual até -7days
        for ($i = 0; $i < 7; $i++) {
            $date = date('Y-m-d', strtotime('- ' . $i . ' days'));
            $dias[] = date('d/', strtotime($date)) . $this->semanaPT[date('N', strtotime($date))];
            $dadosPresencas[] = Falta::whereDate('created_at', $date)->where('falta', false)->count();
            $dadosFaltas[] = Falta::whereDate('created_at', $date)->where('falta', true)->count();
        }

        $resultado = [
            'dias' => array_reverse($dias),
            'dadosPresencas' => array_reverse($dadosPresencas),
            'dadosFaltas' => array_reverse($dadosFaltas),
        ];

        return $resultado;
    }

    /**
     * Alunos por turno
     *
     * @return void
     */
    public function alunosPorTurno()
    {
        $manha = 0;
        foreach (Turma::where('turno', 'manhã')->get() as $obj) {
            $manha += $obj->alunos->count();
        }

        $tarde = 0;
        foreach (Turma::where('turno', 'tarde')->get() as $obj) {
            $tarde += $obj->alunos->count();
        }

        $noite = 0;
        foreach (Turma::where('turno', 'noite')->get() as $obj) {
            $noite += $obj->alunos->count();
        }

        return [
            'manha' => $manha,
            'tarde' => $tarde,
            'noite' => $noite,
        ];
    }

    /**
     * Alunos por sexo
     *
     * @return void
     */
    public function alunosPorSexo()
    {
        return [
            'masculino' => Aluno::where('sexo', 'masculino')->count(),
            'feminino' => Aluno::where('sexo', 'feminino')->count(),
        ];
    }

    /**
     * Alunos por idade
     *
     * @return void
     */
    public function alunosPorIdade()
    {
        $entre1e10 = Aluno::whereBetween('dt_nascimento', [date('Y-m-d', strtotime('- 10 years')), date('Y-m-d')])->count();
        $entre10e20 = Aluno::whereBetween('dt_nascimento', [date('Y-m-d', strtotime('- 20 years')), date('Y-m-d', strtotime('- 10 years'))])->count();
        $entre20e30mais = Aluno::whereBetween('dt_nascimento', [date('Y-m-d', strtotime('- 300 years')), date('Y-m-d', strtotime('- 20 years'))])->count();

        return [
            'entre1e10' => $entre1e10,
            'entre10e20' => $entre10e20,
            'entre20e30mais' => $entre20e30mais,
        ];
    }
}
