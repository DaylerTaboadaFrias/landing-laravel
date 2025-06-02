<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('docente', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_docente_externo')->nullable();
            $table->string('nombre_completo');
            $table->string('prefijo_academico')->nullable();
            $table->string('profesion');
            $table->text('biografia');
            $table->string('enlace_linkedin');
            $table->string('imagen')->nullable();
            $table->boolean('habilitado'); 
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('docente');
    }
};
