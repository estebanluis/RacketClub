<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aniadirstock extends Model
{
    use HasFactory;

    protected $table = 'aniadirStock';
    protected $fillable = [
        'nombreProducto',
        'id_producto_aniadido',
        'catidad_aniadida',
        'responsable',
        'pago_distribuidor',
        
        
    ];
}
