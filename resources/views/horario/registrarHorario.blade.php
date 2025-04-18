@extends('template.main')
@section('title', 'Agregar Turno')
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
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/horarios">Registrar Horario</a></li>
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
                                <a href="/horarios" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Atras
                                </a>
                            </div>
                        </div>
                        <form class="needs-validation" novalidate action="/horarios/{{ $barang->id_user }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" disabled class="form-control" id="name" placeholder="Name Barang" value="{{old('name', $barang->name)}}" required>
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="carril">Carril</label>
                                            <div class="input-group mb-3">
                                                <select name="carril" id="carril" class="form-control">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                </select> 
                                                

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nalumnos">Numero de Alumnos</label>
                                            <input type="int" name="nalumnos" class="form-control"  id="nalumnos"  placeholder="Numero de Alumnos" >
                                            
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="category">Turno</label>
                                            <div class="input-group mb-3">
                                                <select name="horario" id="horario" class="form-control ">
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
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="note">Observaciones</label>
                                            <textarea name="observaciones" id="observaciones" class="form-control @error('note') is-invalid @enderror" cols="10" rows="2" style="resize: none;"  placeholder="Observaciones"></textarea>
                                            @error('note')
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


@endsection