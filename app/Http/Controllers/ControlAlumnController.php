<?php

namespace App\Http\Controllers;
use App\Models\RegistroAlumno;
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

        if ($registro) {
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
                $message = 'Tiene '.$registro->nrsesiones.' sesiones restantes. Vence en fecha: '.$fechaVencimiento->format('d-m-y').'. Nombre: '.$registro->nombre.' '.$registro->apellido.' '.$registro->apellidoMat;
           
            } else {
                $registro->nrsesiones -= 1;
                $registro->save();
                $message = 'Tiene '.$registro->nrsesiones.' sesiones restantes. Vence en fecha: '.$fechaVencimiento->format('d-m-y').'. Nombre: '.$registro->nombre.' '.$registro->apellido.' '.$registro->apellidoMat;
            }

            return back()->with('message', $message);
        } else {
            return back()->with('message', 'No existe este alumno');
        }
    }
}
