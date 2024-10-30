
@extends('template.main')
@section('title', 'Sesiones')
@section('content')
@php
    use Carbon\Carbon;
@endphp
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
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
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
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-right">
                                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">
                                        <i class="fa-solid fa-plus"></i> Añadir session
                                    </a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                            <thead class="thead-dark">
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Horas</th>
                                            <th>Pago</th>
                                            <th>Hora inicio</th>
                                            <th>Hora fin</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barang as $data)
                                            <tr>
                                                <td>{{ $data->nombreSesion}}</td>
                                                <td>{{ $data->cantHoras }}</td>
                                                <td>{{ $data->pago }}</td>
                                                <td>{{ $data->created_at->format('H:i') }}</td>
                                                <td>{{ Carbon::parse($data->created_at)->addHours($data->cantHoras)->format('H:i') }}</td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>
    <div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="registerModalLabel">Sesiones</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate action="{{ route('registrarAlumn.storeSesion') }}" method="POST">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" name="nombreSesion" class="form-control @error('nombreSesion') is-invalid @enderror" placeholder="Nombre sesiones" value="{{ old('nombreSesion') }}" required>
                            @error('nombreSesion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="number" name="cantHoras" class="form-control @error('cantHoras') is-invalid @enderror" placeholder="Cantidad de Horas" value="{{ old('cantHoras') }}" required>
                            @error('cantHoras')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" name="pago" class="form-control @error('pago') is-invalid @enderror" placeholder="Pago" value="{{ old('pago') }}" required>
                            @error('pago')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Registrar</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
