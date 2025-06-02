<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CaracteristicaIncompany;
use App\Models\Util;
use DB;
use Validator;


class CaracteristicaIncompanyController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('caracteristica-incompany.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('caracteristica-incompany.registrar',['estados'=>$estados]);
    }

    public function editar($id_caracteristica)
    {
        $caracteristica = CaracteristicaIncompany::findOrFail($id_caracteristica);
        $estados = Util::getEstados();
        return view('caracteristica-incompany.editar',['caracteristica'=>$caracteristica,'estados'=>$estados]);
    }

    public function listarCaracteristicaIncompany(Request $request)
    {
        $search = $request->input('search');
        $caracteristicas = CaracteristicaIncompany::filtroCaracteristicaIncompany($search);
        $view = view('caracteristica-incompany.item-caracteristica-incompany',['caracteristicas'=>$caracteristicas]);
        return Response($view);
    }


    public function eliminarCaracteristicaIncompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CaracteristicaIncompany::eliminarCaracteristicaIncompany($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Característica eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarCaracteristicaIncompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191',
            'imagen' => 'required',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CaracteristicaIncompany::registrarCaracteristicaIncompany(
                $request->nombre,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Característica registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarCaracteristicaIncompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CaracteristicaIncompany::actualizarCaracteristicaIncompany(
                $request->id,
                $request->nombre,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Característica actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
