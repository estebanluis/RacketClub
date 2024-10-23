<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HorarioController extends Controller
{
    public function index()
    {
        // Obtener los usuarios que son profesores y ordenarlos
        $listaProfesores = User::where('TipoUsuario', 'profesor')->orderBy('id_user')->get();

        return view('horario.horasGeneral', [
            'barang' => $listaProfesores
        ]);
    }

    // Método para registrar el horario del profesor
    public function store(Request $request)
    {
        $fecha_actual = Carbon::now(); // Obtener la fecha actual

        // Validar los datos del formulario
        $request->validate([
            'id_user' => 'required',
            'horario' => 'required|string',
            'carril' => 'required|integer|in:1,2,3,4',
            'nalumnos' => 'required|integer|min:1',
            'observaciones' => 'nullable|string|max:255',
        ]);

        // Obtener los datos del formulario
        $id_user = $request->input('id_user'); // Obtener el id_user del formulario
        $hora = $request->input('horario');
        $carril = $request->input('carril');
        $nalumnos = $request->input('nalumnos');
        $observaciones = $request->input('observaciones');
        $fecha_formateada = $fecha_actual->format('d-m-Y'); // Formatear la fecha como dd-mm-yyyy

        // Verificar si el carril ya está ocupado en esa fecha y hora
        $verificar = DB::table('horarios')
            ->where('carril', '=', $carril)
            ->where('fecha', '=', $fecha_formateada)
            ->where('hora', '=', $hora)
            ->count(); // Contar los registros que coincidan

        // Si el carril está ocupado, mostrar una alerta de error
        if ($verificar > 0) {
            Alert::warning('Error', 'Carril Ocupado!');
            return redirect('/horarios')->withErrors(['carril' => 'Carril Ocupado!']);
        } else {
            // Crear un nuevo registro de horario
            $horario = new Horario();
            $horario->hora = $hora;
            $horario->id_user = $id_user;
            $horario->carril = $carril;
            $horario->nalumnos = $nalumnos;
            $horario->observaciones = $observaciones;
            $horario->fecha = $fecha_formateada;
            $horario->salario = '0'; // Se puede calcular el salario posteriormente
            $horario->save(); // Guardar el registro en la base de datos

            // Mostrar mensaje de éxito
            Alert::success('Éxito', 'Turno Registrado!');
            return redirect('/horarios');
        }
    }
}
