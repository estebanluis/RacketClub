<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class producto extends Model
{
    protected $table='productos';
    protected $primaryKey = 'id_producto';
    
    // Si tu clave primaria no es un campo auto-incremental, también debes especificar:
    public $incrementing = false;

    // Definir el tipo de la clave primaria si no es integer
    protected $keyType = 'int';

    // Definir los campos que son asignables en masa (mass assignment)
    
    protected $guarded = [];
    protected $fillable=[
    'nombre',
    'precio',
    'categoria',
    'stock',
    'id_producto',

    ];
    use HasFactory;
    
}