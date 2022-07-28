<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    use HasFactory;

    protected $table= 'professores';

    protected $fillable= [
        'telefone',
        'user_id',
    ];

    /**
     * Relacionamento com a tabela users
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com a tabela alocacoes_professor_disciplinas
     *
     * @return void
     */
    public function disciplinas()
    {
        return $this->hasMany(AlocacaoProfessorDisciplina::class);
    }

    /**
     * Relacionamento com a tabela alocacoes_professor_turmas
     *
     * @return void
     */
    public function turmas()
    {
        return $this->hasMany(AlocacaoProfessorTurma::class);
    }

}
