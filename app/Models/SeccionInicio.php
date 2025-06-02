<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;
use App\Models\SeccionInicio;

class SeccionInicio extends Model
{
    protected $table = 'seccion_inicio';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'descripcion', 'imagen', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function obtenerSeccionesInicio()
    {
        $query = DB::table('seccion_inicio')
            ->select(
                'seccion_inicio.*'
            )
            ->where('seccion_inicio.habilitado', true)
            ->where('seccion_inicio.eliminado', false);

        return $query->orderBy('seccion_inicio.orden', 'asc')->get();
    }


    public static function filtroSeccionInicio($search)
    {
        $query = DB::table('seccion_inicio')
            ->select(
                'seccion_inicio.*'
            )
            ->where('seccion_inicio.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('seccion_inicio.id', $search)
                  ->orWhereRaw('LOWER(seccion_inicio.titulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('seccion_inicio.orden', 'asc')->get();
    }
    

 

    public static function registrarSeccionInicio($titulo,$descripcion,$imagen,$orden,$habilitado)
    {
        $seccion = new SeccionInicio();
        $seccion->titulo = $titulo;
        $seccion->descripcion = $descripcion;
        $seccion->orden = $orden;
        $seccion->habilitado = $habilitado;
        $seccion->eliminado = false;
        $seccion->save();

        SeccionInicio::actualizarImagenSeccionInicio($imagen, $seccion->id);

        return $seccion;
    }

 

    public static function actualizarSeccionInicio($id,$titulo,$descripcion,$imagen,$orden,$habilitado)
    {
        $seccion = SeccionInicio::findOrFail($id);
        $seccion->titulo = $titulo;
        $seccion->descripcion = $descripcion;
        $seccion->orden = $orden;
        $seccion->habilitado = $habilitado;
        $seccion->update();

        SeccionInicio::actualizarImagenSeccionInicio($imagen, $seccion->id);

        return $seccion;
    }


    public static function eliminarSeccionInicio($id)
    {
        $seccion = SeccionInicio::findOrFail($id);
        $seccion->eliminado = true;
        $seccion->update();
        return $seccion;
    }

    public static function actualizarImagenSeccionInicio($imagen, $id_seccion_inicio)
    {
        if ($imagen != "") {
            $path = '/img/seccionInicio/';
            $destination_path = public_path() . $path . $id_seccion_inicio;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $seccion = SeccionInicio::findOrFail($id_seccion_inicio);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(52, 52)
                ->save($filePath);

            $seccion->imagen = $path . $id_seccion_inicio . '/' . $fileName;
            $seccion->update();

            return $seccion;
        }
    }

}
