<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class InteresadoInscripcion extends Model
{
    public $table = 'interesado_inscripcion';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre_completo',
        'telefono',
        'correo',
        'agente_comercial',
        'eliminado',
        'recibido',
        'id_curso'
    ];


    public static function getInteresadoInscripcion($id_interesado_inscripcion)
    {
        $query = DB::table('interesado_inscripcion')
            ->join('curso','interesado_inscripcion.id_curso','=','curso.id')
            ->select(
                'interesado_inscripcion.*',
                'curso.nombre as nombre_curso'
            )
            ->where('interesado_inscripcion.eliminado', false)
            ->where('interesado_inscripcion.id',$id_interesado_inscripcion);

        return $query->first();
    }

    public static function filtroInteresadoInscripcion($search,$recibido,$fecha_inicio,$fecha_fin,$id_curso)
    {
        $query = DB::table('interesado_inscripcion')
            ->join('curso','interesado_inscripcion.id_curso','=','curso.id')
            ->select(
                'interesado_inscripcion.*',
                'curso.nombre as nombre_curso'
            )
            ->where('interesado_inscripcion.eliminado', false);

        if ($recibido!=-1) {
            $query->where('interesado_inscripcion.recibido',$recibido);
        }

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $inicio = Carbon::parse($fecha_inicio)->startOfDay();
            $fin    = Carbon::parse($fecha_fin)   ->endOfDay();
            $query->whereBetween(
                'interesado_inscripcion.created_at',
                [$inicio, $fin]
            );
        }
       
        if ($id_curso!=0) {
            $query->where('interesado_inscripcion.id_curso',$id_curso);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('interesado_inscripcion.id', $search)
                  ->orWhereRaw('LOWER(interesado_inscripcion.nombre_completo) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(interesado_inscripcion.telefono) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(interesado_inscripcion.correo) LIKE LOWER(?)', ["%$search%"]);
            });
        }
        return $query->orderBy('interesado_inscripcion.id', 'desc')->get();
    }


    public static function registrarInteresadoInscripcion($nombre_completo,$telefono,$correo,$agente_comercial,$id_curso)
    {
        $interesado_inscripcion = new InteresadoInscripcion;
        $interesado_inscripcion->nombre_completo = $nombre_completo;
        $interesado_inscripcion->telefono = $telefono;
        $interesado_inscripcion->correo = $correo;
        $interesado_inscripcion->agente_comercial = $agente_comercial;
        $interesado_inscripcion->eliminado = false;
        $interesado_inscripcion->recibido = false;
        $interesado_inscripcion->id_curso = $id_curso;
        $interesado_inscripcion->save();
        return $interesado_inscripcion;
    }

    public static function eliminarInteresadoInscripcion($id)
    {
        $interesado_inscripcion = InteresadoInscripcion::findOrFail($id);
        $interesado_inscripcion->eliminado = true;
        $interesado_inscripcion->save();

        return $interesado_inscripcion;
    }


    public static function recibidoInteresadoInscripcion(
        $id_interesado_inscripcion
    )
    {
        $interesado_inscripcion = InteresadoInscripcion::findOrFail($id_interesado_inscripcion);
        $interesado_inscripcion->recibido = true;
        $interesado_inscripcion->update();
        return $interesado_inscripcion;
    }

}
