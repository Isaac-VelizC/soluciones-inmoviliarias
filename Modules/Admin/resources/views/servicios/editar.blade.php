@extends('layouts/layoutMaster')

@section('title', ' Servicios- Editar')

<!-- Vendor Styles -->
@section('vendor-style')
<meta name="csrf-token" content="{{ csrf_token() }}">
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
<script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        function agregarPresupuesto() {
            // Recopila los datos de los campos sueltos
            var data = {
                mano_de_obra: $('#mano_de_obra').val(),
                maquinaria: $('#maquinaria').val(),
                material: $('#material').val(),
                precio_total: parseFloat($('#mano_de_obra').val()) + parseFloat($('#maquinaria').val()) + parseFloat($('#material').val()),
                id_servicio: {{ $servicio->id }},
                //token: '{{csrf_token()}}'
            };
            //alert(JSON.stringify(data));
            // Enviar los datos utilizando AJAX
            $.ajax({
                type: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                url: '{{ route('adm.presupuesto.agregar_nuevo') }}', // La URL de la ruta en Laravel
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Datos enviados con éxito');
                    console.log(response);
                    window.location.href = '{{ route('adm.servicios.editar', $servicio->id) }}';
                    // Aquí puedes agregar cualquier acción adicional en caso de éxito
                },
                error: function(error) {
                    alert('Hubo un error al enviar los datos');
                    console.error(error);
                    if (error.status === 422) {
                        var errors = error.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#' + key).addClass('is-invalid');
                            $('#error-' + key).text(value[0]);
                        });
                    }
                    // Aquí puedes manejar el error
                }
            });
        }
</script>
@endsection

@section('content')
<h4 class="py-3 mb-4"><span class="text-muted fw-light">Servicios/</span> Editar</h4>

<!-- Multi Column with Form Separator -->
<div class="card mb-4">
    <h1 class="card-header">Servicios para la propiedad <strong>{{ $propiedadID->nombre }}</strong></h1>
    <h5 class="card-header">Dirección de la Propiedad <strong>{{ $propiedadID->direccion }}</strong></h5>
    
    <form class="card-body" action="{{ route('adm.servicios.editar_existente') }}" method="POST">
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $servicio->id }}">
        @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
        @endif
        <h6>1. Detalles</h6>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <select id="id_usuario" name="id_usuario"
                        class="@error('id_usuario') is-invalid @enderror select2 form-select" data-allow-clear="true">
                        @foreach($usuarios as $u)
                        <option value="{{ $u->id }}">{{ $u->client->nombre.' '.$u->client->apellido }}</option>
                        @endforeach
                    </select>
                    <label for="tipo_de_servicio">Cliente Seleccionar</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <select id="tipo_de_servicio" name="tipo_de_servicio"
                        class="@error('tipo_de_servicio') is-invalid @enderror select2 form-select"
                        data-allow-clear="true">
                        @foreach ($tipoServicio as $item)
                        <option value="{{ $item->id }}" {{ $item->id === $servicio->tipo_de_servicio ? 'selected' : '' }}>{{ $item->nombre }}</option>
                        @endforeach
                    </select>
                    <label for="tipo_de_servicio">Tipo de servicio</label>
                </div>
            </div>
            <div class="col-md-4 select2-primary">
                <div class="form-floating form-floating-outline">
                    <select id="servicios_detalle" name="servicios_detalle[]"
                        class="@error('servicios_detalle') is-invalid @enderror select2 form-select" multiple>
                        @php
                        $array_servicios = explode("|", $servicio->servicios_detalle);
                        @endphp
                        @foreach(['pintura', 'jardineria', 'alabanileria', 'construccion', 'electricidad',
                        'carpinteria', 'volqueta', 'cemento', 'yeso'] as $tipo)
                        <option value="{{ $tipo }}" @if(in_array($tipo, $array_servicios)) selected @endif>
                            {{ ucfirst($tipo) }}
                        </option>
                        @endforeach
                    </select>
                    <label for="servicios_detalle">Servicios</label>
                </div>
            </div>
        </div>

        <!--hr class="my-4 mx-n4" />
        <h6>2. Presupuestos</h6>
        <div-- class="row g-4">
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="number" id="mano_de_obra" name="mano_de_obra"
                        class="@error('mano_de_obra') is-invalid @enderror form-control" min="0" placeholder="Juan"
                        value="0" />
                    <label for="mano_de_obra">Mano de Obra</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="number" id="maquinaria" name="maquinaria"
                        class="@error('maquinaria') is-invalid @enderror form-control" min="0" placeholder="Juan"
                        value="0" />
                    <label for="maquinaria">Maquinaria</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <input type="number" id="material" name="material"
                        class="@error('material') is-invalid @enderror form-control" min="0" placeholder="Juan"
                        value="0" />
                    <label for="material">Material</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating form-floating-outline">
                    <button type="button" onclick="agregarPresupuesto()"
                        class="btn btn-primary me-sm-3 me-1">Agregar</button>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mano de Obra</th>
                            <th>Maquinaria</th>
                            <th>Material</th>
                            <th>Total</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach($presupuestos as $c)
                        <tr>
                            <td><span class="fw-medium">{{ $c->id }}</span></td>
                            <td>{{ $c->mano_de_obra }}</td>
                            <td>{{ $c->maquinaria }}</td>
                            <td>{{ $c->material }}</td>
                            <td>{{ $c->precio_total }}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);"><i
                                                class="mdi mdi-trash-can-outline me-2"></i> Borrar</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div-->
        <hr class="my-4 mx-n4" />
        <h6>3. Trabajador</h6>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="nombre_trabajador" name="nombre_trabajador"
                        class="@error('nombre_trabajador') is-invalid @enderror form-control" placeholder="Juan"
                        value="{{ $servicio->nombre_trabajador }}" />
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
                        placeholder="YYYY-MM-DD" value="{{ $servicio->fecha_inicio }}" />
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
                        placeholder="YYYY-MM-DD" value="{{ $servicio->fecha_fin }}" />
                    @error('fecha_fin')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label for="fecha_fin">Fecha Fin</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                    <select id="estado" name="estado" class="@error('estado') is-invalid @enderror select2 form-select"
                        data-allow-clear="true">
                        <option value="pendiente" {{ $servicio->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="entregado" {{ $servicio->estado === 'entregado' ? 'selected' : '' }}>Entregado</option>
                        <option value="en_proceso" {{ $servicio->estado === 'en_proceso' ? 'selected' : '' }}>En proceso</option>
                        <option value="terminado" {{ $servicio->estado === 'terminado' ? 'selected' : '' }}>Terminado</option>
                    </select>
                    <label for="tipo_de_servicio">Estado</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-floating">
                    <input type="number" min="0" id="precio" name="precio"
                        class="@error('precio') is-invalid @enderror form-control" placeholder="0000"
                        value="{{ $servicio->precio }}" />
                    @error('precio')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label for="precio">Precio</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating form-floating-outline">
                    <textarea class="@error('descripcion') is-invalid @enderror form-control h-px-100" id="descripcion"
                        name="descripcion" placeholder="Detalle...">{{ $servicio->descripcion }}</textarea>
                    @error('descripcion')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <label for="descripcion">Descripción</label>
                </div>
            </div>
        </div>
        <div class="pt-4">
            <button type="submit" class="btn btn-primary me-sm-3 me-1">Enviar</button>
            <a href="{{ route('adm.servicio.solicitud', $propiedadID->id ) }}" class="btn btn-outline-secondary">Cancelar</a>
        </div>
    </form>
</div>

@endsection