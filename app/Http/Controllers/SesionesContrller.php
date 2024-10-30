<?php

namespace App\Http\Controllers;
use App\Models\sesiones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;

class SesionesContrller extends Controller
{
    public function index()
    {
        $sesions = sesiones::all();
        return view('registrarAlumn.listaSeciones', ['barang' => $sesions]);
    }
    public function storeSesion(Request $request)
{
    try {
        $validatedData = $request->validate([
            'nombreSesion' => 'required|string|max:255',
            'cantHoras' => 'required|integer|min:1', // Validación para cantHoras
            'pago' => 'required|numeric|min:0', // Validación para pago
        ]);
        $encargado = Auth::check() ? Auth::user()->encargado : 'default_value';

        if ($encargado === null) {
            // Establece un valor por defecto o muestra un error si 'encargado' es obligatorio
            $encargado = 'default_value'; // Reemplaza esto con el valor que consideres adecuado
        }
        $user = new sesiones();
        $user->nombreSesion = $validatedData['nombreSesion'];
        $user->encargado = $encargado;
        $user->cantHoras = $validatedData['cantHoras'];
        $user->pago = $validatedData['pago'];
        $user->save();

        Alert::success('Success', 'Usuario registrado exitosamente.');
    } catch (\Exception $e) {
        Alert::error('Error', 'Error al registrar el usuario: ' . $e->getMessage());
    }

    return redirect('/listaSeciones');
}

}
