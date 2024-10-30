<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sesiones extends Model
{
    protected $table='sesiones';
    protected $fillable=[
        'nombreSesion',
        'encargado',
        'cantHoras',
        'pago'
        
        
        ];
    use HasFactory;
}
