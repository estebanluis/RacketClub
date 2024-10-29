<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Horario extends Model
{
    use HasFactory;

    protected $table = 'horarios';

    protected $primaryKey = 'idHorario';

    protected $fillable = [
        'id_user',
        'fecha',
        'hora',
        'carril',
        'nalumnos',
        'salario',
        'observaciones',
    ];

    // Relación con el modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
