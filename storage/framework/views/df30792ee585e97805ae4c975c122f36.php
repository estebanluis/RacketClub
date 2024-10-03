
<?php $__env->startSection('title', 'Lista Alumnos'); ?>
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
                                        <th>Apellidos</th>
                                        <th>Fecha inscripcion</th>
                                        <th>Nro de seciones</th>
                                        <th>Telefono</th>
                                        <th>Reinscripciones</th>
                                        <th>Observaciones</th>
                                        <th>Tarjeta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($data->codigo); ?></td>
                                        <td><?php echo e($data->nombre); ?></td>
                                        <td><?php echo e($data->apellido); ?> <?php echo e($data->apellidoMat); ?></td>
                                        <td><?php echo e($data->created_at->format('d-m-Y')); ?></td>
                                        <td><?php echo e($data->nrsesiones); ?></td>
                                        <td><?php echo e($data->telefono); ?></td>
                                        <td><?php echo e($data->nroReinscripciones); ?></td>
                                        <td><?php echo e($data->observciones); ?></td>
                                        <td>
                                        <form class="d-inline" action="/barang/<?php echo e($data->id); ?>/edit" method="GET">
                            <button type="submit" class="btn btn-success btn-sm mr-2">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>
                        </form>

                        <form class="d-inline reinscribirForm" action="<?php echo e(route('reinscribir.alumn', ['id' => $data->id])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="button" class="btn btn-primary btn-sm reinscribirBtn mr-2">
                                <i class="fa-solid fa-file-pdf"></i> Reinscribir
                            </button>
                        </form>

                        <form class="d-inline" action="<?php echo e(route('generate.pdf', ['id' => $data->id])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-file-pdf"></i> Reimprimir
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
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.reinscribirBtn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            Swal.fire({
                title: 'Advertencia',
                html:
                    '<label for="modalidadSelect">Modalidad:</label>' +
                    '<select id="modalidadSelect" class="form-select mb-3">' +
                        '<option value="Natación curso completo">Natación curso completo</option>' +
                        '<option value="Natación*3 semana 12">Natación*3 semana 12</option>' +
                        '<option value="Natación*3 semana 20">Natación*3 semana 20</option>' +
                        '<option value="Natación medio curso">Natación medio curso</option>' +
                    '</select>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, reinscribir',
                cancelButtonText: 'No, cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var modalidad = document.getElementById('modalidadSelect').value;
                    var form = btn.closest('.reinscribirForm');
                    var modalidadInput = document.createElement('input');
                    modalidadInput.type = 'hidden';
                    modalidadInput.name = 'modalidad';
                    modalidadInput.value = modalidad;
                    form.appendChild(modalidadInput);
                    form.submit();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/barang/barang.blade.php ENDPATH**/ ?>