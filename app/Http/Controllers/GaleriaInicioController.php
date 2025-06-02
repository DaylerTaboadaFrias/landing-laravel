<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\GaleriaInicio;
use App\Models\Util;
use DB;
use Validator;


class GaleriaInicioController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('galeria-inicio.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('galeria-inicio.registrar',['estados'=>$estados]);
    }

    public function editar($id_galeria_inicio)
    {
        $galeria = GaleriaInicio::findOrFail($id_galeria_inicio);
        $estados = Util::getEstados();
        return view('galeria-inicio.editar',['galeria'=>$galeria,'estados'=>$estados]);
    }

    public function listarGaleriaInicio(Request $request)
    {
        $search = $request->input('search');
        $galerias = GaleriaInicio::filtroGaleriaInicio($search);
        $view = view('galeria-inicio.item-galeria-inicio',['galerias'=>$galerias]);
        return Response($view);
    }


    public function eliminarGaleriaInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            GaleriaInicio::eliminarGaleriaInicio($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Galería de inicio eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarGaleriaInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'enlace' => 'nullable|string|max:191',
            'imagen' => 'required',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            GaleriaInicio::registrarGaleriaInicio(
                $request->enlace,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Galería de inicio registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarGaleriaInicio(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'enlace' => 'nullable|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            GaleriaInicio::actualizarGaleriaInicio(
                $request->id,
                $request->enlace,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Galeria de inicio actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
