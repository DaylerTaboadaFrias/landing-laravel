<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('permiso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('url');
            $table->string('identificador');
            $table->integer('orden');
            $table->unsignedInteger('id_modulo');
            $table->foreign('id_modulo')->references('id')->on('modulo');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('permiso');
    }
};
