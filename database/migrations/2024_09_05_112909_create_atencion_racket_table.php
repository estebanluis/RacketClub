<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateAtencionRacketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencionRacket', function (Blueprint $table) {
            $table->id(); // Campo 'id' autoincrementable
            $table->string('nombre'); // Campo 'nombre' para el nombre de la reserva o cliente
            $table->string('tipo');
            $table->date('fecha'); // Campo 'fecha' para la fecha de la reserva
            $table->time('hora_inicio'); // Campo 'hora de inicio'
            $table->time('hora_fin'); // Campo 'hora de fin'
            $table->string('total_horas'); // Campo 'total de horas'
            $table->decimal('saldo_cancha', 8, 2); // Campo 'saldo cancha', con 8 dígitos en total y 2 decimales
            $table->decimal('saldo_venta', 8, 2); // Campo 'saldo venta', con 8 dígitos en total y 2 decimales
            $table->integer('cancha'); 
            $table->decimal('total', 8, 2); // Campo 'total', con 8 dígitos en total y 2 decimales
            $table->timestamps(); // Campos 'created_at' y 'updated_at'
            $table->string('estado');
            $table->text('observaciones')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atencionRacket');
    }
}
