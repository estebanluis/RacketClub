@extends('template.main')
@section('title', 'Añadir Reserva')
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
            <li class="breadcrumb-item"><a href="/rcancha">Reservar Canchas</a></li>
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
                <a href="/rcancha" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                  Atras
                </a>
              </div>
            </div>
            <form class="needs-validation" novalidate action="/rcancha" method="POST">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre" value="{{old('name')}}" required>
                      @error('name')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="fecha">Fecha</label>
                      <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror" id="fecha" placeholder="Fecha" value="{{old('fecha')}}" required>
                      @error('category')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="hora">Hora</label>
                      <input type="time" name="hora" class="form-control @error('hora') is-invalid @enderror" id="hora" placeholder="Hora de reserva " value="{{old('hora')}}" required>
                      @error('hora')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="cancha">Nro. Cancha</label>
                      <input type="number" min="1" max="4" name="cancha" class="form-control @error('cancha') is-invalid @enderror" id="cancha" placeholder="Nro Cancha" value="{{old('cancha')}}" required>
                      @error('cancha')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  
                  <!-- <div class="col-lg-6">
                    <div class="form-group">
                      <label for="adelanto">Adelanto (Bs.)</label>
                      <input type="text" name="adelanto" class="form-control @error('adelanto') is-invalid @enderror" id="name" placeholder="Monto del Adelanto" value="{{old('adelanto')}}" >
                      @error('adelanto')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>  -->

                </div>
                
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                  Limpiar</button>
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