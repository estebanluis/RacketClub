
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

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/productos/listaProductos.blade.php ENDPATH**/ ?>