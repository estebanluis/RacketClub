@extends('template.main')
@section('title', 'Actualizar Alumnos')
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
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                                
                            <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#modalAddProduct">
                                <i class="fa-solid fa-plus"></i> Agregar Producto
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Codigo</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Fecha Ins.</th>
                                <th>Nro Sec</th>
                                <th>Telefono</th>
                                <th>Reins.</th>
                                <th>Obs.</th>
                                <th>Tarjeta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $data)
                            <tr>
                                <td>{{ $data->codigo }}</td>
                                <td>{{ $data->nombre }}</td>
                                <td>{{ $data->apellido }} {{ $data->apellidoMat }}</td>
                                <td>{{ $data->created_at->format('d-m-Y') }}</td>
                                <td>{{ $data->nrsesiones }}</td>
                                <td>{{ $data->telefono }}</td>
                                <td>{{ $data->nroReinscripciones }}</td>
                                <td>{{ $data->observciones }}</td>
                                <td>
                                    <!-- Botones de acción -->
                                    <form class="d-inline" action="/barang/{{ $data->id }}/edit" method="GET">
                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                            <i class="fa-solid fa-pen"></i> Editar
                                        </button>
                                    </form>

                                    <form class="d-inline reinscribirForm" action="{{ route('reinscribir.alumn', ['id' => $data->id]) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn btn-primary btn-sm reinscribirBtn mr-2">
                                            <i class="fa-solid fa-file-pdf"></i> Reinscribir
                                        </button>
                                    </form>

                                    <form class="d-inline" action="{{ route('generate.pdf', ['id' => $data->id]) }}" target="_blank" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa-solid fa-file-pdf"></i> Reimprimir
                                        </button>
                                    </form>

                                    @if (auth()->user()->TipoUsuario === 'Administrador')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('{{ $data->id }}')">
                                        <i class="fa-solid fa-trash"></i> Eliminar
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mover el script de SweetAlert fuera de la tabla -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('success'))
<script>
    Swal.fire({
        title: '¡Eliminado!',
        text: "{{ session('success') }}",
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
</script>
@endif

<script>
    document.querySelectorAll('.reinscribirBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Advertencia',
                html:
                    '<label for="modalidadSelect">Modalidad:</label>' +
                    '<select id="modalidadSelect" class="form-select mb-3">' +
                        '<option value="Natación curso completo">Natación curso completo</option>' +
                        '<option value="Natación*3 semana 12">Natación*3 semana 12</option>' +
                        '<option value="Natación*3 semana 20">Natación*3 semana 20</option>' +
                        '<option value="Natación medio curso">Natación medio curso</option>' +
                    '</select>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, reinscribir',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var modalidad = document.getElementById('modalidadSelect').value;
                    var form = btn.closest('.reinscribirForm');
                    var modalidadInput = document.createElement('input');
                    modalidadInput.type = 'hidden';
                    modalidadInput.name = 'modalidad';
                    modalidadInput.value = modalidad;
                    form.appendChild(modalidadInput);
                    form.submit();
                }
            });
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: '¿Estás seguro de eliminar este Alumno?',
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                let form = document.createElement('form');
                form.action = `/listaClientes/${id}`;
                form.method = 'POST';

                let csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = '{{ csrf_token() }}';

                let methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfField);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modalAddProductLabel" aria-hidden="true" data-backdrop="static" data-keyboard="true">
 <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
    <div class="card card-outline card-primary">
        <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="registerModalLabel">Registrar Usuario</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">

<form class="needs-validation" novalidate action="{{ route('registrarAlumn.store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text"2 name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                    placeholder="Nombre completo" value="{{ old('nombre') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('nombre')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Repite esta estructura para los siguientes 4 campos -->
        </div>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror"
                    placeholder="Apellido Paterno" value="{{ old('apellido') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('apellido')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Repite esta estructura para los siguientes 4 campos -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" name="apellidoMat" class="form-control @error('apellidoMat') is-invalid @enderror"
                    placeholder="Apellido Materno" value="{{ old('apellidoMat') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fa fa-eye" ></span>
                    </div>
                </div>
                @error('apellidoMat')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group mb-3">
                    
                    <select name="horario" id="horario" class="form-control @error('horario') is-invalid @enderror">
                <option value="7:00-8:00">7:00-8:00</option>
                <option value="8:00-9:00">8:00-9:00</option>
                <option value="9:00-10:00">9:00-10:00</option>
                <option value="10:00-11:00">10:00-11:00</option>
                <option value="11:00-12:00">11:00-12:00</option>
                <option value="12:00-13:00">12:00-13:00</option>
                <option value="13:00-14:00">13:00-14:00</option>
                <option value="14:00-15:00">14:00-15:00</option>
                <option value="15:00-16:00">15:00-16:00</option>
                <option value="16:00-17:00">16:00-17:00</option>
                <option value="17:00-18:00">17:00-18:00</option>
                <option value="18:00-19:00">18:00-19:00</option>
                <option value="19:00-20:00">19:00-20:00</option>
                <option value="20:00-21:00">20:00-21:00</option>
                </select> 
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('horario')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="input-group mb-3">
                    <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror"
                        placeholder="Direccion" value="{{ old('direccion') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('direccion')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                        placeholder="Telefono" value="{{ old('telefono') }}" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('telefono')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                </div>
            <!-- Repite esta estructura para los siguientes 4 campos -->
        </div>
        <div class="col-md-6">
            <div class="input-group mb-3">
                <input type="text" name="edad" class="form-control @error('edad') is-invalid @enderror"
                    placeholder="Edad" value="{{ old('edad') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('edad')
                    <span class="invalid-feedback text-danger">{{ $message }}</span>
                @enderror
            </div>
            <!-- Repite esta estructura para los siguientes 4 campos -->
            <div class="input-group mb-3">
                    
                        <select name="modalidad" id="modalidad" class="form-control @error('modalidad') is-invalid @enderror">
                        <option value="Natación curso completo">Natación curso completo</option>
                        <option value="Natación*3 semana 12">Natación*3 semana 12</option>
                        <option value="Natación*3 semana 20">Natación*3 semana 20</option>
                        <option value="Natación medio curso">Natación medio curso</option>
                        </select>
                <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                </div>
                    @error('modalidad')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="observciones" class="form-control @error('observciones') is-invalid @enderror"
                        placeholder="Observaciones" value="{{ old('observciones') }}" >
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('observciones')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="text" name="descuento" class="form-control @error('descuento') is-invalid @enderror"
                        placeholder="Descuennto" value="{{ old('descuento') }}" value="0">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                    @error('descuento')
                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                    @enderror
                </div>
        </div>
        
        
    </div>
    <div class="row">
            <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
            </div>
    </div>
    <!-- Repite las filas anteriores para los siguientes campos -->
    <!-- Asegúrate de cerrar el formulario al final -->
</form>
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Reinscripción completada',
            text: "{{ session('success') }}",
            icon: 'success',
            showCancelButton: true,
            confirmButtonText: 'Imprimir',
            cancelButtonText: 'Aceptar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.open("{{ route('generarPdf', session('codigoGenerado')) }}", "_blank");
            }
        });
    });
</script>
@endif
</div>
</div>
</div>
<script src="/assets/plugins/jquery/jquery.min.js"></script>

<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

{{-- <script src="/assets/dist/js/adminlte.min.js"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
@endsection
