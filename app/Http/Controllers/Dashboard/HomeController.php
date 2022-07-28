<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Aluno;
use Illuminate\Http\Request;
use App\Models\EscolaPeriodo;
use App\Http\Controllers\Controller;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('dashboard.home', [
            'cadastroDeAlunosAnoAtual' => $this->cadastroDeAlunosAnoAtual(),
            'diasParaFinalizarPeriodoEscolar' => $this->diasParaFinalizarPeriodoEscolar(),
            'ultimosAlunosCadastrados' => $this->ultimosAlunosCadastrados(),
        ]);
    }

    /**
     * Dias para finalizar o período escolar em andamento
     *
     * @return void
     */
    public function diasParaFinalizarPeriodoEscolar()
    {
        $periodos = EscolaPeriodo::all();

        $periodoAtual = null;
        foreach ($periodos as $periodo) {
            if (strtotime(date('Y-m-d')) >= strtotime($periodo->data_inicio) && strtotime(date('Y-m-d')) <= strtotime($periodo->data_final)) {
                $periodoAtual = $periodo;
            }
        }

        if ($periodoAtual) {
            $dStart = date_create(date('Y-m-d'));
            $dEnd  = date_create($periodoAtual->data_final);
            $dDiff = $dStart->diff($dEnd);

            $dTotal = date_create($periodoAtual->data_inicio);
            $dTotalEnd  = date_create($periodoAtual->data_final);
            $dTotalDiff = $dTotal->diff($dTotalEnd);

            $faltam =  $dDiff->format('%a');
            $totalDias = $dTotalDiff->format('%a');
            $totalDiasCorridosAteAgora = $totalDias - $faltam;
            $porcentDiasCorridos = ($totalDiasCorridosAteAgora / $totalDias * 100);

            return [
                'periodoAtual' => $periodoAtual,
                'totalDias' => $totalDias,
                'diasFaltam' => $faltam,
                'totalDiasCorridosAteAgora' => $totalDiasCorridosAteAgora,
                'porcentDiasCorridos' => number_format($porcentDiasCorridos, 0),
            ];
        }

        return false;
    }

    /**
     * Meses do ano
     *
     * @var array
     */
    public $mesPT = ['', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

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
     * Últimos alunos cadastrados
     *
     * @return void
     */
    public function ultimosAlunosCadastrados()
    {
        $alunos = Aluno::orderBy('created_at', 'desc')->limit(10)->get();
        return $alunos;
    }
}
