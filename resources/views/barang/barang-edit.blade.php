@extends('template.main')
@section('title', 'Editar alumno')
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
                        <li class="breadcrumb-item"><a href="/barang">Editar alumno</a></li>
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
                                <a href="/barang" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Atras
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="/barang/{{ $barang->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nombre">Nombre</label>
                                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre"  placeholder="Nombre cliente" value="{{old('nombre', $barang->nombre)}}" required>
                                            @error('nombre')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="apellido">apellido</label>
                                            <input type="text" name="apellido" class="form-control @error('apellido') is-invalid @enderror" id="apellido" placeholder="apellido" value="{{old('apellido', $barang->apellido)}}" required>
                                            @error('apellido')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="apellidoM">Apellido materno</label>
                                            <input type="text" name="apellidoMat" class="form-control @error('apellidoMat') is-invalid @enderror" id="apellidoMat" placeholder="Apellido Materno" value="{{old('apellidoMat', $barang->apellidoMat)}}" required>
                                            @error('apellidoMat')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="stock">Horario</label>
                                            <select name="horario" class="form-control @error('horario') is-invalid @enderror"  id="horario" value="{{old('horario', $barang->horario)}} class="form-control @error('horario') is-invalid @enderror">
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
                                            @error('horario')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="price">Modalidad</label>
                                            <select name="modalidad" id="modalidad" class="form-control @error('modalidad') is-invalid @enderror" value="{{old('modalidad', $barang->modalidad)}}">
                                                <option value="Natación curso completo">Natación curso completo</option>
                                                <option value="Natación*3 semana 12">Natación*3 semana 12</option>
                                                <option value="Natación*3 semana 20">Natación*3 semana 20</option>
                                                <option value="Natación medio curso">Natación medio curso</option>
                                                </select>
                                            @error('modalidad')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="direccion">Direccion</label>
                                            <input type="text" name="direccion" class="form-control @error('direccion') is-invalid @enderror" id="direccion"  placeholder="Direccion" value="{{old('direccion', $barang->direccion)}}" required>
                                            @error('direccion')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="telefono">Telefono</label>
                                            <input type="text" name="telefono" class="form-control @error('telefono') is-invalid @enderror" id="telefono"  placeholder="Telefono" value="{{old('telefono', $barang->telefono)}}" required>
                                            @error('telefono')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="observciones">Observaciones</label>
                                            <input type="text" name="observciones" class="form-control @error('observciones') is-invalid @enderror" id="observciones" placeholder="observciones" value="{{old('observciones', $barang->observciones)}}" required>
                                            @error('observciones')
                                            <span class="invalid-feedback text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                                    Restablecer</button>
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

@endsection