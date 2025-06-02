<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class OpinionEstudiante extends Model
{
    protected $table = 'opinion_estudiante';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre_completo', 'profesion', 'opinion', 'orden', 'habilitado', 'id_curso', 'eliminado'
    ];
    

    public static function obtenerOpinionesEstudiantes($id_curso)
    {
        $query = DB::table('opinion_estudiante')
            ->select(
                'opinion_estudiante.*'
            )
            ->where('opinion_estudiante.id_curso', $id_curso)
            ->where('opinion_estudiante.habilitado', true)
            ->where('opinion_estudiante.eliminado', false);

        return $query->orderBy('opinion_estudiante.orden', 'asc')->get();
    }


    public static function filtroOpinionEstudiante($search, $id_curso)
    {
        $query = DB::table('opinion_estudiante')
            ->join('curso', 'opinion_estudiante.id_curso', '=', 'curso.id')
            ->select(
                'opinion_estudiante.*'
            )
            ->where('opinion_estudiante.id_curso', $id_curso)
            ->where('opinion_estudiante.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('opinion_estudiante.id', $search)
                  ->orWhereRaw('LOWER(opinion_estudiante.nombre_completo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('opinion_estudiante.orden', 'asc')->get();
    }
    
    
 

    public static function registrarOpinionEstudiante($nombre_completo,$profesion,$opinion,$orden,$habilitado,$id_curso)
    {
        $opinionEstudiante = new OpinionEstudiante();
        $opinionEstudiante->nombre_completo = $nombre_completo;
        $opinionEstudiante->profesion = $profesion;
        $opinionEstudiante->opinion = $opinion;
        $opinionEstudiante->orden = $orden;
        $opinionEstudiante->habilitado = $habilitado;
        $opinionEstudiante->eliminado = false;
        $opinionEstudiante->id_curso = $id_curso;
        $opinionEstudiante->save();

        return $opinionEstudiante;
    }

 

    public static function actualizarOpinionEstudiante($id,$nombre_completo,$profesion,$opinion,$orden,$habilitado,$id_curso)
    {
        $opinionEstudiante = OpinionEstudiante::findOrFail($id);
        $opinionEstudiante->nombre_completo = $nombre_completo;
        $opinionEstudiante->profesion = $profesion;
        $opinionEstudiante->opinion = $opinion;
        $opinionEstudiante->orden = $orden;
        $opinionEstudiante->habilitado = $habilitado;
        $opinionEstudiante->id_curso = $id_curso;
        $opinionEstudiante->update();


        return $opinionEstudiante;
    }


    public static function eliminarOpinionEstudiante($id)
    {
        $opinionEstudiante = OpinionEstudiante::findOrFail($id);
        $opinionEstudiante->eliminado = true;
        $opinionEstudiante->update();
        return $opinionEstudiante;
    }

}
