<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $fillable = ['cancha_id', 'precio'];

    public function cancha()
    {
        return $this->belongsTo(Cancha::class);
    }
}
