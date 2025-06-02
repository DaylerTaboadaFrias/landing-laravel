<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombres');
            $table->string('apellidos');
            $table->string('correo');
            $table->string('nombre_usuario');
            $table->string('codigo_recuperacion_password')->nullable();
            $table->string('token_recuperacion_password')->nullable();
            $table->string('password');
            $table->boolean('habilitado');
            $table->boolean('eliminado');
            $table->unsignedInteger('id_rol');
            $table->foreign('id_rol')->references('id')->on('rol');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('usuario');
    }
};
