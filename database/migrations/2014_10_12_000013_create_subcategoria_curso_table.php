<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('subcategoria_curso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('habilitado');
            $table->integer('orden');
            $table->boolean('eliminado');
            $table->unsignedInteger('id_categoria_curso');
            $table->foreign('id_categoria_curso')->references('id')->on('categoria_curso');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('subcategoria_curso');
    }
};
