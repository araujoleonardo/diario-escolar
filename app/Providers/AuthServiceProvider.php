<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /* https://laravel.com/docs/8.x/authorization */

        // sec_academica
        Gate::define('sec_academica', function (User $user) {
            return $user->user_profile === 'sec_academica';
        });

        // professor
        Gate::define('professor', function (User $user) {
            return $user->user_profile === 'professor';
        });

        // aluno
        Gate::define('aluno', function (User $user) {
            return $user->user_profile === 'aluno';
        });

        // sec_academica_e_professor
        Gate::define('sec_academica_e_professor', function (User $user) {
            return $user->user_profile === 'sec_academica' or $user->user_profile === 'professor';
        });
    }
}
