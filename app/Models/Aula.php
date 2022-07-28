<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'turma_id',
        'disciplina_id',
        'professor_id',
        'horario_inicio',
        'horario_final',
    ];

    /**
     * Relacionamento com a tabela professor
     *
     * @return void
     */
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Relacionamento com a tabela disciplinas
     *
     * @return void
     */
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
    /**
     * Relacionamento com a tabela turmas
     *
     * @return void
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
