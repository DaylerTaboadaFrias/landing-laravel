<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class SolicitudContacto extends Model
{
    public $table = 'solicitud_contacto';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre_completo',
        'correo',
        'telefono',
        'id_motivo_contacto',
        'consulta',
        'recibido',
        'eliminado',
    ];


    public static function getSolicitudContacto($id_solicitud_contacto)
    {
        $query = DB::table('solicitud_contacto')
            ->join('motivo_contacto','solicitud_contacto.id_motivo_contacto','=','motivo_contacto.id')
            ->select(
                'solicitud_contacto.*',
                'motivo_contacto.nombre as nombre_motivo_contacto'
            )
            ->where('solicitud_contacto.eliminado', false)
            ->where('solicitud_contacto.id', $id_solicitud_contacto);
        return $query->first();
    }

    public static function filtroSolicitudContacto($search,$recibido,$fecha_inicio,$fecha_fin,$id_motivo_contacto)
    {
        $query = DB::table('solicitud_contacto')
            ->join('motivo_contacto','solicitud_contacto.id_motivo_contacto','=','motivo_contacto.id')
            ->select(
                'solicitud_contacto.*',
                'motivo_contacto.nombre as nombre_motivo_contacto'
            )
            ->where('solicitud_contacto.eliminado', false);

        if ($recibido!=-1) {
            $query->where('solicitud_contacto.recibido',$recibido);
        }

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $inicio = Carbon::parse($fecha_inicio)->startOfDay();
            $fin    = Carbon::parse($fecha_fin)   ->endOfDay();
            $query->whereBetween(
                'solicitud_contacto.created_at',
                [$inicio, $fin]
            );
        }
       
        if ($id_motivo_contacto!=0) {
            $query->where('solicitud_contacto.id_motivo_contacto',$id_motivo_contacto);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('solicitud_contacto.id', $search)
                  ->orWhereRaw('LOWER(solicitud_contacto.nombre_completo) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(solicitud_contacto.telefono) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(solicitud_contacto.correo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('solicitud_contacto.id', 'desc')->get();
    }


    public static function registrarSolicitudContacto($nombre_completo,$correo,$telefono,$id_motivo_contacto,$consulta)
    {
        $solicitud_contacto = new SolicitudContacto;
        $solicitud_contacto->nombre_completo = $nombre_completo;
        $solicitud_contacto->correo = $correo;
        $solicitud_contacto->telefono = $telefono;
        $solicitud_contacto->id_motivo_contacto = $id_motivo_contacto;
        $solicitud_contacto->consulta = $consulta;
        $solicitud_contacto->eliminado = false;
        $solicitud_contacto->recibido = false;
        $solicitud_contacto->save();

        return $solicitud_contacto;
    }


    public static function eliminarSolicitudContacto($id)
    {
        $solicitud_contacto = SolicitudContacto::findOrFail($id);
        $solicitud_contacto->eliminado = true;
        $solicitud_contacto->save();

        return $solicitud_contacto;
    }


    public static function recibidoSolicitudContacto(
        $id_solicitud_contacto
    )
    {
        $solicitud_contacto = SolicitudContacto::findOrFail($id_solicitud_contacto);
        $solicitud_contacto->recibido = true;
        $solicitud_contacto->update();
        return $solicitud_contacto;
    }


}
