<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MeusDadosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'completar.perfil']);
    }

    /**
     * Formulário para editar os dados do usuário
     *
     * @return void
     */
    public function index()
    {
        return view('dashboard.pages.meus_dados');
    }

    /**
     * Atualizar dados de acordo com o perfil do usuário
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string $perfil
     * @return void
     */
    public function atualizarDados(Request $request, String $perfil)
    {
        switch ($perfil) {
            case 'sec_academica':
                return $this->atualizarDadosSecAcademica($request);
                break;
            case 'professor':
                return $this->atualizarDadosProfessor($request);
                break;
            case 'aluno':
                return $this->atualizarDadosAluno($request);
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * Atualizar dados do usuário sec_academica
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function atualizarDadosSecAcademica(Request $request)
    {
        $this->authorize('sec_academica');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
        ]);

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('session_sucesso', 'Seus dados foram modificados.');
    }

    /**
     * Atualizar dados do usuário professor
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function atualizarDadosProfessor(Request $request)
    {
        $this->authorize('professor');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
            'telefone' => ['required', 'celular_com_ddd'],
        ]);

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->professor->telefone = $request->telefone;
        $user->save();
        $user->professor->save();

        return redirect()->back()->with('session_sucesso', 'Seus dados foram modificados.');
    }

    /**
     * Atualizar dados do usuário aluno
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function atualizarDadosAluno(Request $request)
    {
        $this->authorize('aluno');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->user()->id],
            'dt_nascimento' => ['required', 'date'],
            'telefone' => ['required', 'celular_com_ddd'],
        ]);

        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->aluno->dt_nascimento = $request->dt_nascimento;
        $user->aluno->telefone = $request->telefone;
        $user->save();
        $user->aluno->save();

        return redirect()->back()->with('session_sucesso', 'Seus dados foram modificados.');
    }

    /**
     * Salvar nova senha no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function modificarSenha(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    return $fail(__('Sua senha atual está incorreta.'));
                }
            }],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find(auth()->user()->id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('session_sucesso', 'Sua senha foi modificada.');
    }
}
