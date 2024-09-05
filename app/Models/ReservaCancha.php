<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservaCancha extends Model
{
    use HasFactory;

    protected $table = 'reservas_cancha';

    protected $fillable = [
        'nombre_reserva',
        'hora',
        'numero_cancha',
        'fecha' // Agregamos la columna 'fecha'
    ];
}
