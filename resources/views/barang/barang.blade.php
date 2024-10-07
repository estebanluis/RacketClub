@extends('template.main')
@section('title', 'Lista Alumnos')
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
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                        <thead class="thead-dark">
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Apellidos</th>
                                        <th>Fecha inscripcion</th>
                                        <th>Nro de seciones</th>
                                        <th>Telefono</th>
                                        <th>Reinscripciones</th>
                                        <th>Observaciones</th>
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
                                        <form class="d-inline" action="/barang/{{ $data->id }}/edit" method="GET">
                                            <button type="submit" class="btn btn-success btn-sm mr-2">
                                                <i class="fa-solid fa-pen"></i> Edit
                                            </button>
                                        </form>

                                        <form class="d-inline reinscribirForm" action="{{ route('reinscribir.alumn', ['id' => $data->id]) }}" method="POST">
                                            @csrf
                                            <button type="button" class="btn btn-primary btn-sm reinscribirBtn mr-2">
                                                <i class="fa-solid fa-file-pdf"></i> Reinscribir
                                            </button>
                                        </form>

                                        <form class="d-inline" action="{{ route('generate.pdf', ['id' => $data->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa-solid fa-file-pdf"></i> Reimprimir
                                            </button>
                                        </form>

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
</script>
@endsection
