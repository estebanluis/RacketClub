@extends('template.main')
@section('title', 'Reservas de Canchas')
@section('content')

<div class="content-wrapper">
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
<!-- Modal para Ver Detalles de la Reserva -->
<div class="modal fade" id="modalVerReserva" tabindex="-1" role="dialog" aria-labelledby="modalVerReservaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info text-white">
          <h5 class="modal-title" id="modalVerReservaLabel">Detalles de la Reserva</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p><strong>Deporte:</strong> <span id="detalleDeporte"></span></p>
          <p><strong>Cancha:</strong> <span id="detalleCliente"></span></p>
          <p><strong>Cliente:</strong> <span id="detalleCancha"></span></p>
          <p><strong>Hora Inicio:</strong> <span id="detalleInicio"></span></p>
          <p><strong>Hora Fin:</strong> <span id="detalleFin"></span></p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="btnEliminarReserva">Eliminar Reserva</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
      <form id="formReservaMultiple" method="POST" action="{{ route('reservar.store') }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalReservaMultipleLabel">Reservar múltiples días</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
            <div class="form-group">
                <label for="usuario_nombre">Nombre del Usuario</label>
                <input type="text" id="usuario_nombre" name="usuario_nombre" class="form-control" autocomplete="off">
                <ul id="autocomplete-list" class="list-group" style="display:none; position: absolute; z-index: 9999;"></ul>
            </div>
            <input type="hidden" id="CI" name="CI">
            <div class="form-group">
              <label for="deporte">Deporte</label>
              <select name="deporte" id="deporte" class="form-control">
                <option value="">Seleccionar deporte</option>
                @foreach ($deportes as $deporte)
                  <option value="{{ $deporte->id }}">{{ $deporte->nombre }}</option>
                @endforeach
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

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

<script>

$(document).ready(function() {
    // Inicializar el autocompletado
    $('#usuario_nombre').on('input', function() {
        let query = $(this).val();

        if (query.length > 2) { 
            $.ajax({
                url: '/buscar-usuarios',
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    let suggestions = data.map(function(usuario) {
                        return `<li data-id="${usuario.ci}" class="list-group-item">${usuario.nombre}</li>`;
                    }).join('');
                    $('#autocomplete-list').html(suggestions).show();
                }
            });
        } else {
            $('#autocomplete-list').hide();
        }
    });
    $(document).on('click', '.list-group-item', function() {
        let usuarioId = $(this).data('id');
        let usuarioNombre = $(this).text();

        $('#CI').val(usuarioId);
        $('#usuario_nombre').val(usuarioNombre);
        $('#autocomplete-list').hide();
    });
    $(document).click(function(e) {
        if (!$(e.target).closest('#usuario_nombre').length) {
            $('#autocomplete-list').hide();
        }
    });
});

</script>
<script>
    window.deportes = @json($deportes);
    let fechasSeleccionadas = [];

    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            selectable: true,
            events: '{{ route("calendario.reservas") }}',
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
            eventClick: function(info) {
                const evento = info.event;

                const horaInicio = evento.start.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const horaFin = evento.end ? evento.end.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) : 'No especificado';

                const partes = evento.title.split(' - ');
                const deporte = partes[0] ?? 'No especificado';
                const cancha = partes[1] ?? 'No especificado';
                const cliente = partes[2] ?? 'No especificado';

                $('#detalleDeporte').text(deporte);
                $('#detalleCancha').text(cancha);
                $('#detalleCliente').text(cliente);
                $('#detalleInicio').text(horaInicio);
                $('#detalleFin').text(horaFin);

                $('#modalVerReserva').modal('show');
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
                                 <span class="text-danger" id="error-cancha_${fecha}_${indice}" style="display:none;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            contenedor.insertAdjacentHTML('beforeend', html);

            // Aquí agregamos el event listener para la cancha
            document.getElementById(`cancha_${indice}`).addEventListener('change', function () {
                const canchaId = this.value;
                const hora = document.getElementById(`hora_${indice}`).value;
                const dispo = document.getElementById(`duracion_${indice}`).value;

                if (canchaId && hora && dispo) {
                    // Verificar disponibilidad
                    verificarDisponibilidad(canchaId, fecha, hora, dispo);
                }
            });
        });
    }

    function verificarDisponibilidad(canchaId, fecha, hora, dispo) {
        $.ajax({
            url: '{{ route("verificar.disponibilidad") }}', // Ruta al método en el controlador
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cancha_id: canchaId,
                fecha: fecha,
                hora: hora,
                cantidadHoras: dispo
            },
            success: function(response) {
                const indice = document.querySelectorAll('#contenedorFechasSeleccionadas .card').length - 1; // Indice de la tarjeta
                const errorElement = $('#error-cancha_' + fecha + '_' + indice); // ID dinámico para el error

                if (!response.disponible) {
                    // Mostramos el mensaje de error debajo del campo correspondiente
                    errorElement.text(response.mensaje); // Establecer el mensaje de error
                    errorElement.show(); // Hacer visible el mensaje de error
                } else {
                    // Si la cancha está disponible, ocultamos cualquier mensaje de error
                    errorElement.hide();
                }
            },
            error: function(xhr, status, error) {
                alert('Hubo un error al verificar la disponibilidad.');
            }
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
    window.deportes = @json($deportes);
</script>


@endsection