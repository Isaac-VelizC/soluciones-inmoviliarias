@extends('layouts/layoutMaster')

@section('title', ' Citas - Editar')

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

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Citas/</span> Editar</h4>

<!-- Multi Column with Form Separator -->
<div class="card mb-4">
    <h5 class="card-header">Cita del cliente <strong>{{ $cita->user->name }}</strong>. Propiedad <strong>{{ $cita->propiedad->nombre }}</strong></h5>
    <form class="card-body" action="{{ route('adm.citas.update', $cita->id) }}" method="post">
        @csrf
        @method('PUT')
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="row g-4">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input type="date" id="fecha_de_cita" name="fecha_de_cita"
                            class="@error('fecha_de_cita') is-invalid @enderror form-control" placeholder="xx/xx/xxxx"
                            value="{{ $cita->fecha_de_cita }}" disabled />
                        <label for="fecha_de_cita">Fecha</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <input type="time" id="hora_de_cita" name="hora_de_cita"
                            class="@error('hora_de_cita') is-invalid @enderror form-control" placeholder="Juan Perez"
                            value="{{ $cita->hora_de_cita }}" disabled />
                        <label for="hora_de_cita">Hora</label>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <textarea class="@error('anotaciones') is-invalid @enderror form-control h-px-100" id="anotaciones"
                        name="anotaciones" placeholder="Anotaciones...">{{ $cita->anotaciones }}</textarea>
                    <label for="anotaciones">Anotaciones</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <select id="estado" name="estado" class="@error('estado') is-invalid @enderror form-select"
                        data-allow-clear="true">
                        <option value="">Seleccionar</option>
                        <option value="pendiente" {{ $cita->estado === 'pendiente' ? 'selected' : '' }}>Pendiente
                        </option>
                        <option value="concretada" {{ $cita->estado === 'concretada' ? 'selected' : '' }}>Concretada
                        </option>
                        <option value="cancelada" {{ $cita->estado === 'cancelada' ? 'selected' : '' }}>Cancelada
                        </option>
                    </select>
                    <label for="estado">Estado</label>
                </div>
            </div>
        </div>
        <div class="pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Enviar</button>
            <a href="{{ route('adm.citas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection