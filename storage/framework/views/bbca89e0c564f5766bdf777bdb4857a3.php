
<?php $__env->startSection('title', 'Registrar Canchas'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
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

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerUserModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Canchas
                                </a>
                                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#registerDeporteModal">
                                    <i class="fa-solid fa-plus"></i> Registrar Deporte
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre</th>
                                        <th>Deportes</th>
                                        <th>Precio</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $canchas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td><?php echo e($data->nombre); ?></td>
                                            <td>
                                                <?php $__currentLoopData = $data->deportes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deporte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge badge-info"><?php echo e($deporte->nombre); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                            <td><?php echo e($data->precio->precio ?? 'N/A'); ?></td>
                                            <td>
                                                <!-- Botón Editar -->
                                                <a href="<?php echo e(route('creacanch.edit', $data->id)); ?>" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-edit"></i>
                                                </a>

                                                <!-- Formulario Eliminar -->
                                                <form action="<?php echo e(route('creacanch.destroy', $data->id)); ?>" method="POST" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que deseas eliminar esta cancha?')">
                                                        <i class="fa fa-trash"></i>
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


<!-- Modal Registrar Cancha -->
<div class="modal fade" id="registerUserModal" tabindex="-1" role="dialog" aria-labelledby="registerUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="<?php echo e(route('creacanch.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="tipo_registro" value="cancha">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Registrar Cancha</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="nombre">Nombre de la Cancha</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre')); ?>" required>
              <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label for="precio">Precio (Bs)</label>
              <input type="number" name="precio" step="0.01" class="form-control" required>
              <?php $__errorArgs = ['precio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
              <label for="deportes">Deportes que se pueden practicar</label>
              <select name="deportes[]" class="form-control" multiple required>
                <?php $__currentLoopData = $deportes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deporte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($deporte->id); ?>"><?php echo e($deporte->nombre); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <small class="form-text text-muted">Usa Ctrl o Shift para seleccionar varios.</small>
              <?php $__errorArgs = ['deportes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger d-block"><?php echo e($message); ?></small>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </form>
    </div>
</div>


<!-- Modal Registrar Deporte -->
<div class="modal fade" id="registerDeporteModal" tabindex="-1" role="dialog" aria-labelledby="registerDeporteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="<?php echo e(route('creacanch.deporte')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="tipo_registro" value="deporte">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Registrar Deporte</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="nombre">Nombre del Deporte</label>
              <input type="text" name="nombre" class="form-control" value="<?php echo e(old('nombre')); ?>" required>
              <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <small class="text-danger"><?php echo e($message); ?></small>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    <?php if($errors->any()): ?>
        <?php if(old('tipo_registro') == 'cancha'): ?>
            $('#registerUserModal').modal('show');
        <?php elseif(old('tipo_registro') == 'deporte'): ?>
            $('#registerDeporteModal').modal('show');
        <?php endif; ?>
    <?php endif; ?>
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/CrearCanchas/canchas.blade.php ENDPATH**/ ?>