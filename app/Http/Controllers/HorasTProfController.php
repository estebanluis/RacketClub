<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HorasTProfController extends Controller
{
    public function index()
    {
        $id_usuario = Auth::id();
        $listaAlumnos = DB::table('horarios')
                        ->join('users', 'users.id_user', '=', 'horarios.id_user')
                        ->select('users.name', 'horarios.fecha', DB::raw('count(horarios.fecha) as HorariosAtendidos'), DB::raw('Sum(horarios.salario) AS salario'))
                        ->where('horarios.id_user', $id_usuario)
                        ->groupBy('users.name', 'horarios.fecha') // Agregar 'users.name' a la cláusula GROUP BY
                        ->get();

    return view('horastrabajadas.horasProfe', [
    'barang' => $listaAlumnos
]);
    }
}
