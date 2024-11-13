@extends('template.main')
@section('title', 'Atencion Piscina Fin de Semana')

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
                            <li class="breadcrumb-item active">@yield('title')</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Card header con botón para abrir el modal -->
        <div class="card-header">
            <div class="text-right">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#registerModal">
                    <i class="fa-solid fa-plus"></i> Registrar Atención
                </button>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                            <thead class="thead-dark">
                                        <tr>
                                            <th>Estado</th>
                                            <th>Nombre</th>
                                            <th>Cantidad Adultos</th>
                                            <th>Cantidad Niños</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barang as $data)
                                            <tr data-observaciones="{{ $data->observaciones }}">
                                                <td>
                                                    @if ($data->estado)
                                                        <span class="badge badge-success">En Atención</span>
                                                    @else
                                                        <span class="badge badge-danger">Finalizado</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->nombre }}</td>
                                                <td>{{ $data->adultos }}</td>
                                                <td>{{ $data->ninos }}</td>
                                                <td>{{ $data->fecha }}</td>
                                                <td>{{ $data->total }}</td>
                                                <td class="acciones">
                                                    @if ($data->estado)
                                                        <form class="d-inline" action="{{ route('piscina.finalizar', $data->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" data-id="{{ $data->id }}" class="btn btn-success btn-sm mr-1">
                                                                <i class="fa-solid fa-check"></i> Finalizar Atención
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <div class="text-right">
                                                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#vender">
                                                            <i class="fa-solid fa-plus"></i> Vender
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>

    <!-- Modal para registrar la atención -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="registerModalLabel">Registrar Atención en Piscina</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('piscina.register') }}" method="POST" onsubmit="return validarFormulario()">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre del cliente">
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="adultos">Adultos</label>
                                <input type="number" class="form-control" id="adultos" name="adultos" value="0" min="0" onchange="calcularTotal()">
                                <div class="invalid-feedback">Por favor ingrese un número válido.</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ninos">Niños</label>
                                <input type="number" class="form-control" id="ninos" name="ninos" value="0" min="0" onchange="calcularTotal()">
                                <div class="invalid-feedback">Por favor ingrese un número válido.</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="total">Total</label>
                                <input type="number" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese observaciones..."></textarea>
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para vender-->
    <div class="modal fade" id="vender" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="registerModalLabel">Registrar Atención en Piscina</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                </div>
            </div>
        </div>
        
    </div>

    <!-- Modal para mostrar observaciones -->
    <div class="modal fade" id="observacionesModal" tabindex="-1" role="dialog" aria-labelledby="observacionesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="observacionesModalLabel">Observaciones</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="observacionesText">Aquí van las observaciones...</p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function calcularTotal() {
            var adultos = parseInt(document.getElementById('adultos').value) || 0;
            var ninos = parseInt(document.getElementById('ninos').value) || 0;

            var total = (adultos * 35) + (ninos * 25);
            document.getElementById('total').value = total;
        }
    </script>

    <script>
        function mostrarObservaciones(observaciones) {
            document.getElementById('observacionesText').innerText = observaciones || 'No hay observaciones.';
            $('#observacionesModal').modal('show');
        }

        document.querySelectorAll('tr').forEach(function(row) {
            row.addEventListener('click', function(event) {
                if (event.target.closest('.acciones')) {
                    return;
                }

                var observaciones = this.getAttribute('data-observaciones');
                mostrarObservaciones(observaciones);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    // Escucha el evento click en todos los botones con clase btn-success
    document.querySelectorAll('.btn-success').forEach(function(button) {
        button.addEventListener('click', function() {
            // Obtén el id de la atención desde el atributo data-id
            var atencionId = this.getAttribute('data-id');

            // Realiza una solicitud AJAX para obtener los productos de esa atención
            fetch(`/productos/${atencionId}`)
                .then(response => response.json())
                .then(data => {
                    // Lógica para cargar los productos en el modal
                    let productosContainer = document.querySelector('#productosContainer');
                    productosContainer.innerHTML = ''; // Limpia los productos actuales

                    data.forEach(producto => {
                        let productoElement = document.createElement('div');
                        productoElement.textContent = producto.nombre; // Modifica según tu estructura
                        productosContainer.appendChild(productoElement);
                    });
                });
        });
    });
});

        document.addEventListener("DOMContentLoaded", function() {
            // Referencia al modal "Vender"
            const modalVender = document.querySelector("#vender");
    
            function updateTotal() {
                let total = 0;
                modalVender.querySelectorAll("table tbody tr").forEach(function(row) {
                    let cantidadInput = row.querySelector(".cantidad");
                    let cantidad = cantidadInput.value;
                    let precio = row.cells[2].textContent;
                    total += cantidad * precio;
    
                    let productId = row.getAttribute("data-id");
                    modalVender.querySelector('.product-row[data-id="' + productId + '"] .input-cantidad').value = cantidad;
                });
                modalVender.querySelector(".total-price").textContent = total + " Bs";
                modalVender.querySelector(".input-total").value = total;
            }
    
            modalVender.addEventListener("input", function(event) {
                if (event.target.classList.contains("cantidad")) {
                    updateTotal();
                }
            });
    
            function quitarProducto(event) {
                const button = event.target;
                const row = button.closest("tr");
                const productId = row.getAttribute("data-id");
    
                row.remove();
                modalVender.querySelector('.product-row[data-id="' + productId + '"]').remove();
                updateTotal();
            }
    
            function productoYaEnLista(idProducto) {
                return !!modalVender.querySelector("table tbody tr[data-id='" + idProducto + "']");
            }
    
            modalVender.querySelector(".btn-agregar").addEventListener("click", function() {
                let productId = modalVender.querySelector("input[name='id_producto']").value;
    
                if (productoYaEnLista(productId)) {
                    alert("El producto ya está en la lista.");
                    return;
                }
    
                fetch("/productos/fetch-product", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ id_producto: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        let tableBody = modalVender.querySelector("table tbody");
                        let newRow = `
                            <tr data-id="${data.id_producto}">  
                                <td>${data.nombre}</td>
                                <td><input type="number" value="1" class="form-control cantidad"></td>
                                <td>${data.precio}</td>
                                <td><button class="btn btn-danger btn-quitar">Quitar</button></td>
                            </tr>
                        `;
                        tableBody.insertAdjacentHTML("beforeend", newRow);
    
                        let productInputContainer = modalVender.querySelector(".product-inputs");
                        let productIndex = modalVender.querySelectorAll(".product-row").length;
                        let productRow = `
                            <div class="product-row" data-id="${data.id_producto}">
                                <input type="hidden" name="productos[${productIndex}][id_producto]" value="${data.id_producto}">
                                <input type="hidden" name="productos[${productIndex}][nombre]" value="${data.nombre}">
                                <input type="hidden" name="productos[${productIndex}][cantidad]" value="1" class="input-cantidad">
                                <input type="hidden" name="productos[${productIndex}][precio]" value="${data.precio}">
                            </div>
                        `;
                        productInputContainer.insertAdjacentHTML("beforeend", productRow);
    
                        updateTotal();
    
                        modalVender.querySelectorAll(".btn-quitar").forEach(function(button) {
                            button.addEventListener("click", quitarProducto);
                        });
                    }
                });
            });
        });
    </script>
    
    <script>
        function validarFormulario() {
            var valido = true;

            var nombre = document.getElementById('nombre');
            if (nombre.value.trim() === '') {
                nombre.classList.add('is-invalid');
                valido = false;
            } else {
                nombre.classList.remove('is-invalid');
            }

            var adultos = document.getElementById('adultos');
            if (adultos.value === '' || isNaN(adultos.value) || parseInt(adultos.value) < 0) {
                adultos.classList.add('is-invalid');
                valido = false;
            } else {
                adultos.classList.remove('is-invalid');
            }

            var ninos = document.getElementById('ninos');
            if (ninos.value === '' || isNaN(ninos.value) || parseInt(ninos.value) < 0) {
                ninos.classList.add('is-invalid');
                valido = false;
            } else {
                ninos.classList.remove('is-invalid');
            }

            var observaciones = document.getElementById('observaciones');
            if (observaciones.value.trim() === '') {
                observaciones.classList.add('is-invalid');
                valido = false;
            } else {
                observaciones.classList.remove('is-invalid');
            }

            return valido;
        }

    </script>
    
@endsection
