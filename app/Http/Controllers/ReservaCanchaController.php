<?php
namespace App\Http\Controllers;

use App\Models\ReservaCancha;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use Illuminate\Support\Facades\DB;

class ReservaCanchaController extends Controller
{
    public function index()
    {
        $barang = ReservaCancha::orderBy('nombre_reserva', 'asc')->get();
        
        // Formatear las reservas para FullCalendar
        $events = $barang->map(function ($data) {
            return [
                'id' => $data->id,
                'title' => $data->nombre_reserva,
                'start' => $data->fecha . 'T' . $data->hora,
                'extendedProps' => [
                    'numeroCancha' => $data->numero_cancha,
                    'tiempoReserva' => $data->tiempoReserva,
                    'tipo' => $data->tipo,
                    'observaciones' => $data->observaciones,
                ],
            ];
        });
        
        return view('ReservarCanchas.reservasCanchas', [
            'barang' => $barang,
            'events' => $events,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'hora' => 'required',
            'cancha' => 'required|integer|min:1|max:4',
            'fecha' => 'required|date',
            'tiempoReserva' => 'required|integer|min:1',
            'observaciones' => 'nullable|string|max:500',
            'deporte' => 'required|in:racket,wally',
        ]);
    
        if ($request->input('fecha') < now()->toDateString()) {
            Alert::error('Error', 'La Reserva no puede ser registrada, la fecha no es válida!');
            return redirect('/rcancha')->withInput();
        }
    
        // Calcular hora de inicio y fin
        $horaInicio = $request->input('hora');
        $tiempoReserva = $request->input('tiempoReserva');
        $horaFin = \Carbon\Carbon::createFromFormat('H:i', $horaInicio)->addHours($tiempoReserva)->format('H:i');
    
        // Verificar si ya hay una reserva en la cancha para ese rango de horas
        $ocupada = ReservaCancha::where('numero_cancha', $request->input('cancha'))
            ->where('fecha', $request->input('fecha'))
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->whereBetween('hora', [$horaInicio, $horaFin])
                      ->orWhereBetween(DB::raw("DATE_ADD(hora, INTERVAL tiempoReserva HOUR)"), [$horaInicio, $horaFin]);
            })
            ->exists();
    
        if ($ocupada) {
            Alert::error('Error', 'La cancha ya está ocupada en ese horario!');
            return redirect('/rcancha')->withInput();
        }
    
        try {
            ReservaCancha::create([
                'nombre_reserva' => $request->input('name'),
                'hora' => $horaInicio,
                'numero_cancha' => $request->input('cancha'),
                'fecha' => $request->input('fecha'),
                'tiempoReserva' => $request->input('tiempoReserva'),
                'observaciones' => $request->input('observaciones'),
                'tipo' => $request->input('deporte'),
            ]);
    
            Alert::success('Éxito', 'La Reserva fue Registrada!');
            return redirect('/rcancha');
        } catch (Exception $e) {
            Alert::error('Error', 'La Reserva no pudo ser registrada, intente nuevamente!');
            return redirect('/rcancha')->withInput();
        }
    }
    

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'hora' => 'required',
            'numero_cancha' => 'required|integer|min:1|max:4',
        ]);

        try {
            $reserva = ReservaCancha::findOrFail($id);
            $reserva->hora = $request->input('hora');
            $reserva->numero_cancha = $request->input('numero_cancha');
            $reserva->save();

            Alert::success('Éxito', 'La Reserva fue actualizada correctamente!');
            return redirect('/rcancha');
        } catch (Exception $e) {
            Alert::error('Error', 'No se pudo actualizar la reserva, intente de nuevo.');
            return redirect('/rcancha')->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $reserva = ReservaCancha::findOrFail($id);
            $reserva->delete();

            Alert::success('Éxito', 'La Reserva fue eliminada correctamente!');
            return redirect('/rcancha');
        } catch (Exception $e) {
            Alert::error('Error', 'No se pudo eliminar la reserva, intente de nuevo.');
            return redirect('/rcancha');
        }
    }
}
