
<?php $__env->startSection('title', 'Registrar Horario'); ?>
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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($data->name); ?></td>
                                            <td><?php echo e($data->email); ?></td>
                                            <td>
                                                <!-- Botón para abrir el modal de agregar turno -->
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTurnoModal"
                                                    data-id="<?php echo e($data->id_user); ?>"
                                                    data-name="<?php echo e($data->name); ?>"
                                                    data-email="<?php echo e($data->email); ?>">
                                                    <i class="fa-solid fa-plus"></i> Agregar Turno
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar turno -->
<div class="modal fade" id="addTurnoModal" tabindex="-1" role="dialog" aria-labelledby="addTurnoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addTurnoModalLabel">Agregar Turno</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="<?php echo e(route('horarios.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <!-- Campos ocultos para el ID y nombre del usuario -->
                    <input type="hidden" name="id_user" id="id_user">
                    <input type="hidden" name="name" id="name">

                    <div class="input-group mb-3">
                        <input type="text" name="name_display" id="name_display" class="form-control" placeholder="Nombre" readonly>
                    </div>

                    <div class="input-group mb-3">
                        <select name="carril" class="form-control <?php $__errorArgs = ['carril'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="" disabled selected>Selecciona un carril</option>
                            <option value="1" <?php echo e(old('carril') == '1' ? 'selected' : ''); ?>>Carril 1</option>
                            <option value="2" <?php echo e(old('carril') == '2' ? 'selected' : ''); ?>>Carril 2</option>
                            <option value="3" <?php echo e(old('carril') == '3' ? 'selected' : ''); ?>>Carril 3</option>
                            <option value="4" <?php echo e(old('carril') == '4' ? 'selected' : ''); ?>>Carril 4</option>
                        </select>
                        <?php $__errorArgs = ['carril'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="input-group mb-3">
                        <input type="number" name="nalumnos" class="form-control <?php $__errorArgs = ['nalumnos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Número de Alumnos" value="<?php echo e(old('nalumnos')); ?>" required>
                        <?php $__errorArgs = ['nalumnos'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    <div class="input-group mb-3">
                        <select name="horario" class="form-control <?php $__errorArgs = ['horario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="" disabled selected>Selecciona un horario</option>
                            <?php $__currentLoopData = ['7:00-8:00', '8:00-9:00', '9:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($option); ?>" <?php echo e(old('horario') == $option ? 'selected' : ''); ?>><?php echo e($option); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['horario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                    <div class="input-group mb-3">
                        <textarea name="observaciones" class="form-control" placeholder="Observaciones" rows="3"><?php echo e(old('observaciones')); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Agregar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // Lógica para abrir el modal de agregar turno y rellenar los campos con los datos del usuario seleccionado
    $('#addTurnoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Botón que abrió el modal
        var idUser = button.data('id');
        var nameUser = button.data('name');
        
        // Rellenar los campos ocultos y el nombre en el modal
        var modal = $(this);
        modal.find('#id_user').val(idUser);
        modal.find('#name_display').val(nameUser);
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/horario/horasGeneral.blade.php ENDPATH**/ ?>