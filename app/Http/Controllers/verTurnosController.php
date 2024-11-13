<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class verTurnosController extends Controller
{
    public function index(){

        $id_usuario = Auth::id();

        $tipoUsuario = Auth::user()->TipoUsuario;

        $fechaActual = Carbon::now()->format('d-m-Y');
        //dd($fechaActual);

        if ($tipoUsuario !== 'Profesor') {
            // Mostrar todos los horarios
            $listaAlumnos = DB::table('horarios')
                ->join('users', 'users.id_user', '=', 'horarios.id_user')
                ->select('users.id_user', 'users.name', 'horarios.fecha', DB::raw('COUNT(horarios.fecha) as HorariosAtendidos'))
                ->groupBy('users.name', 'horarios.fecha', 'users.id_user')
                ->get();
        } else {
            
            $listaAlumnos = DB::table('horarios')
            ->join('users', 'users.id_user', '=', 'horarios.id_user')
            ->select('users.id_user', 'users.name', 'horarios.fecha', DB::raw('COUNT(horarios.fecha) as HorariosAtendidos'))
            ->where('users.id_user', $id_usuario) 
            ->where('horarios.salario', 0)
            ->where(DB::raw('STR_TO_DATE(horarios.fecha, "%d-%m-%Y")'), '>=', DB::raw('STR_TO_DATE("'.$fechaActual.'", "%d-%m-%Y")')) 
            ->groupBy('users.name', 'horarios.fecha', 'users.id_user')
            ->get();
        }

        // Retornar la vista con los datos correspondientes
        return view('horario.verTurnos', [
            'barang' => $listaAlumnos
        ]);
    }

    // Método existente para mostrar detalles con fecha
    public function showWithDate($id_user, $fecha)
    {
        $barang = DB::table('horarios')
                ->join('users', 'users.id_user', '=', 'horarios.id_user')
                ->select('users.id_user', 'users.name', 'horarios.fecha', 'horarios.salario', 'horarios.hora', 'horarios.carril', 'horarios.nalumnos', 'horarios.idHorario') // Asegúrate de agregar 'horarios.idHorario'
                ->where('horarios.id_user', $id_user)
                ->where('horarios.fecha', $fecha)
                ->get();
    
        return view('horario.detalleTurnos', [
            'barang' => $barang,
        ]);
    }
    
     // Asegúrate de tener esto al inicio de tu archivo

     public function showSalarioForm($idHorario)
     {
         // Busca el horario correspondiente por idHorario
         $horario = Horario::find($idHorario);
     
         if (!$horario) {
             // Manejo de errores: horario no encontrado
             return redirect()->route('turnos.index')->with('error', 'Horario no encontrado');
         }
     
         // Busca el usuario correspondiente usando el id_user del horario
         $usuario = User::find($horario->id_user);
     
         if (!$usuario) {
             // Manejo de errores: usuario no encontrado
             return redirect()->route('turnos.index')->with('error', 'Usuario no encontrado');
         }
     
         return view('horario.salarioTurnos', [
             'horario' => $horario,
             'usuario' => $usuario // Pasa el usuario a la vista
         ]);
     }
    
    public function updateSalario(Request $request, $idHorario)
        {
            // Validar los datos de entrada
            $request->validate([
                'salario' => 'required|numeric',
                // Agrega otras validaciones necesarias
            ]);

            // Actualiza el salario en la base de datos
            DB::table('horarios')->where('idHorario', $idHorario)->update([
                'salario' => $request->salario,
                // Actualiza otros campos si es necesario
            ]);
            return redirect()->back()->with('success', 'Salario actualizado con éxito');

        }




    
}
