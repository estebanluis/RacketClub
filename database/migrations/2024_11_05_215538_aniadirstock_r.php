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
        Schema::create('aniadirStockr', function (Blueprint $table) {
            $table->id();
            $table->string('nombreProductoR');
            $table->integer('id_producto_aniadidoR');
            $table->integer('catidad_aniadidaR');
            $table->string('responsableR');
            $table->integer('pago_distribuidorR');
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
