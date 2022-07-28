<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatasProvas extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'dia',
        'horario',
        'turma_id',
        'disciplina_id',
    ];

    /**
     * Relacionamento com a tabela disciplinas
     *
     * @return object
     */
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
    
    /**
     * Relacionamento com a tabela turmas
     *
     * @return object
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
