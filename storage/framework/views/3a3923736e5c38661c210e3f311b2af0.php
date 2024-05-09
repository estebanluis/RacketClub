
<?php $__env->startSection('title', 'Turnos Trabajados'); ?>
<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><?php echo $__env->yieldContent('title'); ?></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
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
                    <div class="col-12">
                        <div class="card">
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table  table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Fecha</th>
                                            <th>Nro de seciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($data->name); ?></td>
                                                <td><?php echo e($data->fecha); ?></td>
                                                <td><?php echo e($data->HorariosAtendidos); ?></td>
                                                <td>
                                                <form class="d-inline" action="<?php echo e(route('turnos.showWithDate', ['id_user' => $data->id_user, 'fecha' => $data->fecha])); ?>" method="GET">
                                                    <button type="submit" class="btn btn-success btn-sm mr-1">
                                                        <i class="fa-solid fa-pen"></i> Ver Detalle
                                                    </button>
                                                </form>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/horario/verTurnos.blade.php ENDPATH**/ ?>