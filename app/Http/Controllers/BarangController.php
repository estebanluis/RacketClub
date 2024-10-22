<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\RegistroAlumno;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Exception;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Controllers\RegistroAlumnosController;
use Illuminate\Support\Facades\DB;
class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Subconsulta para obtener los registros duplicados con el mayor nroReinscripciones
        $subquery = RegistroAlumno::select('apellido', 'apellidoMat', 'horario', 'direccion', 'telefono', DB::raw('MAX(nroReinscripciones) as max_reinscripciones'))
            ->groupBy('apellido', 'apellidoMat', 'horario', 'direccion', 'telefono')
            ->havingRaw('COUNT(*) > 1');

        // Unimos la subconsulta con la tabla original para obtener los registros con mayor nroReinscripciones entre los duplicados
        $duplicados = RegistroAlumno::joinSub($subquery, 'sub', function($join) {
            $join->on('clientes.apellido', '=', 'sub.apellido')
                ->on('clientes.apellidoMat', '=', 'sub.apellidoMat')
                ->on('clientes.horario', '=', 'sub.horario')
                ->on('clientes.direccion', '=', 'sub.direccion')
                ->on('clientes.telefono', '=', 'sub.telefono')
                ->on('clientes.nroReinscripciones', '=', 'sub.max_reinscripciones');
        })->select('clientes.*');

        // Seleccionamos los registros únicos (sin duplicados)
        $unicos = RegistroAlumno::select('clientes.*')
            ->leftJoinSub($subquery, 'sub', function($join) {
                $join->on('clientes.apellido', '=', 'sub.apellido')
                    ->on('clientes.apellidoMat', '=', 'sub.apellidoMat')
                    ->on('clientes.horario', '=', 'sub.horario')
                    ->on('clientes.direccion', '=', 'sub.direccion')
                    ->on('clientes.telefono', '=', 'sub.telefono');
            })
            ->whereNull('sub.apellido');

        // Unimos ambas consultas
        $listaClientes = $duplicados->union($unicos)->orderBy('codigo', 'asc')->get();

        return view('barang.barang', [
            'barang' => $listaClientes
        ]);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.barang-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:barangs',
            'category' => 'required',
            'supplier' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'note' => 'max:1000',
        ]);

        $barang = Barang::create($request->all());

        Alert::success('Success', 'Barang has been saved !');
        return redirect('/barang');
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
    public function edit($id)
    {
        $barang = RegistroAlumno::findOrFail($id);

        return view('barang.barang-edit', [
            'barang' => $barang,
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
    $validated = $request->validate([
        'nombre' => 'required',
        'apellido' => 'required',
        'apellidoMat' => 'required',
        'modalidad' => 'required',
        'observciones' => 'required',
        'telefono' => 'required',
        'horario'=> 'required'
    ]);
    
    $barang = RegistroAlumno::findOrFail($id);
    $barang->update($validated);
    
    Alert::info('Exitoso', 'Informacion de alumno actualizada');
    return redirect('/barang');
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
    public function generatePDF($id)
    {
     $alumno = RegistroAlumno::findOrFail($id);

    // Configurar opciones para DomPDF
    

    // Crear la vista del PDF con los datos personalizados
    $pdf = PDF::loadView('pdf.tarjeta', [
        'nom' => $alumno->nombre,
        'apell' => $alumno->apellido,
        'apellM' => $alumno->apellidoMat,
        'hora' => $alumno->horario,
        'codi' =>$alumno->codigo,
        'mod' => $alumno->modalidad,
        'feVen' => now()->addDays(31)->format('d/m/y')
    ]);

    // Retornar el PDF como stream (mostrándolo en el navegador)
    return $pdf->stream('tarjeta.pdf');
    }

public function reinscribirAlumn(Request $request, $id)
{
    $alumno = RegistroAlumno::find($id);

    if ($alumno->nrsesiones == 0) {
        $registroAlumnosController = new RegistroAlumnosController();
        $modalidad = trim($request->modalidad);

        $nuevoCodigo = $registroAlumnosController->generarCodigoCorrelativo();

        $nuevoAlumno = $alumno->replicate();
        $nuevoAlumno->codigo = $nuevoCodigo;
        $nuevoAlumno->nroReinscripciones = $alumno->nroReinscripciones + 1;

        switch (strtolower($modalidad)) {
            case strtolower("Natación curso completo"):
                $nuevoAlumno->nrsesiones = 20;
                break;
            case strtolower("Natación*3 semana 12"):
                $nuevoAlumno->nrsesiones = 12;
                break;
            case strtolower("Natación*3 semana 20"):
                $nuevoAlumno->nrsesiones = 20;
                break;
            case strtolower("Natación medio curso"):
                $nuevoAlumno->nrsesiones = 10;
                break;
            default:
                $nuevoAlumno->nrsesiones = 0;
                break;
        }

        $nuevoAlumno->save();

        Alert::success('Reinscripción completada', 'El alumno ha sido reinscrito exitosamente.');
    } else {
        Alert::error('Error', 'El alumno aún tiene sesiones disponibles.');
    }

    return redirect()->back();
}





}
