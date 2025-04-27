<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = ['CI', 'cancha_id', 'dia', 'hora', 'cantidadHoras', 'deporte'];

    // Relación con el usuario (usuario que realiza la reserva)
    public function usuario()
    {
        return $this->belongsTo(UsuarioRacket::class, 'CI', 'CI');
    }

    // Relación con la cancha reservada
    public function cancha()
    {
        return $this->belongsTo(Cancha::class, 'cancha_id');
    }
    //relacion con deporte
    public function deporteRelacion()
    {
        return $this->belongsTo(Deporte::class, 'deporte'); // 'deporte' es la FK en la tabla reservas
    }
}
