<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // Asegúrate de importar la fachada de PDF

class ReportesController extends Controller
{
    public function indexReporte()
    {
        return view('reportes.graficas');
    }
    public function indexReporteR()
    {
        return view('reportes.graficasR');
    }
    public function obtenerEstudiantesPorDia(Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $anio = $request->input('anio', date('Y'));

        // Obtener la cantidad de estudiantes, ganancias, descuentos, ventas, salarios y pago_distribuidor por día
        $estudiantes = DB::table('clientes')
            ->select(
                DB::raw('DAY(created_at) as dia'), 
                DB::raw('COUNT(id) as cantidad_estudiantes'), 
                DB::raw('SUM(costo) as ganancias'),
                DB::raw('SUM(descuento) as descuentos')
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        $ventas = DB::table('ventas')
            ->select(
                DB::raw('DAY(created_at) as dia'), 
                DB::raw('SUM(total) as ventas')
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        $salarios = DB::table('horarios')
            ->select(
                DB::raw('DAY(created_at) as dia'), 
                DB::raw('SUM(salario) as salarios')
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        $pagosDistribuidor = DB::table('aniadirStock')
            ->select(
                DB::raw('DAY(created_at) as dia'),
                DB::raw('SUM(pago_distribuidor) as pago_distribuidor')
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        // Unir los datos por día
        $resultados = [];
        foreach ($estudiantes as $est) {
            $dia = $est->dia;
            $ventaDia = $ventas->firstWhere('dia', $dia);
            $salarioDia = $salarios->firstWhere('dia', $dia);
            $pagoDistribuidorDia = $pagosDistribuidor->firstWhere('dia', $dia);

            $resultados[] = [
                'dia' => $dia,
                'cantidad_estudiantes' => $est->cantidad_estudiantes,
                'ganancias' => $est->ganancias,
                'descuentos' => $est->descuentos,
                'ventas' => $ventaDia->ventas ?? 0,
                'salarios' => $salarioDia->salarios ?? 0,
                'pago_distribuidor' => $pagoDistribuidorDia->pago_distribuidor ?? 0,
            ];
        }
        
        return response()->json($resultados);
    }
    public function obtenerEstudiantesPorDiaR(Request $request)
    {
        $mes = $request->input('mes', date('m'));
        $anio = $request->input('anio', date('Y'));

        // Obtener la cantidad de estudiantes, ganancias, descuentos, ventas, salarios y pago_distribuidor por día
        $atenciones = DB::table('atencionRacket')
            ->select(
        DB::raw('DAY(created_at) as dia'), // Obtiene el día de la fecha
        DB::raw('COUNT(id) as cantidad_atenciones'), // Cuenta la cantidad de atenciones
        DB::raw('SUM(total) as ganancias') // Suma el total como ganancias
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        $ventas = DB::table('ventasR')
            ->select(
                DB::raw('DAY(created_at) as dia'), 
                DB::raw('SUM(totalR) as ventas')
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();
        $pagosDistribuidor = DB::table('aniadirStockR')
            ->select(
                DB::raw('DAY(created_at) as dia'),
                DB::raw('SUM(pago_distribuidorR) as pago_distribuidor')
            )
            ->whereYear('created_at', $anio)
            ->whereMonth('created_at', $mes)
            ->groupBy(DB::raw('DAY(created_at)'))
            ->orderBy(DB::raw('DAY(created_at)'), 'asc')
            ->get();

        // Unir los datos por día
        $resultados = [];
        foreach ($atenciones as $est) {
            $dia = $est->dia;
            $ventaDia = $ventas->firstWhere('dia', $dia);
            $pagoDistribuidorDia = $pagosDistribuidor->firstWhere('dia', $dia);

            $resultados[] = [
                'dia' => $dia,
                'cantidad_atenciones' => $est->cantidad_atenciones,
                'ganancias' => $est->ganancias,
                'ventas' => $ventaDia->ventas ?? 0,
                'pago_distribuidor' => $pagoDistribuidorDia->pago_distribuidor ?? 0,
            ];
        }
        
        return response()->json($resultados);
    }

    public function generarInforme($dia, $mes, $anio)
{
    // Obtener los detalles de los clientes registrados en la fecha seleccionada
    $detalleClientes = DB::table('clientes')
        ->whereDay('created_at', $dia)
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->select('nombre', 'apellido', 'costo', 'descuento')
        ->get();

    // Obtener los detalles de stock añadido en la fecha seleccionada, incluyendo 'pago_distribuidor'
    $detalleStock = DB::table('aniadirStock')
        ->join('productos', 'aniadirStock.id_producto_aniadido', '=', 'productos.id_producto')
        ->whereDay('aniadirStock.created_at', $dia)
        ->whereMonth('aniadirStock.created_at', $mes)
        ->whereYear('aniadirStock.created_at', $anio)
        ->select('productos.nombre as nombreProductoAñadido', 'aniadirStock.pago_distribuidor')
        ->get();

    // Obtener los detalles de las ventas realizadas en la fecha seleccionada
    $detalleVentas = DB::table('ventas')
        ->whereDay('created_at', $dia)
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->select('nombre', 'total')
        ->get();

    // Obtener los detalles de los salarios de los profesores
    $detalleSalarios = DB::table('horarios') // Nombre correcto de la tabla 'horarios'
    ->join('users', 'horarios.id_user', '=', 'users.id_user') // Cambiar 'id_users' por 'id_user'
    ->whereDay('horarios.created_at', $dia)
    ->whereMonth('horarios.created_at', $mes)
    ->whereYear('horarios.created_at', $anio)
    ->where('users.TipoUsuario', 'profesor')
    ->select('users.name as nombreProfesor', 'horarios.salario')
    ->get();

    // Calcular totales de ingresos y egresos
    $totalGanancias = DB::table('clientes')
        ->whereDay('created_at', $dia)
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->sum('costo');

    $totalDescuentos = DB::table('clientes')
        ->whereDay('created_at', $dia)
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->sum('descuento');

    $totalPagoDistribuidor = DB::table('aniadirStock')
        ->whereDay('created_at', $dia)
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->sum('pago_distribuidor');

    $totalVentas = DB::table('ventas')
        ->whereDay('created_at', $dia)
        ->whereMonth('created_at', $mes)
        ->whereYear('created_at', $anio)
        ->sum('total');
    
    $totalSueldos = DB::table('horarios')
        ->join('users', 'horarios.id_user', '=', 'users.id_user') // Unimos las tablas 'horarios' y 'users'
        ->whereDay('horarios.created_at', $dia)
        ->whereMonth('horarios.created_at', $mes)
        ->whereYear('horarios.created_at', $anio)
        ->where('users.TipoUsuario', 'profesor') // Solo profesores
        ->sum('horarios.salario'); // Sumamos los salarios

    // Obtener la fecha completa
    $fechaCompleta = date('d/m/Y', strtotime("$anio-$mes-$dia"));

    // Preparar los datos para el PDF
    $pdfData = [
        'dia' => $dia,
        'fechaCompleta' => $fechaCompleta,
        'detalleClientes' => $detalleClientes,
        'detalleStock' => $detalleStock,
        'detalleVentas' => $detalleVentas,
        'detalleSalarios' => $detalleSalarios,
        'totalDescuentos' => $totalDescuentos,
        'totalPagoDistribuidor' => $totalPagoDistribuidor,
        'totalGanancias' => $totalGanancias,
        'totalVentas' => $totalVentas,
        'detalleSalarios' => $detalleSalarios, // Lista de salarios de los profesores
        'totalSueldos' => $totalSueldos, //
    ];

    // Generar el PDF (ahora se abre en otra pestaña en lugar de descargarse)
    $pdf = PDF::loadView('pdf.informeF', $pdfData);
    
    // Mostrar el PDF en una nueva pestaña
    return $pdf->stream('informeF_dia_' . $dia . '.pdf');
}

}
