@extends('template.main')
@section('title', 'Lista Productos')
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
                                <thead>
                                    <tr>
                                        <th>Codigo</th>
                                        <th>Nombre</th>
                                        <th>Precio</th>
                                        <th>Categoria</th>
                                        <th>Stock</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $data)
                                    <tr>
                                        <td>{{ $data->id_producto }}</td>
                                        <td>{{ $data->nombre }}</td>
                                        <td>{{ $data->precio }}</td>
                                        <td>{{ $data->categoria}}</td>
                                        <td>{{ $data->stock}}</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#modalAddStock" onclick="setModalValues('{{ $data->id_producto }}', '{{ $data->nombre }}', '{{ $data->precio }}')">
                                                <i class="fa-solid fa-pen"></i> Añadir stock
                                            </button>
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

<!-- Modal para añadir stock -->
<div class="modal fade" id="modalAddStock" tabindex="-1" role="dialog" aria-labelledby="modalAddStockLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddStockLabel">Añadir a Stock</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAddStock" action="{{ route('aniadirStock') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nombreProducto">Producto</label>
                        <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad a Añadir</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="form-group">
                        <label for="pagoDistribuidor">Pago a Distribuidor</label>
                        <input type="number" class="form-control" id="pagoDistribuidor" name="pagoDistribuidor" required>
                    </div>
                    <div class="form-group">
                        <label for="precioProducto">Precio Unitario del Producto</label>
                        <input type="number" class="form-control" id="precioProducto" name="precioProducto" required>
                    </div>
                    <input type="hidden" id="id_producto" name="id_producto">
                    <button type="submit" class="btn btn-primary">Añadir al Stock</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setModalValues(id, nombre, precio) {
        document.getElementById('id_producto').value = id;
        document.getElementById('nombreProducto').value = nombre;
        document.getElementById('precioProducto').value = precio;
    }
</script>

@endsection
