<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Util;
use App\Models\Curso;
use App\Models\Modalidad;
use App\Models\TipoCurso;
use Illuminate\Http\Request;
use App\Models\GaleriaInicio;
use App\Models\NuestroNumero;
use App\Models\PortadaInicio;
use App\Models\SeccionInicio;
use App\Enums\TipoUsuarioEnum;
use App\Models\CategoriaCurso;
use App\Models\OpinionDocente;
use App\Models\SeccionContacto;
use App\Models\PortadaIncompany;
use App\Models\OpinionEstudiante;
use App\Models\SolicitudContacto;
use App\Models\SubcategoriaCurso;
use App\Models\OpinionProfesional;
use App\Models\PortadaPostulacion;
use Illuminate\Support\Facades\DB;
use App\Models\EncuentraCursoIdeal;
use App\Models\SeccionCapacitacion;
use App\Models\SolicitudPostulacion;
use App\Models\PreguntaFrecuenteCurso;
use App\Models\CaracteristicaIncompany;
use Illuminate\Support\Facades\Validator;
use App\Models\NuestrosValoresPostulacion;
use App\Models\PortadaFormularioPostulacion;
use App\Models\PreguntaFrecuentePostulacion;
use App\Models\Disponibilidad;
use App\Models\MotivoContacto;
use App\Models\ConfiguracionIncompany;
use App\Models\InteresadoInscripcion;
use App\Models\CotizacionInCompany;
use App\Models\Suscripcion;

class LandingPageController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest');
    }


    public function index()
    {   
        $portadaInicio = PortadaInicio::obtenerPortadaInicio();
        $secciones = SeccionInicio::obtenerSeccionesInicio();
        $galeria = GaleriaInicio::obtenerGaleriaInicio();
        $cursosPopulares = Curso::obtenerCursosPopulares();
        $categorias = CategoriaCurso::obtenerCategorias();
        $seccionCapacitacion = SeccionCapacitacion::obtenerSeccionCapacitacion();
        $cursoIdeal = EncuentraCursoIdeal::obtenerEncuentraCursoIdeal();
        $nuestrosNumeros = NuestroNumero::obtenerNuestrosNumeros();
        $opinionesProfesionales = OpinionProfesional::obtenerOpinionesProfesionales();
        $meses = Util::getProximosMeses();
        return view('landingpage.index',['portadaInicio'=>$portadaInicio,'secciones'=>$secciones,'galeria'=>$galeria,'cursosPopulares'=>$cursosPopulares,'categorias'=>$categorias,'seccionCapacitacion'=>$seccionCapacitacion,'cursoIdeal'=>$cursoIdeal,'nuestrosNumeros'=>$nuestrosNumeros,'opinionesProfesionales'=>$opinionesProfesionales,'meses'=>$meses]);
    }

    public function listarCursosPorMes(Request $request)
    {
        $mes = $request->input('mes');
        $anio = $request->input('anio');
        $cursos = Curso::obtenerCursosCalendario($mes,$anio);
        $view = view('landingpage.item-curso-inicio', compact('cursos'))->render();
        return response()->json(['html' => $view]);
    }

    public function cursos()
    {
        $tiposCursos = TipoCurso::obtenerTiposCursos();
        $modalidades = Modalidad::obtenerModalidades();
        $categorias = CategoriaCurso::obtenerCategoriasCursos();
        $cursosIdeales = Curso::obtenerCursosIdeales();
        $meses = Util::getProximosMeses();
        return view('landingpage.cursos',['tiposCursos'=>$tiposCursos,'modalidades'=>$modalidades,'meses'=>$meses,'categorias'=>$categorias,'cursosIdeales'=>$cursosIdeales]);
    }


    public function filtrarCursos(Request $request)
    {
        $por_pagina = 12;
        // Ejecutas la consulta con paginate() dentro de obtenerCursos()
        $cursos = Curso::obtenerCursos(
            $request->id_categoria,
            $request->subcategorias,
            $request->meses_anios,
            $request->modalidades,
            $request->tipos,
            $request->ordenar,
            $request->minimo,
            $request->maximo,
            $por_pagina
        );

        // Renderiza sólo los cards, sin links
        $html = view('landingpage.item-curso-curso', compact('cursos'))->render();

        return response()->json([
            'html'           => $html,
            'cantidadCursos' => $cursos->total(),
            'currentPage'    => $cursos->currentPage(),
            'lastPage'       => $cursos->lastPage(),
            'hasMorePages'   => $cursos->hasMorePages(),
            // opcional: 'nextPageUrl' => $cursos->nextPageUrl(),
        ]);
    }

    
    public function listarSubcategorias(Request $request)
    {
        $idCategoria = $request->input('id_categoria');
        $subcategorias = SubcategoriaCurso::obtenerSubcategorias($idCategoria);
        return view('landingpage.subcategorias', compact('subcategorias'))->render();
    }

    public function detalleCurso($id)
    {
        $curso = Curso::obtenerCurso($id);
        $preguntasFrecuentes = PreguntaFrecuenteCurso::obtenerPreguntasFrecuentes($id);
        $opinionesEstudiantes = OpinionEstudiante::obtenerOpinionesEstudiantes($id);
        $cursosRelacionados = Curso::obtenerCursosRelacionados($curso->id_subcategoria_curso,$curso->id_modalidad,$curso->id);
        $urlAdmin = env('URL_ADMIN');
        return view('landingpage.detalle-curso',['curso' => $curso,'preguntasFrecuentes' => $preguntasFrecuentes,'opinionesEstudiantes' => $opinionesEstudiantes,'cursosRelacionados' => $cursosRelacionados,'urlAdmin' => $urlAdmin]);
    } 


    public function empresas($id_curso = null)
    {
        $curso = null;
        if($id_curso){
            $curso = Curso::obtenerCurso($id_curso);
        }
        $configuracionIncompany = ConfiguracionIncompany::getConfiguracionIncompany();
        $modalidades = Modalidad::obtenerModalidades();
        $portada = PortadaIncompany::obtenerPortadaIncompany();
        $caracteristicas = CaracteristicaIncompany::obtenerCaracteristicas();
        return view('landingpage.empresas',['portada'=>$portada,'modalidades'=>$modalidades,'caracteristicas'=>$caracteristicas,'configuracionIncompany'=>$configuracionIncompany,'curso'=>$curso]);
    }



    public function nosotros()
    {
        $portada = PortadaPostulacion::obtenerPortadaPostulacion();
        $valoresPostulacion = NuestrosValoresPostulacion::obtenerValoresPostulacion();
        $preguntasFrecuentes = PreguntaFrecuentePostulacion::obtenerPreguntasFrecuentes();
        $opinionesDocentes = OpinionDocente::obtenerOpinionesDocentes();
        return view('landingpage.nosotros',['portada'=>$portada,'valoresPostulacion'=>$valoresPostulacion,'preguntasFrecuentes'=>$preguntasFrecuentes,'opinionesDocentes'=>$opinionesDocentes]);
    }


    public function contacto()
    {
        $motivoContactos = MotivoContacto::obtenerMotivoContactos();
        $seccionContacto = SeccionContacto::obtenerSeccionConctacto();
        return view('landingpage.contacto',['seccionContacto'=>$seccionContacto,'motivoContactos'=>$motivoContactos]);
    }

    public function registrarContacto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'correo' => 'required|string|max:191',
            'telefono' => 'required|numeric|min:0',	
            'id_motivo_contacto' => 'required',
            'consulta' => 'required|string|max:191',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            SolicitudContacto::registrarSolicitudContacto(
                $request->nombre_completo,
                $request->correo,
                $request->codigoPais.$request->telefono,
                $request->id_motivo_contacto,
                $request->consulta
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Solicitud de contacto registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function postula()
    {
        $disponibilidades = Disponibilidad::obtenerDisponibilidades();
        $portada = PortadaFormularioPostulacion::obtenerPortadaFormularioPostulacion();
        $seccionContacto = SeccionContacto::obtenerSeccionConctacto();
        return view('landingpage.postula',['seccionContacto'=>$seccionContacto,'portada'=>$portada,'disponibilidades'=>$disponibilidades]);
    }

    public function registrarSolicitudPostulacion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'perfil_profesional' => 'required|string|max:191',
            'especializaciones' => 'required|string|max:191',
            'telefono' => 'required|numeric|min:0',
            'correo' => 'required|string|max:191',
            'id_disponibilidad' => 'required',
            'experiencia' => 'required',
            'referencias' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            SolicitudPostulacion::registrarSolicitudPostulacion(
                $request->nombre_completo,
                $request->perfil_profesional,
                $request->especializaciones,
                $request->codigoPais.$request->telefono,
                $request->correo,
                $request->id_disponibilidad,
                $request->experiencia,
                $request->referencias,
                $request->archivo
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Solicitud de postulación registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function registrarInteresadoInscripcion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_completo' => 'required|string|max:191',
            'telefono' => 'required|numeric|min:0',
            'correo' => 'required|string|max:191',
            'agente_comercial' => 'required',
            'id_curso' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            $interesadoInscripcion = InteresadoInscripcion::registrarInteresadoInscripcion(
                $request->nombre_completo,
                $request->codigoPais.$request->telefono,
                $request->correo,
                $request->agente_comercial,
                $request->id_curso
            );
            $curso = Curso::findOrFail($interesadoInscripcion->id_curso);
            $seccionContacto = SeccionContacto::obtenerSeccionConctacto();
            $url_compra = $seccionContacto->enlace_pago.$curso->id_curso_externo;
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Interesado de inscripción registrado correctamente', 'data'=>$url_compra]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

    public function registrarCotizacionInCompany(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre_empresa' => 'required|string|max:191',
            'nombre_responsable' => 'required|string|max:191',
            'telefono_responsable' => 'required|numeric|min:0',
            'correo_responsable' => 'required|string|max:191',
            'duracion_curso' => 'required|string|max:191',
            'fecha_curso' => 'required|date',
            'localizacion_curso' => 'required|string|max:191',
            'numero_participante' => 'required|numeric|min:0',
            'expectativa_curso' => 'required|string|max:191',
            'id_curso' => 'required',
            'id_modalidad' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            CotizacionInCompany::registrarCotizacionInCompany(
                $request->nombre_empresa,
                $request->nombre_responsable,
                $request->codigoPais.$request->telefono_responsable,
                $request->correo_responsable,
                $request->duracion_curso,
                $request->fecha_curso,
                $request->localizacion_curso,
                $request->numero_participante,
                $request->expectativa_curso,
                $request->id_curso,
                $request->id_modalidad
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Cotización In Company registrado correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


    public function obtenerCursosPorNombre(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:191'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            $cursos = Curso::obtenerCursosPorNombre(
                $request->nombre
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Consulta realizada correctamente', 'data'=>$cursos]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }


    public function registrarSuscripcion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'correo' => 'required|string|max:191'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => $validator->errors()->first(), 'data'=>null]);
        }
        try {
            DB::beginTransaction();
            Suscripcion::registrarSuscripcion(
                $request->correo
            );
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Suscripción realizada correctamente', 'data'=>null]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data'=>null]);
        }
    }

}
