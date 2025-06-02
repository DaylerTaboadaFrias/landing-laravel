<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('seccion_contacto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('direccion');
            $table->string('telefono');
            $table->integer('codigo_area');
            $table->integer('celular');
            $table->string('correo');
            $table->string('enlace_facebook');
            $table->string('enlace_instagram');
            $table->string('enlace_linkedin');
            $table->string('enlace_pago');
            $table->string('enlace_inicio_sesion');
            $table->string('enlace_registro');
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('seccion_contacto');
    }
};
