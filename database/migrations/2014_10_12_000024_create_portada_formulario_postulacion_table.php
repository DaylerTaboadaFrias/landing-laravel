<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('portada_formulario_postulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imagen');
            $table->string('enlace')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('portada_formulario_postulacion');
    }
};
