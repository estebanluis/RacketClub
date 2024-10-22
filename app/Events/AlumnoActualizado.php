<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AlumnoActualizado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $datosAlumno;

    public function __construct($datosAlumno)
    {
        $this->datosAlumno = $datosAlumno;

        // Guardar los datos en caché para que el canal SSE los pueda acceder
        cache()->put('alumno_actualizado', $this->datosAlumno);
    }
}
