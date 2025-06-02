<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Docente;
use App\Models\Util;
use DB;
use Validator;


class DocenteController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('docente.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('docente.registrar',['estados'=>$estados]);
    }

    public function editar($id_docente)
    {
        $docente = Docente::findOrFail($id_docente);
        $estados = Util::getEstados();
        return view('docente.editar',['docente'=>$docente,'estados'=>$estados]);
    }

    public function listarDocente(Request $request)
    {
        $search = $request->input('search');
        $docentes = Docente::filtroDocente($search);
        $view = view('docente.item-docente',['docentes'=>$docentes]);
        return Response($view);
    }


    public function eliminarDocente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Docente::eliminarDocente($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Docente eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarDocente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'required|string|max:191',
            'biografia' => 'required',
            'enlace_linkedin' => 'required|string|max:191',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Docente::registrarDocente(
                $request->id_docente_externo,
                $request->nombre_completo,
                $request->prefijo_academico,
                $request->profesion,
                $request->biografia,
                $request->enlace_linkedin,
                $request->imagen,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Docente registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarDocente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'required|string|max:191',
            'biografia' => 'required',
            'enlace_linkedin' => 'required|string|max:191',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            Docente::actualizarDocente(
                $request->id,
                $request->id_docente_externo,
                $request->nombre_completo,
                $request->prefijo_academico,
                $request->profesion,
                $request->biografia,
                $request->enlace_linkedin,
                $request->imagen,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Docente actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
