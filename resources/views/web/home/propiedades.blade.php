@extends('web.layouts.app')
@section('content')

<style>
    .property-description {
        max-width: 500px;
        /* Ajusta según sea necesario */
        overflow: hidden;
        /* Oculta el desbordamiento */
        display: -webkit-box;
        /* Para navegadores WebKit */
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
        /* Cambia a 3 para limitar a 3 líneas */
        line-height: 1.5;
        /* Ajusta la altura de línea según sea necesario */
    }

    .property-card-text {
        margin: 0;
        /* Elimina márgenes por defecto */
    }
</style>
<!--============================== Breadcumb ============================== -->
<div class="breadcumb-wrapper " data-bg-src="/web/assets/img/bg/breadcumb-bg.jpg">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Propiedades</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="/">Principal</a></li>
                        <li>Propiedades</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--============================== Property Page Area ==============================-->
<section class="space-top space-extra-bottom">
    <div class="container">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="rent-tab-pane" role="tabpanel" aria-labelledby="rent-tab"
                tabindex="0">
                <form class="property-search-form" action="{{ route('propiedades.buscar') }}" id="searchForm">
                    @csrf
                    <div class="form-group">
                        <i class="far fa-search"></i>
                        <input class="form-control" type="text" id="query" name="query" placeholder="Texto a buscar"
                            value="{{ $query ?? '' }}">
                    </div>
                    <select class="form-select" name="tipo_id">
                        <option value="" selected>Tipo de Propiedad</option>
                        @foreach ($tipos as $tipo)
                        <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                        @endforeach
                    </select>
                    <select class="form-select" name="ciudad">
                        <option value="" selected>ciudad</option>
                        @foreach ($ciudades as $ciudad)
                        <option value="{{ $ciudad }}">{{ $ciudad }}</option>
                        @endforeach
                    </select>
                    <button class="th-btn" type="submit"><i class="far fa-search"></i> Buscar</button>
                </form>
            </div>
        </div>

        <div class="th-sort-bar">
            <div class="row justify-content-between align-items-center">
                <div class="col-md"></div>
                <div class="col-md-auto">
                    <div class="sorting-filter-wrap">
                        <div class="nav" role=tablist>
                            <a href="#" id="tab-shop-list" data-bs-toggle="tab" data-bs-target="#tab-list" role="tab"
                                aria-controls="tab-grid" aria-selected="false"><i class="fa-light fa-grid-2"></i></a>
                            <a class="active" href="#" id="tab-shop-grid" data-bs-toggle="tab"
                                data-bs-target="#tab-grid" role="tab" aria-controls="tab-grid" aria-selected="true"><i
                                    class="fa-solid fa-list"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
        use App\Models\Image;
        @endphp
        <div class="tab-content" id="nav-tabContent">
            @if (count($propiedades) >= 1)
            <div class="tab-pane fade" id="tab-list" role="tabpanel" aria-labelledby="tab-shop-list">
                <div class="row gy-40">
                    @foreach($propiedades as $propiedad)
                    @php
                    $imagen = Image::where('id_propiedad', $propiedad->id)->where('tipo', '!=', '360')->first();
                    @endphp
                    <div class="col-md-6 col-xl-4">
                        <div class="property-card2">
                            <div class="property-card-thumb img-shine">
                                @if(!empty($imagen))
                                <img src="{{ route('propiedades.imagenes.ver', $imagen->id) }}" alt="img">
                                @else
                                <img src="/assets/img/casa.jpg" alt="img">
                                @endif
                            </div>
                            <div class="property-card-details">
                                <div class="media-left">
                                    <h4 class="property-card-title"><a href="#">{{ $propiedad->nombre }}</a></h4>
                                    <h5 class="property-card-price">{{ $propiedad->precio." ".$propiedad->moneda }}</h5>
                                    <p class="property-card-location">{{ $propiedad->direccion }}</p>
                                </div>
                                <div class="btn-wrap">
                                    <a href="{{ route('propiedades.detalle', $propiedad->id) }}"
                                        class="th-btn style-border2 th-btn-icon">Detalle</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="tab-pane fade active show" id="tab-grid" role="tabpanel" aria-labelledby="tab-shop-grid">
                @foreach($propiedades as $propiedad)
                @php
                $imagen = Image::where('id_propiedad', $propiedad->id)->where('tipo', 'casa_fuera')->first();
                $imagen360 = Image::where('id_propiedad', $propiedad->id)->where('tipo', '=', '360')->first();
                @endphp
                <div class="property-card-wrap style-dark">
                    <div>
                        @if(!empty($imagen))
                        <img src="{{ route('propiedades.imagenes.ver', $imagen->id) }}" alt="Imagen de propiedad"
                            style="object-fit: cover; height: 400px; width: 600px;">
                        @else
                        <img src="/assets/img/casa.jpg" alt="Imagen por defecto"
                            style="object-fit: cover; height: 400px; width: 600px;">
                        @endif
                    </div>
                    <div class="property-card style-dark">
                        <div class="property-card-details">
                            <span class="property-card-subtitle">{{ $propiedad->tipoPropiedad->descripcion }}</span>
                            <h4 class="property-card-title">{{ $propiedad->nombre }}</h4>
                            <div class="property-description">
                                <p class="property-card-text">{{ $propiedad->descripcion }}</p>
                            </div>
                            <div class="property-card-price-meta">
                                <h5 class="property-card-price">{{ $propiedad->precio." ".$propiedad->moneda }}</h5>
                            </div>
                            <div class="property-card-meta">
                                <span><i class="fa-solid fa-bed"></i>Dormitorios {{ $propiedad->num_dormitorios
                                    }}</span>
                                <span><i class="fa-solid fa-toilet"></i>Baños {{ $propiedad->num_banos }}</span>
                                <span><i class="fa-solid fa-warehouse"></i>Garajes {{ $propiedad->num_garajes }}</span>
                                <span><i class="fa-solid fa-up-right-and-down-left-from-center"></i>{{
                                    $propiedad->superficie_terreno }} m2</span>
                            </div>
                            <div class="property-btn-wrap">
                                @if(!empty($imagen360))
                                <a href="{{ url('/') }}/web/pannellum/pannellum.htm#panorama={{ route('propiedades.imagenes.ver', $imagen360->id) }}"
                                    target="_blank" class="th-btn style-border2 th-btn-icon">360º</a>
                                @endif
                                <a href="{{ route('usuario.citas.index', $propiedad->id) }}"
                                    class="th-btn style-border2 th-btn-icon">Solicitar cita</a>
                                <a href="{{ route('usuario.servicios.index.propiedad', $propiedad->id) }}"
                                    class="th-btn style-border2 th-btn-icon">Servicios</a>
                                <a href="{{ route('propiedades.detalle', $propiedad->id) }}"
                                    class="th-btn style-border2 th-btn-icon">Detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="display-1 d-flex justify-content-center align-items-center" style="height: 90%;">
                <h4 class="text-center">No existen propiedades disponibles</h4>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection