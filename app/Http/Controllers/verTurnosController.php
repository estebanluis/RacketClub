<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class verTurnosController extends Controller
{
    public function index()
    {
        $id_usuario = Auth::id();
        $listaAlumnos = DB::table('horarios')
                        ->join('users', 'users.id_user', '=', 'horarios.id_user')
                        ->select('users.id_user','users.name', 'horarios.fecha', DB::raw('COUNT(horarios.fecha) as HorariosAtendidos'))
                        ->groupBy('users.name', 'horarios.fecha','users.id_user') 
                        ->get();

        return view('horario.verTurnos', [
        'barang' => $listaAlumnos
        ]);
    }

    public function showWithDate($id_user, $fecha)
    {
        $barang = DB::table('horarios')
                ->join('users', 'users.id_user', '=', 'horarios.id_user')
                ->select('users.name', 'horarios.fecha', 'horarios.hora', 'horarios.carril', 'horarios.nalumnos' )
                ->where('horarios.id_user', $id_user)
                ->where('horarios.fecha', $fecha)
                ->get();

        return view('horario.detalleTurnos', [
            'barang' => $barang,
        ]);
        
    }
}
