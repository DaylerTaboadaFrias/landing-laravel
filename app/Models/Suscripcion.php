<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use Mail;
use App\Models\Curso;
use App\Models\ColaEnvioCorreo;
use Illuminate\Support\Str;


class Suscripcion extends Model
{
    protected $table='suscripcion';

    protected $primaryKey='id';

    public $timestamps=true;


    protected $fillable =[
        'correo',
        'eliminado'
    ];

    protected $guarded =[

    ];

    //SCOPES


    //RELATIONSHIPS


    //STATICS
    public static function filtroSuscripcion($search)
    {
        $query = DB::table('suscripcion')
            ->select(
                'suscripcion.*'
            )
            ->where('suscripcion.eliminado', false);
            

        if (!empty($search)) {
            $query->where('LOWER(suscripcion.correo) LIKE LOWER(?)', ["%$search%"]);
        }

        return $query->orderBy('suscripcion.id', 'desc')->get();
    }

    public static function registrarColaEnvioCorreoMasivo($id_curso)
    {
        $suscripciones = DB::table('suscripcion')
            ->select(
                'suscripcion.*'
            )
            ->where('suscripcion.eliminado', false)->orderBy('suscripcion.id', 'asc')->get();
        for ($i=0; $i < count($suscripciones) ; $i++) { 
            ColaEnvioCorreo::registrarColaEnvioCorreo($suscripciones[$i]->correo,$id_curso);
        }
        return true;
    }


    public static function registrarSuscripcion($correo)
    {
        $correoNorm = Str::lower(trim($correo));

        $suscripcion = Suscripcion::whereRaw('LOWER(correo) = ?', [$correoNorm])->first();

        if (! $suscripcion) {
            $suscripcion = Suscripcion::create([
                'correo'    => $correoNorm,
                'eliminado' => false,
            ]);
        }
        elseif ($suscripcion->eliminado) {
            $suscripcion->update(['eliminado' => false]);
        }

        return $suscripcion;
    }

    public static function eliminarSuscripcion($id)
    {
        $suscripcion = Suscripcion::findOrFail($id);
        $suscripcion->eliminado = true;
        $suscripcion->update();
        return $suscripcion;
    }
       
   
}
