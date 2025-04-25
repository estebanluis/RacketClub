
<?php $__env->startSection('title', 'Reservas de Canchas'); ?>
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

<!-- Botón oculto -->
<button type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#modalReservaMultiple" id="abrirModalReservaMultiple">
    Abrir Modal Reserva Múltiple
</button>

<!-- Modal de Reservas Múltiples -->
<div class="modal fade" id="modalReservaMultiple" tabindex="-1" role="dialog" aria-labelledby="modalReservaMultipleLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-XXL" role="document">
      <form id="formReservaMultiple">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalReservaMultipleLabel">Reservar múltiples días</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
            <div class="form-group">
              <label for="deporte">Deporte</label>
              <select name="deporte" id="deporte" class="form-control">
                <option value="">Seleccionar deporte</option>
                <?php $__currentLoopData = $deportes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deporte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($deporte->id); ?>"><?php echo e($deporte->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
  
            <div id="contenedorFechasSeleccionadas">
              <!-- Aquí se generarán inputs dinámicos por cada fecha seleccionada -->
            </div>
          </div>
          
          <div class="modal-footer">
            <button type="submit" class="btn btn-success">Guardar reservas</button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<script>
    window.deportes = <?php echo json_encode($deportes, 15, 512) ?>;
    let fechasSeleccionadas = [];

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            selectable: true,
            events: '<?php echo e(route("calendario.reservas")); ?>',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },
            contentHeight: 500,

            dateClick: function(info) {
                const fecha = info.dateStr;

                const yaExiste = document.querySelector(`[data-fecha="${fecha}"]`);
                if (yaExiste) {
                    alert('Ya seleccionaste esta fecha.');
                    return;
                }

                fechasSeleccionadas.push(fecha);
                generarCamposPorFechas([fecha]);

                $('#modalReservaMultiple').modal('show');
            },

            eventContent: function (arg) {
                const horaInicio = arg.event.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const horaFin = arg.event.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

                const intervalo = `${horaInicio} - ${horaFin}`;
                const partes = arg.event.title.split(' - ');
                const deporte = partes[0] ?? '';
                const cancha = partes[1] ?? '';
                const nombre = partes[2] ?? '';

                return {
                    html: `
                        <div style="background:#f4f6f9; padding:5px; border-radius:8px; border:1px solid #ccc; font-size: 0.8rem;">
                            <div style="font-weight: bold; color: #007bff;">${intervalo}</div>
                            <div style="color: #28a745;">${cancha} | ${deporte}</div>
                            <div style="font-size: 0.75rem; color:#555;">${nombre}</div>
                        </div>
                    `
                };
            },
        });

        calendar.render();
    });

    // Función para generar campos de reserva por fecha
    function generarCamposPorFechas(fechas) {
        const contenedor = document.getElementById('contenedorFechasSeleccionadas');
        const deporteId = document.getElementById('deporte').value;

        if (!deporteId) {
            alert('Selecciona un deporte primero.');
            return;
        }

        const deporteSeleccionado = window.deportes.find(dep => dep.id == deporteId);
        const canchas = deporteSeleccionado ? deporteSeleccionado.canchas : [];

        fechas.forEach((fecha) => {
            const indice = document.querySelectorAll('#contenedorFechasSeleccionadas .card').length;

            let opcionesCancha = '<option value="">Seleccionar cancha</option>';
            canchas.forEach(c => {
                opcionesCancha += `<option value="${c.id}">${c.nombre}</option>`;
            });

            const html = `
                <div class="card mb-2" data-fecha="${fecha}">
                    <div class="card-body">
                        <h6 class="card-title">
                            Reserva para el día: <strong>${fecha}</strong>
                            <button type="button" class="btn btn-sm btn-danger float-right" onclick="eliminarFecha('${fecha}', this)">Eliminar</button>
                        </h6>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="hora_${indice}">Hora</label>
                                <input type="time" class="form-control" name="horas[${fecha}]" id="hora_${indice}" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="duracion_${indice}">Duración (horas)</label>
                                <input type="number" class="form-control" name="duraciones[${fecha}]" id="duracion_${indice}" value="1" min="1" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cancha_${indice}">Cancha</label>
                                <select class="form-control" name="canchas[${fecha}]" id="cancha_${indice}" required>
                                    ${opcionesCancha}
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            contenedor.insertAdjacentHTML('beforeend', html);
        });
    }

    // Función para eliminar una fecha seleccionada
    function eliminarFecha(fecha, btn) {
        btn.closest('.card').remove();
        fechasSeleccionadas = fechasSeleccionadas.filter(f => f !== fecha);
    }

    // Si el usuario cambia de deporte, eliminamos los campos generados
    document.getElementById('deporte').addEventListener('change', function () {
        document.getElementById('contenedorFechasSeleccionadas').innerHTML = '';
        fechasSeleccionadas = [];
    });
</script>


<script>
    window.deportes = <?php echo json_encode($deportes, 15, 512) ?>;
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/ReservarCanchasCalendario/reservasCanchas.blade.php ENDPATH**/ ?>