<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PermisoEnum extends Enum
{
    const Inicio = 0;

    // Modulo 1
    const Rol = 1;
    const Usuario = 2;

    // Modulo 2
    const PortadaInicio = 3;
    const SeccionInicio = 4;
    const GaleriaInicio = 5;
    const SeccionCapacitacion = 6;
    const NuestroNumero = 7;
    const OpinionProfesional = 8;
    const EncuentraCursoIdeal = 9;

    // Modulo 3
    const CategoriaCurso = 10;
    const SubCategoriaCurso = 11;
    const Modalidad = 12;
    const TipoCurso = 13;
    const Docente = 14;
    const Curso = 15;


    // Modulo 4
    const PortadaInCompany = 16;
    const CaracteristicaInCompany = 17;
    const SolicitudCotizacion = 18;
    const ConfiguracionInCompany = 19;
  

    // Modulo 5
    const PortadaPostulacion = 20;
    const PortadaFormularioPostulacion = 21;
    const NuestrosValoresPostulacion = 22;
    const PreguntaFrecuentePostulacion = 23;
    const OpinionDocente = 24;
    const SolicitudPostulacion = 25;

    // Modulo 6
    const SeccionContacto = 26;
    const SolicitudContacto = 27;
    

    const Disponibilidad = 28;
    const MotivoContacto = 29;
    const ImportarCurso = 30;
    const Suscripcion = 31;

}
