<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\SeccionCapacitacion;


class SeccionCapacitacionSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'titulo' => '',
                'subtitulo' => '',
                'descripcion' => '',
                'imagen' => '/images/por-defecto.jpg'
            ]
        ];
        foreach ($data as $item) {
            SeccionCapacitacion::firstOrCreate($item);
        }
    }
}