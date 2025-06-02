<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;

class Rol extends Model
{
    public $table = 'rol';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre',
        'eliminado'
    ];

    public static function getRoles()
    {
        return Rol::get();
    }

   
    public static function filtroRol($search)
    {
        $query = DB::table('rol')
            ->select(
                'rol.id',
                'rol.nombre',
                'rol.eliminado',
            )
            ->where('rol.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('rol.id', $search)
                  ->orWhereRaw('LOWER(rol.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('rol.id', 'desc')->get();
    }


    public static function registrarRol($nombre)
    {

        $rol = new Rol;
        $rol->nombre = $nombre;
        $rol->eliminado = false;
        $rol->save();

        return $rol;
    }

    public static function actualizarRol($id,$nombre)
    {
        $rol = Rol::findOrFail($id);
        $rol->nombre = $nombre;
        $rol->save();
        return $rol;
    }


    public static function eliminarRol($id)
    {
        $rol = Rol::findOrFail($id);
        $rol->eliminado = true;
        $rol->save();
        return $rol;
    }



}
