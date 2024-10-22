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
        // Realiza un join entre fechasasistencia y clientes
        $asistencias = fechasAsistencia::join('clientes', 'fechasasistencia.codigoAlumno', '=', 'clientes.codigo')
            ->select('fechasasistencia.fecha', 'clientes.nombre', 'clientes.apellido', 'clientes.apellidoMat', 'clientes.nrsesiones', 'clientes.modalidad', 'fechasasistencia.codigoAlumno')
            ->get();

        return view('dashboard.dashboard', ['asistencias' => $asistencias]);
    }

    public function obtenerFechas()
    {
        // Realiza el join y devuelve solo las últimas 10 asistencias
        $fechas = fechasAsistencia::join('clientes', 'fechasasistencia.codigoAlumno', '=', 'clientes.codigo')
            ->select('fechasAsistencia.fecha', 'clientes.nombre', 'clientes.apellido', 'clientes.apellidoMat', 'clientes.nrsesiones', 'clientes.modalidad')
            ->orderBy('fechasAsistencia.created_at', 'desc')
            ->take(10)
            ->get();

        return response()->json($fechas);
    }
    

public function subirAnuncio(Request $request)
{
    // Validar que haya una imagen en la solicitud
    $request->validate([
        'imagenAnuncio' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    // Directorio donde se guardarán las imágenes
    $carpetaAnuncios = public_path('anuncios');
    
    // Verificar si ya hay una imagen guardada
    $archivos = File::files($carpetaAnuncios);
    if (count($archivos) > 0) {
        // Eliminar la imagen anterior
        foreach ($archivos as $archivo) {
            File::delete($archivo);
        }
    }

    // Subir la nueva imagen
    $archivo = $request->file('imagenAnuncio');
    $nombreImagen = time() . '.' . $archivo->getClientOriginalExtension();
    $archivo->move($carpetaAnuncios, $nombreImagen);

    // Retornar el nombre de la imagen subida
    return response()->json(['nombreImagen' => $nombreImagen]);
}

} 
