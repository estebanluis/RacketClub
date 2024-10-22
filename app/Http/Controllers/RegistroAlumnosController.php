<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\RegistroAlumno;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use RealRashid\SweetAlert\Facades\Alert;
use Dompdf\Options;
use Barryvdh\DomPDF\Facade\Pdf;
class RegistroAlumnosController extends Controller
{
    public function generarCodigoCorrelativo()
    {
        $ultimoCodigo = RegistroAlumno::orderBy('codigo', 'desc')->first();
        $codigo = $ultimoCodigo ? str_pad($ultimoCodigo->codigo + 1, 2, '0', STR_PAD_LEFT) : '5001';
        return $codigo;
    }

    public function indexlis()
    {
        $alumnos = RegistroAlumno::all();
        return view('listaAlumnos.index', ['alumnos' => $alumnos]);
    }

    public function index()
    {
        return view('registrarAlumn.registrar');
    }

    public function store(Request $request)
{
    ini_set('max_execution_time', 120); // Aumentar el tiempo de ejecución máxima

    $request->validate([
        'nombre' => 'required',
        'apellidoMat' => 'required',
        'edad' => 'required',
        'direccion' => 'required',
        'apellido' => 'required',
        'telefono' => 'required',
    ]);

    // Validar si ya existe un alumno con los mismos datos
    $existeAlumno = RegistroAlumno::where([
        'modalidad' => $request->modalidad,
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'apellidoMat' => $request->apellidoMat,
        'horario'=> $request->horario,
    ])->exists();

    if ($existeAlumno) {
        Alert::info('Advertencia', 'El alumno ya está inscrito en la modalidad seleccionada. No es posible inscribirlo de nuevo.');
        return back();
    }

    // Continuar con la inscripción si no existe
    $modalidad = $request->modalidad;
    $alej = $monto = 0;

    switch ($modalidad) {
        case "Natación curso completo":
            $alej = 20;
            $monto = 220;
            $diasVencimiento = 31;
            break;
        case "Natación*3 semana 12":
            $alej = 12;
            $monto = 120;
            $diasVencimiento = 31;
            break;
        case "Natación*3 semana 20":
            $alej = 20;
            $monto = 250;
            $diasVencimiento = 60;
            break;
        case "Natación medio curso":
            $alej = 10;
            $monto = 150;
            $diasVencimiento = 17;
            break;
        default:
            $diasVencimiento = 31;
            break;
    }

    $fechaActual = now();
    $feVen = $fechaActual->addDays($diasVencimiento)->format('d/m/y');
    $codigoGenerado = $this->generarCodigoCorrelativo();

    $registrarAlumno = new RegistroAlumno();
    $registrarAlumno->fill([
        'modalidad' => $modalidad,
        'nroReinscripciones' => 0,
        'nombre' => $request->nombre,
        'apellido' => $request->apellido,
        'apellidoMat' => $request->apellidoMat,
        'edad' => $request->edad,
        'usuario' => Auth::user()->name,
        'horario' => $request->horario,
        'direccion' => $request->direccion,
        'observciones' => $request->observciones,
        'telefono' => $request->telefono,
        'nrsesiones' => $alej,
        'descuento' => $request->descuento,
        'costo' => $monto,
        'codigo' => $codigoGenerado
    ])->save();

    // Generar el PDF
    $pdf = PDF::loadView('pdf.tarjeta', [
        'nom' => $request->nombre,
        'apell' => $request->apellido,
        'apellM' => $request->apellidoMat,
        'hora' => $request->horario,
        'alej' => $alej,
        'codi' => $codigoGenerado,
        'eda' => $request->edad,
        'mod' => $modalidad,
        'feVen' => $feVen
    ]);

    return back()
        ->with('success', 'El alumno ha sido inscrito exitosamente.')
        ->with('codigoGenerado', $codigoGenerado);
}

    public function generarPdf($codigo)
    {
        
        $alumno = RegistroAlumno::where('codigo', $codigo)->firstOrFail();

    // Crear la vista del PDF con los datos personalizados
    $pdf = PDF::loadView('pdf.tarjeta', [
        'nom' => $alumno->nombre,
        'apell' => $alumno->apellido,
        'apellM' => $alumno->apellidoMat,
        'hora' => $alumno->horario,
        'codi' => $alumno->codigo,
        'mod' => $alumno->modalidad,
        'feVen' => now()->addDays(31)->format('d/m/y')
    ]);

    // Retornar el PDF como stream (mostrándolo en el navegador)
    return $pdf->stream('tarjeta.pdf');
        // Mostrar el PDF en una nueva ventana
       // return $dompdf->stream("{$alumno->apellido} {$alumno->apellidoMat} {$alumno->nombre}.pdf", ["Attachment" => false]);
    }
    public function destroy($id)
    {
    // Buscar el producto por su id
    $id = RegistroAlumno::findOrFail($id);

    // Eliminar el producto
    $id->delete();

    // Redirigir con un mensaje de éxito
    return redirect()->back()->with('success', 'Alumno eliminado correctamente.');
    }
}