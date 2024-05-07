@extends('template.main')

@section('title', 'Registrar Usuarios')
@section('content')

<div class="content-wrapper">

    @include('sweetalert::alert')

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

    <div class="content">
        <div class="container-fluid">
            
        <div class="card-body">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Asistencia</b>Alumnos</a>
            </div>
            <div class="container">
            
    <div class="card-container">
    <div class="row">
    <div class="col-md-6">
        <div class="card">
            <h1 style="text-align: center;">CODIGO DE ALUMNO</h1>
            <form name="asistencia" action="{{ route('registrarAlumn.update') }}" method="POST" id="form">
                @csrf
                <div class="form-group">
                    <label style="margin-left: 30px " for="nombre">Codigo:</label>
                    <input type="text" name="codigo" style="width: 365px; margin-left: 20px " value="" id="codigo" class="form-control @error('codigo') is-invalid @enderror"
                        placeholder="Nombre completo" value="{{ old('nombre') }}" required>
                </div>
                <div class="row">
                    <div class="col-4">
                        <button type="submit" style="margin-left: 20px; margin-bottom:20px " class="btn btn-primary btn-block">enviar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <!--<div class="row">
                <div id="calendar"></div>
                
            </div>-->
            <!-- aqui tabla-->
            <div class="col-md-6">
                <div class="card">
                    <h1 style="text-align: center;"></h1>
                    <div class="table-responsive">
                        <table style=" width: 1000px;" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                           
                            @if(isset($fechasAsistencia))
                            <tbody>
                                @php
                                    $chunkedFechas = array_chunk($fechasAsistencia, 6); // Dividir el array en trozos de 3 elementos
                                @endphp
                                @foreach($chunkedFechas as $chunk)
                                    <tr>
                                        @foreach($chunk as $fecha)
                                            <td>{{ date('d-m-Y H:i:s', strtotime($fecha)) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <div class="card">
            <h1 style="text-align: center;">INFORMACION DE ALUMNO</h1>
            <div></div>
            <p>
                @if(isset($messages))
    <div class="alert alert-primary" role="alert">
        <p style="text-align: center;">{{ $messages['message'] }}</p>
        <p style="text-align: center;">{{ $messages['message1'] }}</p>
        <p style="text-align: center;">{{ $messages['message2'] }}</p>
    </div>
@endif
            </p>
            <!-- Nuevo div para el calendario -->
            
        </div>
    </div>
</div>

<script>
    // Enfocar automáticamente en el input cuando la página se cargue o se redirija a ella
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('codigo').focus();
    });
</script>


        </div>

        </div>

        </div>
    </div>
  

</div>

<!-- Incluir FullCalendar JS y CSS 
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
        });
        calendar.render();
      });

</script>
@endsection
