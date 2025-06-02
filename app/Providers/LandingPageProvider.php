<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\RolPermiso;
use App\Enums\TipoUsuarioEnum;
use App\Models\SeccionContacto;
use View;

class LandingPageProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('layout.landing', function ($view) {
            $view->with('seccionContacto', SeccionContacto::first());
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
