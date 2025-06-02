<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\CategoriaCurso;
use App\Models\Util;
use DB;
use Validator;


class CategoriaCursoController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('categoria-curso.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('categoria-curso.registrar',['estados'=>$estados]);
    }

    public function editar($id_categoria)
    {
        $categoria = CategoriaCurso::findOrFail($id_categoria);
        $estados = Util::getEstados();
        return view('categoria-curso.editar',['categoria'=>$categoria,'estados'=>$estados]);
    }

    public function listarCategoriaCurso(Request $request)
    {
        $search = $request->input('search');
        $categorias = CategoriaCurso::filtroCategoriaCurso($search);
        $view = view('categoria-curso.item-categoria-curso',['categorias'=>$categorias]);
        return Response($view);
    }


    public function eliminarCategoriaCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CategoriaCurso::eliminarCategoriaCurso($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Categoría eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrarCategoriaCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191',
            'mostrar_inicio' => 'required',
            'orden' => 'required_if:mostrar_inicio,1',
            'habilitado' => 'required'
        ], [
            'orden.required_if' => 'El campo orden es obligatorio cuando el campo mostrar inicio es "Si".',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CategoriaCurso::registrarCategoriaCurso(
                $request->nombre,
                $request->mostrar_inicio,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Categoría registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarCategoriaCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required|string|max:191',
            'mostrar_inicio' => 'required',
            'orden' => 'required_if:mostrar_inicio,1',
            'habilitado' => 'required'
        ], [
            'orden.required_if' => 'El campo orden es obligatorio cuando el campo mostrar inicio es "Si".',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            CategoriaCurso::actualizarCategoriaCurso(
                $request->id,
                $request->nombre,
                $request->mostrar_inicio,
                $request->imagen,
                $request->orden,
                $request->habilitado
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Categoría actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
