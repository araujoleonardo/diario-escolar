<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'telefone',
        'dt_nascimento',
        'sexo',
        'user_id',
        'turma_id',
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
     * Relacionamento com a tabela turmas
     *
     * @return void
     */
    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }

    /**
     * Relacionamento com a tabela notas
     *
     * @return object
     */
    public function notas()
    {
        return $this->hasMany(Nota::class);
    }

    /**
     * Relacionamento com a tabela faltas
     *
     * @return object
     */
    public function faltas()
    {
        return $this->hasMany(Falta::class);
    }
}
