<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class CotizacionInCompany extends Model
{
    public $table = 'cotizacion_incompany';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre_empresa',
        'nombre_responsable',
        'telefono_responsable',
        'correo_responsable',
        'duracion_curso',
        'fecha_curso',
        'localizacion_curso',
        'numero_participante',
        'expectativa_curso',
        'eliminado',
        'recibido',
        'id_curso',
        'id_modalidad'
    ];


    public static function getCotizacionInCompany($id_cotizacion_incompany)
    {
        $query = DB::table('cotizacion_incompany')
            ->join('curso','cotizacion_incompany.id_curso','=','curso.id')
            ->join('modalidad','cotizacion_incompany.id_modalidad','=','modalidad.id')
            ->select(
                'cotizacion_incompany.*',
                'curso.nombre as nombre_curso',
                'modalidad.nombre as nombre_modalidad'
            )
            ->where('cotizacion_incompany.eliminado', false)
            ->where('cotizacion_incompany.id',$id_cotizacion_incompany);

        return $query->first();
    }

    public static function filtroCotizacionInCompany($search,$recibido,$fecha_inicio,$fecha_fin,$id_curso,$id_modalidad)
    {
        $query = DB::table('cotizacion_incompany')
            ->join('curso','cotizacion_incompany.id_curso','=','curso.id')
            ->join('modalidad','cotizacion_incompany.id_modalidad','=','modalidad.id')
            ->select(
                'cotizacion_incompany.*',
                'curso.nombre as nombre_curso',
                'modalidad.nombre as nombre_modalidad'
            )
            ->where('cotizacion_incompany.eliminado', false);

        if ($recibido!=-1) {
            $query->where('cotizacion_incompany.recibido',$recibido);
        }

        if (!empty($fecha_inicio) && !empty($fecha_fin)) {
            $inicio = Carbon::parse($fecha_inicio)->startOfDay();
            $fin    = Carbon::parse($fecha_fin)   ->endOfDay();
            $query->whereBetween(
                'cotizacion_incompany.created_at',
                [$inicio, $fin]
            );
        }
       
        if ($id_curso!=0) {
            $query->where('cotizacion_incompany.id_curso',$id_curso);
        }

        if ($id_modalidad!=0) {
            $query->where('cotizacion_incompany.id_modalidad',$id_modalidad);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('cotizacion_incompany.id', $search)
                  ->orWhereRaw('LOWER(cotizacion_incompany.nombre_empresa) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(cotizacion_incompany.nombre_responsable) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(cotizacion_incompany.telefono_responsable) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(cotizacion_incompany.correo_responsable) LIKE LOWER(?)', ["%$search%"]);
            });
        }
        return $query->orderBy('cotizacion_incompany.id', 'desc')->get();
    }


    public static function registrarCotizacionInCompany($nombre_empresa,$nombre_responsable,$telefono_responsable,$correo_responsable,$duracion_curso,$fecha_curso,$localizacion_curso,$numero_participante,$expectativa_curso,$id_curso,$id_modalidad)
    {
        $cotizacion_incompany = new CotizacionInCompany;
        $cotizacion_incompany->nombre_empresa = $nombre_empresa;
        $cotizacion_incompany->nombre_responsable = $nombre_responsable;
        $cotizacion_incompany->telefono_responsable = $telefono_responsable;
        $cotizacion_incompany->correo_responsable = $correo_responsable;
        $cotizacion_incompany->duracion_curso = $duracion_curso;
        $cotizacion_incompany->fecha_curso = $fecha_curso;
        $cotizacion_incompany->localizacion_curso = $localizacion_curso;
        $cotizacion_incompany->numero_participante = $numero_participante;
        $cotizacion_incompany->expectativa_curso = $expectativa_curso;
        $cotizacion_incompany->eliminado = false;
        $cotizacion_incompany->recibido = false;
        $cotizacion_incompany->id_curso = $id_curso;
        $cotizacion_incompany->id_modalidad = $id_modalidad;
        $cotizacion_incompany->save();
        return $cotizacion_incompany;
    }

    public static function eliminarCotizacionInCompany($id)
    {
        $cotizacion_incompany = CotizacionInCompany::findOrFail($id);
        $cotizacion_incompany->eliminado = true;
        $cotizacion_incompany->save();

        return $cotizacion_incompany;
    }


    public static function recibidoCotizacionInCompany(
        $id_cotizacion_incompany
    )
    {
        $cotizacion_incompany = CotizacionInCompany::findOrFail($id_cotizacion_incompany);
        $cotizacion_incompany->recibido = true;
        $cotizacion_incompany->update();
        return $cotizacion_incompany;
    }

}
