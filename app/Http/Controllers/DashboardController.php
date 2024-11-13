<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use App\Models\Barang;
use Illuminate\Http\Request;
use App\Models\fechasAsistencia;
use App\Models\RegistroAlumn;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $asistencias = fechasAsistencia::join('clientes', 'fechasasistencia.codigoAlumno', '=', 'clientes.codigo')
            ->select('fechasasistencia.fecha', 'clientes.nombre', 'clientes.apellido', 'clientes.apellidoMat', 'clientes.nrsesiones', 'clientes.modalidad', 'fechasasistencia.codigoAlumno')
            ->get();

        // Obtener archivos en el directorio 'public/anuncios'
        $directorioAnuncios = public_path('anuncios');
        $archivos = File::files($directorioAnuncios);

        return view('dashboard.dashboard', ['asistencias' => $asistencias, 'archivos' => $archivos]);
    }

    public function obtenerFechas()
    {
        // Realiza el join y devuelve solo las últimas 10 asistencias
        $fechas = fechasAsistencia::join('clientes', 'fechasasistencia.codigoAlumno', '=', 'clientes.codigo')
            ->select('fechasAsistencia.fecha', 'clientes.nombre', 'clientes.apellido', 'clientes.apellidoMat', 'clientes.nrsesiones', 'clientes.modalidad')
            ->orderBy('fechasAsistencia.created_at', 'desc')
            ->take(6)
            ->get();

        return response()->json($fechas);
    }
    


public function subirAnuncios(Request $request)
    {
        // Validar archivos
        $request->validate([
            'archivosAnuncio' => 'required|array|max:3',
            'archivosAnuncio.*' => 'mimes:jpeg,jpg,png,gif,mp4,webm,ogg|max:10240' // Límite de 10MB por archivo
        ]);

        // Carpeta de destino para almacenar los archivos
        $carpetaDestino = 'anuncios';

        // Procesar cada archivo subido
        foreach ($request->file('archivosAnuncio') as $archivo) {
            // Generar un nombre único para cada archivo
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();

            // Guardar el archivo en la carpeta 'public/anuncios'
            $archivo->move(public_path($carpetaDestino), $nombreArchivo);
        }

        return back()->with('success', 'Archivos subidos exitosamente.');
    }
} 
