<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompletarPerfil
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Verificar se o usuário não completou seu perfil
        if (auth()->user()->user_profile == 'aluno' && auth()->user()->aluno == null)
            return redirect()->route('completar-perfil');
            
        return $next($request);
    }
}
