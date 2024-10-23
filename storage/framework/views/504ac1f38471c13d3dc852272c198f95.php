
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper" style="background-color: #e0f7fa;">
    <div class="content-header">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Primera columna: Tabla de Asistencias -->
                    <div class="col-lg-8 col-md-12">
                        <div class="card shadow-lg" style="border-radius: 20px;">
                            <div class="card-body p-4">
                                <h2 class="text-center mb-4" style="color: #00796b; font-family: 'Poppins', sans-serif;">Registro de Asistencias</h2>
                                
                                <table id="example1" class="table table-striped table-bordered table-hover text-center" style="width: 100%; background-color: #ffffff; border-radius: 15px;">
                                    <thead style="background-color: #004d40; color: #ffffff; font-family: 'Poppins', sans-serif;">
                                        <tr>
                                            <th>Nombre Completo</th>
                                            <th>Hora Asistencia</th>
                                            <th>Sesiones Restantes</th>
                                            <th>Modalidad</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tablaAsistencias" style="font-family: 'Poppins', sans-serif; color: #004d40;">
                                        <?php $__currentLoopData = $asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $asistencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="asistencia-row">
                                            <td><?php echo e($asistencia->nombre); ?> <?php echo e($asistencia->apellido); ?> <?php echo e($asistencia->apellidoMat); ?></td>
                                            <td><?php echo e(\Carbon\Carbon::parse($asistencia->fecha)->format('H:i:s')); ?></td>
                                            <td><?php echo e($asistencia->nrsesiones); ?></td>
                                            <td><?php echo e($asistencia->modalidad); ?></td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Segunda columna: Subir imagen de anuncios -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card shadow-lg" style="border-radius: 20px;">
                            <div class="card-body p-4">
                                <button class="btn btn-primary" data-toggle="modal" data-target="#modalSubirImagen">
                                    Subir Anuncio
                                </button>
                    
                                <!-- Mostrar imagen subida aquí -->
                                <div id="mostrarImagen">
                                    <?php
                                        $directorioAnuncios = public_path('anuncios');
                                        $archivos = \Illuminate\Support\Facades\File::files($directorioAnuncios);
                                        if (count($archivos) > 0) {
                                            $imagenGuardada = basename($archivos[0]);
                                        } else {
                                            $imagenGuardada = null;
                                        }
                                    ?>
                    
                                    <?php if($imagenGuardada): ?>
                                        <img src="<?php echo e(asset('anuncios/' . $imagenGuardada)); ?>" class="img-fluid mt-3" alt="Anuncio">
                                    <?php endif; ?>
                                </div>
                    
                                <!-- Modal para subir imagen -->
                                <div class="modal fade" id="modalSubirImagen" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel">Subir Anuncio</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Formulario para subir la imagen -->
                                                <form id="formSubirImagen" enctype="multipart/form-data">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="form-group">
                                                        <label for="imagenAnuncio">Seleccionar imagen</label>
                                                        <input type="file" class="form-control" id="imagenAnuncio" name="imagenAnuncio" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Subir</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Fin del modal -->
                            </div>
                        </div>
                    </div>
                </div> <!-- Fin de la fila -->
            </div>
        </div>
    </div>
</div>

<!-- Agregar el enlace a Google Fonts para la fuente Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<!-- Estilos personalizados -->
<style>
    .card {
        background-color: #ffffff;
        border: none;
        border-radius: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    /* Hover en la tabla */
    .asistencia-row:hover {
        background-color: #b2dfdb !important;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    th, td {
        padding: 12px;
        border: none;
    }

    .card-body {
        background-color: #e0f7fa;
        border-radius: 15px;
    }

    thead tr th {
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Animación al hacer hover en el botón de subir anuncio */
    .btn-primary:hover {
        background-color: #00796b;
        transition: background-color 0.3s ease;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Función para actualizar la tabla de asistencias
    function actualizarTablaAsistencias() {
        $.ajax({
            url: "/obtener-asistencias", // Ruta Laravel para obtener las asistencias más recientes
            method: "GET",
            success: function(response) {
                $('#tablaAsistencias').empty();
                response.forEach(function(asistencia) {
                    $('#tablaAsistencias').append(
                        '<tr class="asistencia-row">' +

                            '<td>' + asistencia.nombre + ' ' + asistencia.apellido + ' ' + asistencia.apellidoMat + '</td>' +
                            '<td>' + new Date(asistencia.fecha).toLocaleTimeString() + '</td>' +
                            '<td>' + asistencia.nrsesiones + '</td>' +
                            '<td>' + asistencia.modalidad + '</td>' +
                        '</tr>'
                    );
                });
            }
        });
    }

    setInterval(function() {
        if (document.visibilityState === 'visible') {
            actualizarTablaAsistencias();
        }
    }, 5000);

    $(document).ready(function() {
    actualizarTablaAsistencias();

    // Manejar la subida de imagen con AJAX
    $('#formSubirImagen').on('submit', function(event) {
        event.preventDefault();
        
        var formData = new FormData(this);
        
        $.ajax({
            url: '/subir-anuncio',  // Ruta Laravel para manejar la subida
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Mostrar la imagen subida debajo del botón
                $('#mostrarImagen').html('<img src="/anuncios/' + response.nombreImagen + '" class="img-fluid mt-3" alt="Anuncio">');
                
                // Usamos la función personalizada para cerrar el modal
                setTimeout(function() {
                    cerrarModal();  // Llamar a la función que fuerza el cierre del modal
                }, 500);  // Cerrar el modal después de 500ms para dar tiempo a mostrar el cambio
            },
            error: function(xhr, status, error) {
                console.log('Error al subir la imagen:', error);
            }
        });
    });

    
    // Función para cerrar el modal manualmente
    function cerrarModal() {
        $('#modalSubirImagen').modal('hide'); // Cerrar el modal
        $('.modal-backdrop').remove(); // Eliminar el fondo del modal
        $('body').removeClass('modal-open'); // Eliminar la clase que evita el scroll
        $('body').css('padding-right', ''); // Restablecer el padding
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>