<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('suscripcion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('correo');
            $table->boolean('eliminado');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::drop('suscripcion');
    }
};
