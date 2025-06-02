<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\MotivoContacto;


class MotivoContactoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nombre' => 'Acerca de Nuestros Servicios',
                'orden' => 1,
                'habilitado' => true,
                'eliminado' => false
            ],
            [
                'nombre' => 'Sobre nuestro Portafolio de Cursos',
                'orden' => 2,
                'habilitado' => true,
                'eliminado' => false
            ],
            [
                'nombre' => 'Sobre In Company',
                'orden' => 3,
                'habilitado' => true,
                'eliminado' => false
            ],
            [
                'nombre' => 'Sobre Asociarte',
                'orden' => 4,
                'habilitado' => true,
                'eliminado' => false
            ],
            [
                'nombre' => 'Comentarios y Sugerencias',
                'orden' => 5,
                'habilitado' => true,
                'eliminado' => false
            ]
        ];
        foreach ($data as $item) {
            MotivoContacto::firstOrCreate($item);
        }
    }
}