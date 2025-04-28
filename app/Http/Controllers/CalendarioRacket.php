<?php

namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Deporte;
use App\Models\Reserva;
use App\Models\UsuarioRacket;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CalendarioRacket extends Controller
{
    public function index()
    {
        $usuarios = UsuarioRacket::all();
        $canchas = Cancha::all();
        $deportes = Deporte::with('canchas')->get();

        return view('ReservarCanchasCalendario.reservasCanchas', [ 'canchas' => $canchas, 'deportes' => $deportes,'usuarios' => $usuarios]);
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

    
    public function buscarUsuarios(Request $request)
    {
        $query = $request->get('query');
        
        // Buscar usuarios que coincidan con el nombre (o la CI, si es necesario)
        $usuarios = UsuarioRacket::where('nombre', 'like', '%' . $query . '%')->get();
    
        return response()->json($usuarios);
    }


    public function verificarDisponibilidad(Request $request)
    {
        $canchaId = $request->cancha_id;
        $fecha = $request->fecha;
        $hora = $request->hora;
        $duracion = $request->cantidadHoras; // Duración en horas

        // Calcular la hora de fin
        $hora_fin = \Carbon\Carbon::parse($hora)->addHours($duracion)->toTimeString();

        // Verificar si ya existe una reserva en ese horario
        $conflicto = Reserva::where('cancha_id', $canchaId)
                            ->whereDate('dia', $fecha)
                            ->where(function ($query) use ($hora, $hora_fin) {
                                $query->where(function ($q) use ($hora, $hora_fin) {
                                    $q->whereRaw('hora <= ?', [$hora_fin])
                                    ->whereRaw('DATE_ADD(hora, INTERVAL cantidadHoras HOUR) > ?', [$hora]);
                                });
                                $query->orWhere(function ($q) use ($hora, $hora_fin) {
                                    $q->whereRaw('hora < ?', [$hora_fin])
                                    ->whereRaw('DATE_ADD(hora, INTERVAL cantidadHoras HOUR) > ?', [$hora]);
                                });
                            })
                            ->exists();

        if ($conflicto) {
            return response()->json([
                'disponible' => false,
                'mensaje' => 'La cancha ya está reservada para esa hora.',
            ]);
        }

        return response()->json([
            'disponible' => true,
        ]);
    }
   
    public function store(Request $request)
    {
        $request->validate([
          //  'CI' => 'required|exists:usuarios_racket,CI',
            'usuario_nombre' => 'required|string',
            'deporte' => 'required|exists:deportes,id',
            'horas' => 'required|array',
            'horas.*' => 'required|date_format:H:i',
            'duraciones' => 'required|array',
            'duraciones.*' => 'required|integer|min:1',
            'canchas' => 'required|array',
            'canchas.*' => 'required|exists:canchas,id',
        ]);
        $usuario = UsuarioRacket::where('nombre', $request->usuario_nombre)->first();

        if (!$usuario) {
            Alert::warning('Error', 'Usuario no encontrado debe registrarlo.');
            return redirect()->route('calendario.index');
        }else{
            $id = UsuarioRacket::where('nombre', $request->usuario_nombre)->first()->CI;
            foreach ($request->horas as $fecha => $hora) {
                $reserva = new Reserva();
                $reserva->CI = $id;
                $reserva->dia = $fecha;
                $reserva->hora = $hora;
                $reserva->cantidadHoras = $request->duraciones[$fecha];
                $reserva->cancha_id = $request->canchas[$fecha];
                $reserva->deporte = $request->deporte;
                $reserva->save();
            }
            Alert::success('Exito', 'reservas registradas exitosamente.');
            return redirect()->route('calendario.index');
        }
        
    }
}