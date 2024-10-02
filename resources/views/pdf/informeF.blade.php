<!DOCTYPE html>
<html>
<head>
    <title>Informe F - Detalle del Día</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header .fecha {
            margin-top: 5px;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .column-name, .column-egresos, .column-ingresos {
            width: 33%;
        }
        .section-title {
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Detalle Especifico</h1>
        <div class="fecha">Fecha: {{ $fechaCompleta }}</div>
    </div>
    <table>
        <thead>
            <tr>
                <th class="column-name">Nombre</th>
                <th class="column-egresos">Egresos</th>
                <th class="column-ingresos">Ingresos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalleVentas as $venta)
                <tr>
                    <td>
                        <div class="section-title">Producto Vendido:</div>
                        {{ $venta->nombreProducto }}<br>
                        <div class="section-title">Profesor:</div>
                        {{ $venta->nombreProfesor }}<br>
                        <div class="section-title">Cliente:</div>
                        {{ $venta->nombreCliente }} {{ $venta->apellidoCliente }}<br>
                    </td>
                    <td>
                        <div class="section-title">Descuentos:</div>
                        Bs. {{ number_format($totalDescuentos, 2) }}<br>
                        <div class="section-title">Pago a Distribuidor:</div>
                        Bs. {{ number_format($totalPagoDistribuidor, 2) }}<br>
                        <div class="section-title">Salario Profesor:</div>
                        Bs. {{ number_format($totalSalarios, 2) }}<br>
                    </td>
                    <td>
                        <div class="section-title">Ganancias Inscritos:</div>
                        Bs. {{ number_format($totalGanancias, 2) }}<br>
                        <div class="section-title">Ingresos Ventas:</div>
                        Bs. {{ number_format($totalVentas, 2) }}<br>
                    </td>
                </tr>
            @endforeach

            @foreach ($detalleStock as $stock)
                <tr>
                    <td>
                        <div class="section-title">Producto Añadido:</div>
                        {{ $stock->nombreProductoAñadido }}<br>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach

            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td><strong>Bs. {{ number_format($total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
