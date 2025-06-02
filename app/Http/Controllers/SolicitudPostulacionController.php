<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SolicitudPostulacion;
use App\Models\Disponibilidad;
use App\Models\Util;
use DB;
use Validator;
use Carbon\Carbon;


class SolicitudPostulacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        $hoy = Carbon::now();
        $fecha_inicio = $hoy->startOfMonth()->toDateString();
        $fecha_fin = $hoy->endOfMonth()->toDateString();
        $disponibilidades = Disponibilidad::obtenerDisponibilidades();
        return view('solicitud-postulacion.index',['fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin,'disponibilidades'=>$disponibilidades]);
    }


    public function detalle($id_solicitud_postulacion)
    {
        $solicitud = SolicitudPostulacion::getSolicitudPostulacion($id_solicitud_postulacion);
        $estados = Util::getEstados();
        return view('solicitud-postulacion.detalle',['solicitud'=>$solicitud,'estados'=>$estados]);
    }

    public function listarSolicitudPostulacion(Request $request)
    {
        $search = $request->input('search');
        $recibido = $request->input('recibido');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $id_disponibilidad = $request->input('id_disponibilidad');
        $solicitudes = SolicitudPostulacion::filtroSolicitudPostulacion($search,$recibido,$fecha_inicio,$fecha_fin,$id_disponibilidad);
        $view = view('solicitud-postulacion.item-solicitud-postulacion',['solicitudes'=>$solicitudes]);
        return Response($view);
    }


    public function eliminarSolicitudPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SolicitudPostulacion::eliminarSolicitudPostulacion($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La solicitud de postulación ha sido eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function recibidoSolicitudPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SolicitudPostulacion::recibidoSolicitudPostulacion($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Solicitud de postulación marcado como recibido correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

}
