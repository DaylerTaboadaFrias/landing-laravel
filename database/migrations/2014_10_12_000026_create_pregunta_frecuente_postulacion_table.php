<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('pregunta_frecuente_postulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->text('pregunta');
            $table->text('respuesta');
            $table->integer('orden');
            $table->boolean('habilitado'); 
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('pregunta_frecuente_postulacion');
    }
};
