<?php

namespace App\Http\Controllers;

use App\Models\Util;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\Modalidad;
use App\Models\TipoCurso;
use Illuminate\Http\Request;
use App\Models\OpinionEstudiante;
use App\Models\SubcategoriaCurso;
use Illuminate\Support\Facades\DB;
use App\Models\PreguntaFrecuenteCurso;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    public function index()
    {
        return view('curso.index');
    }

    public function listarCurso(Request $request)
    {
        $search = $request->input('search');
        $cursos = Curso::filtroCurso($search);
        $view = view('curso.item-curso', ['cursos' => $cursos]);
        return response($view);
    }

    public function eliminarCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data' => null]);
        }

        try {
            DB::beginTransaction();
            Curso::eliminarCurso($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Curso eliminado correctamente', 'data' => null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => null]);
        }
    }

    public function registrar()
    {
        
        $estados = Util::getEstados();
        $docentes = Docente::getDocentes();
        $subcategorias = SubcategoriaCurso::getSubategorias();
        $modalidades = Modalidad::getModalidades();
        $tiposCurso = TipoCurso::getTiposCurso();
        return view('curso.registrar',['estados'=>$estados ,'subcategorias'=>$subcategorias ,'docentes'=>$docentes ,'modalidades'=>$modalidades ,'tiposCurso'=>$tiposCurso ,'docentes'=>$docentes ]);
    }

    
    public function editar($id_curso)
    {
        $estados = Util::getEstados();
        $curso = Curso::findOrFail($id_curso);
        $docentes = Docente::getDocentes();
        $subcategorias = SubcategoriaCurso::getSubategorias();
        $modalidades = Modalidad::getModalidades();
        $tiposCurso = TipoCurso::getTiposCurso();
        return view('curso.editar',['estados'=>$estados ,'subcategorias'=>$subcategorias ,'curso'=>$curso ,'docentes'=>$docentes ,'modalidades'=>$modalidades ,'tiposCurso'=>$tiposCurso ,'docentes'=>$docentes ]);
    }

    public function registrarCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191',
            'orden' => 'required',
            'duracion' => 'required|string|max:191',
            'recursos_disponibles' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'precio' => 'required|numeric',
            'descuento' => 'nullable|numeric|min:1|max:100',
            'resumen' => 'required',
            'curso_popular' => 'required',
            'curso_ideal' => 'required',
            'notificar_suscriptores' => 'required',
            'habilitado' => 'required',
            'id_docente' => 'required|exists:docente,id,habilitado,1,eliminado,0',
            'id_subcategoria_curso' => 'required|exists:subcategoria_curso,id,habilitado,1,eliminado,0',
            'id_modalidad' => 'required|exists:modalidad,id,habilitado,1,eliminado,0',
            'id_tipo_curso' => 'required|exists:tipo_curso,id,habilitado,1,eliminado,0',
            'imagen' => 'required'
        ], [
            'id_docente.exists' => 'El docente seleccionado debe estar habilitado y no debe estar eliminado.',
            'id_subcategoria_curso.exists' => 'La subcategoria seleccionada debe estar habilitada y no debe estar eliminada.',
            'id_modalidad.exists' => 'La modalidad seleccionada debe estar habilitada y no debe estar eliminada.',
            'id_tipo_curso.exists' => 'El tipo de curso seleccionado debe estar habilitado y no debe estar eliminado.',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data' => null]);
        }
        try {
            DB::beginTransaction();
            Curso::registrarCurso(
                $request->id_curso_externo,
                $request->nombre,
                $request->orden,
                $request->duracion,
                $request->recursos_disponibles,
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->precio,
                $request->descuento,
                $request->resumen,
                $request->requisitos,
                $request->objetivos,
                $request->contenido,
                $request->archivo,
                $request->imagen,
                $request->curso_popular,
                $request->curso_ideal,
                $request->notificar_suscriptores,
                $request->habilitado,
                $request->id_docente,
                $request->id_subcategoria_curso,
                $request->id_modalidad,
                $request->id_tipo_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Curso registrado correctamente', 'data' => null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => null]);
        }
    }

    public function actualizarCurso(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nombre' => 'required|string|max:191',
            'orden' => 'required',
            'duracion' => 'required|string|max:191',
            'recursos_disponibles' => 'required|integer',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'precio' => 'required|numeric',
            'descuento' => 'nullable|numeric|min:1|max:100',
            'resumen' => 'required',
            'curso_popular' => 'required',
            'curso_ideal' => 'required',
            'notificar_suscriptores' => 'required',
            'habilitado' => 'required',
            'id_docente' => 'required|exists:docente,id,habilitado,1,eliminado,0',
            'id_subcategoria_curso' => 'required|exists:subcategoria_curso,id,habilitado,1,eliminado,0',
            'id_modalidad' => 'required|exists:modalidad,id,habilitado,1,eliminado,0',
            'id_tipo_curso' => 'required|exists:tipo_curso,id,habilitado,1,eliminado,0',
        ], [
            'id_docente.exists' => 'El docente seleccionado debe estar habilitado y no debe estar eliminado.',
            'id_subcategoria_curso.exists' => 'La subcategoria seleccionada debe estar habilitada y no debe estar eliminada.',
            'id_modalidad.exists' => 'La modalidad seleccionada debe estar habilitada y no debe estar eliminada.',
            'id_tipo_curso.exists' => 'El tipo de curso seleccionado debe estar habilitado y no debe estar eliminado.',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data' => null]);
        }

        try {
            DB::beginTransaction();
            Curso::actualizarCurso(
                $request->id,
                $request->id_curso_externo,
                $request->nombre,
                $request->orden,
                $request->duracion,
                $request->recursos_disponibles,
                $request->fecha_inicio,
                $request->fecha_fin,
                $request->precio,
                $request->descuento,
                $request->resumen,
                $request->requisitos,
                $request->objetivos,
                $request->contenido,
                $request->archivo,
                $request->imagen,
                $request->curso_popular,
                $request->curso_ideal,
                $request->notificar_suscriptores,
                $request->habilitado,
                $request->id_docente,
                $request->id_subcategoria_curso,
                $request->id_modalidad,
                $request->id_tipo_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Curso actualizado correctamente', 'data' => null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => null]);
        }
    }

    public function indexPreguntaFrecuente($id_curso)
    {
        $curso = Curso::findOrFail($id_curso);
        return view('curso.index-pregunta-frecuente',['curso'=>$curso]);
    }


    public function registrarPreguntaFrecuente($id_curso)
    {
        $estados = Util::getEstados();
        $curso = Curso::findOrFail($id_curso);
        return view('curso.registrar-pregunta-frecuente',['estados'=>$estados,'curso'=>$curso]);
    }

    public function editarPreguntaFrecuente($id_pregunta_frecuente)
    {
        $preguntaFrecuente = PreguntaFrecuenteCurso::findOrFail($id_pregunta_frecuente);
        $curso = Curso::findOrFail($preguntaFrecuente->id_curso);
        $estados = Util::getEstados();
        return view('curso.editar-pregunta-frecuente',['preguntaFrecuente'=>$preguntaFrecuente,'estados'=>$estados,'curso'=>$curso]);
    }

    public function listarPreguntaFrecuente(Request $request)
    {
        $search = $request->input('search');
        $id_curso = $request->input('id_curso');
        $preguntasFrecuentes = PreguntaFrecuenteCurso::filtroPreguntaFrecuenteCurso($search,$id_curso);
        $view = view('curso.item-pregunta-frecuente',['preguntasFrecuentes'=>$preguntasFrecuentes]);
        return Response($view);
    }


    public function eliminarPreguntaFrecuente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PreguntaFrecuenteCurso::eliminarPreguntaFrecuenteCurso($request->id);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta frecuente eliminada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



    public function agregarPreguntaFrecuente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pregunta' => 'required',
            'respuesta' => 'required',
            'orden' => 'required',
            'habilitado' => 'required',
            'id_curso' => 'required|exists:curso,id,habilitado,1,eliminado,0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PreguntaFrecuenteCurso::registrarPreguntaFrecuenteCurso(
                $request->pregunta,
                $request->respuesta,
                $request->orden,
                $request->habilitado,
                $request->id_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta frecuente registrada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }




    public function actualizarPreguntaFrecuente(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'pregunta' => 'required',
            'respuesta' => 'required',
            'orden' => 'required',
            'habilitado' => 'required',
            'id_curso' => 'required|exists:curso,id,habilitado,1,eliminado,0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }

        try {
            DB::beginTransaction();
            PreguntaFrecuenteCurso::actualizarPreguntaFrecuenteCurso(
                $request->id,
                $request->pregunta,
                $request->respuesta,
                $request->orden,
                $request->habilitado,
                $request->id_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pregunta frecuente actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function indexOpinionEstudiante($id_curso)
    {
        $curso = Curso::findOrFail($id_curso);
        return view('curso.index-opinion-estudiante',['curso'=>$curso]);
    }


    public function registrarOpinionEstudiante($id_curso)
    {   
        $curso = Curso::findOrFail($id_curso);
        $estados = Util::getEstados();
        return view('curso.registrar-opinion-estudiante',['estados'=>$estados,'curso'=>$curso]);
    }

    public function editarOpinionEstudiante($id_opinion_estudiante)
    {
        $opinion = OpinionEstudiante::findOrFail($id_opinion_estudiante);
        $curso = Curso::findOrFail($opinion->id_curso);
        $estados = Util::getEstados();
        return view('curso.editar-opinion-estudiante',['opinion'=>$opinion,'estados'=>$estados,'curso'=>$curso]);
    }

    public function listarOpinionEstudiante(Request $request)
    {
        $search = $request->input('search');
        $id_curso = $request->input('id_curso');
        $opiniones = OpinionEstudiante::filtroOpinionEstudiante($search,$id_curso);
        $view = view('curso.item-opinion-estudiante',['opiniones'=>$opiniones]);
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



    public function agregarOpinionEstudiante(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'profesion' => 'nullable|string|max:191',
            'opinion' => 'required|string',
            'orden' => 'required',
            'habilitado' => 'required',
            'id_curso' => 'required|exists:curso,id,habilitado,1,eliminado,0'
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
                $request->habilitado,
                $request->id_curso
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
            'habilitado' => 'required',
            'id_curso' => 'required|exists:curso,id,habilitado,1,eliminado,0'
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
                $request->habilitado,
                $request->id_curso
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'La opinión del estudiante ha sido actualizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }



}
