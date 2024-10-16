
<?php $__env->startSection('title', 'Dashboard'); ?>
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
                            <li class="breadcrumb-item"><a href="/"><?php echo $__env->yieldContent('title'); ?></a></li>

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
                    <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                    <div class="col-lg-3 col-md-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Registrar Usuarios</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-car"></i>
                            </div>
                            <a href="/registerUser" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        
                    </div>
                    <!-- ./col -->
                    <?php endif; ?>

                    <div class="col-lg-3 col-md-6">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Registrar Alumno</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                            </div>
                            <a href="/registrarAlumno" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-md-6">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Asistencia de alumno</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/dashboard/tomarAsistencia" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Reportes financieros</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/reporte" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Lista Alumnos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/barang" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Registrar Horarios</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                            </div>
                            <a href="/horarios" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Turnos Trabajados</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                            </div>
                            <a href="/turnos" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- /.content -->
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/dashboard/dashboard.blade.php ENDPATH**/ ?>