<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title'); ?> </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/assets/dist/css/adminlte.css">


    <!-- CSS de FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <!-- JS de FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>



</head>

<body class="hold-transition sidebar-mini ">

    <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="/" class="nav-link">Dashboard</a>
                </li>
                 -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <li class="nav-item d-none d-sm-inline-block">
                    <a  class="nav-link"><?php echo e(auth()->user()->name); ?></a>
                </li>
                <li class="nav-item">
                            <a class="nav-link log-out ml-3" href="#" class="nav-link">
                                <i class="nav-icon fa-solid fa-power-off" style="color: red;"></i>
                                <form action="/logout" method="POST" id="logging-out">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </a>
                </li>
                

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4 ">
            <!-- Brand Logo -->
            <a href="/dashboard" class="brand-link">
                <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">RacketClub</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="/" class="nav-link">
                                <i class="nav-icon fa-solid fa-gauge-high"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview <?php echo e(Request::is('registerUser') || Request::is('registrarAlumno') ? 'menu-open' : ''); ?>">
                            <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                <a href="#" class="nav-link <?php echo e(Request::is('registerUser') || Request::is('registrarAlumno') ? 'active' : ''); ?>">
                                    <i class="nav-icon fa fa-plus"></i>
                                    <p>
                                        Registros
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                            <a href="<?php echo e(route('luser.index')); ?>" class="nav-link <?php echo e(Request::is('luser') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-user-plus"></i>
                                                <p>Gestión de Usuarios</p>
                                            </a>
                                        <?php endif; ?>
                                    </li>
                                    <!--<li class="nav-item">
                                        <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                            <a href="/registrarAlumno" class="nav-link <?php echo e(Request::is('registrarAlumno') ? 'active' : ''); ?>">
                                                <i class="nav-icon fa fa-user-plus"></i>
                                                <p>Registrar Alumnos</p>
                                            </a>
                                        <?php endif; ?>
                                    </li>-->
                                </ul>
                            <?php endif; ?>
                        </li>


                        <li class="nav-item has-treeview">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' ): ?>
                            <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-plus"></i>
                                <p>
                                    Piscina
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                    <a href="/barang" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p>
                                             Gestion de Alumnos
                                        </p>
                                    </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                    <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                    <a href="/listaSeciones" class="nav-link">
                                        <i class="nav-icon fa fa-users"></i>
                                        <p>
                                            Lista Seciones
                                        </p>
                                    </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                    <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                        <a href="/dashboard/tomarAsistencia" class="nav-link">
                                            <i class="nav-icon fa fa-address-card"></i>
                                            <p>
                                                Asistencia de alumnos
                                            </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                    <?php if(Auth::user()->TipoUsuario === 'Administrador' ): ?>
                                        <a href="/horarios" class="nav-link">
                                            <i class="nav-icon fa fa-calendar-plus" aria-hidden="true"></i>
                                            <p>
                                                Registrar Horario
                                            </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                    <?php if(Auth::user()->TipoUsuario === 'Administrador' ): ?>
                                    <a href="/turnos" class="nav-link">
                                        <i class="nav-icon fa fa-briefcase"></i>
                                        <p>
                                            Turnos Trabajados
                                        </p>
                                    </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                    <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                        <a href="/piscinaFinde" class="nav-link">
                                                    <i class="nav-icon fa fa-handshake"></i>
                                                    <p>
                                                        Atencion Fin de semana
                                                    </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item has-treeview">
                        <?php if(Auth::user()->TipoUsuario === 'Administrador' ): ?>
                        <a href="#" class="nav-link">
                                <i class="nav-icon fa fa-plus"></i>
                                <p>
                                    Racket
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                <a href="/atenracket" class="nav-link">
                                            <i class="nav-icon fa fa-shopping-cart"></i>
                                            <p>
                                                Atencion Racket
                                            </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                    <?php if( Auth::user()->TipoUsuario === 'Administrador'): ?>
                                        <a href="/rcancha" class="nav-link">
                                            <i class="nav-icon fa fa-clipboard"></i>
                                            <p>
                                                Reservar Canchas
                                            </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            </ul>
                            <?php endif; ?>
                        </li>


                        <li class="nav-item has-treeview">
                            <?php if(Auth::user()->TipoUsuario === 'Administrador' ): ?>
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fa fa-plus"></i>
                                    <p>
                                        Ventas
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                <li class="nav-item">
                                <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                <a href="/ventas" class="nav-link">
                                            <i class="nav-icon fa fa-shopping-basket"></i>
                                            <p>
                                                Vender Productos
                                            </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                <li class="nav-item">
                                <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                                <a href="/dashboard/listaproductos" class="nav-link">
                                            <i class="nav-icon fa fa-list-ol" aria-hidden="true"></i>
                                            <p>
                                                Gestion de Productos
                                            </p>
                                        </a>
                                    <?php endif; ?>
                                </li>
                                </ul>
                            <?php endif; ?>
                        </li>

                        
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                            <a href="/barang" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Gestion De Alumnos
                                </p>
                            </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Administrador'): ?>
                            <a href="/reporte" class="nav-link">
                                <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                <p>
                                    Reporte Financiero
                                </p>
                            </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                                <a href="/dashboard/tomarAsistencia" class="nav-link">
                                    <i class="nav-icon fa fa-address-card"></i>
                                    <p>
                                        Asistencia de alumnos
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                                <a href="/horarios" class="nav-link">
                                    <i class="nav-icon fa fa-calendar-plus" aria-hidden="true"></i>
                                    <p>
                                        Registrar Horario
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                            <a href="/listaSeciones" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Lista Seciones
                                </p>
                            </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Profesor'): ?>
                                <a href="/hprof" class="nav-link">
                                    <i class="nav-icon fa-solid fa-box"></i>
                                    <p>
                                        Sueldos
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Profesor'): ?>
                                <a href="/tula" class="nav-link">
                                    <i class="nav-icon fa fa-briefcase"></i>
                                    <p>
                                        Horarios
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if( Auth::user()->TipoUsuario === 'Secretaria Racket'): ?>
                                <a href="/rcancha" class="nav-link">
                                    <i class="nav-icon fa fa-clipboard"></i>
                                    <p>
                                        Reservar Canchas
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                        <?php if( Auth::user()->TipoUsuario === 'Secretaria Racket'): ?>
                        <a href="/atenracket" class="nav-link">
                                    <i class="nav-icon fa fa-shopping-cart"></i>
                                    <p>
                                        Atencion Racket
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                        <?php if(Auth::user()->TipoUsuario === 'Secretaria Racket'): ?>
                        <a href="/ventas" class="nav-link">
                                    <i class="nav-icon fa fa-shopping-basket"></i>
                                    <p>
                                        Vender
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        
                        <li class="nav-item">
                        <?php if(Auth::user()->TipoUsuario === 'Secretaria Racket'): ?>
                        <a href="/dashboard/listaproductos" class="nav-link">
                                    <i class="nav-icon fa fa-shopping-basket"></i>
                                    <p>
                                        Gestion de Productos
                                    </p>
                                </a>
                            <?php endif; ?>
                        </li>
                        <li class="nav-item">
                            <?php if(Auth::user()->TipoUsuario === 'Secretaria Natacion'): ?>
                                <a href="/piscinaFinde" class="nav-link">
                                            <i class="nav-icon fa fa-handshake"></i>
                                            <p>
                                                Atencion Fin de semana
                                            </p>
                                </a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <?php echo $__env->yieldContent('content'); ?>

        <!-- Content Wrapper. Contains page content -->
        
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>
        <!-- /.control-sidebar -->


    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="/assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/assets/dist/js/adminlte.min.js"></script>
    <?php echo $__env->make('sweetalert::alert', ['cdn' => 'https://cdn.jsdelivr.net/npm/sweetalert2@9'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            var url = window.location;
            // Para el menú de la barra lateral
            $('ul.nav-sidebar a').filter(function() {
                return this.href == url;
            }).addClass('active');
    
            // Para el menú y treeview de la barra lateral
            $('ul.nav-treeview a').filter(function() {
                return this.href == url;
            }).parentsUntil(".nav-sidebar > .nav-treeview")
                .css({'display': 'block'})
                .addClass('menu-open').prev('a')
                .addClass('active');
        });
    
    </script>
    

    <script>
        $(document).ready(function() {
            $('#example1').DataTable({
                responsive: true,
                "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json"
        }
               
            });

        });
    </script>

    <script type="text/javascript">
        $(document).on('click', '#btn-delete', function(e) {
            e.preventDefault();
            var form = $(this).closest("form");
            Swal.fire({
                title: 'Esta Seguro ?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#82868b',
                confirmButtonText: 'Si, borrar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        });
    </script>

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

    <script>
        $(".log-out").on('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Esta seguro?',
                text: "No podras revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#7367f0',
                cancelButtonColor: '#82868b',
                confirmButtonText: 'Sí, cerrar sesión'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#logging-out').submit()
                }
            })
        });
    </script>

    <script>
        // Redirigir a la página de inicio de sesión si la sesión ha expirado
        setInterval(function() {
            $.get('/check-session', function(response) {
                if (response.expired) {
                    window.location.href = '/login'; // Cambia esto por la ruta correcta de tu login
                }
            });
        }, 60000); // Verifica cada 60 segundos
    </script>
    <script>
        $(document).ready(function() {
            $('#addAtencionModal').on('show.bs.modal', function() {
                const now = new Date();
                const horaActual = now.toTimeString().split(' ')[0].slice(0, 5); // Solo HH:MM
                document.getElementById('horaEntrada').value = horaActual;
            });
        });
    </script>

    

<?php echo $__env->yieldContent('scripts'); ?>



</body>

</html>
<?php /**PATH C:\xampp\htdocs\RacketClub\resources\views/template/main.blade.php ENDPATH**/ ?>