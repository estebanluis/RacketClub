<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->increments('idHorario');
            $table->unsignedInteger('id_user')->nullable(); 
            $table->foreign('id_user')->references('id_user')->on('users'); 
            $table->string('fecha');
            $table->string('hora');
            $table->string('carril');
            $table->integer('nalumnos');
            $table->integer('salario');
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('horarios');
    }
};
