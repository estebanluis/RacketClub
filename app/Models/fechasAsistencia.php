<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fechasAsistencia extends Model
{   
    protected $table='fechasasistencia';
    protected $fillable=[
        'fecha',
        'codigoAlumno'
        
        
        ];
    use HasFactory;
}
