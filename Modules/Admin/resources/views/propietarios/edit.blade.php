@extends('layouts/layoutMaster')

@section('title', ' Propietarios - Editar')

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
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Propietarios/</span> Editar</h4>

    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <h5 class="card-header">Propietarios</h5>
        <form class="card-body" action="{{ route('adm.propietarios.update') }}" method="POST">
            @csrf
            <input type="hidden" id="id" name="id" value="{{ $propietario->id }}">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row g-4">
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="nombre" name="nombre" class="@error('nombre') is-invalid @enderror form-control" placeholder="Juan Perez" value="{{ $propietario->nombre }}" />
                        @error('nombre')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <label for="nombre">Nombre propietario</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="apellido" name="apellido" class="@error('apellido') is-invalid @enderror form-control" placeholder="Calle X" value="{{ $propietario->apellido }}" />
                        @error('apellido')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <label for="apellido">Apellido</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror form-control" placeholder="Juan Perez" value="{{ $propietario->email }}" />
                        @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <label for="email">Correo</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floating form-floating-outline">
                        <input type="number" id="telefono" name="telefono" class="@error('telefono') is-invalid @enderror form-control" placeholder="7777777" value="{{ $propietario->telefono }}" />
                        @error('telefono')
                        <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                        <label for="telefono">Telefono</label>
                    </div>
                </div>
            </div>
            <div class="pt-4">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Enviar</button>
                <a href="{{ route('adm.propietarios.index') }}" type="reset" class="btn btn-outline-secondary">Cancelar</a>
            </div>
        </form>
    </div>

@endsection
