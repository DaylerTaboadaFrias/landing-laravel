<?php

namespace App\Models;

use DB;
use File;
use Carbon\Carbon;
use App\Models\Curso;
use App\Models\Suscripcion;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;

class Curso extends Model
{
    public $table = 'curso';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'id_curso_externo',
        'nombre',
        'duracion',
        'recursos_disponibles',
        'fecha_inicio',
        'fecha_fin',
        'precio',
        'precio_descuento',
        'descuento',
        'resumen',
        'requisitos',
        'objetivos',
        'contenido',
        'archivo',
        'imagen',
        'curso_popular',
        'curso_ideal',
        'notificar_suscriptores',
        'habilitado',
        'eliminado',
        'id_subcategoria_curso',
        'id_modalidad',
        'id_tipo_curso'
    ];
    protected $casts = [
      'precio' => 'float',
      'descuento' => 'float',
      'precio_descuento' => 'float',
    ];

    public static function getOrCreateCursoPorNombre($idCursoExterno,$nombreCurso,$orden,$duracion,$recursosDisponibles,$fechaInicio,$fechaFin,$precio,$descuento,$resumen,$requisitos,$objetivos,$contenido,$idSubcategoriaCurso,$idTipoCurso,$idModalidad,$idDocente)
    {
        $curso = DB::table('curso')
            ->where('eliminado', false)
            ->where('id_curso_externo', $idCursoExterno)
            ->first();
        if ($curso) {
            $curso = Curso::actualizarCurso($curso->id,$idCursoExterno,$nombreCurso,$orden,$duracion,$recursosDisponibles,$fechaInicio,$fechaFin,$precio,$descuento,$resumen,$requisitos,$objetivos,$contenido,"","",false,false,false,true,$idDocente,$idSubcategoriaCurso,$idModalidad,$idTipoCurso);
            return $curso->id;
        }

        $curso = Curso::registrarCurso($idCursoExterno,$nombreCurso,$orden,$duracion,$recursosDisponibles,$fechaInicio,$fechaFin,$precio,$descuento,$resumen,$requisitos,$objetivos,$contenido,"","",false,false,false,true,$idDocente,$idSubcategoriaCurso,$idModalidad,$idTipoCurso);
        return $curso->id;
    }


    public static function obtenerCursosRelacionados($id_subcategoria_curso, $id_curso)
    {
        $query = DB::table('curso')
            ->join('docente', 'curso.id_docente', '=', 'docente.id')
            ->join('subcategoria_curso', 'curso.id_subcategoria_curso', '=', 'subcategoria_curso.id')
            ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
            ->join('tipo_curso', 'curso.id_tipo_curso', '=', 'tipo_curso.id')
            ->select(
                'curso.*',
                'docente.prefijo_academico as prefijo_academico_docente',
                'docente.nombre_completo as nombre_docente',
                'subcategoria_curso.nombre as nombre_subcategoria',
                'modalidad.nombre as nombre_modalidad',
                'tipo_curso.nombre as nombre_tipo_curso'
            )
            ->where('curso.eliminado', false)
            ->where('curso.habilitado', true)
            ->where('curso.id_subcategoria_curso', $id_subcategoria_curso)
            ->where('curso.id', '<>', $id_curso)
            ->orderBy('curso.orden', 'asc')
            ->get();

        foreach ($query as $curso) {
            $curso->rango_fechas = self::formatearRangoFechas($curso->fecha_inicio, $curso->fecha_fin);
        }

        return $query;
    }
    
    
    public static function obtenerCurso($id)
    {
        $curso = DB::table('curso')
        ->join('docente', 'curso.id_docente', '=', 'docente.id')
        ->join('subcategoria_curso', 'curso.id_subcategoria_curso', '=', 'subcategoria_curso.id')
        ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
        ->join('tipo_curso', 'curso.id_tipo_curso', '=', 'tipo_curso.id')
        ->select(
            'curso.*',
            'docente.prefijo_academico as prefijo_academico_docente',
            'docente.nombre_completo as nombre_docente',
            'docente.profesion as profesion_docente',
            'docente.imagen as imagen_docente',
            'docente.biografia as biografia_docente',
            'docente.enlace_linkedin as enlace_linkedin_docente',
            'subcategoria_curso.nombre as nombre_subcategoria',
            'modalidad.nombre as nombre_modalidad',
            'tipo_curso.nombre as nombre_tipo_curso'
        )
        ->where('curso.id', $id)
        ->where('curso.eliminado', false)
        ->first();
        Carbon::setLocale('es');

        $inicio = Carbon::parse($curso->fecha_inicio);
        $fin = Carbon::parse($curso->fecha_fin);

        if ($inicio->month === $fin->month && $inicio->year === $fin->year) {
            $curso->rango_fechas = "Del {$inicio->day} al {$fin->day} de {$fin->translatedFormat('F')} de {$fin->year}";
        } elseif ($inicio->year === $fin->year) {
            $curso->rango_fechas = "Del {$inicio->day} de {$inicio->translatedFormat('F')} al {$fin->day} de {$fin->translatedFormat('F')} de {$fin->year}";
        } else {
            $curso->rango_fechas = "Del {$inicio->day} de {$inicio->translatedFormat('F')} de {$inicio->year} al {$fin->day} de {$fin->translatedFormat('F')} de {$fin->year}";
        }
        return $curso;
    }

    public static function obtenerCursosPorNombre($nombre)
    {
        $query = DB::table('curso')
            ->select(
                'curso.id',
                'curso.nombre'
            )
            ->where('curso.habilitado', true)
            ->where('curso.eliminado', false);

        if (!empty($nombre)) {
            $query->where('curso.nombre', 'like', '%' . $nombre . '%');
        }

        return $query->get();
    }



    public static function obtenerCursos($id_categoria,$subcategorias, $meses_anios, $modalidades, $tipos, $ordenar, $minimo = null, $maximo = null, $por_pagina = 10)
    {
        $query = DB::table('curso')
            ->join('docente', 'curso.id_docente', '=', 'docente.id')
            ->join('subcategoria_curso', 'curso.id_subcategoria_curso', '=', 'subcategoria_curso.id')
            ->join('categoria_curso', 'subcategoria_curso.id_categoria_curso', '=', 'categoria_curso.id')
            ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
            ->join('tipo_curso', 'curso.id_tipo_curso', '=', 'tipo_curso.id')
            ->select(
                'curso.*',
                'docente.prefijo_academico as prefijo_academico_docente',
                'docente.nombre_completo as nombre_docente',
                'subcategoria_curso.nombre as nombre_subcategoria',
                'modalidad.nombre as nombre_modalidad',
                'tipo_curso.nombre as nombre_tipo_curso'
            )
            ->where('curso.habilitado', true)
            ->where('curso.eliminado', false);

        if ($id_categoria!=0) {
            $query->where('categoria_curso.id', $id_categoria);
        }

        if (!empty($subcategorias)) {
            $query->whereIn('curso.id_subcategoria_curso', $subcategorias);
        }

        if (!empty($meses_anios)) {
            $query->where(function ($q) use ($meses_anios) {
                foreach ($meses_anios as $pair) {
                    $q->orWhere(function ($subQuery) use ($pair) {
                        $subQuery->whereMonth('curso.fecha_inicio', $pair['mes'])
                                ->whereYear('curso.fecha_inicio', $pair['anio']);
                    });
                }
            });
        }

        if (!empty($modalidades)) {
            $query->whereIn('curso.id_modalidad', $modalidades);
        }

        if (!empty($tipos)) {
            $query->whereIn('curso.id_tipo_curso', $tipos);
        }

        if (!is_null($minimo)) {
            $query->where('curso.precio_descuento', '>=', $minimo);
        } 
        if (!is_null($maximo)) {
            $query->where('curso.precio_descuento', '<=', $maximo);
        }

        switch ($ordenar) {
            case 1:
                $query->orderBy('curso.nombre', 'asc');
                break;
            case 2:
                $query->orderBy('curso.nombre', 'desc');
                break;
            case 3:
                $query->orderBy('curso.precio_descuento', 'asc');
                break;
            case 4:
                $query->orderBy('curso.precio_descuento', 'desc');
                break;
            default:
                $query->orderBy('curso.id', 'desc');
                break;
        }

        $query = $query->paginate($por_pagina);

        foreach ($query as $curso) {
            $curso->rango_fechas = self::formatearRangoFechas($curso->fecha_inicio, $curso->fecha_fin);
        }

        return $query;
    }


    public static function obtenerCursosCalendario($mes,$anio)
    {
        $query = DB::table('curso')
        ->join('docente', 'curso.id_docente', '=', 'docente.id')
        ->join('subcategoria_curso', 'curso.id_subcategoria_curso', '=', 'subcategoria_curso.id')
        ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
        ->join('tipo_curso', 'curso.id_tipo_curso', '=', 'tipo_curso.id')
        ->select(
            'curso.*',
            'docente.prefijo_academico as prefijo_academico_docente',
            'docente.nombre_completo as nombre_docente',
            'subcategoria_curso.nombre as nombre_subcategoria',
            'modalidad.nombre as nombre_modalidad',
            'tipo_curso.nombre as nombre_tipo_curso'
        )
        ->where('curso.eliminado', false)
        ->whereMonth('curso.fecha_inicio', $mes)
        ->whereYear('curso.fecha_inicio', $anio)
        ->orderBy('curso.id', 'desc')
        ->get();

        foreach ($query as $curso) {
            $curso->rango_fechas = self::formatearRangoFechas($curso->fecha_inicio, $curso->fecha_fin);
        }

        return $query;
    }

    public static function obtenerCursosPopulares()
    {
        $query = DB::table('curso')
            ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
            ->select(
                'curso.id',
                'curso.nombre',
                'curso.recursos_disponibles',
                'curso.fecha_inicio',
                'curso.fecha_fin',
                'curso.precio',
                'curso.descuento',
                'curso.precio_descuento',
                'curso.imagen',
                'curso.curso_popular',
                'curso.habilitado',
                'modalidad.nombre as nombre_modalidad',
            )
            ->where('curso.habilitado', true)
            ->where('curso.curso_popular', true)
            ->where('curso.eliminado', false)
            ->orderBy('curso.orden', 'asc')
            ->get();


        foreach ($query as $curso) {
            $curso->rango_fechas = self::formatearRangoFechas($curso->fecha_inicio, $curso->fecha_fin);
        }

        return $query;
    }



    public static function obtenerCursosIdeales()
    {
        $query = DB::table('curso')
            ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
            ->join('docente', 'curso.id_docente', '=', 'docente.id')
            ->select(
                'curso.id',
                'curso.nombre',
                'curso.recursos_disponibles',
                'curso.fecha_inicio',
                'curso.fecha_fin',
                'curso.precio',
                'curso.descuento',
                'curso.precio_descuento',
                'curso.imagen',
                'curso.curso_popular',
                'curso.habilitado',
                'modalidad.nombre as nombre_modalidad',
                'docente.prefijo_academico as prefijo_academico_docente',
                'docente.nombre_completo as nombre_docente',
            )
            ->where('curso.habilitado', true)
            ->where('curso.curso_ideal', true)
            ->where('curso.eliminado', false)
            ->orderBy('curso.orden', 'asc')
            ->get();


        foreach ($query as $curso) {
            $curso->rango_fechas = self::formatearRangoFechas($curso->fecha_inicio, $curso->fecha_fin);
        }

        return $query;
    }



    public static function filtroCurso($search)
    {
        $query = DB::table('curso')
            ->join('docente', 'curso.id_docente', '=', 'docente.id')
            ->join('subcategoria_curso', 'curso.id_subcategoria_curso', '=', 'subcategoria_curso.id')
            ->join('modalidad', 'curso.id_modalidad', '=', 'modalidad.id')
            ->join('tipo_curso', 'curso.id_tipo_curso', '=', 'tipo_curso.id')
            ->select(
                'curso.id',
                'curso.nombre',
                'curso.duracion',
                'curso.recursos_disponibles',
                'curso.fecha_inicio',
                'curso.fecha_fin',
                'curso.precio',
                'curso.descuento',
                'curso.resumen',
                'curso.requisitos',
                'curso.objetivos',
                'curso.contenido',
                'curso.archivo',
                'curso.imagen',
                'curso.curso_popular',
                'curso.curso_ideal',
                'curso.notificar_suscriptores',
                'curso.habilitado',
                'docente.nombre_completo as nombre_docente',
                'subcategoria_curso.nombre as nombre_subcategoria',
                'modalidad.nombre as nombre_modalidad',
                'tipo_curso.nombre as nombre_tipo_curso'
            )
            ->where('curso.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('curso.id', $search)
                  ->orWhereRaw('LOWER(curso.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('curso.id', 'desc')->get();
    }

    public static function formatearRangoFechas($inicio, $fin)
    {
        Carbon::setLocale('es');
    
        $inicio = Carbon::parse($inicio);
        $fin = Carbon::parse($fin);
    
        if ($inicio->month === $fin->month && $inicio->year === $fin->year) {
            return "Del {$inicio->day} al {$fin->day} de {$fin->translatedFormat('F')} de {$fin->year}";
        } elseif ($inicio->year === $fin->year) {
            return "Del {$inicio->day} de {$inicio->translatedFormat('F')} al {$fin->day} de {$fin->translatedFormat('F')} de {$fin->year}";
        } else {
            return "Del {$inicio->day} de {$inicio->translatedFormat('F')} de {$inicio->year} al {$fin->day} de {$fin->translatedFormat('F')} de {$fin->year}";
        }
    }

    public static function registrarCurso($id_curso_externo,$nombre, $orden,$duracion, $recursos_disponibles, $fecha_inicio, $fecha_fin, $precio, $descuento, $resumen, $requisitos, $objetivos, $contenido, $archivo, $imagen, $curso_popular, $curso_ideal, $notificar_suscriptores, $habilitado, $id_docente, $id_subcategoria_curso, $id_modalidad, $id_tipo_curso)
    {
        $curso_notificar = Curso::where('eliminado',false)->where('notificar_suscriptores',true)->first();
        if($curso_notificar){
            throw new \Exception('No puede notificar este curso a sus suscriptores. Por que ya existe un curso por notificar con ID '.$curso_notificar->id);
        }

        $curso = new Curso;
        $curso->id_curso_externo = $id_curso_externo;
        $curso->nombre = $nombre;
        $curso->orden = $orden;
        $curso->duracion = $duracion;
        $curso->recursos_disponibles = $recursos_disponibles;
        $curso->fecha_inicio = $fecha_inicio;
        $curso->fecha_fin = $fecha_fin;
        $curso->precio = $precio;
        $curso->precio_descuento = $precio*(1-($descuento/100));
        $curso->descuento = $descuento;
        $curso->resumen = $resumen;
        $curso->requisitos = $requisitos;
        $curso->objetivos = $objetivos;
        $curso->contenido = $contenido;
        $curso->curso_popular = $curso_popular;
        $curso->curso_ideal = $curso_ideal;
        $curso->notificar_suscriptores = $notificar_suscriptores;
        $curso->habilitado = $habilitado;
        $curso->id_docente = $id_docente;
        $curso->id_subcategoria_curso = $id_subcategoria_curso;
        $curso->id_modalidad = $id_modalidad;
        $curso->id_tipo_curso = $id_tipo_curso;
        $curso->imagen = '/img/cursos/curso_sin_foto.png';
        $curso->eliminado = false;
        $curso->save();

        Curso::actualizarImagenCurso($imagen,$curso->id);
        Curso::actualizarArchivoCurso($archivo,$curso->id);

        if($curso->notificar_suscriptores){
            Suscripcion::registrarColaEnvioCorreoMasivo($curso->id);
        }
        return $curso;
    }

    public static function actualizarCurso($id, $id_curso_externo, $nombre, $orden,$duracion, $recursos_disponibles, $fecha_inicio, $fecha_fin, $precio, $descuento, $resumen, $requisitos, $objetivos, $contenido, $archivo, $imagen, $curso_popular, $curso_ideal, $notificar_suscriptores, $habilitado, $id_docente, $id_subcategoria_curso, $id_modalidad, $id_tipo_curso)
    {

        if($notificar_suscriptores){
            $curso_notificar = Curso::where('eliminado',false)->where('notificar_suscriptores',true)->where('id','<>',$id)->first();
            if($curso_notificar){
                throw new \Exception('No puede notificar este curso a sus suscriptores. Por que ya existe un curso por notificar con ID '.$curso_notificar->id);
            }            
        }


        $curso = Curso::findOrFail($id);

        $notificado = $curso->notificar_suscriptores;


        $curso->id_curso_externo = $id_curso_externo;
        $curso->nombre = $nombre;
        $curso->orden = $orden;
        $curso->duracion = $duracion;
        $curso->recursos_disponibles = $recursos_disponibles;
        $curso->fecha_inicio = $fecha_inicio;
        $curso->fecha_fin = $fecha_fin;
        $curso->precio = $precio;
        $curso->precio_descuento = $precio*(1-($descuento/100));
        $curso->descuento = $descuento;
        $curso->resumen = $resumen;
        $curso->requisitos = $requisitos;
        $curso->objetivos = $objetivos;
        $curso->contenido = $contenido;
        $curso->curso_popular = $curso_popular;
        $curso->curso_ideal = $curso_ideal;
        $curso->notificar_suscriptores = $notificar_suscriptores;
        $curso->habilitado = $habilitado;
        $curso->id_docente = $id_docente;
        $curso->id_subcategoria_curso = $id_subcategoria_curso;
        $curso->id_modalidad = $id_modalidad;
        $curso->id_tipo_curso = $id_tipo_curso;
        $curso->save();

        Curso::actualizarImagenCurso($imagen,$curso->id);
        Curso::actualizarArchivoCurso($archivo,$curso->id);


 
        if( ($notificado != $curso->notificar_suscriptores) && $curso->notificar_suscriptores  ){
            Suscripcion::registrarColaEnvioCorreoMasivo($curso->id);
        }
        return $curso;
    }

    public static function eliminarCurso($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->eliminado = true;
        $curso->save();

        return $curso;
    }

    public static function actualizarImagenCurso($imagen, $id_curso)
    {
        if ($imagen != '') {
            $path = '/img/curso/';
            $destination_path = public_path() . $path . $id_curso;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $curso = Curso::findOrFail($id_curso);
            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(490, 218)
                ->save($filePath);

            $curso->imagen = $path . $id_curso . '/' . $fileName;
            $curso->update();
        }
    }

    public static function actualizarArchivoCurso($archivo, $id_curso)
    {
        if ($archivo != "") {
            $path = '/files/curso/';
            $destination_path = public_path() . $path . $id_curso;
            
            File::makeDirectory($destination_path, 0777, true, true);
            $curso = Curso::findOrFail($id_curso);
    
            // Si el archivo es una cadena Base64
            if (is_string($archivo) && strpos($archivo, 'data:') === 0) {
                list($type, $fileData) = explode(';', $archivo);
                list(, $fileData) = explode(',', $fileData);
                $fileData = base64_decode($fileData);
    
                // Determinar extensión
                $ext = explode('/', mime_content_type($archivo))[1];
                $fileName = 'archivo_' . uniqid() . '.' . $ext;
    
                file_put_contents($destination_path . '/' . $fileName, $fileData);
            } else { 
                // Si el archivo es un `UploadedFile`
                $fileName = 'archivo_' . uniqid() . '.' . pathinfo($archivo->getClientOriginalName(), PATHINFO_EXTENSION);
                $archivo->move($destination_path, $fileName);
            }
    
            // Guardar en la base de datos
            $curso->archivo = $path . $id_curso . '/' . $fileName;
            $curso->update();
        }
    }
}
