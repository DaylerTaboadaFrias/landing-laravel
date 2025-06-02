<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Mail;

class Util extends Model
{
  
    public static function getEstados()
    {
        $data = [
            ['id'=> 1, 'nombre'=> 'Si'],
            ['id'=> 0 ,'nombre'=> 'No']
        ];
        return json_decode(json_encode($data));
    }

    public static function getProximosMeses()
    {
        $mesActual = now()->month;
        $anioActual = now()->year;
        $meses = collect(range(0, 2))->map(function ($i) use ($mesActual, $anioActual) {
            $fecha = now()->setMonth($mesActual)->addMonths($i);
            return [
                'mes' => $fecha->month,
                'anio' => $fecha->year,
                'nombre' => ucfirst($fecha->translatedFormat('F')),
            ];
        });
        return $meses;
    }

    public static function normalizarTexto($texto)
    {
        $texto = strtolower(trim($texto)); 
        $texto = preg_replace('/\s+/', ' ', $texto);
        $texto = strtr($texto, [
            'á' => 'a', 'é' => 'e', 'í' => 'i',
            'ó' => 'o', 'ú' => 'u', 'ñ' => 'n',
            'Á' => 'a', 'É' => 'e', 'Í' => 'i',
            'Ó' => 'o', 'Ú' => 'u', 'Ñ' => 'n',
        ]);
        return $texto;
    }

}
