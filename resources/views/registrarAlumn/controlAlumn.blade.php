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
        <div class="card">
            <h1>CODIGO DE ALUMNO</h1>
            <form name="asistencia" action="{{ route('registrarAlumn.update') }}" method="POST" id="form">
                @csrf
                <div class="form-group">
                    <label for="nombre">Codigo:</label>
                    <input type="text" name="codigo" value="" id="codigo">
                </div>
                <div class="row">
                        {{-- <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="agreeTerms" name="terms" required>
                                <label for="agreeTerms">
                                    I agree to the <a href="#">terms</a>
                                </label>
                            </div>
                        </div> --}}

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">enviar</button>
                        </div>

                    </div>
            </form>
        </div>
        <div class="card">
            <h1>INFORMACION DE ALUMNO</h1>
            <div></div>
            <p>
                @if(session('message')) 
                    <div class="alert alert-primary" role="alert">
                        {{ session('message') }}
                    </div>
                @endif 
            </p>
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