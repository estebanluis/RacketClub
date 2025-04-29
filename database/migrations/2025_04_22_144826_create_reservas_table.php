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
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->string('CI');
            $table->foreign('CI')->references('CI')->on('usuarios_racket')->onDelete('cascade');
            
            $table->foreignId('cancha_id')->constrained('canchas')->onDelete('cascade');

            $table->date('dia');
            $table->time('hora');
            $table->integer('cantidadHoras');
            $table->string('deporte');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
