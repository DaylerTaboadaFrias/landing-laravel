<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Modalidad;
use App\Models\Util;
use DB;
use Validator;


class ModalidadController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('modalidad.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('modalidad.registrar',['estados'=>$estados]);
    }

    public function editar($id_modalidad)
    {
        $modalidad = Modalidad::findOrFail($id_modalidad);
        $estados = Util::getEstados();
        return view('modalidad.editar',['modalidad'=>$modalidad,'estados'=>$estados]);
    }

    public function listarModalidad(Request $request)
    {
        $search = $request->input('search');
        $modalidades = Modalidad::filtroModalidad($search);
        $view = view('modalidad.item-modalidad',['modalidades'=>$modalidades]);
        return Response($view);
    }


    public function eliminarModalidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Modalidad::eliminarModalidad($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Modalidad eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarModalidad(Request $request)
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
            Modalidad::registrarModalidad(
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Modalidad registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarModalidad(Request $request)
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
            Modalidad::actualizarModalidad(
                $request->id,
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Modalidad actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
