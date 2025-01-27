@extends('layouts/layoutMaster')

@section('title', 'Propiedades')

@section('vendor-script')
@vite('resources/assets/vendor/libs/masonry/masonry.js')
@endsection

@section('content')
@php
use App\Models\Image;
use App\Models\Visita;
@endphp
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">
        Propiedades {{ $esDetalle ? 'de '. $propietario?->nombre . ' ' . $propietario?->apellido : '' }}
        /
    </span>
    Lista
</h4>

@if (count($propiedades) <= 0) <div class="display-1 d-flex justify-content-center align-items-center"
    style="height: 90%;">
    <h4 class="text-center">No existen propiedades registradas</h4>
    </div>
    @else
    <div class="row mb-5">
        @foreach($propiedades as $propiedad)
        @php
        $imagen = Image::where('id_propiedad', $propiedad->id)->where('tipo', 'casa_fuera')->first();
        $visita = Visita::obtenerTotalVisitas($propiedad->id);
        @endphp
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                @if(!empty($imagen))
                <img class="card-img-top" src="{{ route('adm.propiedades.imagenes.showImage', $imagen->id) }}"
                    alt="Card image cap" style="height: 200px; object-fit: cover; width: 100%;" />
                @else
                <img class="card-img-top" src="/assets/img/casa.jpg" alt="Imagen por defecto"
                    style="height: 200px; object-fit: cover; width: 100%;" />
                @endif

                <div class="card-body">
                    <h4 class="card-title">{{ $propiedad->nombre }}</h4>
                    @if (!$esDetalle)
                    <h6 class="card-title">Dueño: {{ $propiedad->propietario->nombre .' '.
                        $propiedad->propietario->apellido}}</h6>
                    @endif
                    <p class="card-text">Dirección: {{ $propiedad->direccion }}</p>
                    <p class="card-text">Precio: {{ $propiedad->precio." ".$propiedad->moneda }}</p>
                    <p class="card-text"><span class="mdi mdi-home-city-outline"></span> {{ "Hab:
                        ".$propiedad->num_habitaciones }} - <span class="mdi mdi-toilet"></span> {{
                        "Baños:".$propiedad->num_banos }} - <span class="mdi mdi-garage-open-variant"></span> {{
                        "Garaje:".$propiedad->num_garajes }}</p>
                    <a href="{{ route('adm.propiedades.show', $propiedad->id )}}" class="btn btn-sm
                        btn-outline-primary">Ver Detalles</a>
                    <a href="{{ route('adm.propiedades.citas', $propiedad->id) }}" class="btn btn-sm
                        btn-outline-primary">Ver Citas</a>
                    <a href="#" class="btn btn-sm btn-outline-primary"><span
                            class="mdi mdi-eye-outline"></span>{{$visita
                        }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @endsection