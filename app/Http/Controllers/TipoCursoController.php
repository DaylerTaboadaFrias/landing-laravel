<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\TipoCurso;
use App\Models\Util;
use DB;
use Validator;


class TipoCursoController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('tipo-curso.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('tipo-curso.registrar',['estados'=>$estados]);
    }

    public function editar($id_tipo_curso)
    {
        $tipoCurso = TipoCurso::findOrFail($id_tipo_curso);
        $estados = Util::getEstados();
        return view('tipo-curso.editar',['tipoCurso'=>$tipoCurso,'estados'=>$estados]);
    }

    public function listarTipoCurso(Request $request)
    {
        $search = $request->input('search');
        $tipos = TipoCurso::filtroTipoCurso($search);
        $view = view('tipo-curso.item-tipo-curso',['tipos'=>$tipos]);
        return Response($view);
    }


    public function eliminarTipoCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            TipoCurso::eliminarTipoCurso($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tipo de curso eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarTipoCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            TipoCurso::registrarTipoCurso(
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tipo de curso registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarTipoCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required|string|max:191',
            'orden' => 'required',
            'habilitado' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            TipoCurso::actualizarTipoCurso(
                $request->id,
                $request->nombre,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Tipo de curso actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
