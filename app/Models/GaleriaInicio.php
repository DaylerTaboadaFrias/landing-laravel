<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class GaleriaInicio extends Model
{
    protected $table = 'galeria_inicio';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'enlace', 'imagen', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function obtenerGaleriaInicio()
    {
        $query = DB::table('galeria_inicio')
            ->select(
                'galeria_inicio.*'
            )
            ->where('galeria_inicio.habilitado', true)
            ->where('galeria_inicio.eliminado', false);

        return $query->orderBy('galeria_inicio.orden', 'asc')->get();
    }


    public static function filtroGaleriaInicio($search)
    {
        $query = DB::table('galeria_inicio')
            ->select(
                'galeria_inicio.*'
            )
            ->where('galeria_inicio.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('galeria_inicio.id', $search)
                  ->orWhereRaw('LOWER(galeria_inicio.enlace) LIKE LOWER(?)', ["%$search%"])
                  ->orWhereRaw('LOWER(galeria_inicio.orden) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('galeria_inicio.orden', 'asc')->get();
    }
    

 

    public static function registrarGaleriaInicio($enlace,$imagen,$orden,$habilitado)
    {
        $galeria = new GaleriaInicio();
        $galeria->enlace = $enlace != null ? $enlace : '';
        $galeria->orden = $orden;
        $galeria->habilitado = $habilitado;
        $galeria->eliminado = false;
        $galeria->save();

        GaleriaInicio::actualizarImagenGaleriaInicio($imagen, $galeria->id);

        return $galeria;
    }

 

    public static function actualizarGaleriaInicio($id,$enlace,$imagen,$orden,$habilitado)
    {
        $galeria = GaleriaInicio::findOrFail($id);
        $galeria->enlace = $enlace != null ? $enlace : '';
        $galeria->orden = $orden;
        $galeria->habilitado = $habilitado;
        $galeria->update();

        GaleriaInicio::actualizarImagenGaleriaInicio($imagen, $galeria->id);

        return $galeria;
    }


    public static function eliminarGaleriaInicio($id)
    {
        $galeria = GaleriaInicio::findOrFail($id);
        $galeria->eliminado = true;
        $galeria->update();
        return $galeria;
    }

    public static function actualizarImagenGaleriaInicio($imagen, $id_galeria_inicio)
    {
        if ($imagen != "") {
            $path = '/img/galeriaInicio/';
            $destination_path = public_path() . $path . $id_galeria_inicio;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $galeria = GaleriaInicio::findOrFail($id_galeria_inicio);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(1008, 358)
                ->save($filePath);

            $galeria->imagen = $path . $id_galeria_inicio . '/' . $fileName;
            $galeria->update();

            return $galeria;
        }
    }

}
