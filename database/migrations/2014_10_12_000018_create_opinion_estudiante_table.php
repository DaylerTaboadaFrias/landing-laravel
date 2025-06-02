<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('opinion_estudiante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre_completo');
            $table->string('profesion')->nullable();
            $table->text('opinion');
            $table->integer('orden');
            $table->boolean('habilitado');
            $table->unsignedInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('curso');
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('opinion_estudiante');
    }
};
