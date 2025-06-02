<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('curso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_curso_externo')->nullable();
            $table->integer('orden');
            $table->string('nombre');
            $table->string('duracion');
            $table->integer('recursos_disponibles');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('precio',11,2);
            $table->decimal('precio_descuento',11,2)->nullable();
            $table->decimal('descuento',11,2)->nullable();
            $table->text('resumen');
            $table->text('requisitos')->nullable();
            $table->text('objetivos')->nullable();
            $table->text('contenido')->nullable();
            $table->string('archivo')->nullable();
            $table->string('imagen')->nullable();
            $table->boolean('curso_popular');
            $table->boolean('curso_ideal');
            $table->boolean('notificar_suscriptores');
            $table->boolean('habilitado');
            $table->unsignedInteger('id_docente');
            $table->foreign('id_docente')->references('id')->on('docente');
            $table->unsignedInteger('id_subcategoria_curso');
            $table->foreign('id_subcategoria_curso')->references('id')->on('subcategoria_curso');
            $table->unsignedInteger('id_modalidad');
            $table->foreign('id_modalidad')->references('id')->on('modalidad');
            $table->unsignedInteger('id_tipo_curso');
            $table->foreign('id_tipo_curso')->references('id')->on('tipo_curso');
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('curso');
    }
};
