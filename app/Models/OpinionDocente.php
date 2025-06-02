<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class OpinionDocente extends Model
{
    protected $table = 'opinion_docente';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre_completo', 'profesion', 'opinion', 'imagen', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function obtenerOpinionesDocentes()
    {
        $query = DB::table('opinion_docente')
            ->select(
                'opinion_docente.*'
            )
            ->where('opinion_docente.habilitado', true)
            ->where('opinion_docente.eliminado', false);

        return $query->orderBy('opinion_docente.orden', 'asc')->get();
    }


    public static function filtroOpinionDocente($search)
    {
        $query = DB::table('opinion_docente')
            ->select(
                'opinion_docente.*'
            )
            ->where('opinion_docente.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('opinion_docente.id', $search)
                  ->orWhereRaw('LOWER(opinion_docente.nombre_completo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('opinion_docente.orden', 'asc')->get();
    }
    
    
 

    public static function registrarOpinionDocente($nombre_completo,$profesion,$opinion,$imagen,$orden,$habilitado)
    {
        $opinionDocente = new OpinionDocente();
        $opinionDocente->nombre_completo = $nombre_completo;
        $opinionDocente->profesion = $profesion;
        $opinionDocente->opinion = $opinion;
        $opinionDocente->orden = $orden;
        $opinionDocente->habilitado = $habilitado;
        $opinionDocente->eliminado = false;
        $opinionDocente->save();

        OpinionDocente::actualizarImagenOpinionDocente($imagen, $opinionDocente->id);

        return $opinionDocente;
    }

 

    public static function actualizarOpinionDocente($id,$nombre_completo,$profesion,$opinion,$imagen,$orden,$habilitado)
    {
        $opinionDocente = OpinionDocente::findOrFail($id);
        $opinionDocente->nombre_completo = $nombre_completo;
        $opinionDocente->profesion = $profesion;
        $opinionDocente->opinion = $opinion;
        $opinionDocente->orden = $orden;
        $opinionDocente->habilitado = $habilitado;
        $opinionDocente->update();

        OpinionDocente::actualizarImagenOpinionDocente($imagen, $opinionDocente->id);

        return $opinionDocente;
    }


    public static function eliminarOpinionDocente($id)
    {
        $opinionDocente = OpinionDocente::findOrFail($id);
        $opinionDocente->eliminado = true;
        $opinionDocente->update();
        return $opinionDocente;
    }

    public static function actualizarImagenOpinionDocente($imagen, $id_opinion_docente)
    {
        if ($imagen != "") {
            $path = '/img/opinionDocente/';
            $destination_path = public_path() . $path . $id_opinion_docente;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $opinionDocente = OpinionDocente::findOrFail($id_opinion_docente);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(300, 300)
                ->save($filePath);

            $opinionDocente->imagen = $path . $id_opinion_docente . '/' . $fileName;
            $opinionDocente->update();

            return $opinionDocente;
        }
    }

}
