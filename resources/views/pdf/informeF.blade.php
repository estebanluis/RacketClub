<!DOCTYPE html>
<html>
<head>
    <title>Informe Diario</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Detalle Específico</h1>
    <p>Fecha: {{ $fechaCompleta }}</p>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Egresos</th>
                <th>Ingresos</th>
            </tr>
        </thead>
        <tbody>
            <!-- Clientes registrados -->
            @foreach ($detalleClientes as $cliente)
            <tr>
                <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                <td>{{ $cliente->descuento }}</td>
                <td>{{ $cliente->costo }}</td>
            </tr>
            @endforeach

            <!-- Stock añadido -->
            @foreach ($detalleStock as $stock)
            <tr>
                <td>Stock Añadido: {{ $stock->nombreProductoAñadido }}</td>
                <td>{{ $stock->pago_distribuidor }}</td>
                <td></td>
            </tr>
            @endforeach

            <!-- Ventas realizadas -->
            @foreach ($detalleVentas as $venta)
            <tr>
                <td>Venta Realizada: {{ $venta->nombre }}</td>
                <td></td>
                <td>{{ $venta->total }}</td>
            </tr>
            @endforeach

            <!-- Salarios de profesores -->
            @foreach ($detalleSalarios as $salario)
            <tr>
                <td>Profesor: {{ $salario->nombreProfesor }}</td>
                <td>{{ $salario->salario }}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Total Descuentos:</strong> {{ $totalDescuentos }}</p>
    <p><strong>Total Pago a Distribuidor:</strong> {{ $totalPagoDistribuidor }}</p>
    <p><strong>Total Ganancias:</strong> {{ $totalGanancias }}</p>
    <p><strong>Total Ventas:</strong> {{ $totalVentas }}</p>
    <p><strong>Total Sueldos Profesor:</strong> {{ $totalSueldos }}</p>
</body>
</html>
