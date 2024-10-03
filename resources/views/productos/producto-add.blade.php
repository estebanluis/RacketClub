@extends('template.main')
@section('title', 'Agregar producto')
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
            <li class="breadcrumb-item"><a href="/barang">Productos</a></li>
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
            <form class="needs-validation" novalidate action="{{ route('productos.store') }}" method="POST">
              @csrf
              <div class="card-body">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="nombre">Nombre</label>
                      <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Nombre Producto" value="{{old('nombre')}}" required>
                      @error('nombre')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="id_producto">Codigo Producto</label>
                      <input type="text" name="id_producto" class="form-control @error('id_producto') is-invalid @enderror" id="id_producto" placeholder="Codigo producto" value="{{old('id_producto')}}" required>
                      @error('id_producto')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="stock">Stock</label>
                      <input type="number" min="1" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" placeholder="Stock" value="{{old('stock')}}" required>
                      @error('stock')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="categoria">Categoria</label>
                      <input type="text" name="categoria" class="form-control @error('categoria') is-invalid @enderror" id="categoria" placeholder="Categoria" value="{{old('categoria')}}" required>
                      @error('categoria')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="precio">Precio</label>
                      <input type="number" name="precio" class="form-control @error('precio') is-invalid @enderror" id="precio" placeholder="Precio" value="{{old('precio')}}" required>
                      @error('precio')
                      <span class="invalid-feedback text-danger">{{ $message }}</span>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer text-right">
                <button class="btn btn-dark mr-1" type="reset"><i class="fa-solid fa-arrows-rotate"></i>
                  Borrar</button>
                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i>
                  Guardar</button>
              </div>
              @if(session('success'))
              <script>
                    document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                    title: 'Registro completado',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonText: 'Aceptar'
                });
              });
              </script>
              @endif
            </form>
          </div>
        </div>
        <!-- /.content -->
      </div>
    </div>
  </div>
</div>

@endsection