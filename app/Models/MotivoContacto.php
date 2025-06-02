<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class MotivoContacto extends Model
{
    protected $table = 'motivo_contacto';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre','habilitado','eliminado'
    ];
    

    public static function obtenerMotivoContactos()
    {
        $query = DB::table('motivo_contacto')
            ->select(
                'motivo_contacto.*'
            )
            ->where('motivo_contacto.habilitado', true)
            ->where('motivo_contacto.eliminado', false);

        return $query->orderBy('motivo_contacto.orden', 'asc')->get();
    }

    public static function filtroMotivoContacto($search)
    {
        $query = DB::table('motivo_contacto')
            ->select(
                'motivo_contacto.*'
            )
            ->where('motivo_contacto.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('motivo_contacto.id', $search)
                  ->orWhereRaw('LOWER(motivo_contacto.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('motivo_contacto.orden', 'asc')->get();
    }
    
    
 

    public static function registrarMotivoContacto($nombre,$orden,$habilitado)
    {
        $motivo_contacto = new MotivoContacto();
        $motivo_contacto->nombre = $nombre;
        $motivo_contacto->orden = $orden;
        $motivo_contacto->habilitado = $habilitado;
        $motivo_contacto->eliminado = false;
        $motivo_contacto->save();

        return $motivo_contacto;
    }

 

    public static function actualizarMotivoContacto($id,$nombre,$orden,$habilitado)
    {
        $motivo_contacto = MotivoContacto::findOrFail($id);
        $motivo_contacto->nombre = $nombre;
        $motivo_contacto->orden = $orden;
        $motivo_contacto->habilitado = $habilitado;
        $motivo_contacto->update();

        return $motivo_contacto;
    }


    public static function eliminarMotivoContacto($id)
    {
        $motivo_contacto = MotivoContacto::findOrFail($id);
        $motivo_contacto->eliminado = true;
        $motivo_contacto->update();
        return $motivo_contacto;
    }

   

}
