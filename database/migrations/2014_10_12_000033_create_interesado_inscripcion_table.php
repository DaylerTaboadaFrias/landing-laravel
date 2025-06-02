<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('interesado_inscripcion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo');
            $table->string('telefono');
            $table->string('correo');
            $table->boolean('agente_comercial');
            $table->boolean('eliminado');
            $table->boolean('recibido');
            $table->unsignedInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('curso');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('interesado_inscripcion');
    }
};
