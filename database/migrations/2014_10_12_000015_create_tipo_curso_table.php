<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tipo_curso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('orden');
            $table->boolean('habilitado'); 
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('tipo_curso');
    }
};
