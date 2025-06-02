<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('solicitud_contacto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo');
            $table->string('correo');
            $table->string('telefono');
            $table->text('consulta');
            $table->boolean('eliminado');
            $table->boolean('recibido');
            $table->unsignedInteger('id_motivo_contacto');
            $table->foreign('id_motivo_contacto')->references('id')->on('motivo_contacto');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('solicitud_contacto');
    }
};
