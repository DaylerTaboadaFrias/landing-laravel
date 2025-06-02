<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('solicitud_postulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo');
            $table->string('perfil_profesional');
            $table->string('especializaciones');
            $table->string('telefono');
            $table->string('correo');
            $table->text('experiencia');
            $table->text('referencias');
            $table->string('archivo')->nullable();
            $table->boolean('eliminado');
            $table->boolean('recibido');
            $table->unsignedInteger('id_disponibilidad');
            $table->foreign('id_disponibilidad')->references('id')->on('disponibilidad');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('solicitud_postulacion');
    }
};
