@extends('layouts/layoutMaster')

@section('title', ' Servicios- Agregar')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/select2/select2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
'resources/assets/vendor/libs/cleavejs/cleave.js',
'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
'resources/assets/vendor/libs/moment/moment.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/select2/select2.js'
])

@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/assets/js/form-layouts.js'])
@endsection

@include('admin::servicios.includes.cliente_agregar_js')
@section('content')

<h4 class="py-3 mb-4"><span class="text-muted fw-light">Servicios/</span> Agregar</h4>

<div class="card mb-4">
    <h1 class="card-header">Servicios para la propiedad <strong style="color: #003366;">{{ $propiedadID->nombre
            }}</strong></h1>
    <h3 class="card-header">Dirección de la Propiedad <strong style="color: #003366;">{{ $propiedadID->direccion
            }}</strong></h3>
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <strong>Formulario para registrar un nuevo servicio</strong>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <form class="card-body" action="{{ route('adm.servicios.agregar_nuevo') }}" method="POST">
                        @csrf
                        <input type="hidden" id="id_propiedad" name="id_propiedad" value="{{ $propiedadID->id }}">
                        <input type="hidden" id="direccion" name="direccion" class="form-control"
                            value="{{ $propiedadID->direccion }}" />
                        <h6>1. Detalles</h6>
                        <div class="row g-4">
                            <div class="mb-4 col-md-4 ecommerce-select2-dropdown d-flex justify-content-between">
                                <div class="form-floating form-floating-outline w-100 me-3">
                                    <select id="id_usuario" name="id_usuario"
                                        class="@error('id_usuario') is-invalid @enderror select2 form-select"
                                        data-allow-clear="true">
                                        @foreach($usuarios as $u)
                                        <option value="{{ $u->id }}">{{ $u->client->nombre.' '.$u->client->apellido }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <label for="usuario">Cliente Seleccionar</label>
                                </div>
                                <div>
                                    <button onclick="abrirCliente(event)"
                                        class="btn btn-outline-primary btn-icon btn-lg h-px-50">
                                        <i class="mdi mdi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select id="tipo_de_servicio" name="tipo_de_servicio"
                                        class="@error('tipo_de_servicio') is-invalid @enderror select2 form-select"
                                        data-allow-clear="true">
                                        @foreach ($tipoServicio as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <label for="tipo_de_servicio">Tipo de servicio</label>
                                </div>
                            </div>
                            <div class="col-md-4 select2-primary">
                                <div class="form-floating form-floating-outline">
                                    <select id="servicios_detalle" name="servicios_detalle[]"
                                        class="@error('servicios_detalle') is-invalid @enderror select2 form-select"
                                        multiple>
                                        <option value="pintura">Pintura</option>
                                        <option value="jardineria">Servicios de jardineria</option>
                                        <option value="alabanileria">Albañileria</option>
                                        <option value="construccion">Trabajos de construccion</option>
                                        <option value="electricidad">Electricidad</option>
                                        <option value="carpinteria">Carpinteria</option>
                                        <option value="volqueta">Volqueta</option>
                                        <option value="cemento">Cemento</option>
                                        <option value="yeso">Yeso</option>
                                    </select>
                                    <label for="servicios_detalle">Servicios</label>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4 mx-n4" />
                        <h6>2. Trabajador</h6>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="nombre_trabajador" name="nombre_trabajador"
                                        class="@error('nombre_trabajador') is-invalid @enderror form-control"
                                        placeholder="Juan" value="{{ old('nombre_trabajador') }}" />
                                    @error('nombre_trabajador')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <label for="nombre_trabajador">Nombre del trabajador</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="fecha_inicio" name="fecha_inicio"
                                        class="@error('fecha_inicio') is-invalid @enderror form-control dob-picker"
                                        placeholder="YYYY-MM-DD" value="{{ old('fecha_inicio') ?? date(" Y-m-d") }}" />
                                    @error('fecha_inicio')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <label for="fecha_inicio">Fecha Inicio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <input type="text" id="fecha_fin" name="fecha_fin"
                                        class="@error('fecha_fin') is-invalid @enderror form-control dob-picker"
                                        placeholder="YYYY-MM-DD" value="{{ old('fecha_fin') }}" />
                                    @error('fecha_fin')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <label for="fecha_fin">Fecha Fin</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" min="0" id="precio" name="precio"
                                        class="@error('precio') is-invalid @enderror form-control" placeholder="0000"
                                        value="{{ old('precio') }}" />
                                    @error('precio')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <label for="precio">Precio</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline">
                                    <select id="estado" name="estado"
                                        class="@error('estado') is-invalid @enderror select2 form-select"
                                        data-allow-clear="true">
                                        <option value="entregado">Entregado</option>
                                        <option value="en_proceso">En proceso</option>
                                        <option value="terminado">Terminado</option>
                                    </select>
                                    <label for="estado">Estado de servicio</label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating form-floating-outline">
                                    <textarea class="@error('descripcion') is-invalid @enderror form-control h-px-100"
                                        id="descripcion" name="descripcion"
                                        placeholder="Detalle...">{{ old('descripcion') }}</textarea>
                                    @error('descripcion')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    <label for="descripcion">Descripción</label>
                                </div>
                            </div>
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1">Enviar</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="container my-5">
            <h2 class="text-center">Lista de servicios</h2>
            <table class="table table-bordered data-table">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Usuario</th>
                        <th>Fecha</th>
                        <th>Tipo de Servicio</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicios as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->usuario->client->nombre . ' ' . $item->usuario->client->apellido }}</td>
                        <td>{{ $item->fecha_fin }}</td>
                        <td>{{ $item->tipoServicio->nombre }}</td>
                        <td><span class="badge bg-primary">{{ $item->estado }}</span></td>
                        <td>
                            <div class="d-flex justify-content-around">
                                <a class="badge bg-danger" href="{{ route('adm.servicios.editar', $item->id) }}">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <a class="badge bg-info" href="{{ route('adm.servicios.show', $item->id) }}">
                                    <i class="mdi mdi-information-outline"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


@include('admin::servicios.includes.cliente_agregar')
@endsection