 
<?php $__env->startSection('title', 'Lista Productos'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $__env->yieldContent('title'); ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-header">
                            <div class="d-flex justify-content-between mb-3">
                                
                                <button type="button" class="btn btn-primary ml-2" data-toggle="modal" data-target="#modalAddProduct">
                                    <i class="fa-solid fa-plus"></i> Agregar Producto
                                </button>
                            </div>
                        <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                        <thead class="thead-dark">
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
                                    <?php $__currentLoopData = $productosR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($data->id_productoR); ?></td>
                                        <td><?php echo e($data->nombreR); ?></td>
                                        <td><?php echo e($data->precioR); ?></td>
                                        <td><?php echo e($data->categoriaR); ?></td>
                                        <td><?php echo e($data->stockR); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#modalAddStock" onclick="setModalValues('<?php echo e($data->id_productoR); ?>', '<?php echo e($data->nombreR); ?>', '<?php echo e($data->precioR); ?>')">
                                                <i class="fa-solid fa-pen"></i> Añadir stock
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEditProduct"
                                            onclick="setEditModalValues('<?php echo e($data->id_productoR); ?>', '<?php echo e($data->nombreR); ?>', '<?php echo e($data->categoriaR); ?>', '<?php echo e($data->stockR); ?>', '<?php echo e($data->precioR); ?>')">
                                            <i class="fa-solid fa-pen"></i> Editar
                                            </button>
                                        <!-- Botón de eliminar -->
                                        <?php if(auth()->user()->TipoUsuario === 'Administrador'): ?>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo e($data->id_productoR); ?>')">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    <?php endif; ?>
                                        </button>
                                        <?php if(session('success1')): ?>
                                            <script>
                                                Swal.fire({
                                                    title: '¡Eliminado!',
                                                    text: "<?php echo e(session('success1')); ?>",
                                                    icon: 'success',
                                                    confirmButtonText: 'Aceptar'
                                                });
                                            </script>
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                <form id="formAddStock" action="<?php echo e(route('aniadirStockR')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="nombreProducto">Producto</label>
                        <input type="text" class="form-control" id="nombreProducto" name="nombreProductoR" readonly>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad a Añadir</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidadR" required>
                    </div>
                    <div class="form-group">
                        <label for="pagoDistribuidor">Pago a Distribuidor</label>
                        <input type="number" class="form-control" id="pagoDistribuidor" name="pagoDistribuidorR" required>
                    </div>
                    <div class="form-group">
                        <label for="precioProducto">Precio Unitario del Producto</label>
                        <input type="number" class="form-control" id="precioProducto" name="precioProductoR" required>
                    </div>
                    <input type="hidden" id="id_producto" name="id_productoR">
                    <button type="submit" class="btn btn-primary">Añadir al Stock</button>
                    <?php if(session('success3')): ?>
                                        <script>
                                            Swal.fire({
                                                title: '¡Exitoso!',
                                                text: "<?php echo e(session('success3')); ?>",
                                                icon: 'success',
                                                confirmButtonText: 'Aceptar'
                                            });
                                        </script>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function setModalValues(idR, nombreR, precioR) {
        document.getElementById('id_producto').value = idR;
        document.getElementById('nombreProducto').value = nombreR;
        document.getElementById('precioProducto').value = precioR;
    }
</script>
<!-- Modal para editar producto -->
<div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="modalEditProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditProductLabel">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formEditProductR" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group">
                        <label for="editNombreProducto">Nombre</label>
                        <input type="text" class="form-control" id="editNombreProducto" name="nombreR" required>
                    </div>

                    <div class="form-group">
                        <label for="editCategoriaProducto">Categoría</label>
                        <input type="text" class="form-control" id="editCategoriaProducto" name="categoriaR" required>
                    </div>

                    <div class="form-group">
                        <label for="editStockProducto">Stock</label>
                        <input type="number" class="form-control" id="editStockProducto" name="stockR" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="editPrecioProducto">Precio</label>
                        <input type="number" class="form-control" id="editPrecioProducto" name="precioR" min="0" required>
                    </div>

                    <input type="hidden" id="editIdProducto" name="id_producto">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    <?php if(session('success2')): ?>
                                        <script>
                                            Swal.fire({
                                                title: '¡Cambios registrados!',
                                                text: "<?php echo e(session('success2')); ?>",
                                                icon: 'success',
                                                confirmButtonText: 'Aceptar'
                                            });
                                        </script>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function setEditModalValues(id, nombreR, categoriaR, stockR, precioR) {
    // Establece los valores en los inputs correspondientes
    document.getElementById('editIdProducto').value = id;
    document.getElementById('editNombreProducto').value = nombreR;
    document.getElementById('editCategoriaProducto').value = categoriaR;
    document.getElementById('editStockProducto').value = stockR;
    document.getElementById('editPrecioProducto').value = precioR;

    // Actualiza la acción del formulario con el id del producto
    document.getElementById('formEditProductR').action = '/productosR/' + id;
}


</script>
<script>
    function confirmDelete(id_productoR) {
    Swal.fire({
        title: '¿Estás seguro de eliminar este producto?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Si el usuario confirma, se envía el formulario para eliminar
            let form = document.createElement('form');
            form.action = `/productosR/${id_productoR}`;
            form.method = 'POST';

            // Agregar los campos necesarios para enviar la solicitud DELETE
            let csrfField = document.createElement('input');
            csrfField.type = 'hidden';
            csrfField.name = '_token';
            csrfField.value = '<?php echo e(csrf_token()); ?>';

            let methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

            form.appendChild(csrfField);
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit(); // Enviar el formulario para eliminar
        }
    });
}

</script>
<!-- Modal para agregar producto -->
<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog" aria-labelledby="modalAddProductLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddProductLabel">Agregar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('productos.storeR')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="nombreR">Nombre</label>
                        <input type="text" name="nombreR" class="form-control" id="nombreR" required>
                    </div>
                    <div class="form-group">
                        <label for="id_producto">Código Producto</label>
                        <input type="text" name="id_productoR" class="form-control" id="id_producto" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" name="stockR" class="form-control" id="stock" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <input type="text" name="categoriaR" class="form-control" id="categoria" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" name="precioR" class="form-control" id="precio" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                </form>
                <?php if(session('success')): ?>
                                        <script>
                                            Swal.fire({
                                                title: '¡AGREGADO!',
                                                text: "<?php echo e(session('success')); ?>",
                                                icon: 'success',
                                                confirmButtonText: 'Aceptar'
                                            });
                                        </script>
                    <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/productos/listaProductosR.blade.php ENDPATH**/ ?>