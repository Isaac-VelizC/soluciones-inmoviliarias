@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Detalles')

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
</style>
<div class="app-ecommerce">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">Detalles de la propiedad <strong>{{ $propiedad->nombre }}</strong> </h4>
            <p>Propietario <strong>{{ $propiedad->propietario->nombre .' '. $propiedad->propietario->apellido}}</strong>
            </p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <a href="{{ route('adm.servicios.agregar', $propiedad->id ) }}" class="btn btn-md btn-outline-primary">Registrar Servicio</a>
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
                    <h5 class="card-tile mb-0">Información de la propiedad existente </h5>
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
</script>
@endsection