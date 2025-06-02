<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('cotizacion_incompany', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_empresa');
            $table->string('nombre_responsable');
            $table->string('telefono_responsable');
            $table->string('correo_responsable');
            $table->string('duracion_curso');
            $table->date('fecha_curso');
            $table->string('localizacion_curso');
            $table->integer('numero_participante');
            $table->text('expectativa_curso');
            $table->boolean('eliminado');
            $table->boolean('recibido');
            $table->unsignedInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('curso');
            $table->unsignedInteger('id_modalidad');
            $table->foreign('id_modalidad')->references('id')->on('modalidad');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('cotizacion_incompany');
    }
};
