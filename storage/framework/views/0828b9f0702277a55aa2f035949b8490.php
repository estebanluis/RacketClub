
<?php $__env->startSection('title', 'Reservar Canchas'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $__env->yieldContent('title'); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div id='calendar'></div> <!-- Calendario -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para Registrar Nueva Reserva -->
<div class="modal fade" id="addReservaModal" tabindex="-1" role="dialog" aria-labelledby="addReservaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="addReservaModalLabel">Registrar Nueva Reserva</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('rcancha.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <!-- Fila para Nombre y Fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre:</label>
                            <input type="text" name="name" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fecha" id="fecha" class="form-control" required>
                        </div>
                    </div>

                    <!-- Fila para Hora y Nro. Cancha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hora">Hora:</label>
                            <input type="time" name="hora" id="hora" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="cancha">Nro. Cancha:</label>
                            <input type="number" name="cancha" id="cancha" class="form-control" min="1" max="4" required>
                        </div>
                    </div>

                    <!-- Fila para Deporte y Cantidad de Horas -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="deporte">Deporte:</label>
                            <select name="deporte" id="deporte" class="form-control" required>
                                <option value="racket">Racket</option>
                                <option value="wally">Wally</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tiempoReserva">Cantidad de Horas:</label>
                            <input type="number" name="tiempoReserva" id="tiempoReserva" class="form-control" min="1" required>
                        </div>
                    </div>

                    <!-- Observaciones -->
                    <div class="form-group mb-3">
                        <label for="observaciones">Observaciones:</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" cols="10" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" type="submit">Registrar Reserva</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal para Ver y Editar Detalles de Reserva -->
<div class="modal fade" id="verDetallesModal" tabindex="-1" role="dialog" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="verDetallesModalLabel">Detalles de la Reserva</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="editarReservaForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <p><strong>Nombre:</strong> <span id="detalleNombre"></span></p>

                    <!-- Fila para Fecha y Deporte -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="detalleFecha">Fecha:</label>
                            <input type="date" name="fecha" id="detalleFecha" class="form-control" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="detalleDeporte">Deporte:</label>
                            <select name="deporte" id="detalleDeporte" class="form-control" readonly>
                                <option value="racket">Racket</option>
                                <option value="wally">Wally</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fila para Hora y Nro. Cancha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="detalleHora">Hora:</label>
                            <input type="time" name="hora" id="detalleHora" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="detalleCancha">Nro. Cancha:</label>
                            <input type="number" name="numero_cancha" id="detalleCancha" class="form-control" min="1" max="4">
                        </div>
                    </div>

                    <!-- Cantidad de Horas y Observaciones -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="detalleTiempoReserva">Cantidad de Horas:</label>
                            <input type="number" name="tiempoReserva" id="detalleTiempoReserva" class="form-control" min="1" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="detalleObservaciones">Observaciones:</label>
                            <textarea name="observaciones" id="detalleObservaciones" class="form-control" cols="10" rows="3" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-danger" type="button" id="eliminarReservaBtn">Eliminar</button>
                    <button class="btn btn-success" type="submit">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                height: 'auto',
                contentHeight: 300,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                events: JSON.parse('<?php echo json_encode($events); ?>'),
                dateClick: function(info) {
                    document.getElementById('fecha').value = info.dateStr;
                    $('#addReservaModal').modal('show');
                },
                eventClick: function(info) {
    // Detalles del evento
    document.getElementById('detalleNombre').innerText = info.event.title;
    document.getElementById('detalleFecha').value = info.event.startStr.split('T')[0];

    // Ajuste aquí para tomar la hora correcta sin alterar
    var hora = new Date(info.event.start).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }); // Solo HH:mm

    document.getElementById('detalleHora').value = hora;
    document.getElementById('detalleCancha').value = info.event.extendedProps.numeroCancha;
    document.getElementById('detalleDeporte').value = info.event.extendedProps.tipo;
    document.getElementById('detalleTiempoReserva').value = info.event.extendedProps.tiempoReserva;
    document.getElementById('detalleObservaciones').value = info.event.extendedProps.observaciones;

    document.getElementById('editarReservaForm').action = `/rcancha/${info.event.id}`;

    document.getElementById('eliminarReservaBtn').addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas eliminar esta reserva?')) {
            const deleteForm = document.createElement('form');
            deleteForm.method = 'POST';
            deleteForm.action = `/rcancha/${info.event.id}`;
            deleteForm.innerHTML = `<?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>`;
            document.body.appendChild(deleteForm);
            deleteForm.submit();
        }
    });

    $('#verDetallesModal').modal('show');
}

            });

            calendar.render();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/ReservarCanchas/reservasCanchas.blade.php ENDPATH**/ ?>