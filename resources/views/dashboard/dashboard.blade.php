@extends('template.main')
@section('title', 'Dashboard')
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title')</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">@yield('title')</a></li>

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
                    @if(Auth::user()->TipoUsuario === 'Administrador')
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
                    @endif

                    <div class="col-lg-3 col-md-6">
                        @if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion')
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Registrar Alumno</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                            </div>
                            <a href="/registrarAlumno" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        @endif
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-md-6">
                        @if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion')
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Asistencia de alumno</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/dashboard/tomarAsistencia" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        @endif
                    </div>

                    <div class="col-lg-3 col-md-6">
                        @if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion')
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Lista Alumnos</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="/barang" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-6">
                        @if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion')
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Registrar Horarios</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                            </div>
                            <a href="/horarios" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-6">
                        @if(Auth::user()->TipoUsuario === 'Administrador' || Auth::user()->TipoUsuario === 'Secretaria Natacion')
                        <div class="small-box bg-info">
                            <div class="inner">
                                <p>Turnos Trabajados</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-address-book" aria-hidden="true"></i>
                            </div>
                            <a href="/turnos" class="small-box-footer">Mas informacion <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                        @endif
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <!-- /.content -->
    </div>

@endsection
