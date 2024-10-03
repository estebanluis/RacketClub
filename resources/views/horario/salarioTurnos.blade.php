@extends('template.main')
@section('title', 'Agregar/Editar Salario')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item"><a href="/turnos">Turnos Trabajados</a></li>
                        <li class="breadcrumb-item active">@yield('title')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="text-right">
                                <a href="/turnos" class="btn btn-warning btn-sm"><i class="fa-solid fa-arrow-rotate-left"></i> Atras</a>
                            </div>
                        </div>
                        <form action="{{ route('turnos.salario.actualizar', ['idHorario' => $horario->idHorario]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Nombre" value="{{ old('name', $usuario->name) }}" required>
                                            @error('name')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>
                                            <input type="text" name="fecha" class="form-control @error('fecha') is-invalid @enderror" id="fecha" value="{{ old('fecha', $horario->fecha ?? \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                                            @error('fecha')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="hora">Hora</label>
                                            <input type="text" name="hora" class="form-control @error('hora') is-invalid @enderror" id="hora" placeholder="Hora de Atención" value="{{ old('hora', $horario->hora) }}" required>
                                            @error('hora')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="carril">Nro Carril</label>
                                            <input type="number" name="carril" class="form-control @error('carril') is-invalid @enderror" id="carril" placeholder="Número de Carril" value="{{ old('carril', $horario->carril) }}" required>
                                            @error('carril')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="nalumnos">Nro Alumnos</label>
                                            <input type="number" name="nalumnos" class="form-control @error('nalumnos') is-invalid @enderror" id="nalumnos" placeholder="Número de Alumnos" value="{{ old('nalumnos', $horario->nalumnos) }}" required>
                                            @error('nalumnos')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="salario">Salario</label>
                                            <input type="number" name="salario" class="form-control @error('salario') is-invalid @enderror" id="salario" placeholder="Salario" value="{{ old('salario', $horario->salario) }}" required>
                                            @error('salario')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="observaciones">Observaciones</label>
                                            <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror" cols="10" rows="3" placeholder="Observaciones">{{ old('observaciones', $horario->observaciones ?? '') }}</textarea>
                                            @error('observaciones')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
