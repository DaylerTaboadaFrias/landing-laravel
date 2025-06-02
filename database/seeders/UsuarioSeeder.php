<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Usuario;


class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nombres' => 'Nanet',
                'apellidos' => 'Taboada Frias',
                'nombre_usuario' => 'nanet',
                'correo' => 'nanettaboadafriass@gmail.com',
                'password' => 'nanet',
                'habilitado' => true,
                'eliminado' => false,
                'id_rol' => 1
            ]
        ];
        foreach ($data as $item) {
            Usuario::firstOrCreate($item);
        }
    }
}