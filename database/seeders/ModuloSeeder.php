<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Modulo;

class ModuloSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Modulo: Seguridad
            ['nombre' => 'Seguridad', 'icono' => '/images/seguridad.svg', 'identificador' => 'seguridad', 'orden' => 1],

            // Modulo: Inicio
            ['nombre' => 'Inicio', 'icono' => '/images/home.svg', 'identificador' => 'home', 'orden' => 2],

            // Modulo: Cursos
            ['nombre' => 'Cursos', 'icono' => '/images/curso.svg', 'identificador' => 'cursos', 'orden' => 3],


            // Modulo: InCompany
            ['nombre' => 'InCompany', 'icono' => '/images/incompany.svg', 'identificador' => 'incompany', 'orden' => 4],

            // Modulo: Nosotros
            ['nombre' => 'Nosotros', 'icono' => '/images/postulacion.svg', 'identificador' => 'nosotros', 'orden' => 5],

            // Modulo: Contacto
            ['nombre' => 'Contacto', 'icono' => '/images/contacto.svg', 'identificador' => 'contacto', 'orden' => 6],
        ];

        foreach ($data as $item) {
            Modulo::firstOrCreate($item);
        }
    }
}
