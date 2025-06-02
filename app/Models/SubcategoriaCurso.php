<?php

namespace App\Models;

use DB;
use App\Models\Util;
use App\Models\SubcategoriaCurso;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class SubcategoriaCurso extends Model
{
    public $table = 'subcategoria_curso';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre',
        'orden',
        'habilitado',
        'eliminado',
        'id_categoria_curso'
    ];

    public static function getOrCreateSubcategoriaPorNombre($nombre, $idCategoriaCurso)
    {
        $nombreNormalizado = Util::normalizarTexto($nombre);

        $subcategoria = DB::table('subcategoria_curso')
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
        if ($subcategoria) {
            return $subcategoria->id;
        }

        $subcategoria = SubcategoriaCurso::registrarSubcategoriaCurso($nombre, true, 0, $idCategoriaCurso);

        return $subcategoria->id;
    }

    public static function obtenerSubcategorias($idCategoria)
    {
        if ($idCategoria!=0) {
            $query = DB::table('subcategoria_curso')
            ->select(
                'subcategoria_curso.id',
                'subcategoria_curso.nombre',
                'subcategoria_curso.orden',
                'subcategoria_curso.habilitado',
            )
            ->where('subcategoria_curso.eliminado', false)
            ->where('subcategoria_curso.id_categoria_curso','=', $idCategoria);
            return $query->orderBy('subcategoria_curso.orden', 'asc')->get();
        }
        return [];
    }


    public static function getSubategorias()
    {
        return SubcategoriaCurso::where('eliminado',false)->where('habilitado',true)->orderBy('subcategoria_curso.orden', 'asc')->get();
    }


    public static function filtroSubcategoriaCurso($search)
    {
        $query = DB::table('subcategoria_curso')
            ->join('categoria_curso', 'subcategoria_curso.id_categoria_curso', '=', 'categoria_curso.id')
            ->select(
                'subcategoria_curso.id',
                'subcategoria_curso.nombre',
                'subcategoria_curso.orden',
                'subcategoria_curso.habilitado',
                'categoria_curso.nombre as nombre_categoria_curso'
            )
            ->where('subcategoria_curso.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('subcategoria_curso.id', $search)
                  ->orWhereRaw('LOWER(subcategoria_curso.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('subcategoria_curso.orden', 'asc')->get();
    }


    public static function registrarSubcategoriaCurso($nombre,$habilitado,$orden,$id_categoria_curso)
    {
        $subategoriaCurso = new SubcategoriaCurso;
        $subategoriaCurso->nombre = $nombre;
        $subategoriaCurso->habilitado = $habilitado;
        $subategoriaCurso->orden = $orden;
        $subategoriaCurso->id_categoria_curso = $id_categoria_curso;
        $subategoriaCurso->eliminado = false;
        $subategoriaCurso->save();

        return $subategoriaCurso;
    }

    public static function actualizarSubcategoriaCurso($id,$nombre,$habilitado,$orden,$id_categoria_curso)
    {
        $subategoriaCurso = SubcategoriaCurso::findOrFail($id);
        $subategoriaCurso->nombre = $nombre;
        $subategoriaCurso->habilitado = $habilitado;
        $subategoriaCurso->orden = $orden;
        $subategoriaCurso->id_categoria_curso = $id_categoria_curso;
        $subategoriaCurso->save();

        return $subategoriaCurso;
    }


    public static function eliminarSubcategoriaCurso($id)
    {
        $subategoriaCurso = SubcategoriaCurso::findOrFail($id);
        $subategoriaCurso->eliminado = true;
        $subategoriaCurso->save();

        return $subategoriaCurso;
    }

}
