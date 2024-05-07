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
                <a href="/" class="h1"><b>REGISTRAR</b> ALUMNOS</a>
            </div>
            <div class="card-body">
                
                <form class="needs-validation" novalidate action="{{ route('registrarAlumn.store') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
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
                    <div class="input-group mb-3">
                        <input type="text" name="apellidoMat" class="form-control @error('apellidoMat') is-invalid @enderror"
                            placeholder="Apelldido Materno" value="{{ old('apellidoMat') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('apellidoMat')
                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>
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
                        
                            <select name="modalidad" id="modalidad" class="form-control @error('nombre') is-invalid @enderror">
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
                        @error('nombre')
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
                        <input type="text" name="observciones" class="form-control @error('observciones') is-invalid @enderror"
                            placeholder="Observaciones" value="{{ old('observciones') }}" required>
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
                        <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror"
                            placeholder="Telefono" value="{{ old('telefono') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fa fa-ban" aria-hidden="true"></span>
                            </div>
                        </div>
                        @error('telefono')
                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" name="descuento" class="form-control @error('descuento') is-invalid @enderror"
                            placeholder="Descuennto" value="{{ old('descuento') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('descuento')
                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                        @enderror
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
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>

                    </div>
                </form>
            </div>

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