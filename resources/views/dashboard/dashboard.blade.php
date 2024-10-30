@extends('template.main')
@section('title', 'Dashboard')
@section('content')

<div class="content-wrapper" style="background-color: #e0f7fa;">
    <div class="content-header">
        <div class="content">
            <div class="container-fluid p-0"> <!-- Elimina márgenes -->

                <!-- Contenedor principal en grid -->
                <div class="grid-container">
                    
                    <!-- Item 1: Tablón de Anuncios -->
                    <div class="item1">
                        <div class="card shadow-lg mb-4" style="border-radius: 20px; height: 700px;">
                            <div class="card-body p-4 text-center">
                                <h2 style="color: #00796b; font-family: 'Poppins', sans-serif;">Tablón de Anuncios</h2>
                                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalSubirImagen">
                                    Subir Anuncio
                                </button>

                                <div id="mostrarImagen">
                                    @php
                                        $directorioAnuncios = public_path('anuncios');
                                        $archivos = \Illuminate\Support\Facades\File::files($directorioAnuncios);
                                        $imagenGuardada = count($archivos) > 0 ? basename($archivos[0]) : null;
                                    @endphp

                                    @if ($imagenGuardada)
                                        <img src="{{ asset('anuncios/' . $imagenGuardada) }}" class="img-fluid" alt="Anuncio" style="max-height: 500px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items 2 al 9: Cards de Asistencia en #cardsAsistencias -->
                    <div id="cardsAsistencias" class="item2-to-item9">
                        @foreach ($asistencias as $index => $asistencia)
                            <div class="small-box bg-info" style="border-radius: 5px; text-align: center; color: #ffffff;">
                                <div class="inner">
                                    <p>{{ $asistencia->nombre }} {{ $asistencia->apellido }} {{ $asistencia->apellidoMat }}</p>
                                    <p>Sesiones restantes: {{ $asistencia->nrsesiones }}</p>
                                    <p>{{ $asistencia->modalidad }}</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-user-circle"></i>
                                </div>
                                <a href="/registerUser" class="small-box-footer">
                                    {{ \Carbon\Carbon::parse($asistencia->fecha)->format('H:i:s') }}
                                    <i class="fa fa-check-circle"></i>
                                </a>
                            </div>
                            @if ($index + 2 >= 9)
                                @break
                            @endif
                        @endforeach
                    </div>

                </div>

            </div>
        </div>
    </div>
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
                <form id="formSubirImagen" enctype="multipart/form-data">
                    @csrf
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
        grid-area: 1 / 2 / 5 / 6;
    }

    .item2-to-item9 > .small-box {
        margin-bottom: 10px;
    }

    .small-box .inner p {
        margin: 0;
        line-height: 1.2;
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

@endsection
