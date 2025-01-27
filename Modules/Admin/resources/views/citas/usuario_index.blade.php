@extends('layouts/layoutMaster')

@section('title', 'Citas - Lista')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Citas /</span> Lista</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Citas {{ $titulo ?? '' }}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Propiedad</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($citas as $c)
                    @php
                    $css = "primary";
                    if($c->estado === 'concretada'){
                        $css = "success";
                    }
                    if($c->estado === 'cancelada'){
                        $css = "danger";
                    }
                    @endphp
                    <tr>
                        <td><span class="fw-medium">{{ $c->id }}</span></td>
                        <td><a href="{{ route('adm.propiedades.editar', $c->propiedad_id) }}" target="_blank">{{ $c->nombre }}</a></td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->fecha_de_cita }}</td>
                        <td>{{ $c->hora_de_cita }}</td>
                        <td><span class="badge rounded-pill bg-label-{{ $css }} me-1">{{ ucfirst($c->estado) }}</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('adm.citas.edit', $c->id) }}"><i class="mdi mdi-pencil-outline me-2"></i> Editar</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-trash-can-outline me-2"></i> Borrar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection
