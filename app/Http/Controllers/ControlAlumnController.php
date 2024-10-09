<?php

namespace App\Http\Controllers;

use App\Models\RegistroAlumno;
use App\Models\fechasasistencia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ControlAlumnController extends Controller
{
    public function indexAsistencia()
    {
        return view('registrarAlumn.controlAlumn');
    }

    public function update(Request $request)
    {
        $codigo = $request->input('codigo');
        $registro = RegistroAlumno::where('codigo', $codigo)->first();

        if (!$registro) {
            // Si el alumno no existe, vuelve atrás con un mensaje de error
            return back()->with('error', 'No existe este alumno');
        }

        // Si el alumno existe, procedemos a registrar la asistencia
        $asistencia = new fechasasistencia();
        $asistencia->codigoAlumno = $codigo;
        $asistencia->fecha = now(); // Obtiene la fecha y hora actual
        $asistencia->save();

        // Obtener fechas de asistencia para el calendario
        $fechasAsistencia = fechasasistencia::where('codigoAlumno', $codigo)
            ->get(['fecha'])
            ->map(function ($asistencia) {
                return [
                    'title' => 'Asistencia',
                    'start' => $asistencia->fecha,
                ];
            })->toArray();

        // Calcular la fecha de vencimiento y mensajes
        $modalidad = $registro->modalidad;
        $fechaVencimiento = null;
        switch ($modalidad) {
            case "Natación curso completo" :
                $fechaVencimiento = Carbon::now()->addDays(31);
                break;
            case "Natación*3 semana 12":
                $fechaVencimiento = Carbon::now()->addDays(15);
                break;
            case "Natación*3 semana 20":
                $fechaVencimiento = Carbon::now()->addDays(30);
                break;
            case "Natación medio curso":
                $fechaVencimiento = Carbon::now()->addDays(49);
                break;
            default:
                // Modalidad desconocida
        }

        if ($registro->nrsesiones < 1) {
            $registro->nrsesiones = 0;
            $message = 'Tiene '.$registro->nrsesiones.' sesiones restantes';
            $message1= 'Vence en fecha: '.$fechaVencimiento->format('d-m-y');
            $message2= 'Nombre: '.$registro->nombre.' '.$registro->apellido.' '.$registro->apellidoMat;
        } else {
            $registro->nrsesiones -= 1;
            $registro->save();
            $message = 'Tiene '.$registro->nrsesiones.' sesiones restantes';
            $message1= 'Vence en fecha: '.$fechaVencimiento->format('d-m-y');
            $message2= 'Nombre: '.$registro->nombre.' '.$registro->apellido.' '.$registro->apellidoMat;
        }

        $messages = [
            'message' => $message,
            'message1' => $message1,
            'message2' => $message2,
        ];

        return view('registrarAlumn.controlAlumn', compact('fechasAsistencia', 'messages'));
    }
}
