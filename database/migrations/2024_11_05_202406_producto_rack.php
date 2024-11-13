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
        Schema::create('productosr', function (Blueprint $table) {
            $table->integer('id_productoR');
            $table->string('nombreR', 100);
            $table->string('categoriaR', 50);
            $table->integer('stockR');
            $table->integer('precioR');
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
