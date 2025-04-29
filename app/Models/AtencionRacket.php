<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtencionRacket extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención pluralizada
    public $timestamps = false;
        protected $table = 'atencionRacket';

    // Define los campos que pueden ser asignados en masa
    protected $fillable = [
        'nombre',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'total_horas',
        'total',
        'cancha',
        'estado',
        'observaciones',
    ];
    public function cancha()
{
    return $this->belongsTo(Cancha::class, 'cancha');
}
}
