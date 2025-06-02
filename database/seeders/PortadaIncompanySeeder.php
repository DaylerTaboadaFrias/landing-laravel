<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\PortadaIncompany;


class PortadaIncompanySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'enlace' => '',
                'imagen' => '/images/por-defecto.jpg'
            ]
        ];
        foreach ($data as $item) {
            PortadaIncompany::firstOrCreate($item);
        }
    }
}