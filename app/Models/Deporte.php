<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deporte extends Model
{
    use HasFactory;

    protected $fillable = ['nombre'];

    public $timestamps = false;
    public function canchas()
    {
        return $this->belongsToMany(Cancha::class);
    }
}