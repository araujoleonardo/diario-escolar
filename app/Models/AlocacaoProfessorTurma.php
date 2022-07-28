<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlocacaoProfessorTurma extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id', 
        'turma_id'
    ];

    /**
     * Relacionamento com a tabela disciplinas
     *
     * @return void
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
