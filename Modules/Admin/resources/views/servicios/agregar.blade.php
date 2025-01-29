@extends('layouts/layoutMaster')

@section('title', ' Servicios- Agregar')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
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

<!-- Multi Column with Form Separator -->
<div class="card mb-4">
    <h3 class="card-header">Servicios para la propiedad <strong>{{ $propiedadID->nombre }}</strong></h3>
    <h5 class="card-header">Dirección de la Propiedad <strong>{{ $propiedadID->direccion }}</strong></h5>
    <form class="card-body" action="{{ route('adm.servicios.agregar_nuevo') }}" method="POST">
        @csrf
        <input type="hidden" id="id_propiedad" name="id_propiedad" value="{{ $propiedadID->id }}">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <h6>1. Detalles</h6>
        <div class="row g-4">
            <div class="mb-4 col-md-6 ecommerce-select2-dropdown d-flex justify-content-between">
                <div class="form-floating form-floating-outline w-100 me-3">
                    <select id="id_usuario" name="id_usuario"
                        class="@error('id_usuario') is-invalid @enderror select2 form-select" data-allow-clear="true">
                        @foreach($usuarios as $u)
                        <option value="{{ $u->id }}">{{ $u->client->nombre.' '.$u->client->apellido }}</option>
                        @endforeach
                    </select>
                    <label for="usuario">Cliente Seleccionar</label>
                </div>
                <div>
                    <button onclick="abrirCliente(event)" class="btn btn-outline-primary btn-icon btn-lg h-px-50">
                        <i class="mdi mdi-plus"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="direccion" name="direccion"
                        class="@error('direccion') is-invalid @enderror form-control" placeholder="Calle X"
                        value="{{ old('direccion') }}" />
                    @error('direccion')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label for="direccion">Direccion</label>
                </div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-6 select2-primary">
                <div class="form-floating form-floating-outline">
                    <select id="servicios_detalle" name="servicios_detalle[]"
                        class="@error('servicios_detalle') is-invalid @enderror select2 form-select" multiple>
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
            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="nombre_trabajador" name="nombre_trabajador"
                        class="@error('nombre_trabajador') is-invalid @enderror form-control" placeholder="Juan"
                        value="{{ old('nombre_trabajador') }}" />
                    @error('nombre_trabajador')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label for="nombre_trabajador">Nombre del trabajador</label>
                </div>
            </div>
            <div class="col-md-6">
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
            <div class="col-md-6">
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
            <div class="col-md-6">
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
            <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                    <select id="estado" name="estado" class="@error('estado') is-invalid @enderror select2 form-select"
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
                    <textarea class="@error('descripcion') is-invalid @enderror form-control h-px-100" id="descripcion"
                        name="descripcion" placeholder="Detalle...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label for="descripcion">Descripción</label>
                </div>
            </div>
        </div>
        <div class="pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
        </div>
    </form>
</div>

@include('admin::servicios.includes.cliente_agregar')
@endsection