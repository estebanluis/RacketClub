<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancha extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public function deportes()
    {
        return $this->belongsToMany(Deporte::class);
    }

    public function precio()
{
    return $this->hasOne(Precio::class, 'cancha_id');
}
}
