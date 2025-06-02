<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class RolPermiso extends Model
{
    public $table = 'rol_permiso';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'id_rol',
        'id_permiso'
    ];

    public static function filtroRolPermiso()
    {
        return RolPermiso::get();
    }

    public static function obtenerMenuPorRol()
    {
        $usuario = Session::get('data', null);

        $modulos = Modulo::orderBy('orden')->get();

        $menu = [];

        foreach ($modulos as $modulo) {
            $permisos = DB::table('rol_permiso')
                ->join('permiso', 'rol_permiso.id_permiso', '=', 'permiso.id')
                ->join('rol', 'rol_permiso.id_rol', '=', 'rol.id')
                ->join('usuario', 'rol.id', '=', 'usuario.id_rol')
                ->select('permiso.id', 'permiso.nombre', 'permiso.url', 'permiso.identificador', 'permiso.orden')
                ->where('usuario.id', $usuario->id)
                ->where('permiso.id_modulo', $modulo->id)
                ->where('rol.eliminado', false)
                ->orderBy('permiso.orden')
                ->get();

            if ($permisos->isNotEmpty()) {
                $menu[] = [
                    'id' => $modulo->id,
                    'nombre' => $modulo->nombre,
                    'identificador' => $modulo->identificador,
                    'icono' => $modulo->icono,
                    'permisos' => $permisos
                ];
            }
        }
        return json_decode(json_encode($menu));
    }


    public static function getPermisosPorRol($id_rol)
    {
        $modulos = Modulo::orderBy('orden')->get();
        $menu = [];
        foreach ($modulos as $modulo) {
            $permisos = DB::table('permiso')
                ->leftJoin('rol_permiso', function ($join) use ($id_rol) {
                    $join->on('permiso.id', '=', 'rol_permiso.id_permiso')
                         ->where('rol_permiso.id_rol', $id_rol);
                })
                ->select(
                    'permiso.id', 
                    'permiso.nombre', 
                    'permiso.url', 
                    'permiso.identificador', 
                    'permiso.orden',
                    DB::raw('CASE WHEN rol_permiso.id IS NOT NULL THEN 1 ELSE 0 END as existe')
                )
                ->where('permiso.id_modulo', $modulo->id)
                ->orderBy('permiso.orden')
                ->get();

            if ($permisos->isNotEmpty()) {
                $menu[] = [
                    'id' => $modulo->id,
                    'nombre' => $modulo->nombre,
                    'identificador' => $modulo->identificador,
                    'icono' => $modulo->icono,
                    'permisos' => $permisos
                ];
            }
        }
        return json_decode(json_encode($menu));
    }

    public static function validarPermiso($permiso)
    {
        $usuario = Session::get('data', null);

        $permisos = DB::table('rol_permiso')
            ->join('permiso', 'rol_permiso.id_permiso', '=', 'permiso.id')
            ->join('rol', 'rol_permiso.id_rol', '=', 'rol.id')
            ->join('usuario', 'rol.id', '=', 'usuario.id_rol')
            ->where('usuario.id', $usuario->id)
            ->where('permiso.id', $permiso)
            ->exists();
        return $permisos;
    }

    public static function registrarRolPermiso($id_rol,$id_permiso)
    {
        $rol_permiso = new RolPermiso();
        $rol_permiso->id_rol = $id_rol;
        $rol_permiso->id_permiso = $id_permiso;
        $rol_permiso->save();
        return $rol_permiso;
    }

    public static function registrarRolPermisoMasivo($id_rol,$permisos)
    {
        RolPermiso::where('id_rol',$id_rol)->delete();
        for ($i=0; $i < count($permisos) ; $i++) { 
            RolPermiso::registrarRolPermiso($id_rol,$permisos[$i]);
        }
        return true;
    }

}
