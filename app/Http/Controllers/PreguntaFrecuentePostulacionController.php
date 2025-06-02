<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\PreguntaFrecuentePostulacion;
use App\Models\Util;
use DB;
use Validator;


class PreguntaFrecuentePostulacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('pregunta-frecuente-postulacion.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('pregunta-frecuente-postulacion.registrar',['estados'=>$estados]);
    }

    public function editar($id_pregunta_frecuente)
    {
        $preguntaFrecuente = PreguntaFrecuentePostulacion::findOrFail($id_pregunta_frecuente);
        $estados = Util::getEstados();
        return view('pregunta-frecuente-postulacion.editar',['preguntaFrecuente'=>$preguntaFrecuente,'estados'=>$estados]);
    }

    public function listarPreguntaFrecuentePostulacion(Request $request)
    {
        $search = $request->input('search');
        $preguntasFrecuentes = PreguntaFrecuentePostulacion::filtroPreguntaFrecuentePostulacion($search);
        $view = view('pregunta-frecuente-postulacion.item-pregunta-frecuente-postulacion',['preguntasFrecuentes'=>$preguntasFrecuentes]);
        return Response($view);
    }


    public function eliminarPreguntaFrecuentePostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PreguntaFrecuentePostulacion::eliminarPreguntaFrecuentePostulacion($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta frecuente eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarPreguntaFrecuentePostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required',
            'respuesta' => 'required',
            'orden' => 'required',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PreguntaFrecuentePostulacion::registrarPreguntaFrecuentePostulacion(
                $request->pregunta,
                $request->respuesta,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta frecuente registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarPreguntaFrecuentePostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'pregunta' => 'required',
            'respuesta' => 'required',
            'orden' => 'required',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PreguntaFrecuentePostulacion::actualizarPreguntaFrecuentePostulacion(
                $request->id,
                $request->pregunta,
                $request->respuesta,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta frecuente actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
