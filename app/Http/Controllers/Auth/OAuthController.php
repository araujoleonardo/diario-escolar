<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{

    /**
     * Redirecionar para o site do provider
     *
     * @param  string $provider
     * @return void
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * O método será executado após autorizar acesso aos dados no site de provider
     *
     * @param  string $provider
     * @return void
     */
    public function callback(string $provider)
    {
        // $user = Socialite::driver($provider)->user();

        // dd($user);

        $providerUser = Socialite::driver($provider)->user();

        $user = User::where('email', $providerUser->email)->first();

        if ($user) {
            $user->update([
                'provider' => $provider,
                'provider_token' => $providerUser->token,
                'provider_refresh_token' => $providerUser->refreshToken,
            ]);
        } else {
            $user = User::create([
                'name' => $providerUser->name,
                'email' => $providerUser->email,
                'user_profile' => 'aluno',
                'provider' => $provider,
                'provider_id' => $providerUser->id,
                'provider_token' => $providerUser->token,
                'provider_refresh_token' => $providerUser->refreshToken,
            ]);
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}
