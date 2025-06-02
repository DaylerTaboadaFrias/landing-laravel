<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Disponibilidad;
use App\Models\Util;
use DB;
use Validator;


class DisponibilidadController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('disponibilidad.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('disponibilidad.registrar',['estados'=>$estados]);
    }

    public function editar($id_motivo_contacto)
    {
        $disponibilidad = Disponibilidad::findOrFail($id_motivo_contacto);
        $estados = Util::getEstados();
        return view('disponibilidad.editar',['disponibilidad'=>$disponibilidad,'estados'=>$estados]);
    }

    public function listarDisponibilidad(Request $request)
    {
        $search = $request->input('search');
        $disponibilidades = Disponibilidad::filtroDisponibilidad($search);
        $view = view('disponibilidad.item-disponibilidad',['disponibilidades'=>$disponibilidades]);
        return Response($view);
    }


    public function eliminarDisponibilidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Disponibilidad::eliminarDisponibilidad($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Disponibilidad eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarDisponibilidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Disponibilidad::registrarDisponibilidad(
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Disponibilidad registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarDisponibilidad(Request $request)
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
            Disponibilidad::actualizarDisponibilidad(
                $request->id,
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Disponibilidad actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
