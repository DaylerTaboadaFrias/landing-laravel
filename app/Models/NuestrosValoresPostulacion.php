<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class NuestrosValoresPostulacion extends Model
{
    protected $table = 'nuestros_valores_postulacion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'orden', 'habilitado', 'eliminado'
    ];
    
    public static function obtenerValoresPostulacion()
    {
        $query = DB::table('nuestros_valores_postulacion')
            ->select(
                'nuestros_valores_postulacion.*'
            )
            ->where('nuestros_valores_postulacion.habilitado', true)
            ->where('nuestros_valores_postulacion.eliminado', false);

        return $query->orderBy('nuestros_valores_postulacion.orden', 'asc')->get();
    }
    
    public static function getTiposCurso()
    {
        return NuestrosValoresPostulacion::where('habilitado',true)->get();
    }

    public static function filtroNuestrosValoresPostulacion($search)
    {
        $query = DB::table('nuestros_valores_postulacion')
            ->select(
                'nuestros_valores_postulacion.*'
            )
            ->where('nuestros_valores_postulacion.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nuestros_valores_postulacion.id', $search)
                  ->orWhereRaw('LOWER(nuestros_valores_postulacion.titulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('nuestros_valores_postulacion.orden', 'asc')->get();
    }
    
    
 

    public static function registrarNuestrosValoresPostulacion($titulo,$orden,$habilitado)
    {
        $nuestrosValores = new NuestrosValoresPostulacion();
        $nuestrosValores->titulo = $titulo;
        $nuestrosValores->orden = $orden;
        $nuestrosValores->habilitado = $habilitado;
        $nuestrosValores->eliminado = false;
        $nuestrosValores->save();

        return $nuestrosValores;
    }

 

    public static function actualizarNuestrosValoresPostulacion($id,$titulo,$orden,$habilitado)
    {
        $nuestrosValores = NuestrosValoresPostulacion::findOrFail($id);
        $nuestrosValores->titulo = $titulo;
        $nuestrosValores->orden = $orden;
        $nuestrosValores->habilitado = $habilitado;
        $nuestrosValores->update();

        return $nuestrosValores;
    }


    public static function eliminarNuestrosValoresPostulacion($id)
    {
        $nuestrosValores = NuestrosValoresPostulacion::findOrFail($id);
        $nuestrosValores->eliminado = true;
        $nuestrosValores->update();
        return $nuestrosValores;
    }

}
