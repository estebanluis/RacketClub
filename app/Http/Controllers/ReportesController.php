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

    public function generarInforme($dia, $mes, $anio)
    {
        
        // Obtener los detalles de ventas
        $detalleVentas = DB::table('ventas')
            ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id') // Asumiendo que ventas tiene cliente_id
            ->join('productos', 'ventas.producto_id', '=', 'productos.id') // Asumiendo que ventas tiene producto_id
            ->join('horarios', 'ventas.profesor_id', '=', 'horarios.id') // Asumiendo que ventas tiene profesor_id
            ->whereDay('ventas.created_at', $dia)
            ->whereMonth('ventas.created_at', $mes)
            ->whereYear('ventas.created_at', $anio)
            ->select('productos.nombre as nombreProducto', 'horarios.nombre as nombreProfesor', 'clientes.nombre as nombreCliente', 'clientes.apellido as apellidoCliente')
            ->get();

        // Obtener los detalles de stock añadido
        $detalleStock = DB::table('aniadirStock')
            ->join('productos', 'aniadirStock.id_producto_aniadido', '=', 'productos.id') // Asumiendo que aniadirStock tiene id_producto_aniadido
            ->whereDay('aniadirStock.created_at', $dia)
            ->whereMonth('aniadirStock.created_at', $mes)
            ->whereYear('aniadirStock.created_at', $anio)
            ->select('productos.nombre as nombreProductoAñadido')
            ->get();

        // Calcular los totales financieros
        $totalGanancias = DB::table('clientes')
            ->whereDay('created_at', $dia)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->sum('costo');

        $totalVentas = DB::table('ventas')
            ->whereDay('created_at', $dia)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->sum('total');

        $totalDescuentos = DB::table('clientes')
            ->whereDay('created_at', $dia)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->sum('descuento');

        $totalSalarios = DB::table('horarios')
            ->whereDay('created_at', $dia)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->sum('salario');

        $totalPagoDistribuidor = DB::table('aniadirStock')
            ->whereDay('created_at', $dia)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->sum('pago_distribuidor');

        $total = $totalGanancias + $totalVentas - $totalDescuentos - $totalPagoDistribuidor - $totalSalarios;

        // Obtener la fecha completa
        $fechaCompleta = date('d/m/Y', strtotime("$anio-$mes-$dia"));

        // Preparar los datos para el PDF
        $pdfData = [
            'dia' => $dia,
            'fechaCompleta' => $fechaCompleta,
            'detalleVentas' => $detalleVentas,
            'detalleStock' => $detalleStock,
            'totalDescuentos' => $totalDescuentos,
            'totalPagoDistribuidor' => $totalPagoDistribuidor,
            'totalSalarios' => $totalSalarios,
            'totalGanancias' => $totalGanancias,
            'totalVentas' => $totalVentas,
            'total' => $total,
        ];
        
        // Generar el PDF
        $pdf = PDF::loadView('pdf.informeF', $pdfData);
       
        // Descargar el PDF
        return $pdf->download('informeF_dia_' . $dia . '.pdf');
    }
}
