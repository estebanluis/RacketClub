@extends('template.main')
@section('title', 'Lista Usuarios')
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
                        <div class="card-header">
                            <div class="text-right">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Usuarios
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($barang as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->name }}</td>
                                            <td>{{ $data->email }}</td>
                                            <td>{{ $data->TipoUsuario }}</td>
                                            <td>
                                                <!-- Botón para abrir el modal de edición -->
                                                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#editUserModal" 
                                                    data-id="{{ $data->id_user }}" 
                                                    data-name="{{ $data->name }}"
                                                    data-email="{{ $data->email }}"
                                                    data-tipousuario="{{ $data->TipoUsuario }}">
                                                    <i class="fa-solid fa-pen"></i> Editar
                                                </button>
                                                
                                                <!-- Botón para eliminar -->
                                                <form class="d-inline" action="/luser/{{ $data->id_user }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger btn-sm" id="btn-delete">
                                                        <i class="fa-solid fa-trash-can"></i> Eliminar
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

<!-- Modal para registrar usuarios -->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registerModalLabel">Registrar Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="/luser" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre completo" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo electrónico" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <select name="TipoUsuario" id="TipoUsuario" class="form-control @error('TipoUsuario') is-invalid @enderror" required>
                            <option value="" disabled selected>Selecciona un tipo de usuario</option>
                            <option value="Administrador" {{ old('TipoUsuario') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Secretaria Natacion" {{ old('TipoUsuario') == 'Secretaria Natacion' ? 'selected' : '' }}>Secretaria Piscina</option>
                            <option value="Secretaria Racket" {{ old('TipoUsuario') == 'Secretaria Racket' ? 'selected' : '' }}>Secretaria Racket</option>
                            <option value="Profesor" {{ old('TipoUsuario') == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        </select>
                        @error('TipoUsuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control @error('passwordConfirm') is-invalid @enderror" placeholder="Repite la contraseña" required>
                        @error('passwordConfirm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/luser/update" method="POST">
                    @csrf
                    @method('PUT') <!-- Para que se use el método PUT -->
                    <input type="hidden" name="id_user" id="id_user">

                    <div class="input-group mb-3">
                        <input type="text" name="name" id="edit_name" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre completo" 
                               value="{{ old('name', '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <input type="email" name="email" id="edit_email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo electrónico" 
                               value="{{ old('email', '') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <select name="TipoUsuario" id="edit_TipoUsuario" class="form-control @error('TipoUsuario') is-invalid @enderror" required>
                            <option value="" disabled selected>Selecciona un tipo de usuario</option>
                            <option value="Administrador" {{ old('TipoUsuario', '') == 'Administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="Secretaria Natacion" {{ old('TipoUsuario', '') == 'Secretaria Natacion' ? 'selected' : '' }}>Secretaria Piscina</option>
                            <option value="Secretaria Racket" {{ old('TipoUsuario', '') == 'Secretaria Racket' ? 'selected' : '' }}>Secretaria Racket</option>
                            <option value="Profesor" {{ old('TipoUsuario', '') == 'Profesor' ? 'selected' : '' }}>Profesor</option>
                        </select>
                        @error('TipoUsuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo opcional para cambiar contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nueva contraseña (opcional)">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Campo para confirmar la nueva contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirma la nueva contraseña (opcional)">
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@section('scripts')
<script>
    // Abrir modal de edición y rellenar con datos
    $('#editUserModal').on('show.bs.modal', function (event) {
        // Limpiar errores de validación
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var tipousuario = button.data('tipousuario');

        var modal = $(this);
        modal.find('#id_user').val(id); // Cambiado a 'id_user'
        modal.find('#edit_name').val(name); // Cambiado a 'edit_name'
        modal.find('#edit_email').val(email); // Cambiado a 'edit_email'
        modal.find('#edit_TipoUsuario').val(tipousuario); // Cambiado a 'edit_TipoUsuario'
    });

    @if ($errors->any())
        $('#registerUserModal').modal('show');
    @endif
</script>
@endsection



@endsection
