<?php

namespace App\Models;

use DB;
use File;
use Carbon\Carbon;
use App\Models\Util;
use App\Models\TipoCurso;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoCurso extends Model
{
    protected $table = 'tipo_curso';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function getOrCreateTipoCursoPorNombre($nombre)
    {
        $nombreNormalizado = Util::normalizarTexto($nombre);

        $tipoCurso = DB::table('tipo_curso')
            ->where('eliminado', false)
            ->whereRaw("
                LOWER(
                    REPLACE(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(
                                        REPLACE(
                                            REPLACE(
                                                REPLACE(
                                                    REPLACE(
                                                        REPLACE(
                                                            REPLACE(
                                                                REPLACE(nombre, 'á', 'a'),
                                                                'é', 'e'
                                                            ), 'í', 'i'
                                                        ), 'ó', 'o'
                                                    ), 'ú', 'u'
                                                ), 'Á', 'a'
                                            ), 'É', 'e'
                                        ), 'Í', 'i'
                                    ), 'Ó', 'o'
                                ), 'Ú', 'u'
                            ), 'ñ', 'n'
                        ), 'Ñ', 'n'
                    )
                ) = ?
            ", [$nombreNormalizado])
            ->first();

        if ($tipoCurso) {
            return $tipoCurso->id;
        }

        $tipoCurso = TipoCurso::registrarTipoCurso($nombre, 0, true);

        return $tipoCurso->id;
    }

    
    public static function obtenerTiposCursos()
    {
        $query = DB::table('tipo_curso')
            ->select(
                'tipo_curso.*'
            )
            ->where('tipo_curso.habilitado', true)
            ->where('tipo_curso.eliminado', false);

        return $query->orderBy('tipo_curso.orden', 'asc')->get();
    }

    public static function getTiposCurso()
    {
        return TipoCurso::where('eliminado',false)->where('habilitado',true)->get();
    }

    public static function filtroTipoCurso($search)
    {
        $query = DB::table('tipo_curso')
            ->select(
                'tipo_curso.*'
            )
            ->where('tipo_curso.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('tipo_curso.id', $search)
                  ->orWhereRaw('LOWER(tipo_curso.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('tipo_curso.id', 'desc')->get();
    }
    
    
 

    public static function registrarTipoCurso($nombre,$orden,$habilitado)
    {
        $tipoCurso = new TipoCurso();
        $tipoCurso->nombre = $nombre;
        $tipoCurso->orden = $orden;
        $tipoCurso->habilitado = $habilitado;
        $tipoCurso->eliminado = false;
        $tipoCurso->save();

        return $tipoCurso;
    }

 

    public static function actualizarTipoCurso($id,$nombre,$orden,$habilitado)
    {
        $tipoCurso = TipoCurso::findOrFail($id);
        $tipoCurso->nombre = $nombre;
        $tipoCurso->orden = $orden;
        $tipoCurso->habilitado = $habilitado;
        $tipoCurso->update();

        return $tipoCurso;
    }


    public static function eliminarTipoCurso($id)
    {
        $tipoCurso = TipoCurso::findOrFail($id);
        $tipoCurso->eliminado = true;
        $tipoCurso->update();
        return $tipoCurso;
    }

}
