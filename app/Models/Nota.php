<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota',
        'aluno_id',
        'turma_id',
        'disciplina_id',
        'escola_periodo_id',
        'professor_id'
    ];

    /**
     * Relacionamento com a tabela alunos
     *
     * @return object
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    /**
     * Relacionamento com a tabela professor
     *
     * @return object
     */
    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    /**
     * Relacionamento com a tabela disciplina
     *
     * @return object
     */
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
