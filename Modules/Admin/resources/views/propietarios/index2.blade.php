@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Citas')

@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Propietarios /</span> Lista</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Propietarios</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($propietarios as $p)
                    <tr>
                        <td><span class="fw-medium">{{ $p->id }}</span></td>
                        <td>{{ $p->nombre }}</td>
                        <td>{{ $p->apellido }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->telefono }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('adm.propietarios.edit', $p->id) }}"><i class="mdi mdi-pencil-outline me-2"></i> Editar</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-home-city-outline me-2"></i> Ver Propiedades</a>
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
