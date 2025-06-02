<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class SeccionCapacitacion extends Model
{
    protected $table = 'seccion_capacitacion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'subtitulo', 'descripcion', 'imagen'
    ];


    public static function obtenerSeccionCapacitacion()
    {
        $seccionCapacitacion = SeccionCapacitacion::first();
        return $seccionCapacitacion;
    }

    public static function filtroSeccionCapacitacion($search)
    {
        $query = DB::table('seccion_capacitacion')
            ->select(
                'seccion_capacitacion.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('seccion_capacitacion.id', $search)
                  ->orWhereRaw('LOWER(seccion_capacitacion.titulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('seccion_capacitacion.id', 'desc')->get();
    }
    
    

    public static function actualizarSeccionCapacitacion($id,$titulo,$subtitulo,$descripcion,$imagen)
    {
        $seccionCapacitacion = SeccionCapacitacion::findOrFail($id);
        $seccionCapacitacion->titulo = $titulo;
        $seccionCapacitacion->subtitulo = $subtitulo;
        $seccionCapacitacion->descripcion = $descripcion;
        $seccionCapacitacion->update();

        SeccionCapacitacion::actualizarImagenSeccionCapacitacion($imagen, $seccionCapacitacion->id);

        return $seccionCapacitacion;
    }


    public static function actualizarImagenSeccionCapacitacion($imagen, $id_seccion_capacitacion)
    {
        if ($imagen != "") {
            $path = '/img/seccionCapacitacion/';
            $destination_path = public_path() . $path . $id_seccion_capacitacion;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $seccionCapacitacion = SeccionCapacitacion::findOrFail($id_seccion_capacitacion);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(425,377)
                ->save($filePath);

            $seccionCapacitacion->imagen = $path . $id_seccion_capacitacion . '/' . $fileName;
            $seccionCapacitacion->update();

            return $seccionCapacitacion;
        }
    }

}
