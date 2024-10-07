
<?php $__env->startSection('title', 'Atencion Piscina Fin de Semana'); ?>

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

        <!-- Card header con botón para abrir el modal -->
        <div class="card-header">
            <div class="text-right">
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#registerModal">
                    <i class="fa-solid fa-plus"></i> Registrar Atención
                </button>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%">
                            <thead class="thead-dark">
                                        <tr>
                                            <th>Estado</th>
                                            <th>Nombre</th>
                                            <th>Cantidad Adultos</th>
                                            <th>Cantidad Niños</th>
                                            <th>Fecha</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr data-observaciones="<?php echo e($data->observaciones); ?>">
                                                <td>
                                                    <?php if($data->estado): ?>
                                                        <span class="badge badge-success">En Atención</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger">Finalizado</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo e($data->nombre); ?></td>
                                                <td><?php echo e($data->adultos); ?></td>
                                                <td><?php echo e($data->ninos); ?></td>
                                                <td><?php echo e($data->fecha); ?></td>
                                                <td><?php echo e($data->total); ?></td>
                                                <td class="acciones">
                                                    <?php if($data->estado): ?>
                                                        <form class="d-inline" action="<?php echo e(route('piscina.finalizar', $data->id)); ?>" method="POST">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('PUT'); ?>
                                                            <button type="submit" class="btn btn-success btn-sm mr-1">
                                                                <i class="fa-solid fa-check"></i> Finalizar Atención
                                                            </button>
                                                        </form>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>

    <!-- Modal para registrar la atención -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="registerModalLabel">Registrar Atención en Piscina</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('piscina.register')); ?>" method="POST" onsubmit="return validarFormulario()">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la piscina">
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="adultos">Adultos</label>
                                <input type="number" class="form-control" id="adultos" name="adultos" value="0" min="0" onchange="calcularTotal()">
                                <div class="invalid-feedback">Por favor ingrese un número válido.</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="ninos">Niños</label>
                                <input type="number" class="form-control" id="ninos" name="ninos" value="0" min="0" onchange="calcularTotal()">
                                <div class="invalid-feedback">Por favor ingrese un número válido.</div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="total">Total</label>
                                <input type="number" class="form-control" id="total" name="total" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="3" placeholder="Ingrese observaciones..."></textarea>
                            <div class="invalid-feedback">Este campo es obligatorio.</div>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-success">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar observaciones -->
    <div class="modal fade" id="observacionesModal" tabindex="-1" role="dialog" aria-labelledby="observacionesModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="observacionesModalLabel">Observaciones</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="observacionesText">Aquí van las observaciones...</p>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        function calcularTotal() {
            var adultos = parseInt(document.getElementById('adultos').value) || 0;
            var ninos = parseInt(document.getElementById('ninos').value) || 0;

            var total = (adultos * 35) + (ninos * 25);
            document.getElementById('total').value = total;
        }
    </script>

    <script>
        function mostrarObservaciones(observaciones) {
            document.getElementById('observacionesText').innerText = observaciones || 'No hay observaciones.';
            $('#observacionesModal').modal('show');
        }

        document.querySelectorAll('tr').forEach(function(row) {
            row.addEventListener('click', function(event) {
                if (event.target.closest('.acciones')) {
                    return;
                }

                var observaciones = this.getAttribute('data-observaciones');
                mostrarObservaciones(observaciones);
            });
        });
    </script>

    <script>
        function validarFormulario() {
            var valido = true;

            var nombre = document.getElementById('nombre');
            if (nombre.value.trim() === '') {
                nombre.classList.add('is-invalid');
                valido = false;
            } else {
                nombre.classList.remove('is-invalid');
            }

            var adultos = document.getElementById('adultos');
            if (adultos.value === '' || isNaN(adultos.value) || parseInt(adultos.value) < 0) {
                adultos.classList.add('is-invalid');
                valido = false;
            } else {
                adultos.classList.remove('is-invalid');
            }

            var ninos = document.getElementById('ninos');
            if (ninos.value === '' || isNaN(ninos.value) || parseInt(ninos.value) < 0) {
                ninos.classList.add('is-invalid');
                valido = false;
            } else {
                ninos.classList.remove('is-invalid');
            }

            var observaciones = document.getElementById('observaciones');
            if (observaciones.value.trim() === '') {
                observaciones.classList.add('is-invalid');
                valido = false;
            } else {
                observaciones.classList.remove('is-invalid');
            }

            return valido;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/AtencionFindePiscina/atencionFinde.blade.php ENDPATH**/ ?>