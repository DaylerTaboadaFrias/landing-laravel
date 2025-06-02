<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('configuracion_incompany', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correo');
            $table->integer('codigo_area');
            $table->integer('celular');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('configuracion_incompany');
    }
};
