@extends('template.main')
@section('title', 'Atencion Racket')
@section('content')

<div class="content-wrapper">
    <!-- Encabezado de la página -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.Encabezado -->

    <!-- Botón para añadir nueva atención -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addAtencionModal">
                    <i class="fa-solid fa-plus"></i> Añadir Atención
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Ciclo para las 4 canchas -->
                @for ($i = 1; $i <= 4; $i++)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <!-- Personalización de colores de las canchas -->
                        <div class="card-header" style="background-color: #003554; color: white;">
                            <h3 class="card-title">Cancha {{ $i }}</h3>
                        </div>
                        <div class="card-body">
                            @php
                                // Filtrar los datos para la cancha y estado "ocupado"
                                $canchaData = $barang->where('cancha', $i)->where('estado', 'ocupado');
                            @endphp
                            
                            @if ($canchaData->isEmpty())
                                <div class="text-center">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                    <p class="mt-2">Cancha Disponible</p>
                                </div>
                            @else
                            @foreach ($canchaData as $data)
                                <div class="mb-3 p-2 border rounded bg-light">
                                    <strong>{{ $data->nombre }}</strong>
                                    <span class="badge badge-{{ $data->tipo == 'Racket' ? 'success' : 'info' }} float-right">
                                        {{ $data->tipo }}
                                    </span>
                                    <br>
                                    <small>Hora Entrada: {{ $data->hora_inicio }}</small><br>
                                    <small>Hora Salida: {{ $data->hora_fin }}</small><br>
                                    <small>Total Horas: {{ $data->total_horas }}</small><br>
                                    <small>Total: {{ $data->total }} Bs.</small><br>
                                    <small>Observaciones: {{ $data->observaciones ?? 'Ninguna' }}</small>
                                </div>
                                
                                <div class="mt-2">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#finalizarAtencionModal" 
                                        onclick="setFinalizarDetails('{{ $data->id }}', '{{ $data->nombre }}', '{{ $data->hora_inicio }}', '{{ $data->hora_fin }}', '{{ $data->total_horas }}', '{{ $data->total }}', '{{ $data->observaciones }}')">
                                        <i class="fa-solid fa-pen"></i> Finalizar Atención
                                    </button>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>
<!-- Modal para añadir atención -->
<div class="modal fade" id="addAtencionModal" tabindex="-1" role="dialog" aria-labelledby="addAtencionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="addAtencionModalLabel">Añadir Atención</h5>
            </div>
            <form class="needs-validation" novalidate action="/atenracket" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre de Cliente" value="{{ old('name') }}" required>
                                @error('name')
                                <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="horaEntrada">Hora Entrada</label>
                                <input type="time" name="horaEntrada" class="form-control @error('horaEntrada') is-invalid @enderror" id="horaEntrada" readonly required>
                                @error('horaEntrada')
                                <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="cancha">Nro. Cancha</label>
                                <input type="number" min="1" max="4" name="cancha" class="form-control @error('cancha') is-invalid @enderror" id="cancha" placeholder="Nro. de cancha" value="{{ old('cancha') }}" required>
                                @error('cancha')
                                <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tipo">Tipo de Uso</label>
                                <select name="tipo" class="form-control @error('tipo') is-invalid @enderror" id="tipo" required>
                                    <option value="" disabled selected>Seleccione un tipo</option>
                                    <option value="Racket">Racket</option>
                                    <option value="Wally">Wally</option>
                                </select>
                                @error('tipo')
                                <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" cols="10" rows="3" placeholder="Observaciones">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                <span class="invalid-feedback text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Modal para finalizar atención -->
<div class="modal fade" id="finalizarAtencionModal" tabindex="-1" role="dialog" aria-labelledby="finalizarAtencionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="finalizarAtencionModalLabel">Finalizar Atención</h5>
            </div>
            <form id="finalizarAtencionForm" method="POST" action="">
                @csrf
                @method('PUT') <!-- Cambiado a PUT -->
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas finalizar la atención para el siguiente cliente?</p>
                    <div id="atencionDetails"></div>
                    
                    <div class="form-group">
                        <label for="horaSalida">Hora Salida</label>
                        <input type="time" name="horaSalida" id="horaSalida" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="totalHoras">Total Horas</label>
                        <input type="text" name="totalHoras" id="totalHoras" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total">Total (Bs.)</label>
                        <input type="number" name="total" id="total" class="form-control" min="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                 <button type="submit" class="btn btn-danger">Finalizar Atención</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function setFinalizarDetails(id, nombre, horaInicio, horaFin, totalHoras, total, observaciones) {
        // Establecer el método de acción del formulario
        document.getElementById('finalizarAtencionForm').action = '/atenracket/' + id;

        // Mostrar los detalles en el modal
        const details = `
            <strong>Nombre:</strong> ${nombre}<br>
            <strong>Hora Entrada:</strong> ${horaInicio}<br>
            <strong>Hora Salida:</strong> ${horaFin}<br>
            <strong>Observaciones:</strong> ${observaciones || 'Ninguna'}
        `;
        document.getElementById('atencionDetails').innerHTML = details;

        // Obtener la hora actual y establecerla como hora de salida
        const now = new Date();
        const horaSalida = now.toTimeString().split(' ')[0].slice(0, 5); // Solo HH:MM
        document.getElementById('horaSalida').value = horaSalida;

        // Agregar hora de entrada al formulario como campo oculto
        const horaInicioField = document.createElement('input');
        horaInicioField.type = 'hidden';
        horaInicioField.name = 'horaInicio';
        horaInicioField.value = horaInicio;
        document.getElementById('finalizarAtencionForm').appendChild(horaInicioField);

        // Calcular total de horas y minutos
        const [horaE, minE] = horaInicio.split(':');
        const horaEntrada = new Date();
        horaEntrada.setHours(horaE);
        horaEntrada.setMinutes(minE);

        const horaSalidaDate = new Date();
        horaSalidaDate.setHours(now.getHours());
        horaSalidaDate.setMinutes(now.getMinutes());

        const diferenciaMilisegundos = horaSalidaDate - horaEntrada; // Diferencia en milisegundos
        const totalHorasCalculo = diferenciaMilisegundos / (1000 * 60 * 60); // Convertir de ms a horas
        const totalMinutos = (diferenciaMilisegundos / (1000 * 60)) % 60; // Obtener los minutos restantes

        const horas = Math.floor(totalHorasCalculo);
        const minutos = Math.round(totalMinutos);

        document.getElementById('totalHoras').value = `${horas} hora(s) ${minutos} minuto(s)`; // Formato de texto
        document.getElementById('total').value = total; // Asegúrate de que este valor se pase
    }
</script>


@endsection
