<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolSeeder::class,
            UsuarioSeeder::class,
            ModuloSeeder::class,
            PermisoSeeder::class,
            RolPermisoSeeder::class,
            PortadaInicioSeeder::class,
            SeccionCapacitacionSeeder::class,
            EncuentraCursoIdealSeeder::class,
            PortadaIncompanySeeder::class,
            ConfiguracionIncompanySeeder::class,
            PortadaPostulacionSeeder::class,
            PortadaFormularioPostulacionSeeder::class,
            SeccionContactoSeeder::class,
            MotivoContactoSeeder::class,
            DisponibilidadSeeder::class,
        ]);
    }
}
