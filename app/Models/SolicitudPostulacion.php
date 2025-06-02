<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SolicitudPostulacion extends Model
{
    public $table = 'solicitud_postulacion';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre_completo',
        'perfil_profesional',
        'especializaciones',
        'telefono',
        'correo',
        'experiencia',
        'referencias',
        'eliminado',
        'recibido',
        'archivo',
        'id_disponibilidad',
    ];


    public static function getSolicitudPostulacion($id_solicitud_postulacion)
    {
        $query = DB::table('solicitud_postulacion')
            ->join('disponibilidad','solicitud_postulacion.id_disponibilidad','=','disponibilidad.id')
            ->select(
                'solicitud_postulacion.*',
                'disponibilidad.nombre as nombre_disponibilidad'
            )
            ->where('solicitud_postulacion.eliminado', false)
            ->where('solicitud_postulacion.id',$id_solicitud_postulacion);

        return $query->first();
    }

    public static function filtroSolicitudPostulacion($search,$recibido,$fecha_inicio,$fecha_fin,$id_disponibilidad)
    {
        $query = DB::table('solicitud_postulacion')
            ->join('disponibilidad','solicitud_postulacion.id_disponibilidad','=','disponibilidad.id')
            ->select(
                'solicitud_postulacion.*',
                'disponibilidad.nombre as nombre_disponibilidad'
            )
            ->where('solicitud_postulacion.eliminado', false);

        if ($recibido!=-1) {
            $query->where('solicitud_postulacion.recibido',$recibido);
        }

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $inicio = Carbon::parse($fecha_inicio)->startOfDay();
            $fin    = Carbon::parse($fecha_fin)   ->endOfDay();
            $query->whereBetween(
                'solicitud_postulacion.created_at',
                [$inicio, $fin]
            );
        }
       
        if ($id_disponibilidad!=0) {
            $query->where('solicitud_postulacion.id_disponibilidad',$id_disponibilidad);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('solicitud_postulacion.id', $search)
                  ->orWhereRaw('LOWER(solicitud_postulacion.nombre_completo) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(solicitud_postulacion.telefono) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(solicitud_postulacion.correo) LIKE LOWER(?)', ["%$search%"]);
            });
        }
        return $query->orderBy('solicitud_postulacion.id', 'desc')->get();
    }


    public static function registrarSolicitudPostulacion($nombre_completo,$perfil_profesional,$especializaciones,$telefono,$correo,$id_disponibilidad,$experiencia,$referencias,$archivo)
    {
        $solicitud_postulacion = new SolicitudPostulacion;
        $solicitud_postulacion->nombre_completo = $nombre_completo;
        $solicitud_postulacion->perfil_profesional = $perfil_profesional;
        $solicitud_postulacion->especializaciones = $especializaciones;
        $solicitud_postulacion->telefono = $telefono;
        $solicitud_postulacion->correo = $correo;
        $solicitud_postulacion->id_disponibilidad = $id_disponibilidad;
        $solicitud_postulacion->experiencia = $experiencia;
        $solicitud_postulacion->referencias = $referencias;
        $solicitud_postulacion->eliminado = false;
        $solicitud_postulacion->recibido = false;
        $solicitud_postulacion->save();

        SolicitudPostulacion::actualizarArchivoPostulacion($archivo,$solicitud_postulacion->id);

        return $solicitud_postulacion;
    }

    public static function eliminarSolicitudPostulacion($id)
    {
        $solicitud_postulacion = SolicitudPostulacion::findOrFail($id);
        $solicitud_postulacion->eliminado = true;
        $solicitud_postulacion->save();

        return $solicitud_postulacion;
    }


    public static function recibidoSolicitudPostulacion(
        $id_solicitud_postulacion
    )
    {
        $solicitud_postulacion = SolicitudPostulacion::findOrFail($id_solicitud_postulacion);
        $solicitud_postulacion->recibido = true;
        $solicitud_postulacion->update();
        return $solicitud_postulacion;
    }

    public static function actualizarArchivoPostulacion($archivo, $id_postulacion)
    {
        if ($archivo != "") {
            $path = '/files/postulacion/';
            $destination_path = public_path() . $path . $id_postulacion;
            
            File::makeDirectory($destination_path, 0777, true, true);
            $solicitud_postulacion = SolicitudPostulacion::findOrFail($id_postulacion);
    
            if (is_string($archivo) && strpos($archivo, 'data:') === 0) {
                list($type, $fileData) = explode(';', $archivo);
                list(, $fileData) = explode(',', $fileData);
                $fileData = base64_decode($fileData);
    
                $ext = explode('/', mime_content_type($archivo))[1];
                $fileName = 'archivo_' . uniqid() . '.' . $ext;
    
                file_put_contents($destination_path . '/' . $fileName, $fileData);
            } else { 
                $fileName = 'archivo_' . uniqid() . '.' . pathinfo($archivo->getClientOriginalName(), PATHINFO_EXTENSION);
                $archivo->move($destination_path, $fileName);
            }
    
            $solicitud_postulacion->archivo = $path . $id_postulacion . '/' . $fileName;
            $solicitud_postulacion->update();
        }
    }

}
