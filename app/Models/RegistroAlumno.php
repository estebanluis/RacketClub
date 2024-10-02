<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroAlumno extends Model
{
    protected $table='clientes';
    protected $guarded = [];
    protected $fillable=[
    'nombre',
    'codigo',
    'modalidad',
    'apellido',
    'usuario',
    'horario',
    'observciones',
    'nrsesiones',
    'apellidoMat',
    'direccion',
    'costo',
    'descuento',
    'edad',
    'telefono',
    'nroReinscripciones'
    
    ];
    use HasFactory;

}
