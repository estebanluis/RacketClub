
<?php $__env->startSection('title', 'Horario Profesor'); ?>
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
<!-- Modal -->
<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="eventModalLabel">Detalles del Evento</h5>
                
            </div>
            <div class="modal-body">
                <p id="modalDescription"></p>
                <p><strong>Observaciones:</strong> <span id="modalObservaciones"></span></p>
                <p><strong>Número de Alumnos:</strong> <span id="modalAlumnos"></span></p>
                <p><strong>Fecha:</strong> <span id="modalFecha"></span></p>
                <p><strong>Hora:</strong> <span id="modalHora"></span></p>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                height: 'auto',
                contentHeight: 300,
                slotLabelFormat: {
                    hour: 'numeric',
                    minute: '2-digit',
                    meridiem: 'short',
                    hourCycle: 'h23'
                },
                slotMinTime: "07:00:00",
                slotMaxTime: "21:00:00",
                events: <?php echo json_encode($barang, 15, 512) ?>,

                eventClick: function(info) {
                    // Mostrar el modal con los detalles del evento
                    document.getElementById('modalDescription').innerText = info.event.extendedProps.description;
                    document.getElementById('modalObservaciones').innerText = info.event.extendedProps.observaciones || 'N/A';
                    document.getElementById('modalAlumnos').innerText = info.event.title.split(': ')[1];
                    document.getElementById('modalFecha').innerText = info.event.start.toISOString().slice(0, 10); // Solo la fecha
                    document.getElementById('modalHora').innerText = info.event.start.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) + ' - ' + info.event.end.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});

                    // Mostrar el modal
                    $('#eventModal').modal('show');
                }
            });

            calendar.render();
        });
    </script>
<?php $__env->stopSection(); ?>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/horarioProfe/horarioProf.blade.php ENDPATH**/ ?>