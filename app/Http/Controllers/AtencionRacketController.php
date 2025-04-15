<?php
namespace App\Http\Controllers;

use App\Models\AtencionRacket;
use App\Models\Cancha;
use App\Models\Precio;
use App\Models\ReservaCancha;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class AtencionRacketController extends Controller
{
    public function index()
    {
        $barang = AtencionRacket::orderBy('fecha', 'desc')->get();
        $reservas = ReservaCancha::whereDate('fecha', now()->toDateString())->orderBy('fecha', 'asc')->get(); // Obtener reservas del día actual
        $canchas = Cancha::orderBy('id', 'asc')->get();
        $precios = Precio::orderBy('id')->get()->keyBy('cancha_id');

        return view('AtencionRacket.racket', [
            'barang' => $barang,
            'reservas' => $reservas,
            'canchas' => $canchas,
            'precios' => $precios,
        ]);
    }


    public function store(Request $request)
    {
        // Validación de los datos enviados desde el formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'horaEntrada' => 'required|date_format:H:i',
            'cancha' => 'required|exists:canchas,id',
            'observaciones' => 'nullable|string|max:255',
        ]);

        $date = Carbon::now();

        // Crear la atención y asignar el estado "ocupado"
        $atencion = AtencionRacket::create([
            'nombre' => $request->name,
            'hora_inicio' => $request->horaEntrada,
            'fecha' => $date,
            'hora_fin' => "", // Se completará cuando se finalice la atención
            'cancha' => $request->cancha,
            'observaciones' => $request->observaciones,
            'estado' => 'ocupado',  // Estado "ocupado" al registrar
            'total' => "0",  // El total se calcula más adelante
            'total_horas' => "",  // Se calculará más tarde también
        ]);

        $atencion->save();

        // Mostrar un mensaje de éxito
        Alert::success('Éxito', 'Atención registrada exitosamente');
        
        return redirect('/atenracket');
    }

    public function update(Request $request, $id)
    {
        $atencion = AtencionRacket::findOrFail($id);

        $atencion->hora_fin = $request->horaSalida;
        $atencion->total_horas = $request->totalHoras;
        $atencion->total = $request->total;
        $atencion->estado = 'libre'; // <-- Aquí está el cambio clave
        $atencion->save();

        return redirect()->back()->with('success', 'Atención finalizada correctamente.');
    }
}
