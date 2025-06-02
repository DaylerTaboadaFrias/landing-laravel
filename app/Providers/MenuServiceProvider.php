<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Models\RolPermiso;
use View;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        View::composer('layout.admin', function ($view) {
            $view->with('opciones', RolPermiso::obtenerMenuPorRol());
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
