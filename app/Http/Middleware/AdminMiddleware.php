<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\RolPermiso;
use App\Enums\PermisoEnum;

class AdminMiddleware
{

    public function handle($request, Closure $next, $permiso)
    {
        $data = null;
        if (!Session::has('data')) {
            return redirect('/login');
        }
        if (!(RolPermiso::validarPermiso($permiso) || $permiso==PermisoEnum::Inicio)) {
            Session::forget('data');
            return redirect('/login');
        }
        return $next($request);
    }
}
