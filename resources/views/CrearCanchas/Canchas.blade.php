@extends('template.main')
@section('title', 'Registrar Canchas')
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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Canchas
                                </a>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerDeporteModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Deporte
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Deportes</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($canchas as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data->nombre }}</td>
                                            <td>
                                                @foreach($data->deportes as $deporte)
                                                    <span class="badge badge-info">{{ $deporte->nombre }}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $data->precio->precio ?? 'N/A' }}</td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <a href="{{ route('creacanch.edit', $data->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Formulario Eliminar -->
                                                <form action="{{ route('creacanch.destroy', $data->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta cancha?')">
                                                        <i class="fa fa-trash"></i>
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


<!-- Modal Registrar Cancha -->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('creacanch.store') }}" method="POST">
        @csrf
        <input type="hidden" name="tipo_registro" value="cancha">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Registrar Cancha</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="nombre">Nombre de la Cancha</label>
              <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
              @error('nombre')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <label for="precio">Precio (Bs)</label>
              <input type="number" name="precio" step="0.01" class="form-control" required>
              @error('precio')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>

            <div class="form-group">
              <label for="deportes">Deportes que se pueden practicar</label>
              <select name="deportes[]" class="form-control" multiple required>
                @foreach($deportes as $deporte)
                  <option value="{{ $deporte->id }}">{{ $deporte->nombre }}</option>
                @endforeach
              </select>
              <small class="form-text text-muted">Usa Ctrl o Shift para seleccionar varios.</small>
              @error('deportes')
                <small class="text-danger d-block">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </form>
    </div>
</div>


<!-- Modal Registrar Deporte -->
<div class="modal fade" id="registerDeporteModal" tabindex="-1" role="dialog" aria-labelledby="registerDeporteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('creacanch.deporte') }}" method="POST">
        @csrf
        <input type="hidden" name="tipo_registro" value="deporte">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Registrar Deporte</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="nombre">Nombre del Deporte</label>
              <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
              @error('nombre')
                <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    @if ($errors->any())
        @if(old('tipo_registro') == 'cancha')
            $('#registerUserModal').modal('show');
        @elseif(old('tipo_registro') == 'deporte')
            $('#registerDeporteModal').modal('show');
        @endif
    @endif
</script>
@endsection
