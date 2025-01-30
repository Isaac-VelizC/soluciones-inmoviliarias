@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Detalles')


@section('og_title', $propiedad->nombre)
@section('og_description', $message)
@php
$og_img = asset('web/Soluciones_Inmobiliarias.webp');
if($portadaPublic){
$og_img = route('propiedades.imagenes.ver', $portadaPublic->id);
}
@endphp
@section('og_image', $og_img)
@section('og_url', $urlPublic)

@section('content')
<!-- Pannellum CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<!-- Pannellum JS -->
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

<style>
    .custom-hotspot {
        width: 20px;
        height: 20px;
        background-color: black;
        border-radius: 50%;
        border: 3px solid white;
    }

    .property-slider-img {
        width: 100%;
        height: 550px;
        /* Ajusta según lo que necesites */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .property-slider-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        /* Cubre el div sin deformarse */
        object-position: center;
        /* Centra la imagen dentro del contenedor */
    }

    /* Miniaturas */
    .property-thumb-slider .swiper-slide {
        width: 100%;
        height: 140px;
        /* Altura fija de miniaturas */
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .property-thumb-slider .swiper-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        cursor: pointer;
        border-radius: 5px;
        transition: transform 0.3s ease-in-out;
    }

    .button-facebook {
        background: transparent;
        position: relative;
        padding: 1px 10px;
        display: flex;
        align-items: center;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid #0163E0;
        border-radius: 25px;
        outline: none;
        overflow: hidden;
        color: #0163E0;
        text-align: center;
    }

    .button-facebook svg {
        fill: #0163E0;
        height: 25px;
        width: 25px;
    }

    .button-facebook span {
        margin: 10px;
    }
</style>

<div class="app-ecommerce">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">Detalles de la propiedad <strong>{{ $propiedad->nombre }}</strong> </h4>
            <p>Propietario <strong>{{ $propiedad->propietario->nombre .' '. $propiedad->propietario->apellido}}</strong>
            </p>
        </div>

        @if(session('error'))
        <div class="alert alert-error" role="alert">
            {{ session('error') }}
        </div>
        @endif
        <div class="d-flex align-content-center flex-wrap gap-3">
            <button type="button" onclick="abrirModalDeletePropiedad()"
                class="btn btn-md btn-outline-danger">Eliminar</button>
            <a href="{{ route('adm.servicio.solicitud', $propiedad->id ) }}"
                class="btn btn-md btn-outline-primary">Solicitudes</a>
            <a href="{{ route('adm.servicios.agregar', $propiedad->id ) }}"
                class="btn btn-md btn-outline-primary">Servicio</a>
            <a href="{{ route('adm.subir.imagenes', $propiedad->id ) }}" class="btn btn-outline-secondary">Imagenes</a>
            <a href="{{ route('adm.propiedades.editar', $propiedad->id) }}" id="submitBtn"
                class="btn btn-primary">Editar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Detalles de la Propiedad</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre de la propiedad:</strong> {{ $propiedad->nombre }}
                        </li>
                        <li class="list-group-item"><strong>Propietario:</strong> {{ $propiedad->propietario->nombre . '
                            ' . $propiedad->propietario->apellido }}</li>
                        <li class="list-group-item"><strong>Teléfono:</strong> {{ $propiedad->propietario->telefono }}
                        </li>
                        <li class="list-group-item"><strong>Dirección:</strong> {{ $propiedad->direccion }}</li>
                        <li class="list-group-item"><strong>Ciudad:</strong> {{ $propiedad->ciudad }}</li>
                        <li class="list-group-item"><strong>Tipo de Propiedad:</strong> {{ $propiedad->tipo_propiedad }}
                        </li>
                        <li class="list-group-item"><strong>Tipo de Venta:</strong> {{ $propiedad->tipo_traspaso }}</li>
                        <li class="list-group-item"><strong>Superficie Construida:</strong> {{
                            $propiedad->superficie_construida }} m²</li>
                        <li class="list-group-item"><strong>Superficie Terreno:</strong> {{
                            $propiedad->superficie_terreno }} m²</li>
                        <li class="list-group-item"><strong>Publicidad:</strong> {{ $propiedad->publicidad_estado }}
                        </li>
                        <li class="list-group-item"><strong>Precio:</strong> {{ $propiedad->precio . ' ' .
                            $propiedad->moneda }}</li>
                        <li class="list-group-item"><strong>Estado:</strong> {{ $propiedad->estatus }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="card-tile mb-0">Información de la propiedad existente </h5>
                        <a class="button-facebook" href="{{ $shareLinks['facebook'] }}" target="_blank" data-network="facebook">
                            <svg fill="#ffffff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path
                                        d="M12 2.03998C6.5 2.03998 2 6.52998 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.84998C10.44 7.33998 11.93 5.95998 14.22 5.95998C15.31 5.95998 16.45 6.14998 16.45 6.14998V8.61998H15.19C13.95 8.61998 13.56 9.38998 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96C15.9164 21.5878 18.0622 20.3855 19.6099 18.57C21.1576 16.7546 22.0054 14.4456 22 12.06C22 6.52998 17.5 2.03998 12 2.03998Z">
                                    </path>
                                </g>
                            </svg>
                            <span>Facebook</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <span class="mdi mdi-home-city-outline"></span>
                        {{ "Ambientes: ".$propiedad->num_habitaciones }} -
                        <span class="mdi mdi-toilet"></span>
                        {{ "Baños: ".$propiedad->num_banos }} -
                        <span class="mdi mdi-garage-open-variant"></span>
                        {{ "Garaje: ".$propiedad->num_garajes }} -
                        <span class="mdi mdi-countertop"></span>
                        {{ "Cocina: ".$propiedad->num_cocinas }} -
                        <span class="mdi mdi-bed-king-outline"></span>
                        {{ "Dormitorio: ".$propiedad->num_dormitorios }} -
                        <span class="mdi mdi-sofa-outline"></span>
                        {{ "Sala: ".$propiedad->num_salas }}
                    </p>
                    <div class="">
                        <p>{{ $propiedad->descripcion }}</p>
                    </div>
                    <h4>Imagenes</h4>
                    <div class="row">
                        @foreach ($propiedad->imagenes as $imagen)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img class="card-img-top"
                                    src="{{ route('adm.propiedades.imagenes.showImage', $imagen->id) }}" alt="Imagen"
                                    height={{ 70 }} style="object-fit: cover;">
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="card-title">{{ ucfirst($imagen->tipo) }}</h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div id="panorama" style="width: 100%; height: 400px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var scenes = {
        @foreach ($imagen360 as $imagen)
            "scene_{{ $imagen->id }}": {
                "type": "equirectangular",
                "panorama": "{{ route('propiedades.imagenes.ver', $imagen->id) }}",
                "autoLoad": true,
                "hotSpots": [
                    @foreach ($imagen->hotspots as $hotspot)
                        {
                            "pitch": {{ $hotspot->pitch }},
                            "yaw": {{ $hotspot->yaw }},
                            "type": "scene",
                            "text": "{{ $hotspot->nombre }}",
                            "sceneId": "scene_{{ $hotspot->targetScene }}",
                            "cssClass": "custom-hotspot"
                        },
                    @endforeach
                ]
            },
        @endforeach
    };

    // Inicializa el visor con la primera imagen
    var viewer = pannellum.viewer('panorama', {
        default: {
            firstScene: "scene_{{ $imagen360->first()->id ?? '' }}"
        },
        scenes: scenes
    });

    function abrirModalDeletePropiedad() {
        $('#modalDeletePropiedad').modal('show');
    }
</script>

<!-- Modal Eliminar propiedad -->
<div class="modal fade" id="modalDeletePropiedad" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Eliminar Propiedad</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('adm.propietarios.destroy', $propiedad->id )}}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Esat seguro de que quiere eliminar la propiedad {{ $propiedad->nombre }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-outline-danger" data-bs-dismiss="modal">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection