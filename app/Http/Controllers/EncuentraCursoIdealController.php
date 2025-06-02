<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\EncuentraCursoIdeal;
use App\Models\Util;
use DB;
use Validator;


class EncuentraCursoIdealController extends Controller
{
   
    public function __construct()
    {
   
    }

    public function index()
    {
        return view('encuentra-curso-ideal.index');
    }


    public function registrar()
    {
        $estados = Util::getEstados();
        return view('encuentra-curso-ideal.registrar',['estados'=>$estados]);
    }

    public function editar($id_encuentra_curso)
    {
        $encuentraCurso = EncuentraCursoIdeal::findOrFail($id_encuentra_curso);
        $estados = Util::getEstados();
        return view('encuentra-curso-ideal.editar',['encuentraCurso'=>$encuentraCurso,'estados'=>$estados]);
    }

    public function listarEncuentraCursoIdeal(Request $request)
    {
        $search = $request->input('search');
        $encuentraCursos = EncuentraCursoIdeal::filtroEncuentraCursoIdeal($search);
        $view = view('encuentra-curso-ideal.item-encuentra-curso-ideal',['encuentraCursos'=>$encuentraCursos]);
        return Response($view);
    }


    public function actualizarEncuentraCursoIdeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'titulo' => 'required|string|max:191',
            'subtitulo' => 'required|string|max:191',
            'titulo_enlace' => 'nullable|string|max:191',
            'enlace' => 'nullable|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            EncuentraCursoIdeal::actualizarEncuentraCursoIdeal(
                $request->id,
                $request->titulo,
                $request->subtitulo,
                $request->titulo_enlace,
                $request->enlace,
                $request->imagen,
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Encuentra tu curso ideal actualizado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


}
