<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class ConfiguracionIncompany extends Model
{
    protected $table = 'configuracion_incompany';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'correo', 'codigo_area', 'celular'
    ];
   
    public static function getConfiguracionIncompany()
    {
        $query = DB::table('configuracion_incompany')
            ->select(
                'configuracion_incompany.*'
            );
        return $query->first();
    }

    public static function filtroConfiguracionIncompany($search)
    {
        $query = DB::table('configuracion_incompany')
            ->select(
                'configuracion_incompany.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('configuracion_incompany.id', $search)
                  ->orWhereRaw('LOWER(configuracion_incompany.correo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('configuracion_incompany.id', 'desc')->get();
    }
    
    

    public static function actualizarConfiguracionIncompany($id,$correo,$codigo_area,$celular)
    {
        $configuracion = ConfiguracionIncompany::findOrFail($id);
        $configuracion->correo = $correo;
        $configuracion->codigo_area = $codigo_area;
        $configuracion->celular = $celular;
        $configuracion->update();

        return $configuracion;
    }


}
