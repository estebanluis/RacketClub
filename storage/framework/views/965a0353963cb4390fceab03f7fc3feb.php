

<?php $__env->startSection('title', 'Registrar Usuarios'); ?>

<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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

    <div class="content">
        <div class="container-fluid">
            <div class="card-body">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <a href="/" class="h1"><b>Asistencia</b>Alumnos</a>
                    </div>
                    <div class="container">
                        <div class="card-container">
                            <div class="row">
                                <!-- Columna para el input de codigo de alumno y la informacion -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <h1 style="text-align: center;">CODIGO DE ALUMNO</h1>
                                        <form name="asistencia" action="<?php echo e(route('registrarAlumn.update')); ?>" method="POST" id="form-alumno">
                                            <?php echo csrf_field(); ?>
                                            <div class="form-group">
                                                <label style="margin-left: 30px" for="nombre">Codigo:</label>
                                                <input type="text" name="codigo" style="width: 365px; margin-left: 20px" id="codigo" class="form-control <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Nombre completo" required>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <button type="submit" style="margin-left: 20px; margin-bottom:20px" class="btn btn-primary btn-block">Enviar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Div de Informacion de Alumno movido debajo del input -->
                                    <div class="card mt-4">
                                        <h1 style="text-align: center;">INFORMACIÓN DE ALUMNO</h1>
                                        <p>
                                            <?php if(isset($messages)): ?>
                                            <div class="alert alert-primary" role="alert">
                                                <p style="text-align: center;"><?php echo e($messages['message']); ?></p>
                                                <p style="text-align: center;"><?php echo e($messages['message1']); ?></p>
                                                <p style="text-align: center;"><?php echo e($messages['message2']); ?></p>
                                            </div>
                                            <?php endif; ?>

                                            <!-- Mostrar el mensaje de error si existe -->
                                            <?php if(session('error')): ?>
                                                <div class="alert alert-danger" role="alert">
                                                    <p style="text-align: center;"><?php echo e(session('error')); ?></p>
                                                </div>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Columna para el calendario -->
                                <div class="col-md-6">
                                    <div class="card" style="width: 400px; height: 400px;"> <!-- Cambia el tamaño del card -->
                                        <h3 style="text-align: center;">Calendario de Asistencia</h3>
                                        <div id="calendar" ></div> <!-- El calendario se ajusta al contenedor -->
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <script>
                        // Enfocar automáticamente en el input cuando la página se cargue o se redirija a ella
                        document.addEventListener('DOMContentLoaded', function() {
                            document.getElementById('codigo').focus();
                        });

                        // Incluir FullCalendar JS y generar el calendario
                        var fechasAsistencia = <?php echo json_encode($fechasAsistencia ?? [], 15, 512) ?>;
                        document.addEventListener('DOMContentLoaded', function() {
                            var calendarEl = document.getElementById('calendar');
                            var calendar = new FullCalendar.Calendar(calendarEl, {
                                initialView: 'dayGridMonth',
                                events: fechasAsistencia, // Ahora siempre tendrá un valor
                                locale: 'es',
                                height: 500,  // Cambia la altura aquí
                                contentHeight: 550,  // Altura de contenido
                                aspectRatio: 0.5,  // Relación de aspecto del calendario
                                dayMaxEventRows: true, 
                                views: {
                                    dayGridMonth: {
                                        dayMaxEventRows: 2, 
                                    },
                                },
                            });
                            calendar.render();
                        });
                    </script>

                    <!-- Incluir FullCalendar JS y CSS -->
                    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css' rel='stylesheet' />
                    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>

                    <!-- Agrega un CSS personalizado para cambiar el tamaño de la letra -->
                    <style>
                        /* Tamaño de letra del calendario */
                        .fc-toolbar-title {
                            font-size: 1.2em;  /* Título del calendario */
                        }
                        .fc-daygrid-day-number {
                            font-size: 0.9em;  /* Tamaño de la fecha */
                        }
                        .fc-event-title {
                            font-size: 0.85em; /* Tamaño de los eventos */
                        }
                        /* Ajustar la altura de las celdas del calendario */
                        .fc-daygrid-day {
                            min-height: 50px;  /* Puedes ajustar este valor */
                        }
                    </style>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

                </div>
            </div>
        </div>
    </div>

</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/registrarAlumn/controlAlumn.blade.php ENDPATH**/ ?>