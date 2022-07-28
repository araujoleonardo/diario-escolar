<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index()
    {
        // Verificar se não existe um usuário sec_academica para fazer o cadastro
        if (!User::where('user_profile', 'sec_academica')->first()) {
            return redirect()->route('registro-sec-academica');
        }
        
        return view('inicio');
    }
}
