@extends('template.main')
@section('title', 'Detalle Turnos')
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/turnos">Turnos Trabajados</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="/turnos" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Atras
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Nro Carril</th>
                                        <th>Nro de Alumnos</th>
                                        @if(Auth::user()->TipoUsuario === 'Administrador')
                                        <th>Salario</th>
                                        <th>Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $data)
                                        <tr>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->fecha }}</td>
                                            <td>{{ $data->hora }}</td>
                                            <td>{{ $data->carril }}</td>
                                            <td>{{ $data->nalumnos }}</td>
                                            @if(Auth::user()->TipoUsuario === 'Administrador')
                                            <td>{{ $data->salario }}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#agregarSalarioModal" data-id="{{ $data->idHorario }}" data-nombre="{{ $data->name }}" data-fecha="{{ $data->fecha }}" data-hora="{{ $data->hora }}" data-carril="{{ $data->carril }}" data-nalumnos="{{ $data->nalumnos }}" data-salario="{{ $data->salario }}">
                                                    <i class="fa-solid fa-pen"></i> Agregar salario
                                                </button>
                                            </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar salario -->
<div class="modal fade" id="agregarSalarioModal" tabindex="-1" role="dialog" aria-labelledby="agregarSalarioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="observacionesModalLabel">Agregar o Editar Salario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <form id="salarioForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input type="text" name="fecha" id="fecha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="hora">Hora</label>
                        <input type="text" name="hora" id="hora" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="carril">Nro Carril</label>
                        <input type="number" name="carril" id="carril" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nalumnos">Nro Alumnos</label>
                        <input type="number" name="nalumnos" id="nalumnos" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="salario">Salario</label>
                        <input type="number" name="salario" id="salario" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" cols="10" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $('#agregarSalarioModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var idHorario = button.data('id');
        var nombre = button.data('nombre');
        var fecha = button.data('fecha');
        var hora = button.data('hora');
        var carril = button.data('carril');
        var nalumnos = button.data('nalumnos');
        var salario = button.data('salario');

        // Actualiza los campos del formulario en el modal
        var modal = $(this);
        modal.find('#nombre').val(nombre);
        modal.find('#fecha').val(fecha);
        modal.find('#hora').val(hora);
        modal.find('#carril').val(carril);
        modal.find('#nalumnos').val(nalumnos);
        modal.find('#salario').val(salario);

        // Actualiza la acción del formulario para enviar al controlador correcto
        var actionUrl = "/turnos/salario/" + idHorario; // Actualiza la URL según tu ruta
        modal.find('#salarioForm').attr('action', actionUrl);
    });
</script>
@endsection
