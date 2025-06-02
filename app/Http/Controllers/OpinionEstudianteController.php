<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\OpinionEstudiante;
use App\Models\Util;
use DB;
use Validator;


class OpinionEstudianteController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('opinion-estudiante.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('opinion-estudiante.registrar',['estados'=>$estados]);
    }

    public function editar($id_opinion_estudiante)
    {
        $opinion = OpinionEstudiante::findOrFail($id_opinion_estudiante);
        $estados = Util::getEstados();
        return view('opinion-estudiante.editar',['opinion'=>$opinion,'estados'=>$estados]);
    }

    public function listarOpinionEstudiante(Request $request)
    {
        $search = $request->input('search');
        $opiniones = OpinionEstudiante::filtroOpinionEstudiante($search);
        $view = view('opinion-estudiante.item-opinion-estudiante',['opiniones'=>$opiniones]);
        return Response($view);
    }


    public function eliminarOpinionEstudiante(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionEstudiante::eliminarOpinionEstudiante($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del estudiante ha sido eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarOpinionEstudiante(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'nullable|string|max:191',
            'opinion' => 'required|string',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionEstudiante::registrarOpinionEstudiante(
                $request->nombre_completo,
                $request->profesion,
                $request->opinion,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del estudiante ha sido registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarOpinionEstudiante(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'nullable|string|max:191',
            'opinion' => 'required|string',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionEstudiante::actualizarOpinionEstudiante(
                $request->id,
                $request->nombre_completo,
                $request->profesion,
                $request->opinion,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del estudiante ha sido actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
