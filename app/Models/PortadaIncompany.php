<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Carbon\Carbon;
use File;

class PortadaIncompany extends Model
{
    protected $table = 'portada_incompany';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'imagen', 'enlace'
    ];
    

    public static function obtenerPortadaIncompany()
    {
        $portadaInicio = PortadaIncompany::first();
        return $portadaInicio;
    }


    public static function filtroPortadaIncompany($search)
    {
        $query = DB::table('portada_incompany')
            ->select(
                'portada_incompany.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('portada_incompany.id', $search)
                  ->orWhereRaw('LOWER(portada_incompany.enlace) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('portada_incompany.id', 'desc')->get();
    }
    
    
    public static function actualizarPortadaIncompany($id,$enlace,$imagen)
    {
        $portadaIncompany = PortadaIncompany::findOrFail($id);
        $portadaIncompany->enlace = $enlace;
        $portadaIncompany->update();

        PortadaIncompany::actualizarImagenPortadaIncompany($imagen, $portadaIncompany->id);

        return $portadaIncompany;
    }


    public static function actualizarImagenPortadaIncompany($imagen, $id_portada_incompany)
    {
        if ($imagen != "") {
            $path = '/img/portadaIncompany/';
            $destination_path = public_path() . $path . $id_portada_incompany;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $portadaIncompany = PortadaIncompany::findOrFail($id_portada_incompany);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(980,484)
                ->save($filePath);

            $portadaIncompany->imagen = $path . $id_portada_incompany . '/' . $fileName;
            $portadaIncompany->update();

            return $portadaIncompany;
        }
    }

}
