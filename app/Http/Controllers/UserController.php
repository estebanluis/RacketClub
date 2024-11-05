<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function update(Request $request)
    {
        // Validar que la nueva contraseña esté presente y que coincida con la confirmación
        $request->validate([
            'password' => 'required|confirmed|min:6',
        ]);

        // Obtener el ID del usuario autenticado
        $userId = auth()->id();

        // Encriptar la nueva contraseña y actualizar directamente en la base de datos
        DB::table('users')
            ->where('id_user', $userId)
            ->update(['password' => Hash::make($request->password)]);

        // Mostrar mensaje de éxito
        Alert::success('Éxito', 'La contraseña fue actualizada con éxito!');
        return redirect()->back();
    }
}
