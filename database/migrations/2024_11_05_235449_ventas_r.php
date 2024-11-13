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
        Schema::create('ventasR', function (Blueprint $table) {

            $table->id('id_ventaR');
            $table->string('nombreR');
            $table->string('vendedorR');
            $table->integer('cantidadR',)->nullable();
            $table->integer('totalR');
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
