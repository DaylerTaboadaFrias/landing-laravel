<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('categoria_curso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->boolean('mostrar_inicio');
            $table->string('imagen')->nullable();
            $table->integer('orden')->nullable();
            $table->boolean('habilitado');
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('categoria_curso');
    }
};
