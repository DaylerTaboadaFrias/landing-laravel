<?php

namespace App\Models;

use DB;
use File;
use Carbon\Carbon;
use App\Models\Util;
use App\Models\Modalidad;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modalidad extends Model
{
    protected $table = 'modalidad';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre', 'orden', 'habilitado', 'eliminado'
    ];
    
    public static function getOrCreateModalidadPorNombre($nombre)
    {
        $nombreNormalizado = Util::normalizarTexto($nombre);

        $modalidad = DB::table('modalidad')
            ->where('eliminado', false)
            ->whereRaw("
                LOWER(
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(
                                        REPLACE(
                                            REPLACE(
                                                REPLACE(
                                                    REPLACE(
                                                        REPLACE(
                                                            REPLACE(
                                                                REPLACE(nombre, 'á', 'a'),
                                                                'é', 'e'
                                                            ), 'í', 'i'
                                                        ), 'ó', 'o'
                                                    ), 'ú', 'u'
                                                ), 'Á', 'a'
                                            ), 'É', 'e'
                                        ), 'Í', 'i'
                                    ), 'Ó', 'o'
                                ), 'Ú', 'u'
                            ), 'ñ', 'n'
                        ), 'Ñ', 'n'
                    )
                ) = ?
            ", [$nombreNormalizado])
            ->first();

        if ($modalidad) {
            return $modalidad->id;
        }
        $modalidad = Modalidad::registrarModalidad($nombre, 0, true);

        return $modalidad->id;
    }


    public static function obtenerModalidades()
    {
        $query = DB::table('modalidad')
            ->select(
                'modalidad.*'
            )
            ->where('modalidad.habilitado', true)
            ->where('modalidad.eliminado', false);

        return $query->orderBy('modalidad.orden', 'asc')->get();
    }

    public static function getModalidades()
    {
        return Modalidad::where('eliminado',false)->where('habilitado',true)->get();
    }

    public static function filtroModalidad($search)
    {
        $query = DB::table('modalidad')
            ->select(
                'modalidad.*'
            )
            ->where('modalidad.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('modalidad.id', $search)
                  ->orWhereRaw('LOWER(modalidad.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('modalidad.orden', 'asc')->get();
    }
    
    
 

    public static function registrarModalidad($nombre,$orden,$habilitado)
    {
        $modalidad = new Modalidad();
        $modalidad->nombre = $nombre;
        $modalidad->orden = $orden;
        $modalidad->habilitado = $habilitado;
        $modalidad->eliminado = false;
        $modalidad->save();

        return $modalidad;
    }

 

    public static function actualizarModalidad($id,$nombre,$orden,$habilitado)
    {
        $modalidad = Modalidad::findOrFail($id);
        $modalidad->nombre = $nombre;
        $modalidad->orden = $orden;
        $modalidad->habilitado = $habilitado;
        $modalidad->update();

        return $modalidad;
    }


    public static function eliminarModalidad($id)
    {
        $modalidad = Modalidad::findOrFail($id);
        $modalidad->eliminado = true;
        $modalidad->update();
        return $modalidad;
    }

}
