<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SolicitudContacto;
use App\Models\Util;
use App\Models\MotivoContacto;
use DB;
use Validator;
use Carbon\Carbon;


class SolicitudContactoController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        $hoy = Carbon::now();
        $fecha_inicio = $hoy->startOfMonth()->toDateString();
        $fecha_fin = $hoy->endOfMonth()->toDateString();
        $motivo_contactos = MotivoContacto::obtenerMotivoContactos();
        return view('solicitud-contacto.index',['fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin,'motivo_contactos'=>$motivo_contactos]);
    }


    public function detalle($id_solicitud_contacto)
    {
        $solicitud = SolicitudContacto::getSolicitudContacto($id_solicitud_contacto);
        $estados = Util::getEstados();
        return view('solicitud-contacto.detalle',['solicitud'=>$solicitud,'estados'=>$estados]);
    }

    public function listarSolicitudContacto(Request $request)
    {
        $search = $request->input('search');
        $recibido = $request->input('recibido');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $id_motivo_contacto = $request->input('id_motivo_contacto');
        $solicitudes = SolicitudContacto::filtroSolicitudContacto($search,$recibido,$fecha_inicio,$fecha_fin,$id_motivo_contacto);
        $view = view('solicitud-contacto.item-solicitud-contacto',['solicitudes'=>$solicitudes]);
        return Response($view);
    }


    public function eliminarSolicitudContacto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SolicitudContacto::eliminarSolicitudContacto($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La solicitud de contacto ha sido eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function recibidoSolicitudContacto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SolicitudContacto::recibidoSolicitudContacto($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Solicitud de contacto marcado como recibido correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
