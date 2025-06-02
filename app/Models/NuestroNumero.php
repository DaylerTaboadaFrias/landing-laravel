<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use File;

class NuestroNumero extends Model
{
    protected $table = 'nuestro_numero';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'subtitulo', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function obtenerNuestrosNumeros()
    {
        $query = DB::table('nuestro_numero')
            ->select(
                'nuestro_numero.*'
            )
            ->where('nuestro_numero.habilitado', true)
            ->where('nuestro_numero.eliminado', false);

        return $query->orderBy('nuestro_numero.orden', 'asc')->get();
    }


    public static function filtroNuestroNumero($search)
    {
        $query = DB::table('nuestro_numero')
            ->select(
                'nuestro_numero.*'
            )
            ->where('nuestro_numero.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nuestro_numero.id', $search)
                  ->orWhereRaw('LOWER(nuestro_numero.titulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('nuestro_numero.orden', 'asc')->get();
    }
    
 

    public static function registrarNuestroNumero($titulo,$subtitulo,$orden,$habilitado)
    {
        $nuestroNumero = new NuestroNumero();
        $nuestroNumero->titulo = $titulo;
        $nuestroNumero->subtitulo = $subtitulo;
        $nuestroNumero->orden = $orden;
        $nuestroNumero->habilitado = $habilitado;
        $nuestroNumero->eliminado = false;
        $nuestroNumero->save();
        return $nuestroNumero;
    }

 

    public static function actualizarNuestroNumero($id,$titulo,$subtitulo,$orden,$habilitado)
    {
        $nuestroNumero = NuestroNumero::findOrFail($id);
        $nuestroNumero->titulo = $titulo;
        $nuestroNumero->subtitulo = $subtitulo;
        $nuestroNumero->orden = $orden;
        $nuestroNumero->habilitado = $habilitado;
        $nuestroNumero->update();

        return $nuestroNumero;
    }


    public static function eliminarNuestroNumero($id)
    {
        $nuestroNumero = NuestroNumero::findOrFail($id);
        $nuestroNumero->eliminado = true;
        $nuestroNumero->update();
        return $nuestroNumero;
    }


}
