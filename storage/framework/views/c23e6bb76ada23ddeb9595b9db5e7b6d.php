 
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                        <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                        <thead class="thead-dark">
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
                                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($data->id_producto); ?></td>
                                        <td><?php echo e($data->nombre); ?></td>
                                        <td><?php echo e($data->precio); ?></td>
                                        <td><?php echo e($data->categoria); ?></td>
                                        <td><?php echo e($data->stock); ?></td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#modalAddStock" onclick="setModalValues('<?php echo e($data->id_producto); ?>', '<?php echo e($data->nombre); ?>', '<?php echo e($data->precio); ?>')">
                                                <i class="fa-solid fa-pen"></i> Añadir stock
                                            </button>
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalEditProduct"
                                            onclick="setEditModalValues('<?php echo e($data->id_producto); ?>', '<?php echo e($data->nombre); ?>', '<?php echo e($data->categoria); ?>', '<?php echo e($data->stock); ?>', '<?php echo e($data->precio); ?>')">
                                            <i class="fa-solid fa-pen"></i> Editar
                                            </button>
                                        <!-- Botón de eliminar -->
                                        <?php if(auth()->user()->TipoUsuario === 'Administrador'): ?>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo e($data->id_producto); ?>')">
                                            <i class="fa-solid fa-trash"></i> Eliminar
                                        </button>
                                    <?php endif; ?>
                                        </button>
                                        <?php if(session('success')): ?>
                                        Swal.fire({
                                            title: '¡Eliminado!',
                                            text: "<?php echo e(session('success')); ?>",
                                            icon: 'success',
                                            confirmButtonText: 'Aceptar'
                                        });
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
                <form id="formAddStock" action="<?php echo e(route('aniadirStock')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
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
                <form id="formEditProduct" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="form-group">
                        <label for="editNombreProducto">Nombre</label>
                        <input type="text" class="form-control" id="editNombreProducto" name="nombre" required>
                    </div>

                    <div class="form-group">
                        <label for="editCategoriaProducto">Categoría</label>
                        <input type="text" class="form-control" id="editCategoriaProducto" name="categoria" required>
                    </div>

                    <div class="form-group">
                        <label for="editStockProducto">Stock</label>
                        <input type="number" class="form-control" id="editStockProducto" name="stock" min="0" required>
                    </div>

                    <div class="form-group">
                        <label for="editPrecioProducto">Precio</label>
                        <input type="number" class="form-control" id="editPrecioProducto" name="precio" min="0" required>
                    </div>

                    <input type="hidden" id="editIdProducto" name="id_producto">
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function setEditModalValues(id, nombre, categoria, stock, precio) {
    // Establece los valores en los inputs correspondientes
    document.getElementById('editIdProducto').value = id;
    document.getElementById('editNombreProducto').value = nombre;
    document.getElementById('editCategoriaProducto').value = categoria;
    document.getElementById('editStockProducto').value = stock;
    document.getElementById('editPrecioProducto').value = precio;

    // Actualiza la acción del formulario con el id del producto
    document.getElementById('formEditProduct').action = '/productos/' + id;
}


</script>
<script>
    function confirmDelete(id_producto) {
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
            form.action = `/productos/${id_producto}`;
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
                <form action="<?php echo e(route('productos.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" class="form-control" id="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="id_producto">Código Producto</label>
                        <input type="text" name="id_producto" class="form-control" id="id_producto" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" name="stock" class="form-control" id="stock" min="1" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <input type="text" name="categoria" class="form-control" id="categoria" required>
                    </div>
                    <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" name="precio" class="form-control" id="precio" required>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar Producto</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/productos/listaProductos.blade.php ENDPATH**/ ?>