<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;

class Permiso extends Model
{
    public $table = 'permiso';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre',
        'url',
        'identificador',
        'icono',
        'orden',
        'id_modulo'
    ];

    public static function filtroPermiso()
    {
        return Permiso::get();
    }





}
