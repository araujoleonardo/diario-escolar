<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set bootstrap paginate
        Paginator::useBootstrap();

        // Force HTTPS Laravel
        if (env('APP_ENV') === 'production')
            $this->app["request"]->server->set("HTTPS", "on");
    }
}
