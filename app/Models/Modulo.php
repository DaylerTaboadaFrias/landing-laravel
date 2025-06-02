<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;

class Modulo extends Model
{
    public $table = 'modulo';
    public $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = true;
    public $fillable = [
        'nombre',
        'icono',
        'identificador',
        'nombre'
    ];

    public static function filtroModulos()
    {
        return Modulo::get();
    }

   



}
