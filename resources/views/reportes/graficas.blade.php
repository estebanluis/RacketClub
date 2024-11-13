@extends('template.main')

@section('title', 'Reporte Financiero')
@section('content')

<div class="content-wrapper">
    @include('sweetalert::alert')

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
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
                                <input type="month" id="mes" name="mes" class="form-control" value="{{ date('Y-m') }}">
                            </div>
                            <canvas id="myBarChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar detalles al hacer clic en una columna -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Detalles del Día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Día:</strong> <span id="modalDia"></span></p>
                    <p><strong>Número de Clientes Registrados:</strong> <span id="modalClientes"></span></p>
                    <p><strong>Ganancias Inscritos:</strong> <span id="modalGanancias"></span></p>
                    <p><strong>Ingresos Ventas:</strong> <span id="modalVentas"></span></p>
                    <p><strong>Descuentos:</strong> <span id="modalDescuentos"></span></p>
                    <p><strong>Salarios Profesores:</strong> <span id="modalSalarios"></span></p>
                    <p><strong>Pago a Distribuidor:</strong> <span id="modalPagoDistribuidor"></span></p>
                    <p><strong>Total:</strong> <span id="modalTotal"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="#" id="btnImprimir" class="btn btn-primary" target="_blank">Imprimir Informe</a>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Define una variable global para almacenar los datos recibidos
    var estudiantesData = [];
    var currentMes = "{{ date('m') }}";
    var currentAnio = "{{ date('Y') }}";

    var ctx = document.getElementById('myBarChart').getContext('2d');
    var myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Ganancias Bs',
                    data: [],
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                },
                {
                    label: 'Descuentos Bs',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',
                    borderColor: 'rgba(255, 99, 132, 1)',
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
                    label: 'Salarios Bs',
                    data: [],
                    backgroundColor: 'rgba(255, 159, 64, 0.5)',
                    borderColor: 'rgba(255, 159, 64, 1)',
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
                y: {
                    beginAtZero: true
                }
            },
            onClick: function(e) {
                var activePoints = myBarChart.getElementsAtEventForMode(e, 'nearest', { intersect: true }, true);
                if (activePoints.length > 0) {
                    var clickedElementIndex = activePoints[0].index;
                    var diaData = estudiantesData[clickedElementIndex];

                    document.getElementById('modalDia').textContent = `Día ${diaData.dia}`;
                    document.getElementById('modalClientes').textContent = diaData.cantidad_estudiantes;
                    document.getElementById('modalGanancias').textContent = diaData.ganancias;
                    document.getElementById('modalVentas').textContent = diaData.ventas;
                    document.getElementById('modalDescuentos').textContent = diaData.descuentos;
                    document.getElementById('modalSalarios').textContent = diaData.salarios;
                    document.getElementById('modalPagoDistribuidor').textContent = diaData.pago_distribuidor;

                    // Asegurarse de convertir los valores a números con parseFloat()
                    var ganancias = parseFloat(diaData.ganancias) || 0;
                    var ventas = parseFloat(diaData.ventas) || 0;
                    var descuentos = parseFloat(diaData.descuentos) || 0;
                    var salarios = parseFloat(diaData.salarios) || 0;
                    var pagoDistribuidor = parseFloat(diaData.pago_distribuidor) || 0;

                    // Cálculo del total
                    var total = ganancias + ventas - descuentos - pagoDistribuidor - salarios;
                    document.getElementById('modalTotal').textContent = total.toFixed(2);

                    // Set the href of the "Imprimir Informe" button
                    var btnImprimir = document.getElementById('btnImprimir');
                    btnImprimir.href = `/generar-informe/${diaData.dia}/${currentMes}/${currentAnio}`;

                    var modal = new bootstrap.Modal(document.getElementById('infoModal'));
                    modal.show();
                }
            }
        }
    });

    // Función para actualizar el gráfico con los datos del mes seleccionado
    function actualizarGrafico() {
        var mes = document.getElementById('mes').value;
        currentMes = mes.split('-')[1];
        currentAnio = mes.split('-')[0];

        fetch(`/reporte-estudiantes?mes=${currentMes}&anio=${currentAnio}`)
            .then(response => response.json())
            .then(data => {
                estudiantesData = data;

                var labels = data.map(item => `Día ${item.dia}`);
                var gananciasData = data.map(item => item.ganancias);
                var descuentosData = data.map(item => item.descuentos);
                var ventasData = data.map(item => item.ventas);
                var salariosData = data.map(item => item.salarios);
                var pagoDistribuidorData = data.map(item => item.pago_distribuidor);

                myBarChart.data.labels = labels;
                myBarChart.data.datasets[0].data = gananciasData;
                myBarChart.data.datasets[1].data = descuentosData;
                myBarChart.data.datasets[2].data = ventasData;
                myBarChart.data.datasets[3].data = salariosData;
                myBarChart.data.datasets[4].data = pagoDistribuidorData;
                myBarChart.update();
            });
    }

    // Evento para cambiar el mes
    document.getElementById('mes').addEventListener('change', actualizarGrafico);

    // Inicialización del gráfico al cargar la página
    window.onload = actualizarGrafico;
</script>
@endsection
