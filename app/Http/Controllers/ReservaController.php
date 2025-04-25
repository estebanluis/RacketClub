<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validated = $request->validate([
            'CI' => 'required',
            'deporte' => 'required',
            'cancha_id' => 'required|exists:canchas,id',
            'dia' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'cantidadHoras' => 'required|numeric|min:1',
            'dias_semana' => 'nullable|array',
            'observaciones' => 'nullable|string|max:255',
        ]);
        
        // Formateo de las horas y la fecha
        $hora_inicio = Carbon::createFromFormat('H:i', $request->hora)->format('H:i:s');
        $hora_fin = Carbon::createFromFormat('H:i', $request->hora)
                        ->addHours($request->cantidadHoras)
                        ->format('H:i:s');
        $fechaInicio = Carbon::parse($request->dia)->format('Y-m-d');  // Solo la fecha sin la hora
        
        $diasSeleccionados = $request->dias_semana ?? [];
        
        $reservaCreada = false;  // Bandera para saber si se registró al menos una reserva
        $mensajeError = '';  // Variable para almacenar el mensaje de error
        
        if (empty($diasSeleccionados)) {
            // Verificar si ya existe una reserva en el mismo día y horario
            $conflicto = Reserva::where('cancha_id', $request->cancha_id)
                ->whereDate('dia', $fechaInicio)
                ->where(function ($query) use ($hora_inicio, $hora_fin) {
                    $query->where(function ($query) use ($hora_inicio, $hora_fin) {
                        // Verificar si las horas se solapan
                        $query->whereTime('hora', '<', $hora_fin)
                              ->whereTime('hora', '>', $hora_inicio);
                    });
                })
                ->exists();
               
    
            if ($conflicto == false) {
                // Crear la reserva si no hay conflicto
                Reserva::create([
                    'CI' => $request->CI,
                    'deporte' => $request->deporte,
                    'cancha_id' => $request->cancha_id,
                    'dia' => $fechaInicio,
                    'hora' => $hora_inicio,
                    'cantidadHoras' => $request->cantidadHoras,
                    'observaciones' => $request->observaciones,
                ]);
                $reservaCreada = true;
            } else {
                // Si hay conflicto, generar mensaje de error
                $mensajeError = 'La cancha está ocupada en el horario seleccionado.';
            }
        } else  $fechaFin = Carbon::parse($fechaInicio)->copy()->addWeek()->toDateString();
        $fechasValidas = []; // Guardar las fechas sin conflicto
        $diasConConflicto = [];
    
        foreach (CarbonPeriod::create($fechaInicio, $fechaFin) as $fecha) {
            $fechaString = $fecha->toDateString();
    
            if (in_array(ucfirst($fecha->translatedFormat('l')), $diasSeleccionados)) {
                $conflicto = Reserva::where('cancha_id', $request->cancha_id)
                    ->whereDate('dia', $fechaString)
                    ->where(function ($query) use ($hora_inicio, $hora_fin) {
                        $query->whereRaw('DATE_ADD(hora, INTERVAL cantidadHoras HOUR) > ?', [$hora_inicio])
                              ->whereRaw('hora < ?', [$hora_fin]);
                    })
                    ->exists();
    
                if ($conflicto) {
                    $diasConConflicto[] = $fecha->translatedFormat('l, d/m/Y');
                } else {
                    $fechasValidas[] = $fechaString;
                }
            }
        }
    
        if (count($diasConConflicto) > 0) {
            $mensajeError = "La cancha no está disponible en los siguientes días:\n\n";
            foreach ($diasConConflicto as $dia) {
                $mensajeError .= "- $dia\n";
            }
            Alert::warning('Advertencia', $mensajeError);
            return redirect()->back()
                ->withInput()
                ->with('show_modal', 'registerReservaModal');
        }
    
        // Si no hubo conflictos, se registran todas las reservas
        foreach ($fechasValidas as $fechaString) {
            Reserva::create([
                'CI' => $request->CI,
                'deporte' => $request->deporte,
                'cancha_id' => $request->cancha_id,
                'dia' => $fechaString,
                'hora' => $hora_inicio,
                'cantidadHoras' => $request->cantidadHoras,
                'observaciones' => $request->observaciones,
            ]);
            $reservaCreada = true;
        }

        Alert::success('EXITO', "Las reservas fueron registras !");
        return redirect()->back();
    }
    
    }

