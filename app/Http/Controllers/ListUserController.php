<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ListUserController extends Controller
{
    // Método para listar usuarios
    public function index()
    {
        $users = User::all();
        return view('registerUser.listUser', ['barang' => $users]);
    }

    // Método para registrar un nuevo usuario
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:users,name|regex:/^[\p{L}\s]+$/u',
                'email' => 'required|email|unique:users,email',
                'TipoUsuario' => 'required|string',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = new User();
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->TipoUsuario = $validatedData['TipoUsuario'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            Alert::success('Éxito', 'Usuario registrado exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error al registrar el usuario: ' . $e->getMessage());
        }

        return redirect('/luser');
    }

    // Método para actualizar el usuario
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'id_user' => 'required|integer|exists:users,id_user',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $request->id_user . ',id_user',
                'TipoUsuario' => 'required|string',
                'password' => 'nullable|string|min:6|confirmed',
            ]);

            $user = User::findOrFail($validatedData['id_user']);
            $user->name = $validatedData['name'];
            $user->email = $validatedData['email'];
            $user->TipoUsuario = $validatedData['TipoUsuario'];

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();
            Alert::success('Éxito', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }

        return redirect('/luser');
    }

    // Método para eliminar usuario
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            Alert::success('Éxito', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            Alert::error('Error', 'El usuario no puede ser eliminado, ya que tiene registros de salarios o turnos pendientes.');
        }

        return redirect('/luser');
    }
}
