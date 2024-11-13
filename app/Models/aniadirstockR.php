<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aniadirstockR extends Model
{
    protected $table = 'aniadirStockr';
    protected $fillable = [
        'nombreProductoR',
        'id_producto_aniadidoR',
        'catidad_aniadidaR',
        'responsableR',
        'pago_distribuidorR',
        
        
    ];
}
