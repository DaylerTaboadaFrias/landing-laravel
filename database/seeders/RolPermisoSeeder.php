<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\RolPermiso;
use App\Enums\RolEnum;
use App\Enums\PermisoEnum;


class RolPermisoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Modulo 1
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Rol],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Usuario],
            
            // Modulo 2
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::PortadaInicio],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SeccionInicio],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::GaleriaInicio],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SeccionCapacitacion],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::NuestroNumero],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::OpinionProfesional],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::EncuentraCursoIdeal],

            // Modulo 3
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::CategoriaCurso],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SubCategoriaCurso],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Modalidad],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::TipoCurso],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Docente],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Curso],

            // Modulo 4
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::PortadaInCompany],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::CaracteristicaInCompany],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SolicitudCotizacion],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::ConfiguracionInCompany],

            // Modulo 5
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::PortadaPostulacion],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::PortadaFormularioPostulacion],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::NuestrosValoresPostulacion],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::PreguntaFrecuentePostulacion],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::OpinionDocente],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SolicitudPostulacion],

            // Modulo 6
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SeccionContacto],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::SolicitudContacto],


            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Disponibilidad],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::MotivoContacto],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::ImportarCurso],
            ['id_rol' => RolEnum::Administrador, 'id_permiso' => PermisoEnum::Suscripcion],
            

        ];

        foreach ($data as $item) {
            RolPermiso::firstOrCreate($item);
        }
    }
}