
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
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
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
                    
                    <!-- Primera fila: Nombre y Correo -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Nombre completo</label>
                            <div class="input-group mb-3">
                                <input type="text" name="name" id="name" class="form-control <?php $__errorArgs = ['name'];
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
                        </div>
                        <div class="col-md-6">
                            <label for="email">Correo electrónico</label>
                            <div class="input-group mb-3">
                                <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
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
                        </div>
                    </div>

                    <!-- Segunda fila: Contraseña y Confirmación de Contraseña -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="password">Contraseña</label>
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
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation">Repite la contraseña</label>
                            <div class="input-group mb-3">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Repite la contraseña" required>
                                <?php $__errorArgs = ['password_confirmation'];
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
                        </div>
                    </div>

                    <!-- Tercera fila: Tipo de Usuario -->
                    <label for="TipoUsuario">Tipo de Usuario</label>
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

                    <!-- Botones de acción -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal para editar usuarios -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="registerModalLabel">Editar Usuario</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="<?php echo e(route('luser.update', 'id_user')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?> <!-- Asegúrate de usar PUT aquí -->
                    <input type="hidden" name="id_user" id="id_user">

                    <!-- Fila para Nombre y Correo -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_name">Nombre completo</label>
                            <div class="input-group">
                                <input type="text" name="name" id="edit_name" class="form-control" placeholder="Nombre completo" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_email">Correo electrónico</label>
                            <div class="input-group">
                                <input type="email" name="email" id="edit_email" class="form-control" placeholder="Correo electrónico" required>
                            </div>
                        </div>
                    </div>

                    <!-- Fila para Tipo de Usuario -->
                    <div class="mb-3">
                        <label for="edit_TipoUsuario">Tipo de Usuario</label>
                        <div class="input-group">
                            <select name="TipoUsuario" id="edit_TipoUsuario" class="form-control" required>
                                <option value="" disabled selected>Selecciona un tipo de usuario</option>
                                <option value="Administrador">Administrador</option>
                                <option value="Secretaria Natacion">Secretaria Piscina</option>
                                <option value="Secretaria Racket">Secretaria Racket</option>
                                <option value="Profesor">Profesor</option>
                            </select>
                        </div>
                    </div>

                    <!-- Fila para Contraseña y Confirmación de Contraseña -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_password">Contraseña (deja en blanco si no deseas cambiarla)</label>
                            <div class="input-group">
                                <input type="password" name="password" id="edit_password" class="form-control" placeholder="Contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_password_confirmation">Repite la contraseña (si cambiaste la contraseña)</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="edit_password_confirmation" class="form-control" placeholder="Repite la contraseña">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script>
    // Script para llenar el modal de edición con datos del usuario seleccionado
    $('#editUserModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var name = button.data('name');
        var email = button.data('email');
        var tipoUsuario = button.data('tipousuario');

        var modal = $(this);
        modal.find('#id_user').val(id);
        modal.find('#edit_name').val(name);
        modal.find('#edit_email').val(email);
        modal.find('#edit_TipoUsuario').val(tipoUsuario);
    });
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/registerUser/listUser.blade.php ENDPATH**/ ?>