<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class PortadaInicio extends Model
{
    protected $table = 'portada_inicio';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'subtitulo', 'imagen'
    ];
    

    public static function obtenerPortadaInicio()
    {
        $portadaInicio = PortadaInicio::first();
        return $portadaInicio;
    }


    public static function filtroPortadaInicio($search)
    {
        $query = DB::table('portada_inicio')
            ->select(
                'portada_inicio.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('portada_inicio.id', $search)
                  ->orWhereRaw('LOWER(portada_inicio.titulo) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(portada_inicio.subtitulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('portada_inicio.id', 'desc')->get();
    }
 


    public static function actualizarPortadaInicio($id,$titulo,$subtitulo,$imagen)
    {
        $portada = PortadaInicio::findOrFail($id);
        $portada->titulo = $titulo;
        $portada->subtitulo = $subtitulo;
        $portada->update();

        PortadaInicio::actualizarImagenPortadaInicio($imagen, $portada->id);

        return $portada;
    }


    public static function actualizarImagenPortadaInicio($imagen, $id_portada_inicio)
    {
        if ($imagen != "") {
            $path = '/img/portadaInicio/';
            $destination_path = public_path() . $path . $id_portada_inicio;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $portada = PortadaInicio::findOrFail($id_portada_inicio);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(372, 424)
                ->save($filePath);

            $portada->imagen = $path . $id_portada_inicio . '/' . $fileName;
            $portada->update();

            return $portada;
        }
    }

}
