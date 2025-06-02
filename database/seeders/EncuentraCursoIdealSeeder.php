<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\EncuentraCursoIdeal;


class EncuentraCursoIdealSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'titulo' => '',
                'subtitulo' => '',
                'titulo_enlace' => '',
                'enlace' => '',
                'imagen' => '/images/por-defecto.jpg'
            ]
        ];
        foreach ($data as $item) {
            EncuentraCursoIdeal::firstOrCreate($item);
        }
    }
}