<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HorasProfesorController extends Controller
{
    public function index()
    {
        $id_usuario = Auth::id();

        // Obtener los horarios del profesor actual
        $horarios = DB::table('horarios')
            ->where('id_user', $id_usuario)
            ->select('fecha', 'hora', 'nalumnos', 'carril', 'observaciones')
            ->get()
            ->map(function ($horario) {
                // Dividir la hora en start y end usando el guion como separador
                [$horaInicio, $horaFin] = explode('-', $horario->hora);

                return [
                    'title' => 'Alumnos: ' . $horario->nalumnos,
                    'start' => date('Y-m-d\TH:i:s', strtotime($horario->fecha . ' ' . $horaInicio)),
                    'end' => date('Y-m-d\TH:i:s', strtotime($horario->fecha . ' ' . $horaFin)),
                    'description' => "Carril: {$horario->carril}",
                    'observaciones' => $horario->observaciones,
                ];
            });

        return view('horarioProfe.horarioProf', [
            'barang' => $horarios,
        ]);
    }
}

