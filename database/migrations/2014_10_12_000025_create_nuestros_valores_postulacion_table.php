<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('nuestros_valores_postulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->integer('orden');
            $table->boolean('habilitado');
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('nuestros_valores_postulacion');
    }
};
