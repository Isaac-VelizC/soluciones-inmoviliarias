@extends('web.layouts.app_index')

@section('title', 'Main page')

@section('content')
@php
use App\Models\Image;
@endphp
<!--==============================
Hero Area
==============================-->
<div class="hero-1" id="hero">
    <div class="swiper th-slider hero-slider1" id="heroSlide1"
        data-slider-options='{"effect":"fade", "autoHeight": "true"}'>
        <div class="swiper-wrapper">
            @foreach ($propiedades as $propiedadCarousel)
            <div class="swiper-slide">
                <div class="hero-inner" data-mask-src="/web/assets/img/hero/hero_1_bg_mask.png">
                    @if ($propiedadCarousel->imagenes->isNotEmpty())
                    @php
                    $imagen = $propiedadCarousel->imagenes->first();
                    @endphp
                    <div class="th-hero-bg" data-bg-src="{{ route('propiedades.imagenes.ver', $imagen->id) }}">
                    </div>
                    @else
                    <div class="th-hero-bg" data-bg-src="/web/assets/img/hero/default_bg.jpg">
                    </div>
                    @endif
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div class="hero-style1">
                                    <h1 class="hero-title text-white">
                                        <span class="title1" data-ani="slideindown" data-ani-delay="0.3s">Propiedad en
                                            {{ $propiedadCarousel->ciudad }}</span>
                                    </h1>
                                    <div class="col-8">
                                        <div class="card"
                                            style="background-color: rgba(128, 128, 128, 0.5); border-radius: 15px;"
                                            data-ani="slideinup" data-ani-delay="0.5s">
                                            <div class="card-body">
                                                <h5 style="color: #071d88" data-ani="slideindown" data-ani-delay="0.4s">
                                                    {{ $propiedadCarousel->precio. ' '.$propiedadCarousel->moneda }}
                                                </h5>
                                                <p class=" text-white">🌍 {{ $propiedadCarousel->direccion }}</p>
                                                <p class="card-text text-white">
                                                    {{ "Ambientes: " . $propiedadCarousel->num_habitaciones }} -
                                                    {{ "Baños: " . $propiedadCarousel->num_banos }} -
                                                    {{ "Garaje: " . $propiedadCarousel->num_garajes }} -
                                                    {{ "Cocina: " . $propiedadCarousel->num_cocinas }} -
                                                    {{ "Dormitorio: " . $propiedadCarousel->num_dormitorios }} -
                                                    {{ "Sala: " . $propiedadCarousel->num_salas }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <a href="{{ route('propiedades.detalle', $propiedadCarousel->id) }}"
                                        class="th-btn btn-mask th-btn-icon" data-ani="slideinup"
                                        data-ani-delay="0.6s">Propiedades en venta</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!--======== / Hero Section ========-->

<div class="overflow-hidden space-top bg-theme" id="about-sec">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <div class="title-area">
                    <span class="shadow-title">Nosotros</span>
                    <h2 class="sec-title text-white">Acerca de Nosotros</h2>
                    <p class="sec-text text-white">
                        Porque no se trata de suerte, se trata de una decisión, y nosotros hacemos realidad el sueño de
                        tu nueva casa.
                    </p>
                </div>
            </div>
            <!--div-- class="col-lg-auto">
                <div class="sec-btn">
                    <a href="{{ route('nosotros.index') }}" class="th-btn btn-mask th-btn-icon">Ver Más</a>
                </div>
            </!--div-->
        </div>
        <div class="py-3 py-md-5">
            <div class="container">
                <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
                    <div class="col-12 col-lg-6 col-xl-5">
                        <img class="img-fluid rounded" loading="lazy"
                            src="https://espaciohr.com/wp-content/uploads/2024/05/Organigrama-de-una-inmobiliaria-1.jpg"
                            alt="Sobre nosotros">
                    </div>
                    <div class="col-12 col-lg-6 col-xl-7">
                        <div class="row justify-content-xl-center">
                            <div class="col-12 col-xl-11">
                                <h2 class="mb-3 text-white">¿Quiénes Somos?</h2>
                                <p class="lead fs-4 text-secondary mb-3">En Soluciones Inmobiliarias, transformamos
                                    sueños en realidades. Nuestro compromiso es ofrecer un servicio excepcional y
                                    personalizado a cada cliente.</p>
                                <p class="mb-5">Como una empresa en crecimiento, nos mantenemos fieles a nuestros
                                    valores fundamentales: colaboración, innovación y satisfacción del cliente. Siempre
                                    estamos buscando nuevas formas de mejorar nuestros servicios y adaptarnos a tus
                                    necesidades.</p>
                                <div class="row gy-4 gy-md-0 gx-xxl-5X">
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <div></div>
                                            <div>
                                                <h2 class="h4 mb-3 text-white">Marca Versátil</h2>
                                                <p class="text-secondary mb-0">Creamos métodos digitales que dan vida a
                                                    experiencias en todos los medios.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="d-flex">
                                            <div></div>
                                            <div>
                                                <h2 class="h4 mb-3 text-white">Agencia Digital</h2>
                                                <p class="text-secondary mb-0">Creemos en la innovación al fusionar
                                                    ideas simples con conceptos elaborados.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<section class="project-area-1 space overflow-hidden" data-bg-src="/web/assets/img/bg/project-bg-1-1.png"
    data-opacity="5" data-overlay="title">
    <div class="container-fluid">
        <div class="project-wrap1">
            <div class="row gy-40 justify-content-between align-items-center">
                <div class="col-xl-4">
                    <div class="project-title-wrap1">
                        <div class="title-area mb-40">
                            <span class="shadow-title">PROPIEDADES</span>
                            <h4 class="sec-title text-white">Descubre Tu Nuevo Hogar en Nuestras Propiedades Disponibles
                            </h4>
                            <p class="sec-text fs-5 text-white mt-15">
                                Disfruta de un estilo de vida moderno y sostenible. Nuestras Propiedades están diseñadas
                                para maximizar la luz natural y cuentan con paneles solares que reducen tu huella
                                ecológica.
                            </p>
                            <div class="btn-wrap mt-20">
                                <a href="{{ route('propiedades.index') }}" class="th-btn btn-mask th-btn-icon">Ver
                                    Propiedades</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="slider-area project-slider1">
                        <div class="swiper th-slider" id="projectSlider1"
                            data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"3"}}}'>
                            <div class="swiper-wrapper">
                                @foreach($propiedades as $propiedad)
                                @php
                                // Obtener la primera imagen que no sea del tipo '360'
                                $imagen = Image::where('id_propiedad', $propiedad->id)
                                ->where('tipo', '!=', '360')
                                ->first();
                                @endphp
                                <div class="swiper-slide">
                                    <div class="portfolio-card">
                                        <div class="portfolio-img img-shine"
                                            data-mask-src="/web/assets/img/shape/project-card1-img-mask.png"
                                            data-bs-toggle="modal" data-bs-target="#portfolioModal">
                                            <!-- Imagen de la propiedad o imagen por defecto -->
                                            <img src="{{ $imagen ? route('propiedades.imagenes.ver', $imagen->id) : '/assets/img/casa.jpg' }}"
                                                alt="{{ $imagen ? 'Project ' . $imagen->id : 'Imagen por defecto' }}">

                                            <div class="portfolio-card-shape"
                                                data-mask-src="/web/assets/img/shape/project-card1-img-mask.png">
                                                <img src="/web/assets/img/project/project_shape1_1.png" alt="img">
                                            </div>
                                        </div>
                                        <div class="portfolio-content">
                                            <a href="#portfolioModal" data-bs-toggle="modal"
                                                data-bs-target="#portfolioModal" class="icon-btn">
                                                <img src="/web/assets/img/icon/arrow-right.svg" alt="Ver más">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="service-area-1 overflow-hidden space-bottom bg-theme pt-80" id="service-sec">
    <div class="container">
        <div class="row gy-40">
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-card-icon">
                        <div class="icon">
                            <img src="/web/assets/img/icon/service-icon1-1.png" alt="Icon">
                        </div>
                    </div>
                    <div class="box-content">
                        <h3 class="box-title"><a href="property-details.html">Experiencia</a></h3>
                        <p class="box-text">Más de 10 años ayudando a nuestros clientes a encontrar su hogar ideal.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-card-icon">
                        <div class="icon">
                            <img src="/web/assets/img/icon/service-icon1-2.png" alt="Icon">
                        </div>
                    </div>
                    <div class="box-content">
                        <h3 class="box-title"><a href="property-details.html">Servicios Completos</a></h3>
                        <p class="box-text">Ofrecemos un servicio integral para la compra, venta y gestión de
                            propiedades.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="service-card">
                    <div class="service-card-icon">
                        <div class="icon">
                            <img src="/web/assets/img/icon/service-icon1-3.png" alt="Icon">
                        </div>
                    </div>
                    <div class="box-content">
                        <h3 class="box-title"><a href="property-details.html">Confianza</a></h3>
                        <p class="box-text">Construimos relaciones duraderas basadas en la confianza y la transparencia.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection