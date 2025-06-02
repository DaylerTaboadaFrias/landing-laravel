<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\Models\Util;
use App\Models\Curso;
use App\Http\Requests;
use App\Models\Docente;
use App\Models\Modalidad;
use App\Models\TipoCurso;
use Illuminate\Http\Request;
use App\Models\ImportarCurso;
use App\Models\CategoriaCurso;
use App\Models\SubcategoriaCurso;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class ImportarCursoController extends Controller
{
   
    public function __construct()
    {
   
    }


    public function index()
    {
        return view('importar-curso.index');
    }


    public function visualizarImportarCurso(Request $request)
    {
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($request->file('archivo'));
        $lector = $spreadsheet->getActiveSheet();
        $nfilas = $lector->getHighestRow();
        $datos = array();
        $idExternoCursos = array();
        $format = 'Y-m-d';

        for ($fila = 2; $fila <= $nfilas; ++$fila) {
            $curso = null;
            $error = '';
            try {
                $idCursoExterno = $lector->getCellByColumnAndRow(1,$fila)->getValue();
                if(trim($idCursoExterno)==null || trim($idCursoExterno)==''){
                    $error = $error.' | El ID externo del curso es obligatorio';
                }
                if (!is_numeric($idCursoExterno)) {
                    $error = $error.' | Formato no numérico';
                }
            } catch (\Exception $e) {
                $error = $error.' | ID curso externo tiene formato incorrecto';
            }
            


            try {
                $nombreCurso = $lector->getCellByColumnAndRow(2,$fila)->getValue();
                if(trim($nombreCurso)==null || trim($nombreCurso)==''){
                    $error = $error.' | Nombre del curso es obligatorio';
                }
                if (strlen($nombreCurso) > 191) {
                    $error = $error.' | Nombre alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Nombre del curso formato incorrecto';
            }

            try {
                $orden = $lector->getCellByColumnAndRow(3,$fila)->getValue();
                if(trim($orden)==null || trim($orden)==''){
                    $error = $error.' | El orden del curso es obligatorio';
                }
                if (!is_numeric($orden)) {
                    $error = $error.' | Formato no numérico';
                }
            } catch (\Exception $e) {
                $error = $error.' | Orden del curso tiene formato incorrecto';
            }
            
            try {
                $duracion = $lector->getCellByColumnAndRow(4,$fila)->getValue();
                if(trim($duracion)==null || trim($duracion)==''){
                    $error = $error.' | Duración es obligatorio';
                }
                if (strlen($duracion) > 191) {
                    $error = $error.' | Duración alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Duración formato incorrecto';
            }


            try {
                $recursosDisponibles = $lector->getCellByColumnAndRow(5,$fila)->getValue();
                if(trim($recursosDisponibles)==null || trim($recursosDisponibles)==''){
                    $error = $error.' | Recursos disponibles es obligatorio';
                }
                if (!is_numeric($recursosDisponibles)) {
                    throw new \Exception('Formato incorrecto');
                }
                if ($recursosDisponibles <= 0) {
                    throw new \Exception('Recursos disponibles es negativo');
                }
            } catch (\Exception $e) {
                $error = $error.' | Recursos disponibles formato incorrecto';
            }

            try {
                $fechaInicio      = $lector->getCellByColumnAndRow(6, $fila);
                $fechaInicioValue  = trim($fechaInicio->getFormattedValue());
                if ($fechaInicioValue === '') {
                    $error .= ' | Fecha inicio es obligatorio';
                } else {
                   if (! Carbon::hasFormat($fechaInicioValue, $format)) {
                        throw new \Exception("Formato debe ser $format");
                    }
                    $dt = Carbon::createFromFormat($format, $fechaInicioValue);
                    if ($dt->format($format) !== $fechaInicioValue) {
                        throw new \Exception('Fecha inválida');
                    }
                    $fechaInicio = $fechaInicioValue;
                }
            } catch (\Exception $e) {
                $fechaInicio ="";
                $error .= ' | Fecha inicio formato incorrecto: ' . $e->getMessage();
            }

            try {
                $fechaFin      = $lector->getCellByColumnAndRow(7, $fila);
                $fechaFinValue  = trim($fechaFin->getFormattedValue());
                if ($fechaFinValue === '') {
                    $error .= ' | Fecha fin es obligatorio';
                } else {
                   if (! Carbon::hasFormat($fechaFinValue, $format)) {
                        throw new \Exception("Formato debe ser $format");
                    }
                    $dt = Carbon::createFromFormat($format, $fechaFinValue);
                    if ($dt->format($format) !== $fechaFinValue) {
                        throw new \Exception('Fecha inválida');
                    }
                    $fechaFin = $fechaFinValue;
                }
            } catch (\Exception $e) {
                $fechaFin ="";
                $error .= ' | Fecha fin formato incorrecto: ' . $e->getMessage();
            }

            try {
                $precio = $lector->getCellByColumnAndRow(8,$fila)->getValue();
                if(trim($precio)==null || trim($precio)==''){
                    $error = $error.' | Precio es obligatorio';
                }
                if (!is_numeric($precio)) {
                    $error = $error.' | Formato incorrecto';
                }
                if ($precio <= 0) {
                    $error = $error.' | Precio es negativo';
                }
            } catch (\Exception $e) {
                $error = $error.' | Precio formato incorrecto';
            }

            try {
                $descuento = $lector->getCellByColumnAndRow(9,$fila)->getValue();
                if(trim($descuento)==null || trim($descuento)==''){
                    $error = $error.' | Descuento es obligatorio';
                }
                if (!is_numeric($descuento)) {
                    $error = $error.' | Formato incorrecto';
                }
                if ($descuento <= 0) {
                    $error = $error.' | Descuento es negativo';
                }
            } catch (\Exception $e) {
                $error = $error.' | Descuento formato incorrecto';
            }

            try {
                $resumen = $lector->getCellByColumnAndRow(10,$fila)->getValue();
            } catch (\Exception $e) {
                $error = $error.' | Resumen formato incorrecto';
            }

            try {
                $requisitos = $lector->getCellByColumnAndRow(11,$fila)->getValue();
            } catch (\Exception $e) {
                $error = $error.' | Requisitos formato incorrecto';
            }

            try {
                $objetivos = $lector->getCellByColumnAndRow(12,$fila)->getValue();
            } catch (\Exception $e) {
                $error = $error.' | Objetivos formato incorrecto';
            }

            try {
                $contenido = $lector->getCellByColumnAndRow(13,$fila)->getValue();
            } catch (\Exception $e) {
                $error = $error.' | Contenido formato incorrecto';
            }
            try {
                $idDocenteExterno = $lector->getCellByColumnAndRow(14,$fila)->getValue();
                if(trim($idDocenteExterno)==null || trim($idDocenteExterno)==''){
                    $error = $error.' | El ID externo del docente es obligatorio';
                }
                if (!is_numeric($idDocenteExterno)) {
                    $error = $error.' | Formato incorrecto';
                }
                if ($idDocenteExterno <= 0) {
                    $error = $error.' | El ID externo del docente es negativo';
                }
            } catch (\Exception $e) {
                $error = $error.' | El ID externo del docente formato incorrecto';
            }

            try {
                $nombreDocente = $lector->getCellByColumnAndRow(15,$fila)->getValue();
                if(trim($nombreDocente)==null || trim($nombreDocente)==''){
                    $error = $error.' | Nombre del docente es obligatorio';
                }
                if (strlen($nombreDocente) > 191) {
                    $error = $error.' | Nombre del docente alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Nombre del docente formato incorrecto';
            }

            try {
                $prefijoAcademico = $lector->getCellByColumnAndRow(16,$fila)->getValue();
                if(trim($prefijoAcademico)==null || trim($prefijoAcademico)==''){
                    $error = $error.' | Prefijo academico es obligatorio';
                }
                if (strlen($prefijoAcademico) > 191) {
                    $error = $error.' | Prefijo academico alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Prefijo academico formato incorrecto';
            }

            try {
                $profesion = $lector->getCellByColumnAndRow(17,$fila)->getValue();
                if(trim($profesion)==null || trim($profesion)==''){
                    $error = $error.' | Profesion es obligatorio';
                }
                if (strlen($profesion) > 191) {
                    $error = $error.' | Profesion alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Profesion formato incorrecto';
            }


            try {
                $biografia = $lector->getCellByColumnAndRow(18,$fila)->getValue();
            } catch (\Exception $e) {
                $error = $error.' | Biografia formato incorrecto';
            }


            try {
                $enlaceLinkedin = $lector->getCellByColumnAndRow(19,$fila)->getValue();
            } catch (\Exception $e) {
                $error = $error.' | Enlace linkedin formato incorrecto';
            }


            try {
                $nombreCategoria = $lector->getCellByColumnAndRow(20,$fila)->getValue();
                if(trim($nombreCategoria)==null || trim($nombreCategoria)==''){
                    $error = $error.' | Nombre categoria es obligatorio';
                }
                if (strlen($nombreCategoria) > 191) {
                    $error = $error.' | Nombre categoria alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Nombre categoria formato incorrecto';
            }


            try {
                $nombreSubcategoria = $lector->getCellByColumnAndRow(21,$fila)->getValue();
                if(trim($nombreSubcategoria)==null || trim($nombreSubcategoria)==''){
                    $error = $error.' | Nombre subcategoria es obligatorio';
                }
                if (strlen($nombreSubcategoria) > 191) {
                    $error = $error.' | Nombre subcategoria alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Nombre subcategoria formato incorrecto';
            }


            try {
                $modalidad = $lector->getCellByColumnAndRow(22,$fila)->getValue();
                if(trim($modalidad)==null || trim($modalidad)==''){
                    $error = $error.' | Modalidad es obligatorio';
                }
                if (strlen($modalidad) > 191) {
                    $error = $error.' | Modalidad alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Modalidad formato incorrecto';
            }


            try {
                $tipoCurso = $lector->getCellByColumnAndRow(23,$fila)->getValue();
                if(trim($tipoCurso)==null || trim($tipoCurso)==''){
                    $error = $error.' | Tipo de Curso es obligatorio';
                }
                if (strlen($tipoCurso) > 191) {
                    $error = $error.' | Tipo de Curso alcanzó el límite de caracteres';
                }
            } catch (\Exception $e) {
                $error = $error.' | Tipo de Curso formato incorrecto';
            }
            
            $array = [
                'idCursoExterno' => $idCursoExterno,
                'nombreCurso' => $nombreCurso,
                'orden' => $orden,
                'duracion' => $duracion,
                'recursosDisponibles' => $recursosDisponibles,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'precio' => $precio,
                'descuento' => $descuento,
                'resumen' => $resumen,
                'requisitos' => $requisitos,
                'objetivos' => $objetivos,
                'contenido' => $contenido,
                'idDocenteExterno' => $idDocenteExterno,
                'nombreDocente' => $nombreDocente,
                'prefijoAcademico' => $prefijoAcademico,
                'profesion' => $profesion,
                'biografia' => $biografia,
                'enlaceLinkedin' => $enlaceLinkedin,
                'nombreCategoria' => $nombreCategoria,
                'nombreSubcategoria' => $nombreSubcategoria,
                'modalidad' => $modalidad,
                'tipoCurso' => $tipoCurso,
                'error'=>$error
            ];
            array_push($datos,$array);

        }
        $datos = json_decode(json_encode($datos));
        $view = view('importar-curso.item-importar-curso',['datos'=>$datos]);
        return Response($view);
    }

    public function storeImportarCurso(Request $request)
    {     
        try {

            DB::beginTransaction();
            $idCursoExterno = $request->input('idCursoExterno');
            $nombreCurso = $request->input('nombreCurso');
            $orden = $request->input('orden');
            $duracion = $request->input('duracion');
            $recursosDisponibles = $request->input('recursosDisponibles');
            $fechaInicio = $request->input('fechaInicio');
            $fechaFin = $request->input('fechaFin');
            $precio = $request->input('precio');
            $descuento = $request->input('descuento');
            $resumen = $request->input('resumen');
            $requisitos = $request->input('requisitos');
            $objetivos = $request->input('objetivos');
            $contenido = $request->input('contenido');
            $idDocenteExterno = $request->input('idDocenteExterno');
            $nombreDocente = $request->input('nombreDocente');
            $prefijoAcademico = $request->input('prefijoAcademico');
            $profesion = $request->input('profesion');
            $biografia = $request->input('biografia');
            $enlaceLinkedin = $request->input('enlaceLinkedin');
            $nombreCategoria = $request->input('nombreCategoria');
            $nombreSubcategoria = $request->input('nombreSubcategoria');
            $modalidad = $request->input('modalidad');
            $tipoCurso = $request->input('tipoCurso');

            if($idCursoExterno!=null){
               
                for ($i=0; $i < count($idCursoExterno); $i++) { 
                    $idCategoriaCurso = CategoriaCurso::getOrCreateCategoriaPorNombre($nombreCategoria[$i]);
                    $idSubcategoriaCurso = SubcategoriaCurso::getOrCreateSubcategoriaPorNombre($nombreSubcategoria[$i],$idCategoriaCurso);
                    $idTipoCurso = TipoCurso::getOrCreateTipoCursoPorNombre($tipoCurso[$i]);
                    $idModalidad = Modalidad::getOrCreateModalidadPorNombre($modalidad[$i]);
                    $idDocente = Docente::getOrCreateDocentePorNombre($idDocenteExterno[$i],$nombreDocente[$i],$prefijoAcademico[$i],$profesion[$i],$biografia[$i],$enlaceLinkedin[$i]);
                    $idCurso = Curso::getOrCreateCursoPorNombre(
                        $idCursoExterno[$i],
                        $nombreCurso[$i],
                        $orden[$i],
                        $duracion[$i],
                        $recursosDisponibles[$i],
                        $fechaInicio[$i],
                        $fechaFin[$i],
                        $precio[$i],
                        $descuento[$i],
                        $resumen[$i],
                        $requisitos[$i],
                        $objetivos[$i],
                        $contenido[$i],
                        $idSubcategoriaCurso,
                        $idTipoCurso,
                        $idModalidad,
                        $idDocente
                    );
                }
                DB::commit();
                return response()->json(['success'=>true, 'message'=>'Cursos registrados correctamente']);
                
            }else{
                return response()->json(['success'=>false, 'message'=>'No hay cursos por registrar']);
            }



        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success'=>false, 'message'=>$e->getMessage().' '.$e->getFile()]);
        }
    }

}
