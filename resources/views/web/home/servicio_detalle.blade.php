@extends('web.layouts.app')

@section('title', 'Nosotros')
@section('content')
<div class="breadcumb-wrapper background-image"
    style="background-image: url(&quot;/web/assets/img/bg/breadcumb-bg.jpg&quot;);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Servicios</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('propiedades.detalle', $servicio->propiedad->id) }}">Propiedad</a></li>
                        <li>Detalle</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="py-3 py-md-5">
    <div class="container">
        <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
            <div class="col-12 col-lg-6 col-xl-5">
                <h4>Imagenes del servicio</h4>
                @if (count($servicio->imagenes) <= 0)
                    <h5 class="text-danger">No hay imagenes todabia</h5>
                @else
                    @foreach ($servicio->imagenes as $item)
                    <div class="col-6">
                        <div class="card" style="margin-bottom: 1rem;">
                            <img src="{{ asset('storage/'.$item->imagen) }}" class="card-img-top" alt="Imagen"
                                style="object-fit: cover; height: 200px;">
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            <div class="col-12 col-lg-6 col-xl-7">
                <div class="row justify-content-xl-center">
                    <div class="col-12 col-xl-11">
                        <h2 class="mb-3">Propiedad {{ $servicio->propiedad->nombre }}</h2>
                        <p class="lead fs-4 text-secondary mb-3">Dirección {{ $servicio->propiedad->direccion }}</p>
                        <p class="text-white"><strong>Tipo de Servicio</strong> {{ $servicio->tipoServicio->nombre }}
                        </p>
                        <p class="text-white"><strong>Estado</strong> {{ $servicio->estado }}</p>
                        <p class="text-white"><strong>Precio</strong> {{ $servicio->precio }}</p>
                        <p class="text-white"><strong>Detalle</strong> {{ $servicio->servicios_detalle }}</p>
                        <p class="text-white">{{ $servicio->descripcion }}</p>
                        <div class="row gy-4 gy-md-0 gx-xxl-5X">
                            <div class="col-12 col-md-6">
                                <div class="d-flex">
                                    <h2 class="h4 mb-3">Inicio {{ $servicio->fecha_inicio }}</h2>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex">
                                    <h2 class="h4 mb-3">Fin {{ $servicio->fecha_inicio }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection