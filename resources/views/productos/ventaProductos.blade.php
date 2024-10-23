@extends('template.main')
@section('title', 'Venta de productos')
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Columna más grande para la tabla -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Productos Seleccionados</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se añadirán las filas de productos dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-8 -->

                <!-- Columna más pequeña para el input de ID y el formulario de venta -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Procesar Venta</h3>
                        </div>
                        <div class="card-body">
                            <!-- Formulario para enviar los productos al controlador -->
                            <form method="POST" action="{{ route('storeVenta') }}">
                                @csrf
                            
                                <!-- Input oculto para el total -->
                                <input type="hidden" name="total" class="input-total" value="0">
                            
                                <!-- Contenedor para inputs ocultos de productos -->
                                <div class="product-inputs"></div>
                            
                                <!-- Input para el ID del producto -->
                                <div class="form-group">
                                    <input name="id_producto" class="form-control" placeholder="Ingrese ID del producto">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-success btn-agregar">Agregar</button>
                                </div>
                            
                                <p><strong>Total: </strong><span class="total-price">0 Bs</span></p>
                            
                                <!-- Botón para realizar la venta -->
                                <div class="form-group">
                                    <button class="btn btn-success btn-block" type="submit">Realizar Venta</button>
                                </div>
                                @if(session('success'))
                                <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        Swal.fire({
                                            title: 'Venta realizada',
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
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
    </div>
    <!-- /.content -->

    <script>
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('table tbody tr').forEach(function(row) {
            let cantidadInput = row.querySelector('.cantidad');
            let cantidad = cantidadInput.value;
            let precio = row.cells[2].textContent;
            total += cantidad * precio;

            // Actualizar el input oculto de cantidad correspondiente
            let productId = row.getAttribute('data-id');
            document.querySelector('.product-row[data-id="' + productId + '"] .input-cantidad').value = cantidad;
        });
        document.querySelector('.total-price').textContent = total + ' Bs';
        document.querySelector('.input-total').value = total;
    }

    // Evento cuando cambia la cantidad de un producto
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('cantidad')) {
            updateTotal();
        }
    });

    // Función para quitar un producto de la tabla y del formulario
    function quitarProducto(event) {
        const button = event.target;
        const row = button.closest('tr');
        const productId = row.getAttribute('data-id');

        // Eliminar la fila de la tabla
        row.remove();

        // Eliminar el input oculto correspondiente
        document.querySelector('.product-row[data-id="' + productId + '"]').remove();

        // Actualizar el total
        updateTotal();
    }

    // Función para verificar si un producto ya está en la lista
    function productoYaEnLista(idProducto) {
        return !!document.querySelector('table tbody tr[data-id="' + idProducto + '"]');
    }

    // Evento para agregar un producto a la tabla
    document.querySelector('.btn-agregar').addEventListener('click', function() {
        let productId = document.querySelector('input[name="id_producto"]').value;

        // Verificar si el producto ya está en la lista
        if (productoYaEnLista(productId)) {
            alert('El producto ya está en la lista.');
            return;
        }

        // Hacer una petición AJAX para obtener los datos del producto
        fetch('/productos/fetch-product', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ id_producto: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error); // Mostrar error si el producto no es encontrado
            } else {
                let tableBody = document.querySelector('table tbody');
                let newRow = `
                    <tr data-id="${data.id_producto}">
                        <td>${data.nombre}</td>
                        <td><input type="number" value="1" class="form-control cantidad"></td>
                        <td>${data.precio}</td>
                        <td><button class="btn btn-danger btn-quitar">Quitar</button></td>
                    </tr>
                `;
                tableBody.insertAdjacentHTML('beforeend', newRow);

                // Agregar los inputs ocultos al formulario de manera correcta
                let productInputContainer = document.querySelector('.product-inputs');
                let productIndex = document.querySelectorAll('.product-row').length;
                let productRow = `
                    <div class="product-row" data-id="${data.id_producto}">
                        <input type="hidden" name="productos[${productIndex}][id_producto]" value="${data.id_producto}">
                        <input type="hidden" name="productos[${productIndex}][nombre]" value="${data.nombre}">
                        <input type="hidden" name="productos[${productIndex}][cantidad]" value="1" class="input-cantidad">
                        <input type="hidden" name="productos[${productIndex}][precio]" value="${data.precio}">
                    </div>
                `;
                productInputContainer.insertAdjacentHTML('beforeend', productRow);

                updateTotal(); // Actualizar el total cuando se añade un producto

                // Agregar el evento para el botón "Quitar"
                document.querySelectorAll('.btn-quitar').forEach(function(button) {
                    button.addEventListener('click', quitarProducto);
                });
            }
        });
    });
    </script>
</div>

@endsection
