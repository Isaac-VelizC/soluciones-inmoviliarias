@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Solicitudes')

@section('content')
<div class="app-ecommerce">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">Detalles de la propiedad <strong>{{ $propiedad->nombre }}</strong> </h4>
            </p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <a href="{{ route('adm.servicios.agregar', $propiedad->id ) }}"
                class="btn btn-md btn-outline-primary">Registrar Servicio</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="container my-5">
                <h2 class="text-center">Solicitudes de servicios</h2>
                <table class="table table-bordered data-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Tipo de Servicio</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lista as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->usuario->client->nombre.' '.$item->usuario->client->apellido }}</td>
                                <td>{{ $item->fecha_fin }}</td>
                                <td>{{ $item->tipoServicio->nombre }}</td>
                                <td>{{ $item->servicios_detalle }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
</div>
@endsection