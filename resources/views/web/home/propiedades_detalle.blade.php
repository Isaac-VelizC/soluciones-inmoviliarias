@extends('web.layouts.app')
@section('title', 'Detalles')

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
    
    .wrapper {
        display: inline-flex;
        list-style: none;
        height: 120px;
        width: 100%;
        padding-top: 40px;
        font-family: "Poppins", sans-serif;
        justify-content: center;
    }

    .wrapper .icon {
        position: relative;
        background: #fff;
        border-radius: 50%;
        margin: 10px;
        width: 50px;
        height: 50px;
        font-size: 18px;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
</style>
<div class="breadcumb-wrapper background-image" style="background-image: url('/web/assets/img/bg/breadcumb-bg.jpg');">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">{{ $propiedad->nombre }}</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="/">Home</a></li>
                        <li>{{ $propiedad->nombre }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@php
$n_i = $n_360 = 1;
@endphp
<section class="space-top space-extra-bottom arrow-wrap">
    <div class="container">
        <div class="slider-area property-slider1">
            <div class="swiper th-slider mb-4 swiper-fade swiper-initialized swiper-horizontal swiper-watch-progress swiper-backface-hidden"
                id="propertySlider"
                data-slider-options="{&quot;effect&quot;:&quot;fade&quot;,&quot;loop&quot;:true,&quot;thumbs&quot;:{&quot;swiper&quot;:&quot;.property-thumb-slider&quot;},&quot;autoplayDisableOnInteraction&quot;:&quot;true&quot;}">
                <div class="swiper-wrapper" id="swiper-wrapper-9ccaffcc2a6b6f6c" aria-live="off"
                    style="transition-duration: 0ms; transition-delay: 0ms;">
                    @foreach($imagenes as $imagen)
                    <div class="swiper-slide" role="group" aria-label="3 / 10" data-swiper-slide-index="{{ $n_i++ }}"
                        style="width: 100%; opacity: 1; transform: translate3d(-1296px, 0px, 0px); transition-duration: 0ms;">
                        <div class="property-slider-img">
                            <img src="{{ route('propiedades.imagenes.ver', $imagen->id) }}" alt="img">
                        </div>
                    </div>
                    @endforeach
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>
            <div class="swiper th-slider property-thumb-slider swiper-initialized swiper-horizontal swiper-backface-hidden swiper-thumbs"
                data-slider-options="{&quot;effect&quot;:&quot;slide&quot;,&quot;loop&quot;:true,&quot;breakpoints&quot;:{&quot;0&quot;:{&quot;slidesPerView&quot;:2},&quot;576&quot;:{&quot;slidesPerView&quot;:&quot;2&quot;},&quot;768&quot;:{&quot;slidesPerView&quot;:&quot;3&quot;},&quot;992&quot;:{&quot;slidesPerView&quot;:&quot;3&quot;},&quot;1200&quot;:{&quot;slidesPerView&quot;:&quot;4&quot;}},&quot;autoplayDisableOnInteraction&quot;:&quot;true&quot;}">
                <div class="swiper-wrapper" id="swiper-wrapper-42b106fc6491db754" aria-live="off"
                    style="transform: translate3d(-990px, 0px, 0px); transition-duration: 0ms; transition-delay: 0ms;">
                    @php
                    $n_i = 1;
                    @endphp
                    @foreach($imagenes as $imagen)
                    <div class="swiper-slide" role="group" aria-label="6 / 10" data-swiper-slide-index="{{ $n_i++ }}"
                        style="margin-right: 24px;">
                        <div class="property-slider-img">
                            <img src="{{ route('propiedades.imagenes.ver', $imagen->id) }}" alt="Image">
                        </div>
                    </div>
                    @endforeach
                </div>
                <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
            </div>

            <button data-slider-prev="#propertySlider" class="slider-arrow style3 slider-prev"><img
                    src="/web/assets/img/icon/arrow-left.svg" alt="icon"></button>
            <button data-slider-next="#propertySlider" class="slider-arrow style3 slider-next"><img
                    src="/web/assets/img/icon/arrow-right.svg" alt="icon"></button>
        </div>
        <div class="row gx-30">
            <div class="col-xxl-8 col-lg-7">
                <div class="property-page-single">
                    <div class="page-content">
                        <div class="property-meta mb-30">
                            <a href="#"><img src="/web/assets/img/icon/calendar.svg" alt="img">{{
                                $propiedad->fecha_listado }}</a>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-3">
                                <h2 class="page-title">Ciudad</h2>
                                <p class="mb-30">{{ $propiedad->ciudad }}</p>
                            </div>
                            <div class="col-12 col-md-3">
                                <h2 class="page-title">Direccion</h2>
                                <p class="mb-30">{{ $propiedad->direccion }}</p>
                            </div>
                            <div class="col-12 col-md-3">
                                <h2 class="page-title">Tipo</h2>
                                <p class="mb-30">{{ $propiedad->tipoPropiedad->descripcion }}</p>
                            </div>
                            <div class="col-12 col-md-3">
                                <h2 class="page-title">Estado</h2>
                                <p class="mb-30">{{ $propiedad->estatus }}</p>
                            </div>
                        </div>
                        <h2 class="page-title">Acerca de la Propiedad</h2>
                        <p class="mb-30">{{ $propiedad->descripcion }}</p>
                        <h2 class="page-title mb-20">Detalle</h2>
                        <ul class="property-grid-list">
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-2.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Tipo</h4>
                                    <p class="property-grid-list-text">{{ ucfirst($propiedad->tipo_traspaso) }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-3.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Cuartos</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->num_habitaciones }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-4.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Dormitorios</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->num_dormitorios }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-11.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Cocinas</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->num_cocinas }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-5.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Baños</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->num_banos }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-7.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Superficie</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->superficie_terreno }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-7.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Construida</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->superficie_construida }}</p>
                                </div>
                            </li>
                            <li>
                                <div class="property-grid-list-icon">
                                    <img src="/web/assets/img/icon/property-single-icon1-4.svg" alt="img">
                                </div>
                                <div class="property-grid-list-details">
                                    <h4 class="property-grid-list-title">Salas</h4>
                                    <p class="property-grid-list-text">{{ $propiedad->num_salas }}</p>
                                </div>
                            </li>
                        </ul>
                        <h3 class="page-title mt-50 mb-30">Galeria 360</h3>

                        <!-- Pannellum CSS -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
                        <!-- Pannellum JS -->
                        <script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>

                        <div>
                            @foreach ($imagen360 as $imagen)
                            <img src="{{ route('propiedades.imagenes.ver', $imagen->id) }}" alt="Imagen 360" width="100"
                                height="50" onclick="changeScene({{ $imagen->id }})" class="cursor-pointer">
                            @endforeach
                        </div>
                        <div id="panorama" style="width: 100%; height: 500px;"></div>

                        <h3 class="page-title mt-45 mb-30">Ubicación </h3>
                        <div class="location-map">
                            <div class="contact-map">
                                <iframe
                                    src="https://www.google.com/maps?q={{ $propiedad->latitud }},{{ $propiedad->longitud }}&hl=es;z=15&output=embed"
                                    allowfullscreen="" loading="lazy" zoom={{15}}></iframe>
                            </div>
                            <div class="location-map-address">
                                <div class="thumb">
                                    @if ($imagenCasa)
                                    <img src="{{ route('propiedades.imagenes.ver', $imagenCasa->id) }}" alt="Casa">
                                    @else
                                    <img src="/web/assets/img/property/property_inner_1.jpg" alt="img">
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h4 class="title">Direccion:</h4>
                                    <p class="text">{{ $propiedad->direccion }}, {{ $propiedad->ciudad }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-lg-5">
                <aside class="sidebar-area">
                    <div class="widget widget-property-contact">
                        <h4 class="widget_subtitle">Venta</h4>
                        <h4 class="widget_price">{{ $propiedad->precio." ".$propiedad->moneda }}</h4>
                        <form action="#" class="widget-property-contact-form">
                            <a href="{{ route('usuario.citas.index', $propiedad->id) }}"
                                class="th-btn style-white th-btn-icon mt-15">Solicitar Cita</a>
                        </form>
                    </div>
                </aside>
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

        // Cambia la escena al hacer clic en una imagen
        function changeScene(id) {
            var sceneId = "scene_" + id;
            if (scenes[sceneId]) {
                viewer.loadScene(sceneId);
            } else {
                console.error("Escena no encontrada:", sceneId);
            }
        }
    </script>

</section>
@endsection