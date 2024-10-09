<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ListUserController extends Controller
{
    // Método para listar usuarios
    public function index()
    {
        $users = User::all();
        return view('registerUser.listUser', ['barang' => $users]); // Ajusta la vista si es necesario
    }

    // Método para registrar un nuevo usuario
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'TipoUsuario' => 'required|string',
            'password' => 'required|string|min:6|confirmed', // Validación de confirmación
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->TipoUsuario = $validatedData['TipoUsuario'];
        $user->password = Hash::make($validatedData['password']); // Hash para la contraseña
        $user->save();

        return redirect()->back()->with('success', 'Usuario registrado exitosamente.');
    }

    // Método para actualizar el usuario
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id_user' => 'required|integer|exists:users,id_user',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id_user . ',id_user',
            'TipoUsuario' => 'required|string',
            // La validación de la contraseña solo si es proporcionada
            'password' => 'nullable|string|min:6|confirmed', // Se permite que sea nulo
        ]);

        $user = User::findOrFail($validatedData['id_user']);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->TipoUsuario = $validatedData['TipoUsuario'];

        // Si se proporciona una nueva contraseña, se actualiza
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Usuario actualizado exitosamente.');
    }

    // Método para eliminar usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }
}
