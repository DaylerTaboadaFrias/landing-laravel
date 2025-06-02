<?php

use Illuminate\Support\Facades\Route;
use App\Enums\PermisoEnum;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Auth::routes();
Route::get('/',[App\Http\Controllers\LandingPageController::class,'index']);
Route::get('/cursos',[App\Http\Controllers\LandingPageController::class,'cursos']);
Route::get('/detalle-curso',[App\Http\Controllers\LandingPageController::class,'detalleCurso']);
Route::get('/detalle-curso/{id}',[App\Http\Controllers\LandingPageController::class,'detalleCurso']);
Route::get('/empresas/{id_curso?}', [App\Http\Controllers\LandingPageController::class, 'empresas'])
     ->name('empresas');
Route::get('/nosotros',[App\Http\Controllers\LandingPageController::class,'nosotros']);
Route::get('/contacto',[App\Http\Controllers\LandingPageController::class,'contacto']);
Route::post('/contacto/registrar-contacto', [App\Http\Controllers\LandingPageController::class, 'registrarContacto']);
Route::get('/postula',[App\Http\Controllers\LandingPageController::class,'postula']);
Route::post('/postulacion/registrar-postulacion', [App\Http\Controllers\LandingPageController::class, 'registrarSolicitudPostulacion']);
Route::post('/interesado-inscripcion/registrar-interesado-inscripcion', [App\Http\Controllers\LandingPageController::class, 'registrarInteresadoInscripcion']);
Route::post('/cotizacion-incompany/registrar-cotizacion-incompany', [App\Http\Controllers\LandingPageController::class, 'registrarCotizacionInCompany']);
Route::post('/suscripcion/registrar-suscripcion', [App\Http\Controllers\LandingPageController::class, 'registrarSuscripcion']);
Route::post('/cursos/obtener-cursos-nombre', [App\Http\Controllers\LandingPageController::class, 'obtenerCursosPorNombre']);
Route::get('/cursos/por-mes', [App\Http\Controllers\LandingPageController::class,'listarCursosPorMes'])->name('curso.porMes');
Route::get('/cursos/filtrar', [App\Http\Controllers\LandingPageController::class,'filtrarCursos'])->name('cursos.filtrar');
Route::get('/cursos/subcategorias', [App\Http\Controllers\LandingPageController::class,'listarSubcategorias'])->name('subcategorias.html');

Route::get('login', [App\Http\Controllers\AutenticacionController::class,'login']);
Route::get('recuperar-password', [App\Http\Controllers\AutenticacionController::class,'recuperarPassword']);
Route::get('codigo-recuperacion/{token}', [App\Http\Controllers\AutenticacionController::class,'codigoRecuperacion']);
Route::get('resetear-password/{token}', [App\Http\Controllers\AutenticacionController::class,'resetearPassword']);



Route::post('autenticacion/login-usuario', [App\Http\Controllers\AutenticacionController::class,'loginUsuario']);
Route::post('autenticacion/cerrar-session', [App\Http\Controllers\AutenticacionController::class,'cerrarSessionUsuario']);
Route::post('autenticacion/generar-codigo-recuperacion', [App\Http\Controllers\AutenticacionController::class,'generarCodigoRecuperacion']);
Route::post('autenticacion/validar-codigo-recuperacion', [App\Http\Controllers\AutenticacionController::class,'validarCodigoRecuperacion']);
Route::post('autenticacion/actualizar-nuevo-password', [App\Http\Controllers\AutenticacionController::class,'actualizarNuevoPassword']);



Route::middleware(['admin:' . PermisoEnum::Inicio])->group(function () {
    Route::get('/inicio', [App\Http\Controllers\InicioController::class, 'index']);
});

Route::middleware(['admin:' . PermisoEnum::Rol])->group(function () {
    Route::get('/rol', [App\Http\Controllers\RolController::class, 'index']);
    Route::post('/rol/listar-rol', [App\Http\Controllers\RolController::class, 'listarRol']);
    Route::post('/rol/eliminar-rol', [App\Http\Controllers\RolController::class, 'eliminarRol']);
    Route::post('/rol/registrar-rol', [App\Http\Controllers\RolController::class, 'registrarRol']);
    Route::post('/rol/actualizar-rol', [App\Http\Controllers\RolController::class, 'actualizarRol']);
    Route::get('/rol/registrar', [App\Http\Controllers\RolController::class, 'registrar']);
    Route::get('/rol/editar/{id}', [App\Http\Controllers\RolController::class, 'editar']);
    Route::get('/rol/permiso/{id_rol}', [App\Http\Controllers\RolController::class, 'indexPermiso']);
    Route::post('/rol/actualizar-permiso', [App\Http\Controllers\RolController::class, 'actualizarPermiso']);
});

Route::middleware(['admin:' . PermisoEnum::Usuario])->group(function () {
    Route::get('/usuario', [App\Http\Controllers\UsuarioController::class, 'index']);
    Route::post('/usuario/listar-usuario', [App\Http\Controllers\UsuarioController::class, 'listarUsuario']);
    Route::post('/usuario/eliminar-usuario', [App\Http\Controllers\UsuarioController::class, 'eliminarUsuario']);
    Route::post('/usuario/registrar-usuario', [App\Http\Controllers\UsuarioController::class, 'registrarUsuario']);
    Route::post('/usuario/actualizar-usuario', [App\Http\Controllers\UsuarioController::class, 'actualizarUsuario']);
    Route::get('/usuario/registrar', [App\Http\Controllers\UsuarioController::class, 'registrar']);
    Route::get('/usuario/editar/{id}', [App\Http\Controllers\UsuarioController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::PortadaInicio])->group(function () {
    Route::get('/portada-inicio', [App\Http\Controllers\PortadaInicioController::class, 'index']);
    Route::post('/portada-inicio/listar-portada-inicio', [App\Http\Controllers\PortadaInicioController::class, 'listarPortadaInicio']);
    Route::post('/portada-inicio/actualizar-portada-inicio', [App\Http\Controllers\PortadaInicioController::class, 'actualizarPortadaInicio']);
    Route::get('/portada-inicio/editar/{id}', [App\Http\Controllers\PortadaInicioController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::SeccionInicio])->group(function () {
    Route::get('/seccion-inicio', [App\Http\Controllers\SeccionInicioController::class, 'index']);
    Route::post('/seccion-inicio/listar-seccion-inicio', [App\Http\Controllers\SeccionInicioController::class, 'listarSeccionInicio']);
    Route::post('/seccion-inicio/eliminar-seccion-inicio', [App\Http\Controllers\SeccionInicioController::class, 'eliminarSeccionInicio']);
    Route::post('/seccion-inicio/registrar-seccion-inicio', [App\Http\Controllers\SeccionInicioController::class, 'registrarSeccionInicio']);
    Route::post('/seccion-inicio/actualizar-seccion-inicio', [App\Http\Controllers\SeccionInicioController::class, 'actualizarSeccionInicio']);
    Route::get('/seccion-inicio/registrar', [App\Http\Controllers\SeccionInicioController::class, 'registrar']);
    Route::get('/seccion-inicio/editar/{id}', [App\Http\Controllers\SeccionInicioController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::GaleriaInicio])->group(function () {
    Route::get('/galeria-inicio', [App\Http\Controllers\GaleriaInicioController::class, 'index']);
    Route::post('/galeria-inicio/listar-galeria-inicio', [App\Http\Controllers\GaleriaInicioController::class, 'listarGaleriaInicio']);
    Route::post('/galeria-inicio/eliminar-galeria-inicio', [App\Http\Controllers\GaleriaInicioController::class, 'eliminarGaleriaInicio']);
    Route::post('/galeria-inicio/registrar-galeria-inicio', [App\Http\Controllers\GaleriaInicioController::class, 'registrarGaleriaInicio']);
    Route::post('/galeria-inicio/actualizar-galeria-inicio', [App\Http\Controllers\GaleriaInicioController::class, 'actualizarGaleriaInicio']);
    Route::get('/galeria-inicio/registrar', [App\Http\Controllers\GaleriaInicioController::class, 'registrar']);
    Route::get('/galeria-inicio/editar/{id}', [App\Http\Controllers\GaleriaInicioController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::CategoriaCurso])->group(function () {
    Route::get('/categoria-curso', [App\Http\Controllers\CategoriaCursoController::class, 'index']);
    Route::post('/categoria-curso/listar-categoria-curso', [App\Http\Controllers\CategoriaCursoController::class, 'listarCategoriaCurso']);
    Route::post('/categoria-curso/eliminar-categoria-curso', [App\Http\Controllers\CategoriaCursoController::class, 'eliminarCategoriaCurso']);
    Route::post('/categoria-curso/registrar-categoria-curso', [App\Http\Controllers\CategoriaCursoController::class, 'registrarCategoriaCurso']);
    Route::post('/categoria-curso/actualizar-categoria-curso', [App\Http\Controllers\CategoriaCursoController::class, 'actualizarCategoriaCurso']);
    Route::get('/categoria-curso/registrar', [App\Http\Controllers\CategoriaCursoController::class, 'registrar']);
    Route::get('/categoria-curso/editar/{id}', [App\Http\Controllers\CategoriaCursoController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::SeccionCapacitacion])->group(function () {
    Route::get('/seccion-capacitacion', [App\Http\Controllers\SeccionCapacitacionController::class, 'index']);
    Route::post('/seccion-capacitacion/listar-seccion-capacitacion', [App\Http\Controllers\SeccionCapacitacionController::class, 'listarSeccionCapacitacion']);
    Route::post('/seccion-capacitacion/actualizar-seccion-capacitacion', [App\Http\Controllers\SeccionCapacitacionController::class, 'actualizarSeccionCapacitacion']);
    Route::get('/seccion-capacitacion/editar/{id}', [App\Http\Controllers\SeccionCapacitacionController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::NuestroNumero])->group(function () {
    Route::get('/nuestro-numero', [App\Http\Controllers\NuestroNumeroController::class, 'index']);
    Route::post('/nuestro-numero/listar-nuestro-numero', [App\Http\Controllers\NuestroNumeroController::class, 'listarNuestroNumero']);
    Route::post('/nuestro-numero/eliminar-nuestro-numero', [App\Http\Controllers\NuestroNumeroController::class, 'eliminarNuestroNumero']);
    Route::post('/nuestro-numero/registrar-nuestro-numero', [App\Http\Controllers\NuestroNumeroController::class, 'registrarNuestroNumero']);
    Route::post('/nuestro-numero/actualizar-nuestro-numero', [App\Http\Controllers\NuestroNumeroController::class, 'actualizarNuestroNumero']);
    Route::get('/nuestro-numero/registrar', [App\Http\Controllers\NuestroNumeroController::class, 'registrar']);
    Route::get('/nuestro-numero/editar/{id}', [App\Http\Controllers\NuestroNumeroController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::OpinionProfesional])->group(function () {
    Route::get('/opinion-profesional', [App\Http\Controllers\OpinionProfesionalController::class, 'index']);
    Route::post('/opinion-profesional/listar-opinion-profesional', [App\Http\Controllers\OpinionProfesionalController::class, 'listarOpinionProfesional']);
    Route::post('/opinion-profesional/eliminar-opinion-profesional', [App\Http\Controllers\OpinionProfesionalController::class, 'eliminarOpinionProfesional']);
    Route::post('/opinion-profesional/registrar-opinion-profesional', [App\Http\Controllers\OpinionProfesionalController::class, 'registrarOpinionProfesional']);
    Route::post('/opinion-profesional/actualizar-opinion-profesional', [App\Http\Controllers\OpinionProfesionalController::class, 'actualizarOpinionProfesional']);
    Route::get('/opinion-profesional/registrar', [App\Http\Controllers\OpinionProfesionalController::class, 'registrar']);
    Route::get('/opinion-profesional/editar/{id}', [App\Http\Controllers\OpinionProfesionalController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::EncuentraCursoIdeal])->group(function () {
    Route::get('/encuentra-curso-ideal', [App\Http\Controllers\EncuentraCursoIdealController::class, 'index']);
    Route::post('/encuentra-curso-ideal/listar-encuentra-curso-ideal', [App\Http\Controllers\EncuentraCursoIdealController::class, 'listarEncuentraCursoIdeal']);
    Route::post('/encuentra-curso-ideal/actualizar-encuentra-curso-ideal', [App\Http\Controllers\EncuentraCursoIdealController::class, 'actualizarEncuentraCursoIdeal']);
    Route::get('/encuentra-curso-ideal/editar/{id}', [App\Http\Controllers\EncuentraCursoIdealController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::SubCategoriaCurso])->group(function () {
    Route::get('/subcategoria-curso', [App\Http\Controllers\SubcategoriaCursoController::class, 'index']);
    Route::post('/subcategoria-curso/listar-subcategoria-curso', [App\Http\Controllers\SubcategoriaCursoController::class, 'listarSubcategoriaCurso']);
    Route::post('/subcategoria-curso/eliminar-subcategoria-curso', [App\Http\Controllers\SubcategoriaCursoController::class, 'eliminarSubcategoriaCurso']);
    Route::post('/subcategoria-curso/registrar-subcategoria-curso', [App\Http\Controllers\SubcategoriaCursoController::class, 'registrarSubcategoriaCurso']);
    Route::post('/subcategoria-curso/actualizar-subcategoria-curso', [App\Http\Controllers\SubcategoriaCursoController::class, 'actualizarSubcategoriaCurso']);
    Route::get('/subcategoria-curso/registrar', [App\Http\Controllers\SubcategoriaCursoController::class, 'registrar']);
    Route::get('/subcategoria-curso/editar/{id}', [App\Http\Controllers\SubcategoriaCursoController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::Modalidad])->group(function () {
    Route::get('/modalidad', [App\Http\Controllers\ModalidadController::class, 'index']);
    Route::post('/modalidad/listar-modalidad', [App\Http\Controllers\ModalidadController::class, 'listarModalidad']);
    Route::post('/modalidad/eliminar-modalidad', [App\Http\Controllers\ModalidadController::class, 'eliminarModalidad']);
    Route::post('/modalidad/registrar-modalidad', [App\Http\Controllers\ModalidadController::class, 'registrarModalidad']);
    Route::post('/modalidad/actualizar-modalidad', [App\Http\Controllers\ModalidadController::class, 'actualizarModalidad']);
    Route::get('/modalidad/registrar', [App\Http\Controllers\ModalidadController::class, 'registrar']);
    Route::get('/modalidad/editar/{id}', [App\Http\Controllers\ModalidadController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::TipoCurso])->group(function () {
    Route::get('/tipo-curso', [App\Http\Controllers\TipoCursoController::class, 'index']);
    Route::post('/tipo-curso/listar-tipo-curso', [App\Http\Controllers\TipoCursoController::class, 'listarTipoCurso']);
    Route::post('/tipo-curso/eliminar-tipo-curso', [App\Http\Controllers\TipoCursoController::class, 'eliminarTipoCurso']);
    Route::post('/tipo-curso/registrar-tipo-curso', [App\Http\Controllers\TipoCursoController::class, 'registrarTipoCurso']);
    Route::post('/tipo-curso/actualizar-tipo-curso', [App\Http\Controllers\TipoCursoController::class, 'actualizarTipoCurso']);
    Route::get('/tipo-curso/registrar', [App\Http\Controllers\TipoCursoController::class, 'registrar']);
    Route::get('/tipo-curso/editar/{id}', [App\Http\Controllers\TipoCursoController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::Docente])->group(function () {
    Route::get('/docente', [App\Http\Controllers\DocenteController::class, 'index']);
    Route::post('/docente/listar-docente', [App\Http\Controllers\DocenteController::class, 'listarDocente']);
    Route::post('/docente/eliminar-docente', [App\Http\Controllers\DocenteController::class, 'eliminarDocente']);
    Route::post('/docente/registrar-docente', [App\Http\Controllers\DocenteController::class, 'registrarDocente']);
    Route::post('/docente/actualizar-docente', [App\Http\Controllers\DocenteController::class, 'actualizarDocente']);
    Route::get('/docente/registrar', [App\Http\Controllers\DocenteController::class, 'registrar']);
    Route::get('/docente/editar/{id}', [App\Http\Controllers\DocenteController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::Curso])->group(function () {
    Route::get('/curso', [App\Http\Controllers\CursoController::class, 'index']);
    Route::post('/curso/listar-curso', [App\Http\Controllers\CursoController::class, 'listarCurso']);
    Route::post('/curso/eliminar-curso', [App\Http\Controllers\CursoController::class, 'eliminarCurso']);
    Route::post('/curso/registrar-curso', [App\Http\Controllers\CursoController::class, 'registrarCurso']);
    Route::post('/curso/actualizar-curso', [App\Http\Controllers\CursoController::class, 'actualizarCurso']);
    Route::get('/curso/registrar', [App\Http\Controllers\CursoController::class, 'registrar']);
    Route::get('/curso/editar/{id}', [App\Http\Controllers\CursoController::class, 'editar']);
    
    Route::get('/curso/pregunta-frecuente/{id}', [App\Http\Controllers\CursoController::class, 'indexPreguntaFrecuente']);
    Route::post('/curso/pregunta-frecuente/listar-pregunta-frecuente', [App\Http\Controllers\CursoController::class, 'listarPreguntaFrecuente']);
    Route::post('/curso/pregunta-frecuente/eliminar-pregunta-frecuente', [App\Http\Controllers\CursoController::class, 'eliminarPreguntaFrecuente']);
    Route::post('/curso/pregunta-frecuente/registrar-pregunta-frecuente', [App\Http\Controllers\CursoController::class, 'agregarPreguntaFrecuente']);
    Route::post('/curso/pregunta-frecuente/actualizar-pregunta-frecuente', [App\Http\Controllers\CursoController::class, 'actualizarPreguntaFrecuente']);
    Route::get('/curso/pregunta-frecuente/registrar/{id}', [App\Http\Controllers\CursoController::class, 'registrarPreguntaFrecuente']);
    Route::get('/curso/pregunta-frecuente/editar/{id}', [App\Http\Controllers\CursoController::class, 'editarPreguntaFrecuente']);

    Route::get('/curso/opinion-estudiante/{id}', [App\Http\Controllers\CursoController::class, 'indexOpinionEstudiante']);
    Route::post('/curso/opinion-estudiante/listar-opinion-estudiante', [App\Http\Controllers\CursoController::class, 'listarOpinionEstudiante']);
    Route::post('/curso/opinion-estudiante/eliminar-opinion-estudiante', [App\Http\Controllers\CursoController::class, 'eliminarOpinionEstudiante']);
    Route::post('/curso/opinion-estudiante/registrar-opinion-estudiante', [App\Http\Controllers\CursoController::class, 'agregarOpinionEstudiante']);
    Route::post('/curso/opinion-estudiante/actualizar-opinion-estudiante', [App\Http\Controllers\CursoController::class, 'actualizarOpinionEstudiante']);
    Route::get('/curso/opinion-estudiante/registrar/{id}', [App\Http\Controllers\CursoController::class, 'registrarOpinionEstudiante']);
    Route::get('/curso/opinion-estudiante/editar/{id}', [App\Http\Controllers\CursoController::class, 'editarOpinionEstudiante']);
});



Route::middleware(['admin:' . PermisoEnum::PortadaInCompany])->group(function () {
    Route::get('/portada-incompany', [App\Http\Controllers\PortadaIncompanyController::class, 'index']);
    Route::post('/portada-incompany/listar-portada-incompany', [App\Http\Controllers\PortadaIncompanyController::class, 'listarPortadaIncompany']);
    Route::post('/portada-incompany/actualizar-portada-incompany', [App\Http\Controllers\PortadaIncompanyController::class, 'actualizarPortadaIncompany']);
    Route::get('/portada-incompany/editar/{id}', [App\Http\Controllers\PortadaIncompanyController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::CaracteristicaInCompany])->group(function () {
    Route::get('/caracteristica-incompany', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'index']);
    Route::post('/caracteristica-incompany/listar-caracteristica-incompany', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'listarCaracteristicaIncompany']);
    Route::post('/caracteristica-incompany/eliminar-caracteristica-incompany', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'eliminarCaracteristicaIncompany']);
    Route::post('/caracteristica-incompany/registrar-caracteristica-incompany', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'registrarCaracteristicaIncompany']);
    Route::post('/caracteristica-incompany/actualizar-caracteristica-incompany', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'actualizarCaracteristicaIncompany']);
    Route::get('/caracteristica-incompany/registrar', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'registrar']);
    Route::get('/caracteristica-incompany/editar/{id}', [App\Http\Controllers\CaracteristicaIncompanyController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::ConfiguracionInCompany])->group(function () {
    Route::get('/configuracion-incompany', [App\Http\Controllers\ConfiguracionIncompanyController::class, 'index']);
    Route::post('/configuracion-incompany/listar-configuracion-incompany', [App\Http\Controllers\ConfiguracionIncompanyController::class, 'listarConfiguracionIncompany']);
    Route::post('/configuracion-incompany/actualizar-configuracion-incompany', [App\Http\Controllers\ConfiguracionIncompanyController::class, 'actualizarConfiguracionIncompany']);
    Route::get('/configuracion-incompany/editar/{id}', [App\Http\Controllers\ConfiguracionIncompanyController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::PortadaPostulacion])->group(function () {
    Route::get('/portada-postulacion', [App\Http\Controllers\PortadaPostulacionController::class, 'index']);
    Route::post('/portada-postulacion/listar-portada-postulacion', [App\Http\Controllers\PortadaPostulacionController::class, 'listarPortadaPostulacion']);
    Route::post('/portada-postulacion/actualizar-portada-postulacion', [App\Http\Controllers\PortadaPostulacionController::class, 'actualizarPortadaPostulacion']);
    Route::get('/portada-postulacion/editar/{id}', [App\Http\Controllers\PortadaPostulacionController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::PortadaFormularioPostulacion])->group(function () {
    Route::get('/portada-formulario-postulacion', [App\Http\Controllers\PortadaFormularioPostulacionController::class, 'index']);
    Route::post('/portada-formulario-postulacion/listar-portada-formulario-postulacion', [App\Http\Controllers\PortadaFormularioPostulacionController::class, 'listarPortadaFormularioPostulacion']);
    Route::post('/portada-formulario-postulacion/actualizar-portada-formulario-postulacion', [App\Http\Controllers\PortadaFormularioPostulacionController::class, 'actualizarPortadaFormularioPostulacion']);
    Route::get('/portada-formulario-postulacion/editar/{id}', [App\Http\Controllers\PortadaFormularioPostulacionController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::NuestrosValoresPostulacion])->group(function () {
    Route::get('/nuestros-valores-postulacion', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'index']);
    Route::post('/nuestros-valores-postulacion/listar-nuestros-valores-postulacion', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'listarNuestrosValoresPostulacion']);
    Route::post('/nuestros-valores-postulacion/eliminar-nuestros-valores-postulacion', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'eliminarNuestrosValoresPostulacion']);
    Route::post('/nuestros-valores-postulacion/registrar-nuestros-valores-postulacion', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'registrarNuestrosValoresPostulacion']);
    Route::post('/nuestros-valores-postulacion/actualizar-nuestros-valores-postulacion', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'actualizarNuestrosValoresPostulacion']);
    Route::get('/nuestros-valores-postulacion/registrar', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'registrar']);
    Route::get('/nuestros-valores-postulacion/editar/{id}', [App\Http\Controllers\NuestrosValoresPostulacionController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::PreguntaFrecuentePostulacion])->group(function () {
    Route::get('/pregunta-frecuente-postulacion', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'index']);
    Route::post('/pregunta-frecuente-postulacion/listar-pregunta-frecuente-postulacion', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'listarPreguntaFrecuentePostulacion']);
    Route::post('/pregunta-frecuente-postulacion/eliminar-pregunta-frecuente-postulacion', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'eliminarPreguntaFrecuentePostulacion']);
    Route::post('/pregunta-frecuente-postulacion/registrar-pregunta-frecuente-postulacion', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'registrarPreguntaFrecuentePostulacion']);
    Route::post('/pregunta-frecuente-postulacion/actualizar-pregunta-frecuente-postulacion', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'actualizarPreguntaFrecuentePostulacion']);
    Route::get('/pregunta-frecuente-postulacion/registrar', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'registrar']);
    Route::get('/pregunta-frecuente-postulacion/editar/{id}', [App\Http\Controllers\PreguntaFrecuentePostulacionController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::OpinionDocente])->group(function () {
    Route::get('/opinion-docente', [App\Http\Controllers\OpinionDocenteController::class, 'index']);
    Route::post('/opinion-docente/listar-opinion-docente', [App\Http\Controllers\OpinionDocenteController::class, 'listarOpinionDocente']);
    Route::post('/opinion-docente/eliminar-opinion-docente', [App\Http\Controllers\OpinionDocenteController::class, 'eliminarOpinionDocente']);
    Route::post('/opinion-docente/registrar-opinion-docente', [App\Http\Controllers\OpinionDocenteController::class, 'registrarOpinionDocente']);
    Route::post('/opinion-docente/actualizar-opinion-docente', [App\Http\Controllers\OpinionDocenteController::class, 'actualizarOpinionDocente']);
    Route::get('/opinion-docente/registrar', [App\Http\Controllers\OpinionDocenteController::class, 'registrar']);
    Route::get('/opinion-docente/editar/{id}', [App\Http\Controllers\OpinionDocenteController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::SeccionContacto])->group(function () {
    Route::get('/seccion-contacto', [App\Http\Controllers\SeccionContactoController::class, 'index']);
    Route::post('/seccion-contacto/listar-seccion-contacto', [App\Http\Controllers\SeccionContactoController::class, 'listarSeccionContacto']);
    Route::post('/seccion-contacto/eliminar-seccion-contacto', [App\Http\Controllers\SeccionContactoController::class, 'eliminarSeccionContacto']);
    Route::post('/seccion-contacto/registrar-seccion-contacto', [App\Http\Controllers\SeccionContactoController::class, 'registrarSeccionContacto']);
    Route::post('/seccion-contacto/actualizar-seccion-contacto', [App\Http\Controllers\SeccionContactoController::class, 'actualizarSeccionContacto']);
    Route::get('/seccion-contacto/registrar', [App\Http\Controllers\SeccionContactoController::class, 'registrar']);
    Route::get('/seccion-contacto/editar/{id}', [App\Http\Controllers\SeccionContactoController::class, 'editar']);
});


Route::middleware(['admin:' . PermisoEnum::SolicitudPostulacion])->group(function () {
    Route::get('/solicitud-postulacion', [App\Http\Controllers\SolicitudPostulacionController::class, 'index']);
    Route::post('/solicitud-postulacion/listar-solicitud-postulacion', [App\Http\Controllers\SolicitudPostulacionController::class, 'listarSolicitudPostulacion']);
    Route::post('/solicitud-postulacion/eliminar-solicitud-postulacion', [App\Http\Controllers\SolicitudPostulacionController::class, 'eliminarSolicitudPostulacion']);
    Route::post('/solicitud-postulacion/recibido-solicitud-postulacion', [App\Http\Controllers\SolicitudPostulacionController::class, 'recibidoSolicitudPostulacion']);
    Route::get('/solicitud-postulacion/detalle/{id}', [App\Http\Controllers\SolicitudPostulacionController::class, 'detalle']);
});

Route::middleware(['admin:' . PermisoEnum::SolicitudContacto])->group(function () {
    Route::get('/solicitud-contacto', [App\Http\Controllers\SolicitudContactoController::class, 'index']);
    Route::post('/solicitud-contacto/listar-solicitud-contacto', [App\Http\Controllers\SolicitudContactoController::class, 'listarSolicitudContacto']);
    Route::post('/solicitud-contacto/eliminar-solicitud-contacto', [App\Http\Controllers\SolicitudContactoController::class, 'eliminarSolicitudContacto']);
    Route::post('/solicitud-contacto/recibido-solicitud-contacto', [App\Http\Controllers\SolicitudContactoController::class, 'recibidoSolicitudContacto']);
    Route::get('/solicitud-contacto/detalle/{id}', [App\Http\Controllers\SolicitudContactoController::class, 'detalle']);
});

Route::middleware(['admin:' . PermisoEnum::SolicitudCotizacion])->group(function () {
    Route::get('/solicitud-cotizacion', [App\Http\Controllers\SolicitudCotizacionController::class, 'index']);
    Route::post('/solicitud-cotizacion/listar-solicitud-cotizacion', [App\Http\Controllers\SolicitudCotizacionController::class, 'listarSolicitudCotizacion']);
    Route::post('/solicitud-cotizacion/obtener-cursos-nombre', [App\Http\Controllers\SolicitudCotizacionController::class, 'obtenerCursosPorNombre']);
    Route::post('/solicitud-cotizacion/eliminar-solicitud-cotizacion', [App\Http\Controllers\SolicitudCotizacionController::class, 'eliminarSolicitudCotizacion']);
    Route::post('/solicitud-cotizacion/recibido-solicitud-cotizacion', [App\Http\Controllers\SolicitudCotizacionController::class, 'recibidoSolicitudCotizacion']);
    Route::get('/solicitud-cotizacion/detalle/{id}', [App\Http\Controllers\SolicitudCotizacionController::class, 'detalle']);
});



Route::middleware(['admin:' . PermisoEnum::Suscripcion])->group(function () {
    Route::get('/suscripcion', [App\Http\Controllers\SuscripcionController::class, 'index']);
    Route::post('/suscripcion/listar-suscripcion', [App\Http\Controllers\SuscripcionController::class, 'listarSuscripcion']);
    Route::post('/suscripcion/eliminar-suscripcion', [App\Http\Controllers\SuscripcionController::class, 'eliminarSuscripcion']);
});


Route::middleware(['admin:' . PermisoEnum::Disponibilidad])->group(function () {
    Route::get('/disponibilidad', [App\Http\Controllers\DisponibilidadController::class, 'index']);
    Route::post('/disponibilidad/listar-disponibilidad', [App\Http\Controllers\DisponibilidadController::class, 'listarDisponibilidad']);
    Route::post('/disponibilidad/eliminar-disponibilidad', [App\Http\Controllers\DisponibilidadController::class, 'eliminarDisponibilidad']);
    Route::post('/disponibilidad/registrar-disponibilidad', [App\Http\Controllers\DisponibilidadController::class, 'registrarDisponibilidad']);
    Route::post('/disponibilidad/actualizar-disponibilidad', [App\Http\Controllers\DisponibilidadController::class, 'actualizarDisponibilidad']);
    Route::get('/disponibilidad/registrar', [App\Http\Controllers\DisponibilidadController::class, 'registrar']);
    Route::get('/disponibilidad/editar/{id}', [App\Http\Controllers\DisponibilidadController::class, 'editar']);
});


Route::middleware(['admin:' . PermisoEnum::MotivoContacto])->group(function () {
    Route::get('/motivo-contacto', [App\Http\Controllers\MotivoContactoController::class, 'index']);
    Route::post('/motivo-contacto/listar-motivo-contacto', [App\Http\Controllers\MotivoContactoController::class, 'listarMotivoContacto']);
    Route::post('/motivo-contacto/eliminar-motivo-contacto', [App\Http\Controllers\MotivoContactoController::class, 'eliminarMotivoContacto']);
    Route::post('/motivo-contacto/registrar-motivo-contacto', [App\Http\Controllers\MotivoContactoController::class, 'registrarMotivoContacto']);
    Route::post('/motivo-contacto/actualizar-motivo-contacto', [App\Http\Controllers\MotivoContactoController::class, 'actualizarMotivoContacto']);
    Route::get('/motivo-contacto/registrar', [App\Http\Controllers\MotivoContactoController::class, 'registrar']);
    Route::get('/motivo-contacto/editar/{id}', [App\Http\Controllers\MotivoContactoController::class, 'editar']);
});

Route::middleware(['admin:' . PermisoEnum::ImportarCurso])->group(function () {
    Route::get('/importar-curso', [App\Http\Controllers\ImportarCursoController::class, 'index']);
    Route::post('/importar-curso/visualizar-importar-curso', [App\Http\Controllers\ImportarCursoController::class, 'visualizarImportarCurso']);
    Route::post('/importar-curso/store-importar-curso', [App\Http\Controllers\ImportarCursoController::class, 'storeImportarCurso']);
});