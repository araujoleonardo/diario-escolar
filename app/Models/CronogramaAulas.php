<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronogramaAulas extends Model
{
    use HasFactory;

    protected $fillable = [
        'hora_inicio',
        'hora_final',
        'segunda',
        'terca',
        'quarta',
        'quinta',
        'sexta',
        'turma_id',
    ];
}
