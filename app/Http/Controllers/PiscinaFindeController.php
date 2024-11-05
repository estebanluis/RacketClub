<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PiscinaExtra;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PiscinaFindeController extends Controller
{
    public function index()
    {
        $listaAtencion = PiscinaExtra::orderBy('estado', 'desc')->get();
        return view('AtencionFindePiscina.atencionFinde', [
            'barang' => $listaAtencion
        ]);
    }

    // Método para registrar nuevos datos desde el formulario del modal
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255|regex:/^[\p{L}\s]+$/u',
            'adultos' => 'required|integer|min:0',
            'ninos' => 'required|integer|min:0',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Calcular el total
        $total = ($request->adultos * 35) + ($request->ninos * 25);

        // Crear una nueva instancia de PiscinaExtra y guardar los datos
        $piscinaExtra = new PiscinaExtra();
        $piscinaExtra->nombre = $request->nombre;
        $piscinaExtra->adultos = $request->adultos; // Asegúrate de tener este campo en tu modelo
        $piscinaExtra->ninos = $request->ninos; // Asegúrate de tener este campo en tu modelo
        $piscinaExtra->total = $total; // Asegúrate de que tu modelo tenga el campo 'total'
        $piscinaExtra->observaciones = $request->observaciones; // Asegúrate de tener este campo en tu modelo
        $piscinaExtra->fecha = Carbon::now()->format('Y-m-d'); // Guarda la fecha actual
        $piscinaExtra->estado = true; // Establece el estado en true

        // Guarda el registro en la base de datos
        $piscinaExtra->save();

        Alert::success('Éxito', 'Atención registrada exitosamente!');
         return redirect('/piscinaFinde');
    }

    public function finalizar($id)
    {
        // Buscar el registro por ID
        $atencion = PiscinaExtra::find($id);

        if ($atencion) {
            // Cambiar el estado a 0
            $atencion->estado = 0; 
            $atencion->save(); // Guardar los cambios
        }
        Alert::success('Éxito', 'Atención Finalizada exitosamente!');
         return redirect('/piscinaFinde');
     }

}
