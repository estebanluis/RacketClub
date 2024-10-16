<?php

namespace App\Http\Controllers;

use App\Models\AtencionRacket;
use App\Models\Barang;
use App\Models\ReservaCancha;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class ReservaCanchaController extends Controller
{

/**
     * Display a listing of the resource.
     */
    public function index()
    {
        $barang = ReservaCancha::orderBy('nombre_reserva', 'asc')->get();
        
        // Formatear las reservas para FullCalendar
        $events = $barang->map(function ($data) {
            return [
                'title' => $data->nombre_reserva,
                'start' => $data->fecha . 'T' . $data->hora,
                'extendedProps' => [
                    'numeroCancha' => $data->numero_cancha, // Agrega el número de cancha aquí
                    'tiempoReserva' => $data->tiempoReserva,
                    'observaciones' => $data->observaciones,
                ],
            ];
        });
        
    
        return view('ReservarCanchas.reservasCanchas', [
            'barang' => $barang,
            'events' => $events,
        ]);
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ReservarCanchas.reservaCanchas-add');
    }

    /**
     * Store a newly created resource in storage.
     */
   /*  public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:barangs',
            'category' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = ReservaCancha::create($request->all());

        Alert::success('Success', 'Barang has been saved !');
        return redirect('/barang');
    } */

    public function store(Request $request)
    {
        // Validar los campos de entrada, incluyendo los nuevos
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'hora' => 'required',
            'cancha' => 'required|integer',
            'fecha' => 'required|date', // Validar el formato de fecha
            'tiempoReserva' => 'required|integer|min:1', // Validar tiempoReserva
            'observaciones' => 'nullable|string|max:500', // Validar observaciones (opcional)
            'deporte' => 'required|in:racket,wally', // Validar el campo deporte
        ]);
    
        // Crear la reserva con los nuevos campos
        $barang = ReservaCancha::create([
            'nombre_reserva' => $request->input('name'),
            'hora' => $request->input('hora'),
            'numero_cancha' => $request->input('cancha'),
            'fecha' => $request->input('fecha'),
            'tiempoReserva' => $request->input('tiempoReserva'), // Agregar tiempoReserva
            'observaciones' => $request->input('observaciones'), // Agregar observaciones
            'tipo' => $request->input('deporte'), // Agregar tipo (racket o wally)
        ]);
    
        Alert::success('Success', 'La Reserva fue Registrada !');
        return redirect('/rcancha');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_barang)
    {
        $barang = barang::findOrFail($id_barang);

        return view('barang.barang-edit', [
            'barang' => $barang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $deletedbarang = ReservaCancha::findOrFail($id);

            $deletedbarang->delete();

            Alert::error('Success', 'La Reserva fue Eliminada!');
            return redirect('/rcancha');
        } catch (Exception $ex) {
            Alert::warning('Error', 'La Reserva no pudo ser Eliminada !');
            return redirect('/rcancha');
        }
    }

    public function transferToAtencion($id)
    {
        // Obtener la reserva por ID
        $reserva = ReservaCancha::findOrFail($id); // Asegúrate de tener el modelo correcto
    
        // Crear nueva instancia de AtencionRacket
        $atencionRacket = new AtencionRacket();
        $atencionRacket->nombre = $reserva->nombre_reserva;
        $atencionRacket->fecha = $reserva->fecha;
        $atencionRacket->hora_inicio = $reserva->hora;
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
    
        Alert::success('Success', 'La reserva ha sido pasada a atención exitosamente y eliminada de reservas!');
        return redirect('/rcancha');
    }

   
    

}
