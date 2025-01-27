@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Citas')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Propiedades /</span> Citas</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Citas</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($citas as $c)
                <tr>
                    <td><span class="fw-medium">{{ $c->id }}</span></td>
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->fecha_de_cita }}</td>
                    <td>{{ $c->hora_de_cita }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-pencil-outline me-2"></i> Editar</a>
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
