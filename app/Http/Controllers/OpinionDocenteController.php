<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\OpinionDocente;
use App\Models\Util;
use DB;
use Validator;


class OpinionDocenteController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('opinion-docente.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('opinion-docente.registrar',['estados'=>$estados]);
    }

    public function editar($id_opinion_docente)
    {
        $opinion = OpinionDocente::findOrFail($id_opinion_docente);
        $estados = Util::getEstados();
        return view('opinion-docente.editar',['opinion'=>$opinion,'estados'=>$estados]);
    }

    public function listarOpinionDocente(Request $request)
    {
        $search = $request->input('search');
        $opiniones = OpinionDocente::filtroOpinionDocente($search);
        $view = view('opinion-docente.item-opinion-docente',['opiniones'=>$opiniones]);
        return Response($view);
    }


    public function eliminarOpinionDocente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionDocente::eliminarOpinionDocente($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del docente ha sido eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarOpinionDocente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'required|string|max:191',
            'opinion' => 'required|string',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionDocente::registrarOpinionDocente(
                $request->nombre_completo,
                $request->profesion,
                $request->opinion,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del docente ha sido registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarOpinionDocente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'required|string|max:191',
            'opinion' => 'required|string',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionDocente::actualizarOpinionDocente(
                $request->id,
                $request->nombre_completo,
                $request->profesion,
                $request->opinion,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del docente ha sido actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
