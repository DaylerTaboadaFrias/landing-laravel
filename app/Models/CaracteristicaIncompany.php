<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class CaracteristicaIncompany extends Model
{
    protected $table = 'caracteristica_incompany';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'nombre', 'imagen', 'mostrar_inicio', 'orden', 'habilitado', 'eliminado'
    ];
    

    public static function obtenerCaracteristicas()
    {
        $query = DB::table('caracteristica_incompany')
            ->select(
                'caracteristica_incompany.*'
            )
            ->where('caracteristica_incompany.habilitado', true)
            ->where('caracteristica_incompany.eliminado', false);

        return $query->orderBy('caracteristica_incompany.orden', 'asc')->get();
    }

    public static function filtroCaracteristicaIncompany($search)
    {
        $query = DB::table('caracteristica_incompany')
            ->select(
                'caracteristica_incompany.*'
            )
            ->where('caracteristica_incompany.eliminado', false);

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('caracteristica_incompany.id', $search)
                  ->orWhereRaw('LOWER(caracteristica_incompany.nombre) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('caracteristica_incompany.orden', 'asc')->get();
    }
    
    
 

    public static function registrarCaracteristicaIncompany($nombre,$imagen,$orden,$habilitado)
    {
        $caracteristicaIncompany = new CaracteristicaIncompany();
        $caracteristicaIncompany->nombre = $nombre;
        $caracteristicaIncompany->orden = $orden;
        $caracteristicaIncompany->habilitado = $habilitado;
        $caracteristicaIncompany->eliminado = false;
        $caracteristicaIncompany->save();

        CaracteristicaIncompany::actualizarImagenCaracteristicaIncompany($imagen, $caracteristicaIncompany->id);

        return $caracteristicaIncompany;
    }

 

    public static function actualizarCaracteristicaIncompany($id,$nombre,$imagen,$orden,$habilitado)
    {
        $caracteristicaIncompany = CaracteristicaIncompany::findOrFail($id);
        $caracteristicaIncompany->nombre = $nombre;
        $caracteristicaIncompany->orden = $orden;
        $caracteristicaIncompany->habilitado = $habilitado;
        $caracteristicaIncompany->update();

        CaracteristicaIncompany::actualizarImagenCaracteristicaIncompany($imagen, $caracteristicaIncompany->id);

        return $caracteristicaIncompany;
    }


    public static function eliminarCaracteristicaIncompany($id)
    {
        $caracteristicaIncompany = CaracteristicaIncompany::findOrFail($id);
        $caracteristicaIncompany->eliminado = true;
        $caracteristicaIncompany->update();
        return $caracteristicaIncompany;
    }

    public static function actualizarImagenCaracteristicaIncompany($imagen, $id_caracteristica)
    {
        if ($imagen != "") {
            $path = '/img/caracteristicaIncompany/';
            $destination_path = public_path() . $path . $id_caracteristica;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $caracteristicaIncompany = CaracteristicaIncompany::findOrFail($id_caracteristica);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(100, 100)
                ->save($filePath);

            $caracteristicaIncompany->imagen = $path . $id_caracteristica . '/' . $fileName;
            $caracteristicaIncompany->update();

            return $caracteristicaIncompany;
        }
    }

}
