<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class PreguntaFrecuenteCurso extends Model
{
    protected $table = 'pregunta_frecuente_curso';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'pregunta', 'respuesta', 'orden', 'habilitado', 'id_curso', 'eliminado'
    ];
    

    public static function obtenerPreguntasFrecuentes($id_curso)
    {
        $query = DB::table('pregunta_frecuente_curso')
            ->select(
                'pregunta_frecuente_curso.*'
            )
            ->where('pregunta_frecuente_curso.id_curso', $id_curso)
            ->where('pregunta_frecuente_curso.habilitado', true)
            ->where('pregunta_frecuente_curso.eliminado', false);

        return $query->orderBy('pregunta_frecuente_curso.orden', 'asc')->get();
    }


    public static function filtroPreguntaFrecuenteCurso($search, $id_curso)
    {
        $query = DB::table('pregunta_frecuente_curso')
            ->join('curso', 'pregunta_frecuente_curso.id_curso', '=', 'curso.id')
            ->select(
                'pregunta_frecuente_curso.*'
            )
            ->where('pregunta_frecuente_curso.id_curso', $id_curso)
            ->where('pregunta_frecuente_curso.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('pregunta_frecuente_curso.id', $search)
                  ->orWhereRaw('LOWER(pregunta_frecuente_curso.pregunta) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('pregunta_frecuente_curso.orden', 'asc')->get();
    }
    
    
 

    public static function registrarPreguntaFrecuenteCurso($pregunta,$respuesta,$orden,$habilitado,$id_curso)
    {
        $preguntaFrecuente = new PreguntaFrecuenteCurso();
        $preguntaFrecuente->pregunta = $pregunta;
        $preguntaFrecuente->respuesta = $respuesta;
        $preguntaFrecuente->orden = $orden;
        $preguntaFrecuente->habilitado = $habilitado;
        $preguntaFrecuente->eliminado = false;
        $preguntaFrecuente->id_curso = $id_curso;
        $preguntaFrecuente->save();

        return $preguntaFrecuente;
    }

 

    public static function actualizarPreguntaFrecuenteCurso($id,$pregunta,$respuesta,$orden,$habilitado,$id_curso)
    {
        $preguntaFrecuente = PreguntaFrecuenteCurso::findOrFail($id);
        $preguntaFrecuente->pregunta = $pregunta;
        $preguntaFrecuente->respuesta = $respuesta;
        $preguntaFrecuente->orden = $orden;
        $preguntaFrecuente->habilitado = $habilitado;
        $preguntaFrecuente->id_curso = $id_curso;
        $preguntaFrecuente->update();

        return $preguntaFrecuente;
    }


    public static function eliminarPreguntaFrecuenteCurso($id)
    {
        $preguntaFrecuente = PreguntaFrecuenteCurso::findOrFail($id);
        $preguntaFrecuente->eliminado = true;
        $preguntaFrecuente->update();
        return $preguntaFrecuente;
    }

}
