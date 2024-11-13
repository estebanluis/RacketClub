<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventasR extends Model
{
    protected $table='ventasR';
    protected $primaryKey = 'id_ventaR';
    
    // Si tu clave primaria no es un campo auto-incremental, también debes especificar:
    public $incrementing = false;

    // Definir el tipo de la clave primaria si no es integer
    protected $keyType = 'int';

    // Definir los campos que son asignables en masa (mass assignment)
    
    protected $guarded = [];
    protected $fillable=[
    'nombreR',
    'totalR',
    'vendedorR',
    'cantidadR'
    ,

    ];
    use HasFactory;
}
