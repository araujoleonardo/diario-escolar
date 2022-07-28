<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscolaPeriodo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'data_inicio',
        'data_final',
    ];

    
}
