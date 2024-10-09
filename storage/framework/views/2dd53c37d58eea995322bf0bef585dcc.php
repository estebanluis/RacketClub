
<?php $__env->startSection('title', 'Lista Usuarios'); ?>
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
                        <div class="card-header">
                            <div class="text-right">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Usuarios
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Correo</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($data->name); ?></td>
                                            <td><?php echo e($data->email); ?></td>
                                            <td><?php echo e($data->TipoUsuario); ?></td>
                                            <td>
                                                <!-- Botón para abrir el modal de edición -->
                                                <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#editUserModal" 
                                                    data-id="<?php echo e($data->id_user); ?>" 
                                                    data-name="<?php echo e($data->name); ?>"
                                                    data-email="<?php echo e($data->email); ?>"
                                                    data-tipousuario="<?php echo e($data->TipoUsuario); ?>">
                                                    <i class="fa-solid fa-pen"></i> Editar
                                                </button>
                                                
                                                <!-- Botón para eliminar -->
                                                <form class="d-inline" action="/luser/<?php echo e($data->id_user); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('delete'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" id="btn-delete">
                                                        <i class="fa-solid fa-trash-can"></i> Eliminar
                                                    </button>
                                                </form>
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

<!-- Modal para registrar usuarios -->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registerModalLabel">Registrar Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="/luser" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nombre completo" value="<?php echo e(old('name')); ?>" required>
                        <?php $__errorArgs = ['name'];
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
                        <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Correo electrónico" value="<?php echo e(old('email')); ?>" required>
                        <?php $__errorArgs = ['email'];
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
                        <select name="TipoUsuario" id="TipoUsuario" class="form-control <?php $__errorArgs = ['TipoUsuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="" disabled selected>Selecciona un tipo de usuario</option>
                            <option value="Administrador" <?php echo e(old('TipoUsuario') == 'Administrador' ? 'selected' : ''); ?>>Administrador</option>
                            <option value="Secretaria Natacion" <?php echo e(old('TipoUsuario') == 'Secretaria Natacion' ? 'selected' : ''); ?>>Secretaria Piscina</option>
                            <option value="Secretaria Racket" <?php echo e(old('TipoUsuario') == 'Secretaria Racket' ? 'selected' : ''); ?>>Secretaria Racket</option>
                            <option value="Profesor" <?php echo e(old('TipoUsuario') == 'Profesor' ? 'selected' : ''); ?>>Profesor</option>
                        </select>
                        <?php $__errorArgs = ['TipoUsuario'];
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
                        <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Contraseña" required>
                        <?php $__errorArgs = ['password'];
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
                        <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control <?php $__errorArgs = ['passwordConfirm'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Repite la contraseña" required>
                        <?php $__errorArgs = ['passwordConfirm'];
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
                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/luser/update" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?> <!-- Para que se use el método PUT -->
                    <input type="hidden" name="id_user" id="id_user">

                    <div class="input-group mb-3">
                        <input type="text" name="name" id="edit_name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nombre completo" 
                               value="<?php echo e(old('name', '')); ?>" required>
                        <?php $__errorArgs = ['name'];
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
                        <input type="email" name="email" id="edit_email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Correo electrónico" 
                               value="<?php echo e(old('email', '')); ?>" required>
                        <?php $__errorArgs = ['email'];
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
                        <select name="TipoUsuario" id="edit_TipoUsuario" class="form-control <?php $__errorArgs = ['TipoUsuario'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                            <option value="" disabled selected>Selecciona un tipo de usuario</option>
                            <option value="Administrador" <?php echo e(old('TipoUsuario', '') == 'Administrador' ? 'selected' : ''); ?>>Administrador</option>
                            <option value="Secretaria Natacion" <?php echo e(old('TipoUsuario', '') == 'Secretaria Natacion' ? 'selected' : ''); ?>>Secretaria Piscina</option>
                            <option value="Secretaria Racket" <?php echo e(old('TipoUsuario', '') == 'Secretaria Racket' ? 'selected' : ''); ?>>Secretaria Racket</option>
                            <option value="Profesor" <?php echo e(old('TipoUsuario', '') == 'Profesor' ? 'selected' : ''); ?>>Profesor</option>
                        </select>
                        <?php $__errorArgs = ['TipoUsuario'];
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

                    <!-- Campo opcional para cambiar contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nueva contraseña (opcional)">
                        <?php $__errorArgs = ['password'];
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

                    <!-- Campo para confirmar la nueva contraseña -->
                    <div class="input-group mb-3">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirma la nueva contraseña (opcional)">
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Guardar Cambios</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $__env->startSection('scripts'); ?>
<script>
    // Abrir modal de edición y rellenar con datos
    $('#editUserModal').on('show.bs.modal', function (event) {
        // Limpiar errores de validación
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var tipousuario = button.data('tipousuario');

        var modal = $(this);
        modal.find('#id_user').val(id); // Cambiado a 'id_user'
        modal.find('#edit_name').val(name); // Cambiado a 'edit_name'
        modal.find('#edit_email').val(email); // Cambiado a 'edit_email'
        modal.find('#edit_TipoUsuario').val(tipousuario); // Cambiado a 'edit_TipoUsuario'
    });

    <?php if($errors->any()): ?>
        $('#registerUserModal').modal('show');
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/registerUser/listUser.blade.php ENDPATH**/ ?>