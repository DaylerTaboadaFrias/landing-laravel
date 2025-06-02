<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cola_envio_correo', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('enviado');
            $table->string('correo');
            $table->unsignedInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('curso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cola_envio_correo');
    }
};
