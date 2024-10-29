@extends('template.main')
@section('title', 'Registrar Horario')
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
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>
                                                <!-- Botón para abrir el modal de agregar turno -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTurnoModal"
                                                    data-id="{{ $data->id_user }}"
                                                    data-name="{{ $data->name }}"
                                                    data-email="{{ $data->email }}">
                                                    <i class="fa-solid fa-plus"></i> Agregar Turno
                                                </button>
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

<!-- Modal para agregar turno -->
<div class="modal fade" id="addTurnoModal" tabindex="-1" role="dialog" aria-labelledby="addTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTurnoModalLabel">Agregar Turno</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="{{ route('horarios.store') }}" method="POST">
                    @csrf

                    <!-- Campos ocultos para el ID y nombre del usuario -->
                    <input type="hidden" name="id_user" id="id_user">
                    <input type="hidden" name="name" id="name">

                    <div class="input-group mb-3">
                        <input type="text" name="name_display" id="name_display" class="form-control" placeholder="Nombre" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <select name="carril" class="form-control @error('carril') is-invalid @enderror" required>
                            <option value="" disabled selected>Selecciona un carril</option>
                            <option value="1" {{ old('carril') == '1' ? 'selected' : '' }}>Carril 1</option>
                            <option value="2" {{ old('carril') == '2' ? 'selected' : '' }}>Carril 2</option>
                            <option value="3" {{ old('carril') == '3' ? 'selected' : '' }}>Carril 3</option>
                            <option value="4" {{ old('carril') == '4' ? 'selected' : '' }}>Carril 4</option>
                        </select>
                        @error('carril')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="number" name="nalumnos" class="form-control @error('nalumnos') is-invalid @enderror" placeholder="Número de Alumnos" value="{{ old('nalumnos') }}" required>
                        @error('nalumnos')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    <div class="input-group mb-3">
                        <select name="horario" class="form-control @error('horario') is-invalid @enderror" required>
                            <option value="" disabled selected>Selecciona un horario</option>
                            @foreach (['7:00-8:00', '8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00'] as $option)
                                <option value="{{ $option }}" {{ old('horario') == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                        @error('horario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    <div class="input-group mb-3">
                        <textarea name="observaciones" class="form-control" placeholder="Observaciones" rows="3">{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // Lógica para abrir el modal de agregar turno y rellenar los campos con los datos del usuario seleccionado
    $('#addTurnoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que abrió el modal
        var idUser = button.data('id');
        var nameUser = button.data('name');
        
        // Rellenar los campos ocultos y el nombre en el modal
        var modal = $(this);
        modal.find('#id_user').val(idUser);
        modal.find('#name_display').val(nameUser);
    });
</script>
@endsection
