<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class EncuentraCursoIdeal extends Model
{
    protected $table = 'encuentra_curso_ideal';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'subtitulo', 'titulo_enlace', 'enlace', 'imagen'
    ];
    



    public static function obtenerEncuentraCursoIdeal()
    {
        $encuentraCurso = EncuentraCursoIdeal::first();
        return $encuentraCurso;
    }

    public static function filtroEncuentraCursoIdeal($search)
    {
        $query = DB::table('encuentra_curso_ideal')
            ->select(
                'encuentra_curso_ideal.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('encuentra_curso_ideal.id', $search)
                  ->orWhereRaw('LOWER(encuentra_curso_ideal.titulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('encuentra_curso_ideal.id', 'desc')->get();
    }
    
    

    public static function actualizarEncuentraCursoIdeal($id,$titulo,$subtitulo,$titulo_enlace,$enlace,$imagen)
    {
        $encuentraCurso = EncuentraCursoIdeal::findOrFail($id);
        $encuentraCurso->titulo = $titulo;
        $encuentraCurso->subtitulo = $subtitulo;
        $encuentraCurso->titulo_enlace = $titulo_enlace;
        $encuentraCurso->enlace = $enlace;
        $encuentraCurso->update();

        EncuentraCursoIdeal::actualizarImagenEncuentraCursoIdeal($imagen, $encuentraCurso->id);

        return $encuentraCurso;
    }


    public static function actualizarImagenEncuentraCursoIdeal($imagen, $id_encuentra_curso)
    {
        if ($imagen != "") {
            $path = '/img/encuentraCursoIdeal/';
            $destination_path = public_path() . $path . $id_encuentra_curso;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $encuentraCurso = EncuentraCursoIdeal::findOrFail($id_encuentra_curso);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(425,434)
                ->save($filePath);

            $encuentraCurso->imagen = $path . $id_encuentra_curso . '/' . $fileName;
            $encuentraCurso->update();

            return $encuentraCurso;
        }
    }

}
