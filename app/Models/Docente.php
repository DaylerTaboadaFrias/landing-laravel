<?php

namespace App\Models;

use DB;
use File;
use Carbon\Carbon;
use App\Models\Docente;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Docente extends Model
{
    protected $table = 'docente';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre_completo','prefijo_academico','profesion', 'biografia', 'enlace_linkedin', 'imagen', 'habilitado', 'eliminado'
    ];
    

    public static function getOrCreateDocentePorNombre($idDocenteExterno,$nombre,$prefijoAcademico,$profesion,$biografia,$enlaceLinkedin)
    {

        $docente = DB::table('docente')
            ->where('eliminado', false)
            ->where('id_docente_externo', $idDocenteExterno)
            ->first();

        if ($docente) {
            $docente = Docente::actualizarDocente($docente->id,$idDocenteExterno,$nombre,$prefijoAcademico,$profesion,$biografia,$enlaceLinkedin,"",true);
            return $docente->id;
        }

        $docente = Docente::registrarDocente($idDocenteExterno,$nombre,$prefijoAcademico,$profesion,$biografia,$enlaceLinkedin,"",true);
        return $docente->id;
    }

    
    public static function getCursoPorIdDocenteExterno($idDocenteExterno)
    {
        return DB::table('docente')
            ->where('id', $idDocenteExterno)
            ->where('eliminado', false)
            ->first();
    }

    public static function getDocentes()
    {
        return Docente::where('eliminado',false)->where('habilitado',true)->get();
    }

    public static function filtroDocente($search)
    {
        $query = DB::table('docente')
            ->select(
                'docente.*'
            )
            ->where('docente.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('docente.id', $search)
                  ->orWhereRaw('LOWER(docente.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('docente.id', 'desc')->get();
    }
    
    
 

    public static function registrarDocente($id_docente_externo,$nombre_completo,$prefijo_academico,$profesion,$biografia,$enlace_linkedin,$imagen,$habilitado)
    {
        $docente = new Docente();
        $docente->id_docente_externo = $id_docente_externo;
        $docente->nombre_completo = $nombre_completo;
        $docente->prefijo_academico = $prefijo_academico;
        $docente->profesion = $profesion;
        $docente->biografia = $biografia;
        $docente->enlace_linkedin = $enlace_linkedin;
        $docente->habilitado = $habilitado;
        $docente->eliminado = false;
        $docente->imagen = '/img/docente/docente_sin_foto.png';
        $docente->save();

        Docente::actualizarImagenDocente($imagen, $docente->id);

        return $docente;
    }

 

    public static function actualizarDocente($id,$id_docente_externo,$nombre_completo,$prefijo_academico,$profesion,$biografia,$enlace_linkedin,$imagen,$habilitado)
    {
        $docente = Docente::findOrFail($id);
        $docente->id_docente_externo = $id_docente_externo;
        $docente->nombre_completo = $nombre_completo;
        $docente->prefijo_academico = $prefijo_academico;
        $docente->profesion = $profesion;
        $docente->biografia = $biografia;
        $docente->enlace_linkedin = $enlace_linkedin;
        $docente->habilitado = $habilitado;
        $docente->update();
        
        Docente::actualizarImagenDocente($imagen, $docente->id);

        return $docente;
    }


    public static function eliminarDocente($id)
    {
        $docente = Docente::findOrFail($id);
        $docente->eliminado = true;
        $docente->update();
        return $docente;
    }

    public static function actualizarImagenDocente($imagen, $id_docente)
    {
        if ($imagen != "") {
            $path = '/img/docente/';
            $destination_path = public_path() . $path . $id_docente;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $docente = Docente::findOrFail($id_docente);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(400,400)
                ->save($filePath);

            $docente->imagen = $path . $id_docente . '/' . $fileName;
            $docente->update();

            return $docente;
        }
    }

}
