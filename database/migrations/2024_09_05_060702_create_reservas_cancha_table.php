<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasCanchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservas_cancha', function (Blueprint $table) {
            $table->id(); // Campo 'id' autoincrementable
            $table->string('nombre_reserva');
            $table->string('tipo'); 
            $table->time('hora'); // Campo 'hora'
            $table->integer('numero_cancha'); // Campo 'numeroCancha'
            $table->date('fecha'); // Campo 'fecha' para almacenar la fecha de la reserva
            $table->text('observaciones')->nullable(); // Campo para observaciones
            $table->integer('tiempoReserva')->nullable(); 
            $table->timestamps(); // Agrega 'created_at' y 'updated_at'

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservas_cancha');
    }
}
