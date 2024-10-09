
<?php $__env->startSection('title', 'Reservar Canchas'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Reservas Actuales</h3>
                            <div>
                                <!-- Cambiar el enlace a un botón que abre el modal -->
                                <button class="btn btn-primary mr-2" data-toggle="modal" data-target="#addReservaModal">
                                    <i class="fa-solid fa-plus"></i> Añadir Reserva
                                </button>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#reservaModal">
                                    <i class="fa-solid fa-calendar-alt"></i> Ver Reserva en Calendario
                                </a>
                            </div>
                        </div>

                        <!-- Modal para Añadir Reserva -->
                            <div class="modal fade" id="addReservaModal" tabindex="-1" role="dialog" aria-labelledby="addReservaModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #003554; color: white;">
                                            <h5 class="modal-title" id="addReservaModalLabel">Añadir Reserva</h5>
                                                
                                        </div>
                                        <form class="needs-validation" novalidate action="/rcancha" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="name">Nombre</label>
                                                            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="fecha">Fecha</label>
                                                            <input type="date" name="fecha" class="form-control" id="fecha" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="hora">Hora</label>
                                                            <input type="time" name="hora" class="form-control" id="hora" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="cancha">Nro. Cancha</label>
                                                            <input type="number" min="1" max="4" name="cancha" class="form-control" id="cancha" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="deporte">Deporte</label>
                                                            <select name="deporte" class="form-control" id="deporte" required>
                                                                <option value="">Seleccionar Deporte</option>
                                                                <option value="racket">Racket</option>
                                                                <option value="wally">Wally</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 mb-3">
                                                        <div class="form-group">
                                                            <label for="tiempoReserva">Cantidad de Horas</label>
                                                            <input type="number" min="1" name="tiempoReserva" class="form-control" id="tiempoReserva" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <div class="form-group">
                                                            <label for="observaciones">Observaciones</label>
                                                            <textarea name="observaciones" id="observaciones" class="form-control" cols="10" rows="3" placeholder="Observaciones"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cerrar</button>
                                                <button class="btn btn-success" type="submit">Guardar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>



                        <!-- Modal para Ver Reservas -->
                        <div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-full-height" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #003554; color: white;">
                                        <h5 class="modal-title" id="exampleModalLabel">Reservar Cancha</h5>
                                    </div>
                                    <div class="modal-body modal-body-full">
                                        <div id='calendar'></div> <!-- Aquí se mostrará el calendario -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para Detalles del Evento -->
                        <div class="modal fade" id="eventDetailModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #003554; color: white;">
                                        <h5 class="modal-title" id="eventDetailLabel">Detalles de la Reserva</h5>
                                    </div>
                                    <div class="modal-body">
                                        <!-- Detalles del evento se agregarán aquí -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Nro. Cancha</th>
                                        <th>Deporte</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($data->nombre_reserva); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($data->fecha)->format('d/m/Y')); ?></td>
                                            <td><?php echo e($data->hora); ?></td>
                                            <td><?php echo e($data->numero_cancha); ?></td>
                                            <td><?php echo e($data->tipo); ?></td>
                                            <td>
                                                <form class="d-inline" action="<?php echo e(route('rcancha.transferToAtencion', $data->id)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn btn-success btn-sm mr-1">
                                                        <i class="fa-solid fa-pen"></i> Pasar a atención
                                                    </button>
                                                </form>
                                                <form class="d-inline" action="/rcancha/<?php echo e($data->id); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('delete'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" id="btn-delete"><i class="fa-solid fa-trash-alt"></i> Borrar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        // Script para inicializar el calendario
        document.addEventListener('DOMContentLoaded', function() {
            $('#reservaModal').on('shown.bs.modal', function () {
                var calendarEl = document.getElementById('calendar');

                // Verifica si ya existe un calendario y destrúyelo si es necesario
                if (calendarEl.hasAttribute('data-fullcalendar-initialized')) {
                    return; // El calendario ya está inicializado
                }

                // Inicializar FullCalendar dentro del modal
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listWeek'
                    },
                    events: JSON.parse('<?php echo json_encode($events); ?>'), // Cargar eventos desde el controlador
                    eventClick: function(info) {
                        const startTime = info.event.start;
                        const tiempoReserva = info.event.extendedProps.tiempoReserva;
                        const endTime = new Date(startTime);
                        endTime.setHours(startTime.getHours() + tiempoReserva);

                        $('#eventDetailModal .modal-title').text(info.event.title); // Título del evento
                        $('#eventDetailModal .modal-body').html(`
                            <p><strong>Fecha:</strong> ${startTime.toLocaleDateString()}</p>
                            <p><strong>Hora de Entrada:</strong> ${startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            <p><strong>Hora de Salida:</strong> ${endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            <p><strong>Número de Cancha:</strong> ${info.event.extendedProps.numeroCancha}</p>
                            <p><strong>Tiempo de Reserva:</strong> ${tiempoReserva} horas</p>
                            <p><strong>Observaciones:</strong> ${info.event.extendedProps.observaciones}</p>
                        `);
                        $('#eventDetailModal').modal('show');
                    }
                });

                calendar.render();
                calendarEl.setAttribute('data-fullcalendar-initialized', 'true');
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/ReservarCanchas/reservasCanchas.blade.php ENDPATH**/ ?>