 
<?php $__env->startSection('title', 'Registrar Usuarios'); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">

    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

    <div class="content">
        <div class="container-fluid">
            
        <div class="card-body">

        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="/" class="h1"><b>Asistencia</b>Alumnos</a>
            </div>
            <div class="container">
    
    <div class="card-container">
        <div class="card">
            <h1>CODIGO DE ALUMNO</h1>
            <form name="asistencia" action="<?php echo e(route('registrarAlumn.update')); ?>" method="POST" id="form">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label for="nombre">Codigo:</label>
                    <input type="text" name="codigo" value="" id="codigo">
                </div>
                <div class="row">
                        

                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">enviar</button>
                        </div>

                    </div>
            </form>
        </div>
        <div class="card">
            <h1>INFORMACION DE ALUMNO</h1>
            <div></div>
            <p>
                <?php if(session('message')): ?> 
                    <div class="alert alert-primary" role="alert">
                        <?php echo e(session('message')); ?>

                    </div>
                <?php endif; ?> 
            </p>
        </div>
    </div>
</div>

<script>
    // Enfocar automáticamente en el input cuando la página se cargue o se redirija a ella
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('codigo').focus();
    });
</script>


        </div>

        </div>

        </div>
    </div>
  

</div>

<script src="/assets/plugins/jquery/jquery.min.js"></script>

<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/registrarAlumn/controlAlumn.blade.php ENDPATH**/ ?>