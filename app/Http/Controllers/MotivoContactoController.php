<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\MotivoContacto;
use App\Models\Util;
use DB;
use Validator;


class MotivoContactoController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('motivo-contacto.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('motivo-contacto.registrar',['estados'=>$estados]);
    }

    public function editar($id_motivo_contacto)
    {
        $motivo = MotivoContacto::findOrFail($id_motivo_contacto);
        $estados = Util::getEstados();
        return view('motivo-contacto.editar',['motivo'=>$motivo,'estados'=>$estados]);
    }

    public function listarMotivoContacto(Request $request)
    {
        $search = $request->input('search');
        $motivos = MotivoContacto::filtroMotivoContacto($search);
        $view = view('motivo-contacto.item-motivo-contacto',['motivos'=>$motivos]);
        return Response($view);
    }


    public function eliminarMotivoContacto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            MotivoContacto::eliminarMotivoContacto($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Motivo de contacto eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarMotivoContacto(Request $request)
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
            MotivoContacto::registrarMotivoContacto(
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Motivo de contacto registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarMotivoContacto(Request $request)
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
            MotivoContacto::actualizarMotivoContacto(
                $request->id,
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Motivo de contacto actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
