<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiscinaExtra extends Model
{
    use HasFactory;

    // Definir la tabla asociada
    protected $table = 'piscinaFinde';

    // Definir los atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'estado',
        'fecha',
        'adultos',
        'ninos',
        'observaciones',
        'total',
    ];
    protected $casts = [
        'estado' => 'boolean',
    ];
}
