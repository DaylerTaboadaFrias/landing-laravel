<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PortadaFormularioPostulacion;


class PortadaFormularioPostulacionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'enlace' => '',
                'imagen' => '/images/por-defecto-rectangular.jpg'
            ]
        ];
        foreach ($data as $item) {
            PortadaFormularioPostulacion::firstOrCreate($item);
        }
    }
}