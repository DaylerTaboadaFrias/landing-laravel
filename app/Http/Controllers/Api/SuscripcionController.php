<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Suscripcion;
use App\Models\ColaEnvioCorreo;
use DB;
use Validator;


class SuscripcionController extends Controller
{
   

    public function procesarColaEnvioCorreo()
    {
        try {
            $cantidadEnvios = env('CANTIDAD_ENVIOS_CORREO');
            $existeColaEnvioCorreos = ColaEnvioCorreo::getSiguienteCorreoPorEnviar($cantidadEnvios);
            if(count($existeColaEnvioCorreos)>0){
                for ($i=0; $i <count($existeColaEnvioCorreos) ; $i++) { 
                    ColaEnvioCorreo::enviarCorreo($existeColaEnvioCorreos[$i]);
                    echo "Enviado ".$existeColaEnvioCorreos[$i]->id;
                }
            }else{
                echo "Sin cola";
            }
        } catch (\Exception $e) {
            echo "Error ".$e->getMessage();
        }
    }

}
