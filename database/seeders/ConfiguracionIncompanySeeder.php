<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ConfiguracionIncompany;


class ConfiguracionIncompanySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'correo' => '',
                'codigo_area' => 0,
                'celular' => 0,
            ]
        ];
        foreach ($data as $item) {
            ConfiguracionIncompany::firstOrCreate($item);
        }
    }
}