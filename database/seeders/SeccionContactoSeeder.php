<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SeccionContacto;


class SeccionContactoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'titulo' => '',
                'direccion' => '',
                'telefono' => '',
                'codigo_area' => 0,
                'celular' => 0,
                'correo' => '',
                'enlace_facebook' => '',
                'enlace_instagram' => '',
                'enlace_linkedin' => '',
                'enlace_pago' => 'https://formularios.upsa.edu.bo/formCenace/?curso=',
                'enlace_inicio_sesion' => 'https://cenace.upsa.edu.bo/ingresar',
                'enlace_registro' => 'https://cenace.upsa.edu.bo/crear-cuenta',
                'imagen' => '/images/por-defecto-rectangular.jpg'
            ]
        ];
        foreach ($data as $item) {
            SeccionContacto::firstOrCreate($item);
        }
    }
}