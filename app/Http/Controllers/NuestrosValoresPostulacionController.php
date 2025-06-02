<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\NuestrosValoresPostulacion;
use App\Models\Util;
use DB;
use Validator;


class NuestrosValoresPostulacionController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('nuestros-valores-postulacion.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('nuestros-valores-postulacion.registrar',['estados'=>$estados]);
    }

    public function editar($id_nuestro_valor)
    {
        $nuestroValor = NuestrosValoresPostulacion::findOrFail($id_nuestro_valor);
        $estados = Util::getEstados();
        return view('nuestros-valores-postulacion.editar',['nuestroValor'=>$nuestroValor,'estados'=>$estados]);
    }

    public function listarNuestrosValoresPostulacion(Request $request)
    {
        $search = $request->input('search');
        $nuestrosValores = NuestrosValoresPostulacion::filtroNuestrosValoresPostulacion($search);
        $view = view('nuestros-valores-postulacion.item-nuestros-valores-postulacion',['nuestrosValores'=>$nuestrosValores]);
        return Response($view);
    }


    public function eliminarNuestrosValoresPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            NuestrosValoresPostulacion::eliminarNuestrosValoresPostulacion($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nuestro valor ha sido eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarNuestrosValoresPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'orden' => 'required',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            NuestrosValoresPostulacion::registrarNuestrosValoresPostulacion(
                $request->titulo,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nuestro valor ha sido registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarNuestrosValoresPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required',
            'orden' => 'required',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            NuestrosValoresPostulacion::actualizarNuestrosValoresPostulacion(
                $request->id,
                $request->titulo,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Nuestro valor ha sido actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
