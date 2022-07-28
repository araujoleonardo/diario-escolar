<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'turno'
    ];

    /**
     * Relacionamento com a tabela alunos
     *
     * @return object
     */
    public function alunos()
    {
        return $this->hasMany(Aluno::class);
    }

    /**
     * Relacionamento com a tabela AlocacaoProfessorTurma
     *
     * @return object
     */
    public function alocacao_professor_turma()
    {
        return $this->hasMany(AlocacaoProfessorTurma::class);
    }

    /**
     * Relacionamento com a tabela alunos
     *
     * @return object
     */
    public function faltas()
    {
        return $this->hasMany(Falta::class);
    }

    /**
     * Relacionamento com a tabela CronogramaAulas
     *
     * @return object
     */
    public function cronograma_aulas()
    {
        return $this->hasMany(CronogramaAulas::class);
    }
}
