<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionRacket extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención pluralizada
    protected $table = 'atencionRacket';

    // Define los campos que pueden ser asignados en masa
    protected $fillable = [
        'nombre',
        'tipo',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'total_horas',
        'saldo_cancha',
        'saldo_venta',
        'total',
        'cancha',
        'estado',
        'observaciones',
    ];
}
