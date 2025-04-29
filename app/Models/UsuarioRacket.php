<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRacket extends Model
{
    use HasFactory;

    // Asegúrate de que el nombre de la tabla esté bien configurado
    protected $table = 'usuarios_racket';

    protected $primaryKey = 'CI'; // Usamos CI como clave primaria
    public $incrementing = false; // No será autoincrementable
    protected $fillable = ['CI', 'nombre', 'telefono'];
    public $timestamps = false;
    // Relación con las reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'CI', 'CI'); // Un usuario tiene muchas reservas
    }
}
