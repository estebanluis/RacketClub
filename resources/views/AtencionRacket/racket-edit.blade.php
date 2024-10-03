@extends('template.main')
@section('title', 'Edit Barang')
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
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/atenracket">Atencion Racket</a></li>
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="/atenracket" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Atras
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="/atenracket/{{ $barang->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Name Barang" value="{{old('name', $barang->nombre)}}" required>
                                            @error('name')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="horainicio">Hora Entrada</label>
                                            <input type="time" name="horainicio" class="form-control @error('horainicio') is-invalid @enderror" id="horainicio" placeholder="Hora de entrada" value="{{ old('horainicio', \Carbon\Carbon::parse($barang->hora_inicio)->format('H:i')) }}"
                                            required >
                                            @error('horainicio')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="horasalida">Hora Salida</label>
                                            <input type="time" name="horasalida" class="form-control @error('horasalida') is-invalid @enderror" id="horasalida" placeholder="Hora de Salida" value="{{old('horasalida', $barang->hora_fin)}}" required>
                                            @error('horasalida')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="horauso">Horas de Uso </label>
                                            <input type="text" name="horauso" class="form-control" id="horauso" placeholder="Tiempo de Uso" value="{{old('horauso', $barang->total_horas)}}" required>
                                        </div>
                                    </div>
                                    
                                    
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="total">Total (Bs.) </label>
                                            <input type="int" name="total" class="form-control @error('total') is-invalid @enderror" id="total" placeholder="Total Gatado" value="{{old('supplier', $barang->total)}}" required>
                                            @error('total')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label for="observaciones">Observaciones</label>
                                        <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" cols="10" rows="3" placeholder="Observaciones">{{old('supplier', $barang->observaciones)}}</textarea>
                                        @error('observaciones')
                                        <span class="invalid-feedback text-danger">{{ $message }}</span>
                                        @enderror
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                
                                
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                                    Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('horasalida').addEventListener('change', function() {
        const horaEntrada = document.getElementById('horainicio').value;
        const horaSalida = this.value;

        if (horaEntrada && horaSalida) {
            const [entradaHoras, entradaMinutos] = horaEntrada.split(':');
            const [salidaHoras, salidaMinutos] = horaSalida.split(':');

            const entrada = new Date();
            entrada.setHours(entradaHoras, entradaMinutos, 0);

            const salida = new Date();
            salida.setHours(salidaHoras, salidaMinutos, 0);

            // Calculamos la diferencia en milisegundos
            const diffMs = salida - entrada;

            if (diffMs >= 0) { // Asegurarse de que la hora de salida es después de la hora de entrada
                // Convertir la diferencia en horas y minutos
                const diffHrs = Math.floor(diffMs / (1000 * 60 * 60));
                const diffMins = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

                // Mostramos el resultado en el campo de Horas de Uso
                document.getElementById('horauso').value = `${diffHrs} horas y ${diffMins} minutos`;
            } else {
                document.getElementById('horauso').value = 'La hora de salida debe ser mayor que la hora de entrada';
            }
        } else {
            document.getElementById('horauso').value = ''; // Limpiar el campo si falta alguna hora
        }
    });
</script>


@endsection