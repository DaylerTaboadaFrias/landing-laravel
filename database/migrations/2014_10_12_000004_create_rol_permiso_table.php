<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rol_permiso', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_rol');
            $table->foreign('id_rol')->references('id')->on('rol');
            $table->unsignedInteger('id_permiso');
            $table->foreign('id_permiso')->references('id')->on('permiso');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('rol_permiso');
    }
};
