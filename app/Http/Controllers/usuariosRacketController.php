<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cancha;
use App\Models\Deporte;
use App\Models\UsuarioRacket;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class usuariosRacketController extends Controller
{
    public function index()
    {
        $users = UsuarioRacket::all();
        $canchas = Cancha::all();
        $deportes = Deporte::with('canchas')->get();

        return view('reservasCancha.UserRacket', ['barang' => $users, 'canchas' => $canchas, 'deportes' => $deportes]);
    }

    public function store(Request $request)
    {
        // Validación de los otros campos
        $validatedData = $request->validate([
            'CI' => 'required|string',
            'nombre' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
        ]);

        // Verificar si el usuario ya existe por CI
        $existingUser = UsuarioRacket::where('CI', $request->CI)->first();

        if ($existingUser) {
            // Si el usuario ya existe, mostrar el mensaje de error
            Alert::error('Error', 'El usuario ya se encuentra registrado!');
            return redirect()->back()->withInput();  // Retorna con los datos previos para que el formulario no se vacíe
        } else {
            // Si no existe, registrar el nuevo usuario
            UsuarioRacket::create($validatedData);
            Alert::success('Éxito', 'El usuario fue registrado con éxito!');
            return redirect()->back();
        }
    }


    public function destroy($CI)
    {
        try {
            $user = UsuarioRacket::findOrFail($CI);
            $user->delete();
            Alert::success('Éxito', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            Alert::error('Error', 'No se pudo eliminar el usuario');
        }

        return redirect()->back();
    }
}
