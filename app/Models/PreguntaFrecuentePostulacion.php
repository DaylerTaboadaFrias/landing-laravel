<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

class PreguntaFrecuentePostulacion extends Model
{
    protected $table = 'pregunta_frecuente_postulacion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'pregunta', 'respuesta', 'orden', 'habilitado', 'eliminado'
    ];
    
    public static function obtenerPreguntasFrecuentes()
    {
        $query = DB::table('pregunta_frecuente_postulacion')
            ->select(
                'pregunta_frecuente_postulacion.*'
            )
            ->where('pregunta_frecuente_postulacion.habilitado', true)
            ->where('pregunta_frecuente_postulacion.eliminado', false);

        return $query->orderBy('pregunta_frecuente_postulacion.orden', 'asc')->get();
    }


    public static function filtroPreguntaFrecuentePostulacion($search)
    {
        $query = DB::table('pregunta_frecuente_postulacion')
            ->select(
                'pregunta_frecuente_postulacion.*'
            )
            ->where('pregunta_frecuente_postulacion.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('pregunta_frecuente_postulacion.id', $search)
                  ->orWhereRaw('LOWER(pregunta_frecuente_postulacion.pregunta) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('pregunta_frecuente_postulacion.orden', 'asc')->get();
    }
    
    
 

    public static function registrarPreguntaFrecuentePostulacion($pregunta,$respuesta,$orden,$habilitado)
    {
        $preguntaFrecuente = new PreguntaFrecuentePostulacion();
        $preguntaFrecuente->pregunta = $pregunta;
        $preguntaFrecuente->respuesta = $respuesta;
        $preguntaFrecuente->orden = $orden;
        $preguntaFrecuente->habilitado = $habilitado;
        $preguntaFrecuente->eliminado = false;
        $preguntaFrecuente->save();

        return $preguntaFrecuente;
    }

 

    public static function actualizarPreguntaFrecuentePostulacion($id,$pregunta,$respuesta,$orden,$habilitado)
    {
        $preguntaFrecuente = PreguntaFrecuentePostulacion::findOrFail($id);
        $preguntaFrecuente->pregunta = $pregunta;
        $preguntaFrecuente->respuesta = $respuesta;
        $preguntaFrecuente->orden = $orden;
        $preguntaFrecuente->habilitado = $habilitado;
        $preguntaFrecuente->update();

        return $preguntaFrecuente;
    }


    public static function eliminarPreguntaFrecuentePostulacion($id)
    {
        $preguntaFrecuente = PreguntaFrecuentePostulacion::findOrFail($id);
        $preguntaFrecuente->eliminado = true;
        $preguntaFrecuente->update();
        return $preguntaFrecuente;
    }

}
