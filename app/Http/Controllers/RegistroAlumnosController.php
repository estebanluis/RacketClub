<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\RegistroAlumno;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
class RegistroAlumnosController extends Controller
{
    public function generarCodigoCorrelativo()
    {
    $ultimoCodigo = RegistroAlumno::orderBy('codigo', 'desc')->first();

    if (!$ultimoCodigo) {
        $codigo = '5001';
    } else {
        //$codigo ='0'. str_pad($ultimoCodigo->codigo + 1, 2, '0', STR_PAD_LEFT);
        $codigo = str_pad($ultimoCodigo->codigo + 1, 2, '0', STR_PAD_LEFT);
    }

    return $codigo;
    }
    public function indexlis()
        {
            $alumnos = RegistroAlumno::all();

            return view('listaAlumnos.index', [
                'alumnos' => $alumnos
             ]); 
        }
    public function index(){

        return view('registrarAlumn.registrar');
    }
    public function store(Request $request){
        $request-> validate([
            'nombre'=> 'required',
            'apellidoMat' => 'required',
            'edad' => 'required',
            'direccion' => 'required',
            'apellido'=> 'required',
            'telefono'=> 'required',

        ]);
        
        $registrarAlumno = new RegistroAlumno();
        $registrarAlumno -> modalidad = $request-> modalidad;
        $alej = 0;
        $monto = 0;
        if( $request-> modalidad == "Natación curso completo"){
            $alej += 20;
        }else{
            if($request-> modalidad == "Natación*3 semana 12"){
                $alej += 12;
            }else{
                if($request-> modalidad == "Natación*3 semana 20"){
                    $alej += 20;
                }else{
                    if($request-> modalidad == "Natación medio curso"){
                        $alej += 10;
                    } 
                }
            }
        }
        if( $request-> modalidad == "Natación curso completo"){
            $monto += 220;
        }else{
            if($request-> modalidad == "Natación*3 semana 12"){
                $monto += 120;
            }else{
                if($request-> modalidad == "Natación*3 semana 20"){
                    $monto += 250;
                }else{
                    if($request-> modalidad == "Natación medio curso"){
                        $monto += 150;
                    } 
                }
            }
        }
        if ($request->modalidad == "Natación curso completo" || $request->modalidad == "Natación*3 semana 12") {
            $diasVencimiento = 31;
        } elseif ($request->modalidad == "Natación medio curso") {
            $diasVencimiento = 17;
        } elseif ($request->modalidad == "Natación*3 semana 20") {
            $diasVencimiento = 60;
        } else {
            // Modalidad no reconocida, asignar un valor predeterminado
            $diasVencimiento = 31;
        }
    
        $fechaActual = now();
        $feVen = $fechaActual->addDays($diasVencimiento)->format('d/m/y');
        $codigoGenerado = $this->generarCodigoCorrelativo();
        $registrarAlumno -> nombre = $request -> nombre;
        
        $registrarAlumno -> apellido = $request -> apellido;
        $registrarAlumno -> apellidoMat = $request -> apellidoMat;
        $registrarAlumno -> edad = $request -> edad;
        $registrarAlumno -> usuario = Auth::user()->name;
        $registrarAlumno -> horario = $request -> horario;
        $registrarAlumno -> direccion = $request -> direccion;
        $registrarAlumno -> observciones = $request -> observciones;
        $registrarAlumno -> telefono = $request -> telefono;
        $registrarAlumno -> nrsesiones = $alej;
        $registrarAlumno -> descuento = $request -> descuento;
        $registrarAlumno -> costo = $monto;
        $registrarAlumno -> codigo = $codigoGenerado;
        $registrarAlumno->save();

        $nom = $request -> nombre;
        $apell = $request -> apellido;
        $apellM = $request -> apellidoMat;
        $hora = $request -> horario;
        $codi = $codigoGenerado;
        $eda = $request -> edad;
        $mod = $request -> modalidad;
        $apellM = $request -> apellidoMat;
        $pdf = PDF::loadView('pdf.tarjeta', compact('nom','apell','apellM','hora','alej','codi','apellM','eda','mod','feVen'));
        
        return $pdf->download($apell.' '.$apellM.''.$nom.'.pdf');
    }
}
