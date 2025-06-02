<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CotizacionInCompany;
use App\Models\Modalidad;
use App\Models\Curso;
use App\Models\Util;
use DB;
use Validator;
use Carbon\Carbon;


class SolicitudCotizacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        $hoy = Carbon::now();
        $fecha_inicio = $hoy->startOfMonth()->toDateString();
        $fecha_fin = $hoy->endOfMonth()->toDateString();
        $modalidades = Modalidad::obtenerModalidades();
        return view('solicitud-cotizacion.index',['fecha_inicio'=>$fecha_inicio,'fecha_fin'=>$fecha_fin,'modalidades'=>$modalidades]);
    }


    public function detalle($id_solicitud_cotizacion)
    {
        $solicitud = CotizacionInCompany::getCotizacionInCompany($id_solicitud_cotizacion);
        $estados = Util::getEstados();
        return view('solicitud-cotizacion.detalle',['solicitud'=>$solicitud,'estados'=>$estados]);
    }

    public function listarSolicitudCotizacion(Request $request)
    {
        $search = $request->input('search');
        $recibido = $request->input('recibido');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $id_modalidad = $request->input('id_modalidad');
        $id_curso = $request->input('id_curso');
        $solicitudes = CotizacionInCompany::filtroCotizacionInCompany($search,$recibido,$fecha_inicio,$fecha_fin,$id_curso,$id_modalidad);
        $view = view('solicitud-cotizacion.item-solicitud-cotizacion',['solicitudes'=>$solicitudes]);
        return Response($view);
    }

    public function obtenerCursosPorNombre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            $cursos = Curso::obtenerCursosPorNombre(
                $request->nombre
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Consulta realizada correctamente', 'data'=>$cursos]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function eliminarSolicitudCotizacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CotizacionInCompany::eliminarCotizacionInCompany($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La solicitud de cotización ha sido eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function recibidoSolicitudCotizacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CotizacionInCompany::recibidoCotizacionInCompany($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Solicitud de cotización marcado como recibido correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

}
