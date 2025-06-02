<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SeccionInicio;
use App\Models\Util;
use DB;
use Validator;


class SeccionInicioController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('seccion-inicio.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('seccion-inicio.registrar',['estados'=>$estados]);
    }

    public function editar($id_seccion_inicio)
    {
        $seccion = SeccionInicio::findOrFail($id_seccion_inicio);
        $estados = Util::getEstados();
        return view('seccion-inicio.editar',['seccion'=>$seccion,'estados'=>$estados]);
    }

    public function listarSeccionInicio(Request $request)
    {
        $search = $request->input('search');
        $secciones = SeccionInicio::filtroSeccionInicio($search);
        $view = view('seccion-inicio.item-seccion-inicio',['secciones'=>$secciones]);
        return Response($view);
    }


    public function eliminarSeccionInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SeccionInicio::eliminarSeccionInicio($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Seccion de inicio eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarSeccionInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:191',
            'descripcion' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required',
            'imagen' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SeccionInicio::registrarSeccionInicio(
                $request->titulo,
                $request->descripcion,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Seccion de inicio registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarSeccionInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required',
            'descripcion' => 'required',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SeccionInicio::actualizarSeccionInicio(
                $request->id,
                $request->titulo,
                $request->descripcion,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Seccion de inicio actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
