

<?php $__env->startSection('title', 'Registrar Usuarios'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $__env->yieldContent('title'); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <a href="/" class="h1"><b>Graficas</b> Financieras</a>
                    </div>
                    <div class="container">
                        <div class="card-container">
                            <div class="form-group">
                                <label for="mes">Seleccionar Mes:</label>
                                <input type="month" id="mes" name="mes" class="form-control" value="<?php echo e(date('Y-m')); ?>">
                            </div>
                            <canvas id="myBarChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Inicialización de los datos y el gráfico
    var ctx = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Cantidad de Atenciones',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Ganancias Bs',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Ventas Bs',
                    data: [],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Pago Distribuidor Bs',
                    data: [],
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: { title: { display: true, text: 'Día del Mes' }},
                y: { title: { display: true, text: 'Monto (Bs)' }}
            }
        }
    });

    // Función para actualizar el gráfico con los datos del mes seleccionado
    function actualizarGrafico() {
        var mes = document.getElementById('mes').value;
        var currentMes = mes.split('-')[1];
        var currentAnio = mes.split('-')[0];

        fetch(`/reporte-estudiantes?mes=${currentMes}&anio=${currentAnio}`)
            .then(response => response.json())
            .then(data => {
                // Procesar los datos recibidos y actualizar el gráfico
                var labels = data.map(item => `Día ${item.dia}`);
                var cantidadAtencionesData = data.map(item => item.cantidad_atenciones);
                var gananciasData = data.map(item => item.ganancias);
                var ventasData = data.map(item => item.ventas);
                var pagoDistribuidorData = data.map(item => item.pago_distribuidor);

                myBarChart.data.labels = labels;
                myBarChart.data.datasets[0].data = cantidadAtencionesData;
                myBarChart.data.datasets[1].data = gananciasData;
                myBarChart.data.datasets[2].data = ventasData;
                myBarChart.data.datasets[3].data = pagoDistribuidorData;
                myBarChart.update();
            });
    }

    // Evento para cambiar el mes
    document.getElementById('mes').addEventListener('change', actualizarGrafico);

    // Inicialización del gráfico al cargar la página
    window.onload = actualizarGrafico;
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/reportes/graficasR.blade.php ENDPATH**/ ?>