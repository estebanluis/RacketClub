<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('apellidoMat');
            $table->string('direccion');
            $table->integer('costo')->nullable();
            $table->integer('codigo')->unique();
            $table->string('modalidad');
            $table->string('horario');
            $table->string('observciones')->nullable();
            $table->string('usuario');
            $table->integer('nrsesiones');
            $table->integer('descuento')->nullable();
            $table->integer('edad');
            $table->bigInteger('telefono');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
