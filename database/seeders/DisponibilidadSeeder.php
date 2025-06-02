<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Disponibilidad;


class DisponibilidadSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nombre' => 'Jornada completa',
                'orden' => 1,
                'habilitado' => true,
                'eliminado' => false
            ],
            [
                'nombre' => 'Media jornada',
                'orden' => 2,
                'habilitado' => true,
                'eliminado' => false
            ],
            [
                'nombre' => 'Turnos',
                'orden' => 3,
                'habilitado' => true,
                'eliminado' => false
            ]
        ];
        foreach ($data as $item) {
            Disponibilidad::firstOrCreate($item);
        }
    }
}