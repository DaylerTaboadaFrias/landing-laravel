<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\OpinionProfesional;
use App\Models\Util;
use DB;
use Validator;


class OpinionProfesionalController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('opinion-profesional.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('opinion-profesional.registrar',['estados'=>$estados]);
    }

    public function editar($id_opinion_profesional)
    {
        $opinion = OpinionProfesional::findOrFail($id_opinion_profesional);
        $estados = Util::getEstados();
        return view('opinion-profesional.editar',['opinion'=>$opinion,'estados'=>$estados]);
    }

    public function listarOpinionProfesional(Request $request)
    {
        $search = $request->input('search');
        $opiniones = OpinionProfesional::filtroOpinionProfesional($search);
        $view = view('opinion-profesional.item-opinion-profesional',['opiniones'=>$opiniones]);
        return Response($view);
    }


    public function eliminarOpinionProfesional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionProfesional::eliminarOpinionProfesional($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Opinión profesional eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarOpinionProfesional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'required|string|max:191',
            'opinion' => 'required',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionProfesional::registrarOpinionProfesional(
                $request->nombre_completo,
                $request->profesion,
                $request->opinion,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Opinión profesional registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarOpinionProfesional(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'required|string|max:191',
            'opinion' => 'required',
            'orden' => 'required',
            'habilitado' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            OpinionProfesional::actualizarOpinionProfesional(
                $request->id,
                $request->nombre_completo,
                $request->profesion,
                $request->opinion,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Opinión profesional actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
