<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SeccionCapacitacion;
use App\Models\Util;
use DB;
use Validator;


class SeccionCapacitacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('seccion-capacitacion.index');
    }

    public function editar($id_seccion_capacitacion)
    {
        $seccionCapacitacion = SeccionCapacitacion::findOrFail($id_seccion_capacitacion);
        $estados = Util::getEstados();
        return view('seccion-capacitacion.editar',['seccionCapacitacion'=>$seccionCapacitacion,'estados'=>$estados]);
    }

    public function listarSeccionCapacitacion(Request $request)
    {
        $search = $request->input('search');
        $secciones = SeccionCapacitacion::filtroSeccionCapacitacion($search);
        $view = view('seccion-capacitacion.item-seccion-capacitacion',['secciones'=>$secciones]);
        return Response($view);
    }

    public function actualizarSeccionCapacitacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required|string|max:191',
            'subtitulo' => 'required|string|max:191',
            'descripcion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SeccionCapacitacion::actualizarSeccionCapacitacion(
                $request->id,
                $request->titulo,
                $request->subtitulo,
                $request->descripcion,
                $request->imagen
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Sección de capacitación actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
