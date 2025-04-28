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
                                              <button type="button" 
                                              class="btn btn-warning btn-sm editCanchaBtn" 
                                              data-toggle="modal" 
                                              data-target="#editCanchaModal"
                                              data-id="{{ $data->id }}"
                                              data-nombre="{{ $data->nombre }}"
                                              data-precio="{{ $data->precio->precio ?? '' }}"
                                              data-deportes='@json($data->deportes->pluck("id"))'>
                                              <i class="fa fa-edit"></i>
                                          </button>

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
<!-- Modal Editar Cancha -->
<div class="modal fade" id="editCanchaModal" tabindex="-1" role="dialog" aria-labelledby="editCanchaModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <form id="editCanchaForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-content">
              <div class="modal-header bg-warning text-white">
                  <h5 class="modal-title" id="editCanchaModalLabel">Editar Cancha</h5>
                  <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <div class="form-group">
                      <label for="edit_nombre">Nombre de la Cancha</label>
                      <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label for="edit_precio">Precio (Bs)</label>
                      <input type="number" name="precio" id="edit_precio" step="0.01" class="form-control" required>
                  </div>

                  <div class="form-group">
                      <label for="edit_deportes">Deportes que se pueden practicar</label>
                      <select name="deportes[]" id="edit_deportes" class="form-control" multiple required>
                          @foreach($deportes as $deporte)
                              <option value="{{ $deporte->id }}">{{ $deporte->nombre }}</option>
                          @endforeach
                      </select>
                      <small class="form-text text-muted">Usa Ctrl o Shift para seleccionar varios.</small>
                  </div>
              </div>

              <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Guardar Cambios</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              </div>
          </div>
      </form>
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
<script>
  $(document).ready(function() {
      @if ($errors->any())
          @if(old('tipo_registro') == 'cancha')
              $('#registerUserModal').modal('show');
          @elseif(old('tipo_registro') == 'deporte')
              $('#registerDeporteModal').modal('show');
          @endif
      @endif

      // Script para llenar datos al abrir Modal Editar
      $('.editCanchaBtn').click(function() {
          var id = $(this).data('id');
          var nombre = $(this).data('nombre');
          var precio = $(this).data('precio');
          var deportes = $(this).data('deportes');

          $('#edit_nombre').val(nombre);
          $('#edit_precio').val(precio);

          // Resetear selección de deportes
          $('#edit_deportes option').prop('selected', false);

          // Marcar deportes que ya tiene la cancha
          deportes.forEach(function(deporte_id) {
              $('#edit_deportes option[value="'+deporte_id+'"]').prop('selected', true);
          });

          // Cambiar la acción del formulario para el PUT
          var action = "{{ url('creacanch') }}/" + id;
          $('#editCanchaForm').attr('action', action);
      });
  });
</script>
@endsection
