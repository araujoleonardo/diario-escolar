<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlocacaoProfessorDisciplina extends Model
{
    use HasFactory;

    protected $fillable = [
        'professor_id', 
        'disciplina_id'
    ];

    /**
     * Relacionamento com a tabela disciplinas
     *
     * @return void
     */
    public function disciplina()
    {
        return $this->belongsTo(Disciplina::class);
    }
}
