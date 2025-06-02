<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class OpinionProfesional extends Model
{
    protected $table = 'opinion_profesional';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre_completo', 'profesion', 'opinion', 'imagen', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function obtenerOpinionesProfesionales()
    {
        $query = DB::table('opinion_profesional')
            ->select(
                'opinion_profesional.*'
            )
            ->where('opinion_profesional.habilitado', true)
            ->where('opinion_profesional.eliminado', false);

        return $query->orderBy('opinion_profesional.orden', 'asc')->get();
    }


    public static function filtroOpinionProfesional($search)
    {
        $query = DB::table('opinion_profesional')
            ->select(
                'opinion_profesional.*'
            )
            ->where('opinion_profesional.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('opinion_profesional.id', $search)
                  ->orWhereRaw('LOWER(opinion_profesional.nombre_completo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('opinion_profesional.orden', 'asc')->get();
    }
    
    
 

    public static function registrarOpinionProfesional($nombre_completo,$profesion,$opinion,$imagen,$orden,$habilitado)
    {
        $opinionProfesional = new OpinionProfesional();
        $opinionProfesional->nombre_completo = $nombre_completo;
        $opinionProfesional->profesion = $profesion;
        $opinionProfesional->opinion = $opinion;
        $opinionProfesional->orden = $orden;
        $opinionProfesional->habilitado = $habilitado;
        $opinionProfesional->eliminado = false;
        $opinionProfesional->save();

        OpinionProfesional::actualizarImagenOpinionProfesional($imagen, $opinionProfesional->id);

        return $opinionProfesional;
    }

 

    public static function actualizarOpinionProfesional($id,$nombre_completo,$profesion,$opinion,$imagen,$orden,$habilitado)
    {
        $opinionProfesional = OpinionProfesional::findOrFail($id);
        $opinionProfesional->nombre_completo = $nombre_completo;
        $opinionProfesional->profesion = $profesion;
        $opinionProfesional->opinion = $opinion;
        $opinionProfesional->orden = $orden;
        $opinionProfesional->habilitado = $habilitado;
        $opinionProfesional->update();

        OpinionProfesional::actualizarImagenOpinionProfesional($imagen, $opinionProfesional->id);

        return $opinionProfesional;
    }


    public static function eliminarOpinionProfesional($id)
    {
        $opinionProfesional = OpinionProfesional::findOrFail($id);
        $opinionProfesional->eliminado = true;
        $opinionProfesional->update();
        return $opinionProfesional;
    }

    public static function actualizarImagenOpinionProfesional($imagen, $id_opinion_profesional)
    {
        if ($imagen != "") {
            $path = '/img/opinionProfesional/';
            $destination_path = public_path() . $path . $id_opinion_profesional;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $opinionProfesional = OpinionProfesional::findOrFail($id_opinion_profesional);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(300, 300)
                ->save($filePath);

            $opinionProfesional->imagen = $path . $id_opinion_profesional . '/' . $fileName;
            $opinionProfesional->update();

            return $opinionProfesional;
        }
    }

}
