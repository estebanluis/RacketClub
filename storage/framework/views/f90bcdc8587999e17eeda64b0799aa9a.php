
<?php $__env->startSection('title', 'Detalle Turnos'); ?>
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
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item"><a href="/turnos">Turnos Trabajados</a></li>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="/turnos" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i>
                                    Atras
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Nro Carril</th>
                                        <th>Nro de Alumnos</th>
                                        <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                        <th>Salario</th>
                                        <th>Acciones</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($data->name); ?></td>
                                            <td><?php echo e($data->fecha); ?></td>
                                            <td><?php echo e($data->hora); ?></td>
                                            <td><?php echo e($data->carril); ?></td>
                                            <td><?php echo e($data->nalumnos); ?></td>
                                            <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                            <td><?php echo e($data->salario); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#agregarSalarioModal" data-id="<?php echo e($data->idHorario); ?>" data-nombre="<?php echo e($data->name); ?>" data-fecha="<?php echo e($data->fecha); ?>" data-hora="<?php echo e($data->hora); ?>" data-carril="<?php echo e($data->carril); ?>" data-nalumnos="<?php echo e($data->nalumnos); ?>" data-salario="<?php echo e($data->salario); ?>">
                                                    <i class="fa-solid fa-pen"></i> Agregar salario
                                                </button>
                                            </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal para agregar/editar salario -->
<div class="modal fade" id="agregarSalarioModal" tabindex="-1" role="dialog" aria-labelledby="agregarSalarioModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="observacionesModalLabel">Agregar o Editar Salario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="salarioForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <!-- Fila para Nombre y Fecha -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="name" id="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha">Fecha</label>
                            <input type="text" name="fecha" id="fecha" class="form-control" required>
                        </div>
                    </div>
                    
                    <!-- Fila para Hora, Nro Carril y Nro Alumnos -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="hora">Hora</label>
                            <input type="text" name="hora" id="hora" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="carril">Nro Carril</label>
                            <input type="number" name="carril" id="carril" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="nalumnos">Nro Alumnos</label>
                            <input type="number" name="nalumnos" id="nalumnos" class="form-control" required>
                        </div>
                    </div>

                    <!-- Fila para Observaciones y Salario -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control" cols="10" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="salario">Salario</label>
                            <input type="number" name="salario" id="salario" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    $('#agregarSalarioModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var idHorario = button.data('id');
        var nombre = button.data('nombre');
        var fecha = button.data('fecha');
        var hora = button.data('hora');
        var carril = button.data('carril');
        var nalumnos = button.data('nalumnos');
        var salario = button.data('salario');

        // Actualiza los campos del formulario en el modal
        var modal = $(this);
        modal.find('#nombre').val(nombre);
        modal.find('#fecha').val(fecha);
        modal.find('#hora').val(hora);
        modal.find('#carril').val(carril);
        modal.find('#nalumnos').val(nalumnos);
        modal.find('#salario').val(salario);

        // Actualiza la acción del formulario para enviar al controlador correcto
        var actionUrl = "/turnos/salario/" + idHorario; // Actualiza la URL según tu ruta
        modal.find('#salarioForm').attr('action', actionUrl);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/horario/detalleTurnos.blade.php ENDPATH**/ ?>