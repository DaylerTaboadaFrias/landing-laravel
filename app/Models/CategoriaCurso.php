<?php

namespace App\Models;

use DB;
use File;
use Carbon\Carbon;
use App\Models\Util;
use App\Models\CategoriaCurso;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CategoriaCurso extends Model
{
    protected $table = 'categoria_curso';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre', 'imagen', 'mostrar_inicio', 'orden', 'habilitado', 'eliminado'
    ];
    
    public static function getOrCreateCategoriaPorNombre($nombre)
    {
        $nombreNormalizado = Util::normalizarTexto($nombre);

        $categoria = DB::table('categoria_curso')
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

        if ($categoria) {
            return $categoria->id;
        }

        $categoria = CategoriaCurso::registrarCategoriaCurso($nombre, true, "", 0, true);

        return $categoria->id;
    }

    

    public static function obtenerCategoriasCursos()
    {
        $query = DB::table('categoria_curso')
            ->select(
                'categoria_curso.*'
            )
            ->where('categoria_curso.habilitado', true)
            ->where('categoria_curso.eliminado', false);

        return $query->orderBy('categoria_curso.orden', 'asc')->get();
    }

    public static function obtenerCategorias()
    {
        $query = DB::table('categoria_curso')
            ->select(
                'categoria_curso.*'
            )
            ->where('categoria_curso.mostrar_inicio', true)
            ->where('categoria_curso.habilitado', true)
            ->where('categoria_curso.eliminado', false);

        return $query->orderBy('categoria_curso.orden', 'asc')->get();
    }


    public static function getCategorias()
    {
        return CategoriaCurso::where('eliminado',false)->where('habilitado',true)->get();
    }

    public static function filtroCategoriaCurso($search)
    {
        $query = DB::table('categoria_curso')
            ->select(
                'categoria_curso.*'
            )
            ->where('categoria_curso.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('categoria_curso.id', $search)
                  ->orWhereRaw('LOWER(categoria_curso.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('categoria_curso.orden', 'asc')->get();
    }
    
    
 

    public static function registrarCategoriaCurso($nombre,$mostrar_inicio,$imagen,$orden,$habilitado)
    {
        $categoriaCurso = new CategoriaCurso();
        $categoriaCurso->nombre = $nombre;
        $categoriaCurso->mostrar_inicio = $mostrar_inicio;
        $categoriaCurso->orden = $orden;
        $categoriaCurso->habilitado = $habilitado;
        $categoriaCurso->eliminado = false;
        $categoriaCurso->imagen = '/img/categoriaCurso/categoria_sin_foto.png';
        $categoriaCurso->save();

        CategoriaCurso::actualizarImagenCategoriaCurso($imagen, $categoriaCurso->id);

        return $categoriaCurso;
    }

 

    public static function actualizarCategoriaCurso($id,$nombre,$mostrar_inicio,$imagen,$orden,$habilitado)
    {
        $categoriaCurso = CategoriaCurso::findOrFail($id);
        $categoriaCurso->nombre = $nombre;
        $categoriaCurso->mostrar_inicio = $mostrar_inicio;
        $categoriaCurso->orden = $orden;
        $categoriaCurso->habilitado = $habilitado;
        $categoriaCurso->update();

        CategoriaCurso::actualizarImagenCategoriaCurso($imagen, $categoriaCurso->id);

        return $categoriaCurso;
    }


    public static function eliminarCategoriaCurso($id)
    {
        $categoriaCurso = CategoriaCurso::findOrFail($id);
        $categoriaCurso->eliminado = true;
        $categoriaCurso->update();
        return $categoriaCurso;
    }

    public static function actualizarImagenCategoriaCurso($imagen, $id_categoria_curso)
    {
        if ($imagen != "") {
            $path = '/img/categoriaCurso/';
            $destination_path = public_path() . $path . $id_categoria_curso;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $categoriaCurso = CategoriaCurso::findOrFail($id_categoria_curso);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(100,100)
                ->save($filePath);

            $categoriaCurso->imagen = $path . $id_categoria_curso . '/' . $fileName;
            $categoriaCurso->update();

            return $categoriaCurso;
        }
    }

}
