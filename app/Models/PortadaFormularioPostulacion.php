<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class PortadaFormularioPostulacion extends Model
{
    protected $table = 'portada_formulario_postulacion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'imagen', 'enlace'
    ];
    
    public static function obtenerPortadaFormularioPostulacion()
    {
        $portadaFormularioPostulacion = PortadaFormularioPostulacion::first();
        return $portadaFormularioPostulacion;
    }
    

    public static function filtroPortadaFormularioPostulacion($search)
    {
        $query = DB::table('portada_formulario_postulacion')
            ->select(
                'portada_formulario_postulacion.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('portada_formulario_postulacion.id', $search)
                  ->orWhereRaw('LOWER(portada_formulario_postulacion.enlace) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('portada_formulario_postulacion.id', 'desc')->get();
    }
    
    
    public static function actualizarPortadaFormularioPostulacion($id,$enlace,$imagen)
    {
        $portadaFormularioPostulacion = PortadaFormularioPostulacion::findOrFail($id);
        $portadaFormularioPostulacion->enlace = $enlace;
        $portadaFormularioPostulacion->update();

        PortadaFormularioPostulacion::actualizarImagenPortadaFormularioPostulacion($imagen, $portadaFormularioPostulacion->id);

        return $portadaFormularioPostulacion;
    }


    public static function actualizarImagenPortadaFormularioPostulacion($imagen, $id_portada)
    {
        if ($imagen != "") {
            $path = '/img/portadaFormularioPostulacion/';
            $destination_path = public_path() . $path . $id_portada;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $portadaFormularioPostulacion = PortadaFormularioPostulacion::findOrFail($id_portada);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(980,484)
                ->save($filePath);

            $portadaFormularioPostulacion->imagen = $path . $id_portada . '/' . $fileName;
            $portadaFormularioPostulacion->update();

            return $portadaFormularioPostulacion;
        }
    }

}
