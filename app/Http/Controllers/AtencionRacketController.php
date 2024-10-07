<?php

namespace App\Http\Controllers;

use App\Models\AtencionRacket;
use App\Models\Barang;
use DateTime;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;

class AtencionRacketController extends Controller
{
   
    public function index()
    {
        $barang = AtencionRacket::orderBy('nombre', 'asc')->get();

        return view('AtencionRacket.racket', [
            'barang' => $barang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('AtencionRacket.racket-add');
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
{
    // Validamos los campos obligatorios
    $validated = $request->validate([
        'name' => 'required|max:100',
        'horaEntrada' => 'required|date_format:H:i',
        'cancha' => 'required|integer|min:1|max:4',
        'tipo' => 'required|string', // Validación del nuevo campo
        'observaciones' => 'nullable|string|max:500', 
    ]);

    // Verificamos si la cancha está ocupada
    $canchaOcupada = AtencionRacket::where('cancha', $request->input('cancha'))
        ->where('estado', 'ocupado')
        ->exists();

    if ($canchaOcupada) {
        // Si la cancha está ocupada, retornamos un error
        Alert::warning('Error', 'La cancha esta ocupada!');
        return redirect()->back();
    }

    // Creamos una nueva instancia de AtencionRacket y asignamos los valores
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

}
