<?php
namespace App\Http\Controllers;

use App\Models\Cancha;
use App\Models\Deporte;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class CanchaController extends Controller
{
    // Mostrar la vista con las canchas y deportes
    public function index()
    {
        $canchas = Cancha::with(['deportes', 'precio'])->get();
        $deportes = Deporte::all();

        return view('CrearCanchas.canchas', compact('canchas', 'deportes'));
    }

    // Guardar nueva cancha
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:canchas,nombre',
            'deportes' => 'required|array',
            'precio' => 'required|numeric|min:0',
        ]);

        // Crear la nueva cancha
        $cancha = Cancha::create([
            'nombre' => $request->nombre,
        ]);

        // Asignar los deportes a la cancha
        $cancha->deportes()->attach($request->deportes);

        // Crear el precio para la cancha
        $cancha->precio()->create([
            'precio' => $request->precio,
        ]);
        Alert::success('Éxito', 'Cancha registrada correctamente.');
        return redirect('/creacanch');
    }

    // Guardar nuevo deporte
    public function storeDeporte(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:deportes,nombre',
        ]);

        // Crear el nuevo deporte
        Deporte::create([
            'nombre' => $request->nombre,
        ]);
        
        Alert::success('Éxito', 'Deporte registrado correctamente.');
        return redirect('/creacanch');
        
    }

    public function destroy($id)
    {
        $cancha = Cancha::findOrFail($id);

        // Eliminar relación con deportes si existe
        $cancha->deportes()->detach();

        // Eliminar el precio
        $cancha->precio()->delete();

        // Eliminar la cancha
        $cancha->delete();

        return redirect()->route('creacanch.index')->with('success', 'Cancha eliminada correctamente.');
    }

   

}
