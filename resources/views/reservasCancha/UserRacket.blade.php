@extends('template.main')
@section('title', 'Lista de Usuarios Racket')
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
                        <div class="card-header">
                            <div class="text-right">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Usuario
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>C.I.</th>
                                        <th>Nombre</th>
                                        <th>Telefono</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $data)
                                        <tr>
                                            <td>{{ $data->CI }}</td>
                                            <td>{{ $data->nombre }}</td>
                                            <td>{{ $data->telefono }}</td>
                                            <td>
                                                <!-- Botón para abrir el modal de reserva -->
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#registerReservaModal" data-ci="{{ $data->CI }}">
                                                    <i class="fa fa-calendar-plus"></i> Añadir Reserva
                                                </button>
                                                <form action="{{ route('usuariosRacket.destroy', $data->CI) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
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

<!-- Modal para Registrar Usuario -->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="registerUserModalLabel">Registrar Usuario Racket</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('usuariosRacket.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="CI">C.I.</label>
                        <input type="text" name="CI" id="CI" class="form-control @error('CI') is-invalid @enderror" value="{{ old('CI') }}" required>
                        @error('CI')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="telefono">Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control @error('telefono') is-invalid @enderror" value="{{ old('telefono') }}" required>
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Registrar Usuario</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Registrar Reserva -->
<div class="modal fade" id="registerReservaModal" tabindex="-1" role="dialog" aria-labelledby="registerReservaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="registerReservaModalLabel">Registrar Reserva</h5>
            </div>
            <div class="modal-body">
                <form action="{{ route('reservas.store') }}" method="POST">
                    @csrf

                    <!-- CI (usuario) -->
                    <div class="form-group">
                        <label for="CI">C.I. del Cliente</label>
                        <input type="text" name="CI" id="CI_reserva" class="form-control @error('CI') is-invalid @enderror" value="{{ old('CI') }}" readonly required>
                        @error('CI')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Deporte -->
                    <div class="form-group">
                        <label for="deporte">Deporte</label>
                        <select name="deporte" id="deporte" class="form-control @error('deporte') is-invalid @enderror" required>
                            <option value="">Seleccione un deporte</option>
                            @foreach ($deportes as $deporte)
                                <option value="{{ $deporte->id }}" >
                                    {{ $deporte->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('deporte')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Cancha -->
                    <div class="form-group">
                        <label for="cancha_id">Cancha</label>
                        <select name="cancha_id" id="cancha_id" class="form-control @error('cancha_id') is-invalid @enderror" required>
                            <option value="">Seleccione una cancha</option>
                        </select>
                        @error('cancha_id')
                         <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Día -->
                    <div class="form-group">
                        <label for="dia">Día</label>
                        <input type="date" name="dia" id="dia" class="form-control @error('dia') is-invalid @enderror" value="{{ old('dia') }}" required>
                        @error('dia')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Hora -->
                    <div class="form-group">
                        <label for="hora">Hora</label>
                        <input type="time" name="hora" id="hora" class="form-control @error('hora') is-invalid @enderror" value="{{ old('hora') }}" required>
                        @error('hora')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Días de la semana -->
                    <label>Días de la semana:</label><br>
                    @php
                        $diasSeleccionados = old('dias_semana', []);
                    @endphp
                    @foreach(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'] as $dia)
                        <label>
                            <input type="checkbox" name="dias_semana[]" value="{{ $dia }}" {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}> {{ $dia }}
                        </label>
                    @endforeach
                    @error('dias_semana')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror

                    <!-- Cantidad de Horas -->
                    <div class="form-group">
                        <label for="cantidadHoras">Cantidad de Horas</label>
                        <input type="number" name="cantidadHoras" id="cantidadHoras" class="form-control @error('cantidadHoras') is-invalid @enderror" value="{{ old('cantidadHoras') }}" min="1" required>
                        @error('cantidadHoras')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Observaciones -->
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" rows="2">{{ old('observaciones') }}</textarea>
                        @error('observaciones')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Botón -->
                    <div class="form-group text-right">
                        <button type="submit" class="btn btn-success">Registrar Reserva</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        @if(session('show_modal') === 'registerReservaModal')
            $('#registerReservaModal').modal('show');
        @endif

        // Cargar CI automáticamente
        $('#registerReservaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var ci = button.data('ci');
            if (ci) {
                $('#CI_reserva').val(ci);
            }
        });


        // Mapeo deporte -> canchas desde PHP a JS
        const deporteCanchasMap = @json($deportes->mapWithKeys(function ($deporte) {
            return [$deporte->id => $deporte->canchas->map(function ($cancha) {
                return ['id' => $cancha->id, 'nombre' => $cancha->nombre];
            })];
        }));

        // Al cambiar deporte, mostrar solo canchas relacionadas
        $('#deporte').on('change', function () {
            const deporteId = $(this).val();
            const canchas = deporteCanchasMap[deporteId] || [];

            // Limpiar las canchas anteriores
            const canchaSelect = $('#cancha_id');
            canchaSelect.empty().append('<option value="">Seleccione una cancha</option>');

            // Agregar nuevas canchas relacionadas
            canchas.forEach(function (cancha) {
                canchaSelect.append(`<option value="${cancha.id}">${cancha.nombre}</option>`);
            });
        });
    });
</script>



@endsection
