
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
                <!-- Columna de las 4 canchas -->
                <div class="col-lg-8 col-md-12">
                    <div class="row">
                        <!-- Ciclo para las 4 canchas -->
                        <?php $__currentLoopData = $canchas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cancha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="card-header" style="background-color: #003554; color: white;">
                                    <h3 class="card-title"> <?php echo e($cancha->nombre); ?></h3>
                                </div>
                                <div class="card-body">
                                    <?php
                                        // Filtrar las atenciones que sean de la cancha actual y estén ocupadas
                                        $canchaData = $barang->where('cancha', $cancha->id)->where('estado', 'ocupado');
                                    ?>
                    
                                    <?php if($canchaData->isEmpty()): ?>
                                        <div class="text-center">
                                            <i class="fas fa-check-circle text-success fa-2x"></i>
                                            <p class="mt-2">Cancha Disponible</p>
                                        </div>
                                    <?php else: ?>
                                        <?php $__currentLoopData = $canchaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <!-- Mostrar datos de atención -->
                                            <div class="mb-3 p-2 border rounded bg-light">
                                                <strong><?php echo e($data->nombre); ?></strong>
                                                <span class="badge badge-success float-right"><?php echo e($data->tipo); ?></span>
                                                <br>
                                                <small>Hora Entrada: <?php echo e($data->hora_inicio); ?></small><br>
                                                <small>Hora Salida: <?php echo e($data->hora_fin); ?></small><br>
                                                <small>Total Horas: <?php echo e($data->total_horas); ?></small><br>
                                                <small>Total: <?php echo e($data->total); ?> Bs.</small><br>
                                                <small>Observaciones: <?php echo e($data->observaciones ?? 'Ninguna'); ?></small>
                                            </div>
                                            <div class="mt-2">
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#finalizarAtencionModal" 
                                                    onclick="setFinalizarDetails(
                                                        '<?php echo e($data->id); ?>',
                                                        '<?php echo e($data->nombre); ?>',
                                                        '<?php echo e($data->hora_inicio); ?>',
                                                        '<?php echo e($data->hora_fin); ?>',
                                                        '<?php echo e($data->total_horas); ?>',
                                                        '<?php echo e($data->total); ?>',
                                                        '<?php echo e($data->observaciones); ?>',
                                                        '<?php echo e($canchas->where('id', $data->cancha)->first()?->precio->precio ?? 0); ?>'
                                                    )"
                                                >
                                                    <i class="fa-solid fa-pen"></i> Finalizar Atención
                                                </button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                            
                    </div>
                </div>

                <!-- Columna para Reservas -->
<div class="col-lg-4 col-md-12">
    <div class="card shadow-sm">
        <div class="card-header" style="background-color: #003554; color: white;">
            <h3 class="card-title">Reservas de Canchas</h3>
        </div>
        <div class="card-body">
            <?php if($reservas->isEmpty()): ?>
                <div class="text-center">
                    <i class="fas fa-calendar-check text-warning fa-2x"></i>
                    <p class="mt-2">No hay Reservas</p>
                </div>
            <?php else: ?>
                <?php $__currentLoopData = $reservas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reserva): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-3 p-2 border rounded bg-light">
                    <strong><?php echo e($reserva->nombre_reserva); ?></strong>
                    <span class="badge badge-info float-right"><?php echo e($reserva->tipo); ?></span>
                    <br>
                    <small>Hora Entrada: <?php echo e($reserva->hora); ?></small><br>
                    <small>Cancha: <?php echo e($reserva->numero_cancha); ?></small><br>
                    <small>Observaciones: <?php echo e($reserva->observaciones ?? 'Ninguna'); ?></small>

                    <!-- Botón para pasar a atención -->
                    <div class="mt-2">
                        <form action="<?php echo e(route('reservas.transferirAtencion', $reserva->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-arrow-right"></i> Pasar a Atención
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>

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
unset($__errorArgs, $__bag); ?>" id="horaEntrada" readonly required>
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
                                <label for="cancha">Seleccionar Cancha</label>
                                <select name="cancha" id="cancha" class="form-control" required>
                                    <option value="">-- Seleccione una cancha --</option>
                                    <?php $__currentLoopData = $canchas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cancha): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            // Verificar si la cancha está ocupada
                                            $canchaOcupada = $barang->where('cancha', $cancha->id)->where('estado', 'ocupado')->isNotEmpty();
                                        ?>
                                        <?php if(!$canchaOcupada): ?>
                                            <option value="<?php echo e($cancha->id); ?>"><?php echo e($cancha->nombre); ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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
                <?php echo method_field('PUT'); ?> 
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
                        <input type="number" name="total" id="total" class="form-control" min="1" step="0.01" required>
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
    function setFinalizarDetails(id, nombre, horaInicio, horaFin, totalHoras, total, observaciones, precioPorHora) {
        document.getElementById('finalizarAtencionForm').action = '/atenracket/' + id;

        const details = `
            <strong>Nombre:</strong> ${nombre}<br>
            <strong>Hora Entrada:</strong> ${horaInicio}<br>
            <strong>Observaciones:</strong> ${observaciones || 'Ninguna'}
        `;
        document.getElementById('atencionDetails').innerHTML = details;

        const now = new Date();
        const horaSalida = now.toTimeString().split(' ')[0].slice(0, 5);
        document.getElementById('horaSalida').value = horaSalida;

        const horaInicioField = document.createElement('input');
        horaInicioField.type = 'hidden';
        horaInicioField.name = 'horaInicio';
        horaInicioField.value = horaInicio;
        document.getElementById('finalizarAtencionForm').appendChild(horaInicioField);

        // Calcular tiempo
        const [horaE, minE] = horaInicio.split(':');
        const horaEntrada = new Date();
        horaEntrada.setHours(horaE);
        horaEntrada.setMinutes(minE);

        const horaSalidaDate = new Date();
        horaSalidaDate.setHours(now.getHours());
        horaSalidaDate.setMinutes(now.getMinutes());

        const diferenciaMilisegundos = horaSalidaDate - horaEntrada;
        const totalHorasCalculo = diferenciaMilisegundos / (1000 * 60 * 60);
        const totalMinutos = (diferenciaMilisegundos / (1000 * 60)) % 60;

        const horas = Math.floor(totalHorasCalculo);
        const minutos = Math.round(totalMinutos);

        document.getElementById('totalHoras').value = `${horas} hora(s) ${minutos} minuto(s)`;

        // Calcular total automáticamente
        // Calcular total automáticamente
        const totalCalculado = (totalHorasCalculo * parseFloat(precioPorHora));

        // Redondear el total a 2 decimales
        const totalRedondeado = Math.round(totalCalculado * 100) / 100;

        document.getElementById('total').value = totalRedondeado.toFixed(2);

    }
</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/AtencionRacket/racket.blade.php ENDPATH**/ ?>