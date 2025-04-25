<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Deporte;
use App\Models\Reserva;
use Illuminate\Http\Request;

class CalendarioRacket extends Controller
{
    public function index()
    {
        $canchas = Cancha::all();
        $deportes = Deporte::with('canchas')->get();

        return view('ReservarCanchasCalendario.reservasCanchas', [ 'canchas' => $canchas, 'deportes' => $deportes]);
    }

    public function getReservas()
    {
        $reservas = Reserva::with(['usuario', 'cancha', 'deporteRelacion'])->get();

        $eventos = $reservas->map(function ($reserva) {
            return [
                'title' => ($reserva->deporteRelacion->nombre ?? 'Deporte') . ' - ' .
                        ($reserva->usuario->nombre ?? $reserva->CI) . ' - ' .
                        ($reserva->cancha->nombre ?? 'Cancha'),
                'start' => $reserva->dia . 'T' . $reserva->hora,
                'end' => \Carbon\Carbon::parse($reserva->dia . ' ' . $reserva->hora)
                            ->addHours($reserva->cantidadHoras)
                            ->format('Y-m-d\TH:i:s'),
            ];
        });

        return response()->json($eventos);
    }
    
}
