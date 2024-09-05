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
     



    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $barang = AtencionRacket::findOrFail($id);

        return view('AtencionRacket.racket-edit', [
            'barang' => $barang,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
   /*  public function update(Request $request, $id_barang)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:barangs,name,' . $id_barang . ',id_barang',
            'category' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = Barang::findOrFail($id_barang);
        $barang->update($validated);

        Alert::info('Success', 'Barang has been updated !');
        return redirect('/barang');
    } */


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'horainicio' => 'required|date_format:H:i',
            'horasalida' => 'required|date_format:H:i|after:horainicio',
            'total' => 'required|numeric',
        ]);
        
        $atencion = AtencionRacket::findOrFail($id);

        
        $horaInicio = new DateTime($request->horainicio);
        $horaFin = new DateTime($request->horasalida);
        $interval = $horaInicio->diff($horaFin);

        $totalHoras = $interval->h; // Horas
        $totalMinutos = $interval->i; // Minutos


        $totalTiempo = $totalHoras . ' horas ' . $totalMinutos . ' minutos';

        $atencion->update([
            'nombre' => $request->name,
            'hora_inicio' => $request->horainicio,  
            'hora_fin' => $request->horasalida,     
            'total_horas' => $totalTiempo,          
            'total' => $request->total,
            'estado' => 'libre',

        ]);

        Alert::info('Success', 'Atención actualizada correctamente.');
        return redirect('/atenracket');
    }

    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_barang)
    {
        try {
            $deletedbarang = Barang::findOrFail($id_barang);

            $deletedbarang->delete();

            Alert::error('Success', 'Barang has been deleted !');
            return redirect('/barang');
        } catch (Exception $ex) {
            Alert::warning('Error', 'Cant deleted, Barang already used !');
            return redirect('/barang');
        }
    }

}
