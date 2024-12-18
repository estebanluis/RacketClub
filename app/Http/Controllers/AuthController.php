<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {

        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);


        User::where('email', $credentials);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Alert::success('Éxito', 'Inicio de sesion correcto !');
            return redirect()->intended('/dashboard');
        } else {
            Alert::error('Error', 'Inicio de sesion incorrecto !');
            return redirect('/login');
        }
    }

    public function register()
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }
    public function process(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|regex:/^[\p{L}\s]+$/u |min:6',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'passwordConfirm' => 'required|same:password',
            'TipoUsuario' => 'required'
        ]);
        
        $validated['password'] = Hash::make($request['password']);
        $validated['TipoUsuario'] = $request->input('TipoUsuario');
        $user = User::create($validated);

        Alert::success('Éxito', 'Usario Registrado Exitosamente !');
        return redirect('/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::success('Éxito', 'Sesion Cerrada Exitosamente !');
        return redirect('/login');
    }

    public function registerUser()
    {
        return view('registerUser.registerUser', [
            'title' => 'Register',
        ]);
    }

    public function processUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'passwordConfirm' => 'required|same:password'
        ]);

        $validated['password'] = Hash::make($request['password']);

        $user = User::create($validated);

        Alert::success('Éxito', 'Usario Registrado Exitosamente  !');
        return redirect('/RegisterUser');
    }

}
