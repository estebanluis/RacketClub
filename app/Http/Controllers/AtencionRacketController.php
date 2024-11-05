<?php

namespace App\Http\Controllers;

use App\Models\AtencionRacket;
use App\Models\ReservaCancha;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class AtencionRacketController extends Controller
{
   
    public function index()
    {
        $barang = AtencionRacket::orderBy('nombre', 'asc')->get();
        $reservas = ReservaCancha::whereDate('fecha', now()->toDateString())->orderBy('fecha', 'asc')->get(); // Obtener reservas del día actual
    
        return view('AtencionRacket.racket', [
            'barang' => $barang,
            'reservas' => $reservas // Pasar las reservas a la vista
        ]);
    }
    

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AtencionRacket.racket-add');
    }

    public function store(Request $request)
    {
        // Validamos los campos obligatorios
        $validated = $request->validate([
            'name' => 'required|max:100|regex:/^[\p{L}\s]+$/u',
            'horaEntrada' => 'required|date_format:H:i',
            'cancha' => 'required|integer|min:1|max:4',
            'tipo' => 'required|string',
            'observaciones' => 'nullable|string|max:500',
        ]);
    
        // Verificamos si la cancha ya tiene una atención activa (ocupada)
        $canchaOcupada = AtencionRacket::where('cancha', $request->input('cancha'))
            ->where('estado', 'ocupado')
            ->exists();
    
        if ($canchaOcupada) {
            // Si la cancha está ocupada, retornamos un error
            Alert::warning('Error', 'La cancha está ocupada!');
            return redirect()->back();
        }
    
        // Convertir la hora de entrada solicitada a formato de hora
        $horaEntradaNueva = $request->input('horaEntrada');
        
        // Obtenemos todas las reservas para la cancha solicitada en el día actual
        $reservasCancha = ReservaCancha::where('numero_cancha', $request->input('cancha'))
            ->whereDate('fecha', now()->toDateString()) // Solo la fecha sin la hora
            ->get();
    
        // Verificar si la hora de entrada está dentro del rango de cualquier reserva
        foreach ($reservasCancha as $reserva) {
            $horaInicioReserva = date('H:i', strtotime($reserva->hora)); // Hora de inicio de la reserva en formato H:i
    
            // Convertimos tiempoReserva (en horas) a segundos para sumarlo a la hora de inicio
            $horaFinReserva = date('H:i', strtotime($reserva->hora) + $reserva->tiempoReserva * 3600); // tiempoReserva en horas
    
            // Verificamos si hay solapamiento entre la hora de la nueva atención y la reserva existente
            if ($horaEntradaNueva >= $horaInicioReserva && $horaEntradaNueva < $horaFinReserva) {
                Alert::warning('Error', 'La cancha está reservada en ese horario!');
                return redirect()->back();
            }
        }
    
        // Si no hay conflictos de ocupación o reservas, creamos una nueva atención
        $atencionRacket = new AtencionRacket();
        $atencionRacket->nombre = $request->input('name');
        $atencionRacket->hora_inicio = $request->input('horaEntrada');
        $atencionRacket->cancha = $request->input('cancha');
        $atencionRacket->tipo = $request->input('tipo'); // Almacenar el tipo seleccionado
        $atencionRacket->observaciones = $request->input('observaciones');
    
        // Llenamos los campos faltantes con valores predeterminados
        $atencionRacket->fecha = now()->toDateString(); // Fecha del sistema
        $atencionRacket->hora_fin = '00:00:00'; // Campo vacío
        $atencionRacket->total_horas = 0; // Default 0 horas
        $atencionRacket->saldo_cancha = 0.00; // Default saldo cancha 0
        $atencionRacket->saldo_venta = 0.00; // Default saldo venta 0
        $atencionRacket->total = 0.00; // Default total 0
        $atencionRacket->estado = 'ocupado';
    
        $atencionRacket->save();
    
        // Mostrar mensaje de éxito
        Alert::success('Success', 'Atención Racket registrada exitosamente!');
        return redirect('/atenracket');
    }
    


     public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'horaSalida' => 'required|date_format:H:i',
            'total' => 'required|numeric|min:0',
        ]);

        // Obtener la atención específica
        $atencion = AtencionRacket::findOrFail($id);

        // Calcular total de horas
        $horaEntrada = new DateTime($atencion->hora_inicio);
        $horaSalida = new DateTime($request->input('horaSalida'));
        $intervalo = $horaEntrada->diff($horaSalida);
        
        // Obtener horas y minutos
        $horas = $intervalo->h;
        $minutos = $intervalo->i;

        // Formatear como texto
        $totalHorasTexto = "{$horas} hora(s) {$minutos} minuto(s)";

        // Guardar los datos actualizados
        $atencion->hora_fin = $request->input('horaSalida');
        $atencion->total_horas = $totalHorasTexto; // Guardar el total en formato de texto
        $atencion->total = $request->input('total');
        $atencion->estado = 'libre'; // Cambiar estado a libre
        $atencion->save();

        Alert::success('Success', 'Atención finalizada exitosamente!');
        return redirect('/atenracket');
    }

    public function transferToAtencion($id)
{
    // Obtener la reserva por ID
    $reserva = ReservaCancha::findOrFail($id);

    // Obtener la hora actual
    $horaActual = new DateTime();

    // Obtener la hora de la reserva
    $horaReserva = new DateTime($reserva->hora);

    // Calcular la hora permitida para pasar la atención (30 minutos antes de la reserva)
    $horaPermitida = clone $horaReserva; // Hacemos una copia de la hora de la reserva
    $horaPermitida->modify('-30 minutes'); // Restamos 30 minutos

    // Verificar si la cancha ya está ocupada
    $canchaOcupada = AtencionRacket::where('cancha', $reserva->numero_cancha)
                                    ->where('estado', 'ocupado')
                                    ->exists();

    // Lógica para permitir pasar a atención
    if ($canchaOcupada) {
        // Mostrar mensaje de error si la cancha está ocupada
        Alert::error('Error', 'La cancha está ocupada. No se puede transferir la reserva a atención.');
        return redirect('/atenracket'); // Redirigir a la página de canchas
    }

    // Verificar si la atención se puede pasar
    if ($horaActual < $horaPermitida) {
        // Si la hora actual es menor que la hora permitida, no se puede pasar la atención
        Alert::warning('Advertencia', 'No se puede transferir la atencion modifique la hora de reserva o espere a la hora indicada.');
        return redirect('/atenracket'); // Redirigir a la página de canchas
    }

    // Crear nueva instancia de AtencionRacket
    $atencionRacket = new AtencionRacket();
    $atencionRacket->nombre = $reserva->nombre_reserva;
    $atencionRacket->fecha = $reserva->fecha;
    $atencionRacket->hora_inicio = $horaActual;
    $atencionRacket->tipo = $reserva->tipo; 
    $atencionRacket->cancha = $reserva->numero_cancha;
    $atencionRacket->observaciones = $reserva->observaciones;

    // Llenamos los campos faltantes con valores predeterminados
    $atencionRacket->hora_fin = '00:00:00'; // Campo vacío
    $atencionRacket->total_horas = 0; // Default 0 horas
    $atencionRacket->saldo_cancha = 0.00; // Default saldo cancha 0
    $atencionRacket->saldo_venta = 0.00; // Default saldo venta 0
    $atencionRacket->total = 0.00; // Default total 0
    $atencionRacket->estado = 'ocupado';

    // Guardamos la atención
    $atencionRacket->save();

    // Eliminar la reserva original
    $reserva->delete();

    // Mostrar mensaje de éxito usando SweetAlert
    Alert::success('Éxito', 'La reserva ha sido pasada a atención exitosamente y eliminada de reservas.');
    return redirect('/atenracket'); // Redirigir a la página de canchas
}


}