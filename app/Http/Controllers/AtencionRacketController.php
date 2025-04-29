<?php
namespace App\Http\Controllers;

use App\Models\AtencionRacket;
use App\Models\Cancha;
use App\Models\Precio;
use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use Illuminate\Support\Facades\DB;

class AtencionRacketController extends Controller
{
    public function index()
    {
        $barang = AtencionRacket::orderBy('fecha', 'desc')->get();
        $reservas = Reserva::whereDate('dia', now()->toDateString())
                            ->with(['cancha', 'deporteRelacion'])
                            ->orderBy('dia', 'asc')
                            ->get();
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
            'hora_fin' => "00:00:00", // Se completará cuando se finalice la atención
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

    public function transferToAtencion( $id){
       
        $datos  = Reserva::with('usuario', 'cancha', 'deporteRelacion')
                            ->where('id', $id)
                            ->first();
        $verificar = AtencionRacket::where('cancha', $datos->cancha->id)
                            ->where('estado', '=', 'ocupado')  // Asumiendo que "ocupada" es el estado que indica que la cancha está ocupada
                            ->get();

        if($verificar->isEmpty()){

            $atencion = AtencionRacket::create([
                'nombre' => $datos->usuario->nombre,
                'hora_inicio' => $datos->hora,
                'fecha' => $datos->dia,
                'hora_fin' => "", 
                'cancha' => $datos->cancha->id,
                'estado' => 'ocupado',  
                'total' => "0", 
                'total_horas' => "",  
            ]);
            $atencion->save();
            $datos->delete();
            Alert::success('Éxito', 'Reserva pasada a atención exitosamente');
            
            return redirect('/atenracket');
        }else{
            Alert::error('Error', 'La cancha esta ocupada la reserva no puede pasarse a atención');
            
            return redirect('/atenracket');
        }
        


    }
}
