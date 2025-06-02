<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class Disponibilidad extends Model
{
    protected $table = 'disponibilidad';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre','habilitado','eliminado'
    ];
    

    public static function obtenerDisponibilidades()
    {
        $query = DB::table('disponibilidad')
            ->select(
                'disponibilidad.*'
            )
            ->where('disponibilidad.habilitado', true)
            ->where('disponibilidad.eliminado', false);

        return $query->orderBy('disponibilidad.orden', 'asc')->get();
    }

    public static function filtroDisponibilidad($search)
    {
        $query = DB::table('disponibilidad')
            ->select(
                'disponibilidad.*'
            )
            ->where('disponibilidad.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('disponibilidad.id', $search)
                  ->orWhereRaw('LOWER(disponibilidad.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('disponibilidad.orden', 'asc')->get();
    }
    
    
 

    public static function registrarDisponibilidad($nombre,$orden,$habilitado)
    {
        $disponibilidad = new Disponibilidad();
        $disponibilidad->nombre = $nombre;
        $disponibilidad->orden = $orden;
        $disponibilidad->habilitado = $habilitado;
        $disponibilidad->eliminado = false;
        $disponibilidad->save();

        return $disponibilidad;
    }

 

    public static function actualizarDisponibilidad($id,$nombre,$orden,$habilitado)
    {
        $disponibilidad = Disponibilidad::findOrFail($id);
        $disponibilidad->nombre = $nombre;
        $disponibilidad->orden = $orden;
        $disponibilidad->habilitado = $habilitado;
        $disponibilidad->update();

        return $disponibilidad;
    }


    public static function eliminarDisponibilidad($id)
    {
        $disponibilidad = Disponibilidad::findOrFail($id);
        $disponibilidad->eliminado = true;
        $disponibilidad->update();
        return $disponibilidad;
    }

   

}
