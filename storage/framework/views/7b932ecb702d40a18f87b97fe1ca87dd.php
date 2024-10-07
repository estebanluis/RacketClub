
<?php $__env->startSection('title', 'Atencion Racket'); ?>
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
                            <div class="card-header">
                                <div class="text-right">
                                    <a href="/atenracket/create" class="btn btn-primary"><i class="fa-solid fa-plus"></i>Añadir Atencion</a>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-striped table-bordered table-hover text-center"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nombre</th>
                                            <th>Nro. Cancha</th>
                                            <th>Hora Entrada</th>
                                            <th>Hora Salida</th>
                                            <th>Total Horas</th>
                                            <th>Total (Bs.)</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($data->nombre); ?></td>
                                                <td><?php echo e($data->cancha); ?></td>
                                                <td> <?php echo e($data->hora_inicio); ?></td>
                                                <td><?php echo e($data->hora_fin); ?></td>
                                                <td><?php echo e($data->total_horas); ?></td>
                                                <td><?php echo e($data->total); ?></td>
                                                <td>
                                                    <form class="d-inline" action="/atenracket/<?php echo e($data->id); ?>/edit"
                                                        method="GET">
                                                        <button type="submit" class="btn btn-success btn-sm mr-1">
                                                            <i class="fa-solid fa-pen"></i> Edit
                                                        </button>
                                                    </form>
                                                    <form class="d-inline" action="/atenracket/<?php echo e($data->id); ?>"
                                                        method="POST">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('delete'); ?>
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            id="btn-delete"><i class="fa-solid fa-trash-can"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
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
<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/AtencionRacket/racket.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Atencion Racket'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <!-- Encabezado de la página -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?php echo $__env->yieldContent('title'); ?></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                        <li class="breadcrumb-item active"><?php echo $__env->yieldContent('title'); ?></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.Encabezado -->

    <!-- Botón para añadir nueva atención -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addAtencionModal">
                    <i class="fa-solid fa-plus"></i> Añadir Atención
                </a>
            </div>
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- Ciclo para las 4 canchas -->
                <?php for($i = 1; $i <= 4; $i++): ?>
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <!-- Personalización de colores de las canchas -->
                        <div class="card-header" style="background-color: #003554; color: white;">
                            <h3 class="card-title">Cancha <?php echo e($i); ?></h3>
                        </div>
                        <div class="card-body">
                            <?php
                                // Filtrar los datos para la cancha y estado "ocupado"
                                $canchaData = $barang->where('cancha', $i)->where('estado', 'ocupado');
                            ?>
                            
                            <?php if($canchaData->isEmpty()): ?>
                                <div class="text-center">
                                    <i class="fas fa-check-circle text-success fa-2x"></i>
                                    <p class="mt-2">Cancha Disponible</p>
                                </div>
                            <?php else: ?>
                            <?php $__currentLoopData = $canchaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="mb-3 p-2 border rounded bg-light">
                                    <strong><?php echo e($data->nombre); ?></strong>
                                    <span class="badge badge-<?php echo e($data->tipo == 'Racket' ? 'success' : 'info'); ?> float-right">
                                        <?php echo e($data->tipo); ?>

                                    </span>
                                    <br>
                                    <small>Hora Entrada: <?php echo e($data->hora_inicio); ?></small><br>
                                    <small>Hora Salida: <?php echo e($data->hora_fin); ?></small><br>
                                    <small>Total Horas: <?php echo e($data->total_horas); ?></small><br>
                                    <small>Total: <?php echo e($data->total); ?> Bs.</small><br>
                                    <small>Observaciones: <?php echo e($data->observaciones ?? 'Ninguna'); ?></small>
                                </div>
                                
                                <div class="mt-2">
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#finalizarAtencionModal" 
                                        onclick="setFinalizarDetails('<?php echo e($data->id); ?>', '<?php echo e($data->nombre); ?>', '<?php echo e($data->hora_inicio); ?>', '<?php echo e($data->hora_fin); ?>', '<?php echo e($data->total_horas); ?>', '<?php echo e($data->total); ?>', '<?php echo e($data->observaciones); ?>')">
                                        <i class="fa-solid fa-pen"></i> Finalizar Atención
                                    </button>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para añadir atención -->
<div class="modal fade" id="addAtencionModal" tabindex="-1" role="dialog" aria-labelledby="addAtencionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="addAtencionModalLabel">Añadir Atención</h5>
            </div>
            <form class="needs-validation" novalidate action="/atenracket" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" placeholder="Nombre de Cliente" value="<?php echo e(old('name')); ?>" required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="horaEntrada">Hora Entrada</label>
                                <input type="time" name="horaEntrada" class="form-control <?php $__errorArgs = ['horaEntrada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="horaEntrada" value="<?php echo e(old('horaEntrada')); ?>" required>
                                <?php $__errorArgs = ['horaEntrada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="cancha">Nro. Cancha</label>
                                <input type="number" min="1" max="4" name="cancha" class="form-control <?php $__errorArgs = ['cancha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="cancha" placeholder="Nro. de cancha" value="<?php echo e(old('cancha')); ?>" required>
                                <?php $__errorArgs = ['cancha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="tipo">Tipo de Uso</label>
                                <select name="tipo" class="form-control <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="tipo" required>
                                    <option value="" disabled selected>Seleccione un tipo</option>
                                    <option value="Racket">Racket</option>
                                    <option value="Wally">Wally</option>
                                </select>
                                <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <textarea name="observaciones" id="observaciones" class="form-control <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" cols="10" rows="3" placeholder="Observaciones"><?php echo e(old('observaciones')); ?></textarea>
                                <?php $__errorArgs = ['observaciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="invalid-feedback text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal para finalizar atención -->
<div class="modal fade" id="finalizarAtencionModal" tabindex="-1" role="dialog" aria-labelledby="finalizarAtencionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #003554; color: white;">
                <h5 class="modal-title" id="finalizarAtencionModalLabel">Finalizar Atención</h5>
            </div>
            <form id="finalizarAtencionForm" method="POST" action="">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?> <!-- Cambiado a PUT -->
                <div class="modal-body">
                    <p>¿Estás seguro de que deseas finalizar la atención para el siguiente cliente?</p>
                    <div id="atencionDetails"></div>
                    
                    <div class="form-group">
                        <label for="horaSalida">Hora Salida</label>
                        <input type="time" name="horaSalida" id="horaSalida" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="totalHoras">Total Horas</label>
                        <input type="text" name="totalHoras" id="totalHoras" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total">Total (Bs.)</label>
                        <input type="number" name="total" id="total" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Finalizar Atención</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    function setFinalizarDetails(id, nombre, horaInicio, horaFin, totalHoras, total, observaciones) {
        // Establecer el método de acción del formulario
        document.getElementById('finalizarAtencionForm').action = '/atenracket/' + id;

        // Mostrar los detalles en el modal
        const details = `
            <strong>Nombre:</strong> ${nombre}<br>
            <strong>Hora Entrada:</strong> ${horaInicio}<br>
            <strong>Hora Salida:</strong> ${horaFin}<br>
            <strong>Observaciones:</strong> ${observaciones || 'Ninguna'}
        `;
        document.getElementById('atencionDetails').innerHTML = details;

        // Obtener la hora actual y establecerla como hora de salida
        const now = new Date();
        const horaSalida = now.toTimeString().split(' ')[0].slice(0, 5); // Solo HH:MM
        document.getElementById('horaSalida').value = horaSalida;

        // Agregar hora de entrada al formulario como campo oculto
        const horaInicioField = document.createElement('input');
        horaInicioField.type = 'hidden';
        horaInicioField.name = 'horaInicio';
        horaInicioField.value = horaInicio;
        document.getElementById('finalizarAtencionForm').appendChild(horaInicioField);

        // Calcular total de horas y minutos
        const [horaE, minE] = horaInicio.split(':');
        const horaEntrada = new Date();
        horaEntrada.setHours(horaE);
        horaEntrada.setMinutes(minE);

        const horaSalidaDate = new Date();
        horaSalidaDate.setHours(now.getHours());
        horaSalidaDate.setMinutes(now.getMinutes());

        const diferenciaMilisegundos = horaSalidaDate - horaEntrada; // Diferencia en milisegundos
        const totalHorasCalculo = diferenciaMilisegundos / (1000 * 60 * 60); // Convertir de ms a horas
        const totalMinutos = (diferenciaMilisegundos / (1000 * 60)) % 60; // Obtener los minutos restantes

        const horas = Math.floor(totalHorasCalculo);
        const minutos = Math.round(totalMinutos);

        document.getElementById('totalHoras').value = `${horas} hora(s) ${minutos} minuto(s)`; // Formato de texto
        document.getElementById('total').value = total; // Asegúrate de que este valor se pase
    }
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/AtencionRacket/racket.blade.php ENDPATH**/ ?>