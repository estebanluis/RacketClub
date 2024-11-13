
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper" style="background-color: #e0f7fa;">
    <div class="content-header">
        <div class="content">
            <div class="container-fluid p-0"> <!-- Elimina márgenes -->

                <!-- Contenedor principal en grid -->
                <div class="grid-container">
                    
                    <!-- Item 1: Tablón de Anuncios -->
                    <div class="item1">
                        <div class="">
                            <div class="card shadow-lg" style="border-radius: 20px; height: 700px;">
                                <div class="card-body p-4 text-center">
                                    <h2 style="color: #00796b; font-family: 'Poppins', sans-serif;">Tablón de Anuncios</h2>
                                    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalSubirArchivo">
                                        Subir Anuncios
                                    </button>
    
                                    <!-- Carrusel de imágenes y videos -->
                                    <div id="carouselAnuncios" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                                $directorioAnuncios = public_path('anuncios');
                                                $archivos = \Illuminate\Support\Facades\File::files($directorioAnuncios);
                                            ?>
    
                                            <?php if(count($archivos) > 0): ?>
                                                <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $archivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="carousel-item <?php echo e($index === 0 ? 'active' : ''); ?>">
                                                        <?php if(Str::endsWith($archivo, ['.mp4', '.webm', '.ogg'])): ?>
                                                            <video class="d-block w-100" controls style="max-height: 500px;">
                                                                <source src="<?php echo e(asset('anuncios/' . basename($archivo))); ?>" type="video/<?php echo e(pathinfo($archivo, PATHINFO_EXTENSION)); ?>">
                                                                Tu navegador no soporta la reproducción de videos.
                                                            </video>
                                                        <?php else: ?>
                                                            <img src="<?php echo e(asset('anuncios/' . basename($archivo))); ?>" class="d-block w-100" alt="Anuncio" style="max-height: 500px;">
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                                <div class="carousel-item active">
                                                    <p>No hay anuncios disponibles</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <a class="carousel-control-prev" href="#carouselAnuncios" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carouselAnuncios" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items 2 al 9: Cards de Asistencia en #cardsAsistencias -->
                    <div id="cardsAsistencias" class="item2-to-item9">
                        <?php $__currentLoopData = $asistencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $asistencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="small-box bg-info" style="border-radius: 5px; text-align: center; color: #ffffff;">
                                <div class="inner">
                                    <p><?php echo e($asistencia->nombre); ?> <?php echo e($asistencia->apellido); ?> <?php echo e($asistencia->apellidoMat); ?></p>
                                    <p>Sesiones restantes: <?php echo e($asistencia->nrsesiones); ?></p>
                                    <p><?php echo e($asistencia->modalidad); ?></p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-circle"></i>
                                </div>
                                <a href="" class="small-box-footer">
                                    <?php echo e(\Carbon\Carbon::parse($asistencia->fecha)->format('H:i:s')); ?>

                                    <i class="fa fa-check-circle"></i>
                                </a>
                            </div>
                            <?php if($index + 2 >= 9): ?>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal para subir archivo -->
<div class="modal fade" id="modalSubirArchivo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Subir Archivos para el Anuncio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSubirArchivo" enctype="multipart/form-data" method="POST" action="<?php echo e(route('subir.anuncios')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label for="archivosAnuncio">Seleccionar hasta 3 archivos (imágenes o videos)</label>
                        <input type="file" class="form-control" id="archivosAnuncio" name="archivosAnuncio[]" multiple accept="image/*,video/*" required>
                    </div>
                    <button type="submit" class="btn btn-success">Subir Archivos</button>
                    <?php if(session('success')): ?>
                         <div class="alert alert-success">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

<style>
    .grid-container {
        display: grid;
        grid-template-columns: repeat(6, auto);
        gap: 10px;
        padding: 10px;
    }

    .grid-container > div {
        text-align: center;
        padding: 20px;
    }

    .item1 {
        grid-area: 1 / 2 / 5 / 7;
    }

    .item2-to-item9 > .small-box {
        margin-bottom: 10px;
    }

    .small-box .inner p {
        margin: 0;
        line-height: 1.2;
    }
    
    .carrusel-responsive {
        height: auto;
        max-height: 500px;
    }

    .img-carrusel, .video-carrusel {
        object-fit: cover;
        width: 100%;
        max-height: 400px;
    }

    @media (max-width: 768px) {
        .carrusel-responsive {
            max-height: 300px;
        }
        .img-carrusel, .video-carrusel {
            max-height: 200px;
        }
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function actualizarCardsAsistencias() {
        $.ajax({
            url: "/obtener-asistencias",
            method: "GET",
            success: function(response) {
                $('#cardsAsistencias').empty();  // Vaciar contenedor antes de actualizar
                response.slice(0, 8).forEach(function(asistencia) {  // Limitar a 8 cards
                    $('#cardsAsistencias').append(`
                        <div class="small-box bg-info" style="border-radius: 5px; text-align: center; color: #ffffff;">
                            <div class="inner">
                                <p>${asistencia.nombre} ${asistencia.apellido} ${asistencia.apellidoMat}</p>
                                <p>Sesiones restantes: ${asistencia.nrsesiones}</p>
                                <p>${asistencia.modalidad}</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-circle"></i>
                            </div>
                            <a href="" class="small-box-footer">
                                ${new Date(asistencia.fecha).toLocaleTimeString()}
                                <i class="fa fa-check-circle"></i>
                            </a>
                        </div>
                    `);
                });
            }
        });
    }

    // Actualizar cada 5 segundos cuando la pestaña está visible
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            actualizarCardsAsistencias();
        }
    }, 5000);
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>