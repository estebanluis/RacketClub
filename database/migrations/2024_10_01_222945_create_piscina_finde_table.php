<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('piscinaFinde', function (Blueprint $table) {
            $table->id(); // Campo id
            $table->string('nombre');
            $table->integer('adultos');
            $table->integer('ninos');
            $table->boolean('estado')->default(true); 
            $table->string('fecha');
            $table->text('observaciones');
            $table->integer('total');
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('piscinaExtra');
    }
};
