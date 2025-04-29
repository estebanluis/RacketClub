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
    <p>Fecha: <?php echo e($fechaCompleta); ?></p>

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
            <?php $__currentLoopData = $detalleClientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($cliente->nombre); ?> <?php echo e($cliente->apellido); ?></td>
                <td><?php echo e($cliente->descuento); ?></td>
                <td><?php echo e($cliente->costo); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Stock añadido -->
            <?php $__currentLoopData = $detalleStock; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>Stock Añadido: <?php echo e($stock->nombreProductoAñadido); ?></td>
                <td><?php echo e($stock->pago_distribuidor); ?></td>
                <td></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Ventas realizadas -->
            <?php $__currentLoopData = $detalleVentas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>Venta Realizada: <?php echo e($venta->nombre); ?></td>
                <td></td>
                <td><?php echo e($venta->total); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Salarios de profesores -->
            <?php $__currentLoopData = $detalleSalarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $salario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td>Profesor: <?php echo e($salario->nombreProfesor); ?></td>
                <td><?php echo e($salario->salario); ?></td>
                <td></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <p><strong>Total Descuentos:</strong> <?php echo e($totalDescuentos); ?></p>
    <p><strong>Total Pago a Distribuidor:</strong> <?php echo e($totalPagoDistribuidor); ?></p>
    <p><strong>Total Ganancias:</strong> <?php echo e($totalGanancias); ?></p>
    <p><strong>Total Ventas:</strong> <?php echo e($totalVentas); ?></p>
    <p><strong>Total Sueldos Profesor:</strong> <?php echo e($totalSueldos); ?></p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/pdf/informeF.blade.php ENDPATH**/ ?>