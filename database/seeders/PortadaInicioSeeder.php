<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PortadaInicio;


class PortadaInicioSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'titulo' => 'Nuevas oportunidades de aprendizaje',
                'subtitulo' => 'Encuentra el curso ideal para tu formación profesional',
                'imagen' => '/images/por-defecto.jpg'
            ]
        ];
        foreach ($data as $item) {
            PortadaInicio::firstOrCreate($item);
        }
    }
}