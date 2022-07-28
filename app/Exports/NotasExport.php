<?php

namespace App\Exports;

use App\Models\Nota;
use App\Models\Turma;
use App\Models\Disciplina;
use App\Models\EscolaPeriodo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NotasExport implements FromView, ShouldAutoSize
{
    protected $turma = null;
    protected $disciplina = null;

    /**
     * Setar as intâncias dos models
     *
     * @param  \App\Models\Turma $turma
     * @param  \App\Models\Disciplina $disciplina
     * @return void
     */
    public function __construct(Turma $turma, Disciplina $disciplina)
    {
        $this->turma = $turma;
        $this->disciplina = $disciplina;
    }

    /**
     * Exportar tabela de notas para excel
     *
     * @return View
     */
    public function view(): View
    {
        $notas = Nota::where('turma_id', $this->turma->id)
            ->where('disciplina_id', $this->disciplina->id)
            ->orderBy('created_at', 'desc')->get();

        $periodos = EscolaPeriodo::orderby('nome', 'asc')->get();
        $turma = $this->turma;
        $disciplina = $this->disciplina;

        // Obter os professores responsáveis pela aplicação da nota se tiver
        // Grupo de registros de cada professor
        $professoresResponsaveisPelaAplicacao = Nota::where('turma_id', $this->turma->id)
            ->where('disciplina_id', $this->disciplina->id)
            ->get()->groupBy('professor_id', 'asc');

        return view('dashboard.pages.notas.exportar_notas_excel', compact('turma', 'disciplina', 'periodos', 'notas', 'professoresResponsaveisPelaAplicacao'));
    }
}
