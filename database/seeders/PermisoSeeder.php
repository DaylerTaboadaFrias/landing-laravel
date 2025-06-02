<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permiso;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Modulo 1
            ['nombre' => 'Roles', 'id_modulo' => 1, 'url' => 'rol', 'identificador' => 'navRoles', 'orden' => 1],
            ['nombre' => 'Usuarios', 'id_modulo' => 1, 'url' => 'usuario', 'identificador' => 'navUsuarios', 'orden' => 2],

            // Modulo 2
            ['nombre' => 'Portadas', 'id_modulo' => 2, 'url' => 'portada-inicio', 'identificador' => 'navPortadaInicio', 'orden' => 1],
            ['nombre' => 'Secciones', 'id_modulo' => 2, 'url' => 'seccion-inicio', 'identificador' => 'navSeccionInicio', 'orden' => 2],
            ['nombre' => 'Galerías', 'id_modulo' => 2, 'url' => 'galeria-inicio', 'identificador' => 'navGaleriaInicio', 'orden' => 3],
            ['nombre' => 'Sección capacitación', 'id_modulo' => 2, 'url' => 'seccion-capacitacion', 'identificador' => 'navSeccionCapacitacion', 'orden' => 4],
            ['nombre' => 'Nuestros números', 'id_modulo' => 2, 'url' => 'nuestro-numero', 'identificador' => 'navNuestroNumero', 'orden' => 5],
            ['nombre' => 'Opinión profesionales', 'id_modulo' => 2, 'url' => 'opinion-profesional', 'identificador' => 'navOpinionProfesional', 'orden' => 6],
            ['nombre' => 'Encuentra tu curso ideal', 'id_modulo' => 2, 'url' => 'encuentra-curso-ideal', 'identificador' => 'navEncuentraCursoIdeal', 'orden' => 7],

            // Modulo 3
            ['nombre' => 'Categorías', 'id_modulo' => 3, 'url' => 'categoria-curso', 'identificador' => 'navCategoriaCurso', 'orden' => 1],
            ['nombre' => 'Subcategorías', 'id_modulo' => 3, 'url' => 'subcategoria-curso', 'identificador' => 'navSubCategoriaCurso', 'orden' => 2],
            ['nombre' => 'Modalidades', 'id_modulo' => 3, 'url' => 'modalidad', 'identificador' => 'navModalidad', 'orden' => 3],
            ['nombre' => 'Tipos de Curso', 'id_modulo' => 3, 'url' => 'tipo-curso', 'identificador' => 'navTipoCurso', 'orden' => 4],
            ['nombre' => 'Docentes', 'id_modulo' => 3, 'url' => 'docente', 'identificador' => 'navDocente', 'orden' => 5],
            ['nombre' => 'Cursos', 'id_modulo' => 3, 'url' => 'curso', 'identificador' => 'navCurso', 'orden' => 6],

            // Modulo 4
            ['nombre' => 'Portadas', 'id_modulo' => 4, 'url' => 'portada-incompany', 'identificador' => 'navPortadaInCompany', 'orden' => 1],
            ['nombre' => 'Características', 'id_modulo' => 4, 'url' => 'caracteristica-incompany', 'identificador' => 'navCaracteristicaInCompany', 'orden' => 2],
            ['nombre' => 'Solicitudes de cotización', 'id_modulo' => 4, 'url' => 'solicitud-cotizacion', 'identificador' => 'navSolicitudCotizacion', 'orden' => 3],
            ['nombre' => 'Configuración in company', 'id_modulo' => 4, 'url' => 'configuracion-incompany', 'identificador' => 'navConfiguracionInCompany', 'orden' => 4],

            // Modulo 5
            ['nombre' => 'Portadas postulación', 'id_modulo' => 5, 'url' => 'portada-postulacion', 'identificador' => 'navPortadaPostulacion', 'orden' => 1],
            ['nombre' => 'Portadas formulario postulación', 'id_modulo' => 5, 'url' => 'portada-formulario-postulacion', 'identificador' => 'navPortadaFormularioPostulacion', 'orden' => 2],
            ['nombre' => 'Nuestros valores', 'id_modulo' => 5, 'url' => 'nuestros-valores-postulacion', 'identificador' => 'navNuestrosValoresPostulacion', 'orden' => 4],
            ['nombre' => 'Preguntas frecuentes', 'id_modulo' => 5, 'url' => 'pregunta-frecuente-postulacion', 'identificador' => 'navPreguntaFrecuentePostulacion', 'orden' => 3],
            ['nombre' => 'Opinión docentes', 'id_modulo' => 5, 'url' => 'opinion-docente', 'identificador' => 'navOpinionDocente', 'orden' => 5],
            ['nombre' => 'Solicitud de postulación', 'id_modulo' => 5, 'url' => 'solicitud-postulacion', 'identificador' => 'navSolicitudPostulacion', 'orden' => 6],

            // Modulo 6
            ['nombre' => 'Sección contacto', 'id_modulo' => 6, 'url' => 'seccion-contacto', 'identificador' => 'navSeccionContacto', 'orden' => 1],
            ['nombre' => 'Solicitud de contacto', 'id_modulo' => 6, 'url' => 'solicitud-contacto', 'identificador' => 'navSolicitudContacto', 'orden' => 2],

            ['nombre' => 'Disponibilidad', 'id_modulo' => 5, 'url' => 'disponibilidad', 'identificador' => 'navDisponibilidad', 'orden' => 3],

            ['nombre' => 'Motivo de contacto', 'id_modulo' => 6, 'url' => 'motivo-contacto', 'identificador' => 'navMotivoContacto', 'orden' => 3],

            ['nombre' => 'Importar cursos', 'id_modulo' => 3, 'url' => 'importar-curso', 'identificador' => 'navImportarCurso', 'orden' => 7],

            ['nombre' => 'Suscripciones', 'id_modulo' => 6, 'url' => 'suscripcion', 'identificador' => 'navSuscripcion', 'orden' => 4],
            
        ];

        foreach ($data as $item) {
            Permiso::firstOrCreate($item);
        }
    }
}
