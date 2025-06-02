<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('modulo', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('icono');
            $table->string('identificador');
            $table->integer('orden');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('modulo');
    }
};
