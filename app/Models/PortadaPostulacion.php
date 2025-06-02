<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class PortadaPostulacion extends Model
{
    protected $table = 'portada_postulacion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'imagen', 'enlace'
    ];

    public static function obtenerPortadaPostulacion()
    {
        $portadaPostulacion = PortadaPostulacion::first();
        return $portadaPostulacion;
    }
    
    public static function filtroPortadaPostulacion($search)
    {
        $query = DB::table('portada_postulacion')
            ->select(
                'portada_postulacion.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('portada_postulacion.id', $search)
                  ->orWhereRaw('LOWER(portada_postulacion.enlace) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('portada_postulacion.id', 'desc')->get();
    }
    
    
    public static function actualizarPortadaPostulacion($id,$enlace,$imagen)
    {
        $portadaPostulacion = PortadaPostulacion::findOrFail($id);
        $portadaPostulacion->enlace = $enlace;
        $portadaPostulacion->update();

        PortadaPostulacion::actualizarImagenPortadaPostulacion($imagen, $portadaPostulacion->id);

        return $portadaPostulacion;
    }


    public static function actualizarImagenPortadaPostulacion($imagen, $id_portada)
    {
        if ($imagen != "") {
            $path = '/img/portadaPostulacion/';
            $destination_path = public_path() . $path . $id_portada;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $portadaPostulacion = PortadaPostulacion::findOrFail($id_portada);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(980, 484)
                ->save($filePath);

            $portadaPostulacion->imagen = $path . $id_portada . '/' . $fileName;
            $portadaPostulacion->update();

            return $portadaPostulacion;
        }
    }

}
