<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Falta extends Model
{
    use HasFactory;

    protected $fillable = [
        'turma_id',
        'aluno_id',
        'falta',
        'professor_id'
    ];

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
     * Relacionamento com a tabela alunos
     *
     * @return object
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}
