<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('encuentra_curso_ideal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo');
            $table->string('subtitulo');
            $table->string('titulo_enlace')->nullable();
            $table->string('enlace')->nullable();
            $table->string('imagen')->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('encuentra_curso_ideal');
    }
};
