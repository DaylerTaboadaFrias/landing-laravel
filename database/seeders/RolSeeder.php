<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Rol;


class RolSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nombre' => 'Administrador',
                'eliminado' => false
            ]
        ];
        foreach ($data as $item) {
            Rol::firstOrCreate($item);
        }
    }
}