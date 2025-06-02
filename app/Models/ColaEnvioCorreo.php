<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use File;
use DB;
use Mail;
use App\Models\Curso;

class ColaEnvioCorreo extends Model
{
    protected $table='cola_envio_correo';

    protected $primaryKey='id';

    public $timestamps=true;


    protected $fillable =[
        'enviado',
        'correo',
        'id_curso'
    ];

    protected $guarded =[

    ];

    //SCOPES


    //RELATIONSHIPS


    //STATICS
    public static function enviarCorreo($colaEnvioCorreo)
    {
        $curso = Curso::findOrFail($colaEnvioCorreo->id_curso);
        $url = env('URL_ADMIN');
        $colaEnvioCorreo = ColaEnvioCorreo::findOrFail($colaEnvioCorreo->id);
        $colaEnvioCorreo->enviado = true;
        $colaEnvioCorreo->update();
        ColaEnvioCorreo::enviarCorreoSuscrito($curso,$colaEnvioCorreo->correo,$url);
        return true;
    }

    public static function enviarCorreoSuscrito($curso,$correo,$url)
    {
        Mail::send('email.nuevo-curso-disponible', 
            ['curso' => $curso,'url'=>$url], 
            function($message) use ($correo) {
                $message->to($correo)
                    ->subject('Nuevo curso disponible')
                    ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            });
        return true;
    }


    public static function registrarColaEnvioCorreo($correo,$id_curso)
    {
        $colaEnvioCorreo = new ColaEnvioCorreo();
        $colaEnvioCorreo->enviado = false;
        $colaEnvioCorreo->correo = $correo;
        $colaEnvioCorreo->id_curso = $id_curso;
        $colaEnvioCorreo->save();
        return $colaEnvioCorreo;
    }

    public static function getSiguienteCorreoPorEnviar($x)
    {
        return ColaEnvioCorreo::where('enviado',false)->orderBy('id','asc')->skip(0)->take($x)->get();
    }

    public static function getSiguienteCorreoPorEnviarPorIdCurso($id_curso)
    {
        return ColaEnvioCorreo::where('enviado',false)->where('id_curso',$id_curso)->orderBy('id','asc')->first();
    }

}
