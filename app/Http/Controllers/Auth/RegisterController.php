<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_profile' => 'aluno',
            'password' => Hash::make($data['password']),
        ]);
    }
    /**
     * Verificar se o aluno já tem dados cadastrados
     *
     * @return void
     */
    public function seTemDados()
    {
        if (auth()->user()->user_profile == 'aluno' && auth()->user()->aluno != null)
            abort(403);
    }

    /**
     * Formulário para cadastro de sec academica
     *
     * @return void
     */
    public function registroSecAcademica()
    {
        // Se já existe um sec. academica cadastrado
        if (User::where('user_profile', 'sec_academica')->first()) {
            abort(403);
        }

        return view('auth.registro_sec_academica');
    }

    /**
     * Salvar os dados do registro de sec academica no banco de dados
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function registroSecAcademicaStore(Request $request)
    {
        // Se já existe um sec. academica cadastrado
        if (User::where('user_profile', 'sec_academica')->first()) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'user_profile' => 'sec_academica',
            'password' => Hash::make($request['password']),
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('session_sucesso', 'Registro de Sec. Academica foi realizado.');
    }
}
