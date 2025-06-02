<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\SubcategoriaCurso;
use App\Models\CategoriaCurso;
use DB;
use Validator;

class SubcategoriaCursoController extends Controller
{
   
    public function __construct()
    {
   
    }

    
    public function index()
    {
        return view('subcategoria-curso.index');
    }

    public function listarSubcategoriaCurso(Request $request)
    {
        $search = $request->input('search');
        $subcategorias = SubcategoriaCurso::filtroSubcategoriaCurso($search);
        $view = view('subcategoria-curso.item-subcategoria-curso',['subcategorias'=>$subcategorias]);
        return Response($view);
    }


    public function eliminarSubcategoriaCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SubcategoriaCurso::eliminarSubcategoriaCurso($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'SubcategoriaCurso eliminado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function registrar()
    {
        $categorias = CategoriaCurso::getCategorias();
        return view('subcategoria-curso.registrar',['categorias'=>$categorias]);
    }


    public function registrarSubcategoriaCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191',
            'habilitado' => 'required',
            'orden' => 'required',
            'id_categoria_curso' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SubcategoriaCurso::registrarSubcategoriaCurso(
                $request->nombre,
                $request->habilitado,
                $request->orden,
                $request->id_categoria_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'SubcategoriaCurso registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function actualizarSubcategoriaCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required|string|max:191',
            'habilitado' => 'required',
            'orden' => 'required',
            'id_categoria_curso' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            SubcategoriaCurso::actualizarSubcategoriaCurso(
                $request->id,
                $request->nombre,
                $request->habilitado,
                $request->orden,
                $request->id_categoria_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'SubcategoriaCurso actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function editar($id_subcategoria_curso)
    {
        $categorias = CategoriaCurso::getCategorias();
        $subcategoria = SubcategoriaCurso::findOrFail($id_subcategoria_curso);
        return view('subcategoria-curso.editar',['categorias'=>$categorias,'subcategoria'=>$subcategoria]);
    }


}
