@extends('layouts/layoutMaster')

@section('title', 'Servicio - Detalles')

@section('content')

<div class="app-ecommerce">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">Detalles de la propiedad <strong>{{ $servicio->propiedad->nombre }}</strong> </h4>
            <p>Cliente <strong>{{ $servicio->usuario->client->nombre .' '.
                    $servicio->usuario->client->apellido}}</strong>
            </p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <a href="{{ route('adm.servicios.agregar', $servicio->propiedad->id) }}" class="btn btn-outline-secondary">Volver</a>
            <a href="{{ route('adm.servicios.editar', $servicio->id) }}" id="submitBtn"
                class="btn btn-primary">Editar</a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Detalles del servicio</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Tipo de Servicio:</strong> {{
                            $servicio->tipoServicio->nombre }}</li>
                        <li class="list-group-item"><strong>Dirección:</strong> {{ $servicio->direccion }}</li>
                        <li class="list-group-item"><strong>Detalles:</strong> {{ $servicio->servicios_detalle }}</li>
                        <li class="list-group-item"><strong>Nombre del trabajador:</strong> {{
                            $servicio->nombre_trabajador }}
                        </li>
                        <li class="list-group-item"><strong>Fecha inicio:</strong> {{ $servicio->fecha_inicio }}</li>
                        <li class="list-group-item"><strong>Fecha fin:</strong> {{$servicio->fecha_fin }}</li>
                        <li class="list-group-item"><strong>Precio:</strong> {{$servicio->precio }}</li>
                        <li class="list-group-item"><strong>Estado:</strong> {{ $servicio->estado }}</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Información de la servicio existente </h5>
                </div>
                <div class="card-body">
                    <div class="">
                        <p>{{ $servicio->descripcion }}</p>
                    </div>
                    <h4>Imagenes de Prueba</h4>
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                    @endif
                    <form action="{{ route('adm.servicios.agregar_imagen') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_servicio" value="{{ $servicio->id }}">

                        <label class="form-label">Subir Imágenes</label>
                        <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple>
                        <div class="mt-3 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                    <div class="row">
                        @foreach ($servicio->imagenes as $imagen)
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <img class="card-img-top" src="{{ asset('storage/' . $imagen->imagen) }}" alt="Imagen"
                                    height="70" style="object-fit: cover;">
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="card-title">{{ ucfirst($imagen->tipo) }}</h5>
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

@endsection