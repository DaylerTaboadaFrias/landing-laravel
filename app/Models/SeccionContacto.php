<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use File;

class SeccionContacto extends Model
{
    protected $table = 'seccion_contacto';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'titulo', 'ubicacion', 'telefono', 'codigo_area','celular', 'correo', 'enlace_facebook', 'enlace_instagram' , 'enlace_linkedin', 'enlace_pago', 'enlace_inicio_sesion', 'enlace_registro' ,'imagen'
    ];

    public static function obtenerSeccionConctacto()
    {
        $seccionContacto = SeccionContacto::first();
        return $seccionContacto;
    }


    public static function filtroSeccionContacto($search)
    {
        $query = DB::table('seccion_contacto')
            ->select(
                'seccion_contacto.*'
            );

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('seccion_contacto.id', $search)
                  ->orWhereRaw('LOWER(seccion_contacto.titulo) LIKE LOWER(?)', ["%$search%"]);
            });
        }

        return $query->orderBy('seccion_contacto.id', 'desc')->get();
    }
    
    

    public static function actualizarSeccionContacto($id,$titulo,$direccion,$telefono,$codigo_area,$celular,$correo,$enlace_facebook,$enlace_instagram,$enlace_linkedin,$enlace_pago,$enlace_inicio_sesion,$enlace_registro,$imagen)
    {
        $seccionContacto = SeccionContacto::findOrFail($id);
        $seccionContacto->titulo = $titulo;
        $seccionContacto->direccion = $direccion;
        $seccionContacto->telefono = $telefono;
        $seccionContacto->codigo_area = $codigo_area;
        $seccionContacto->celular = $celular;
        $seccionContacto->correo = $correo;
        $seccionContacto->enlace_facebook = $enlace_facebook;
        $seccionContacto->enlace_instagram = $enlace_instagram;
        $seccionContacto->enlace_linkedin = $enlace_linkedin;
        $seccionContacto->enlace_pago = $enlace_pago;
        $seccionContacto->enlace_inicio_sesion = $enlace_inicio_sesion;
        $seccionContacto->enlace_registro = $enlace_registro;
        $seccionContacto->update();

        SeccionContacto::actualizarImagenSeccionContacto($imagen, $seccionContacto->id);

        return $seccionContacto;
    }

    public static function actualizarImagenSeccionContacto($imagen, $id_seccion_contacto)
    {
        if ($imagen != "") {
            $path = '/img/seccionContacto/';
            $destination_path = public_path() . $path . $id_seccion_contacto;

            File::makeDirectory($destination_path, $mode = 0777, true, true);

            $seccionContacto = SeccionContacto::findOrFail($id_seccion_contacto);

            $fileName = 'img_' . uniqid() . '.png';
            $filePath = $destination_path . '/' . $fileName;

            Image::make($imagen)
                ->resize(326, 246)
                ->save($filePath);

            $seccionContacto->imagen = $path . $id_seccion_contacto . '/' . $fileName;
            $seccionContacto->update();

            return $seccionContacto;
        }
    }

}
