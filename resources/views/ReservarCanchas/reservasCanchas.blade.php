@extends('template.main')
@section('title', 'Reservar Canchas')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
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
                        <div class="card-header d-flex justify-content-end">
                            <div class="text-right mr-2">
                                <a href="/rcancha/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Añadir Reserva</a>
                            </div>

                            <div class="text-right">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#reservaModal">
                                    <i class="fa-solid fa-plus"></i> Ver en Reserva
                                </a>
                            </div>

                            <!-- Modal Bootstrap -->
<div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-full-height" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reservar Cancha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
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
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailLabel">Detalles de la Reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Detalles del evento se agregarán aquí -->
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div> -->
        </div>
    </div>
</div>

                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Nro. Cancha</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nombre_reserva }}</td>
                                            <td>{{ $data->fecha }}</td>
                                            <td>{{ $data->hora }}</td>
                                            <td>{{ $data->numero_cancha }}</td>
                                            <td>
                                                <form class="d-inline" action="{{ route('rcancha.transferToAtencion', $data->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm mr-1">
                                                        <i class="fa-solid fa-pen"></i> Pasar a atención
                                                    </button>
                                                </form>
                                                <form class="d-inline" action="/rcancha/{{ $data->id }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm" id="btn-delete"><i class="fa-solid fa-trash-can"></i> Borrar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@section('scripts')
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
                    events: JSON.parse('{!! json_encode($events) !!}'), // Cargar eventos desde el controlador
                    eventClick: function(info) {
                        // Obtener la hora de inicio
                        const startTime = info.event.start;
                        // Obtener el tiempo de reserva
                        const tiempoReserva = info.event.extendedProps.tiempoReserva;

                        // Calcular la hora final sumando el tiempo de reserva
                        const endTime = new Date(startTime);
                        endTime.setHours(startTime.getHours() + tiempoReserva);

                        // Mostrar los detalles del evento en un modal
                        $('#eventDetailModal .modal-title').text(info.event.title); // Título del evento
                        $('#eventDetailModal .modal-body').html(`
                            <p>Fecha: ${startTime.toLocaleDateString()}</p>
                            <p>Hora de Entrada: ${startTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            <p>Hora de Salida: ${endTime.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</p>
                            <p>Número de Cancha: ${info.event.extendedProps.numeroCancha}</p>
                            <p>Tiempo de reserva: ${tiempoReserva} horas</p>
                            <p>Observaciones: ${info.event.extendedProps.observaciones}</p>
                        `); // Detalles adicionales
                        $('#eventDetailModal').modal('show'); // Mostrar el modal
                    }

                });

                calendar.render(); // Renderizar el calendario
                calendarEl.setAttribute('data-fullcalendar-initialized', 'true'); // Marcar como inicializado
            });
        });

    </script>



@endsection

@endsection


