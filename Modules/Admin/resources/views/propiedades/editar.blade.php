@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Editar')

@section('vendor-style')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite([
'resources/assets/vendor/libs/quill/typography.scss',
'resources/assets/vendor/libs/quill/katex.scss',
'resources/assets/vendor/libs/quill/editor.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/dropzone/dropzone.scss',
'resources/assets/vendor/libs/flatpickr/flatpickr.scss',
'resources/assets/vendor/libs/tagify/tagify.scss'
])
@endsection

@section('page-style')
<link rel="stylesheet" href="/assets/js/leaflet/dist/leaflet.css" />
@endsection

@section('vendor-script')
@vite([
'resources/assets/vendor/libs/quill/katex.js',
'resources/assets/vendor/libs/quill/quill.js',
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/dropzone/dropzone.js',
'resources/assets/vendor/libs/jquery-repeater/jquery-repeater.js',
'resources/assets/vendor/libs/flatpickr/flatpickr.js',
'resources/assets/vendor/libs/tagify/tagify.js'
])
@endsection

@section('page-script')
<script>
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        //$(document).ready(function() {
        //     $('#submitBtn').click(function(event) {
        //         event.preventDefault(); // Evita que el botón envíe el formulario de la manera tradicional
        function editarInmueble() {
            // Recopila los datos de los campos sueltos
            var data = {
                nombre: $('#nombre').val(),
                direccion: $('#direccion').val(),
                ciudad: $('#ciudad').val(),
                // estado: $('#estado').val(),
                // codigo_postal: $('#codigo_postal').val(),
                // pais: $('#pais').val(),
                tipo_propiedad: $('#tipo_propiedad').val(),
                tipo_traspaso: $('#tipo_traspaso').val(),
                num_habitaciones: $('#num_habitaciones').val(),
                num_dormitorios: $('#num_dormitorios').val(),
                num_cocinas: $('#num_cocinas').val(),
                num_salas: $('#num_salas').val(),
                num_banos: $('#num_banos').val(),
                num_garajes: $('#num_garajes').val(),
                superficie_construida: $('#superficie_construida').val(),
                superficie_terreno: $('#superficie_terreno').val(),
                descripcion: $('#descripcion').val(),
                precio: $('#precio').val(),
                moneda: $('#moneda').val(),
                estatus: $('#estatus').val(),
                financiamiento_bancario: $('#financiamiento_bancario').val(),
                fecha_listado: $('#fecha_listado').val(),
                fecha_final: $('#fecha_final').val(),
                id_propietario: $('#id_propietario').val(),
                latitud: $('#latitud').val(),
                longitud: $('#longitud').val(),
                publicidad_estado: $('#publicidad_estado').val(),
                id_agente: 1//$('#id_agente').val(),
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
                url: '{{ route('adm.propiedades.editar_existente')."/".$propiedad->id }}', // La URL de la ruta en Laravel
                contentType: 'application/json',
                data: JSON.stringify(data),
                success: function(response) {
                    alert('Datos enviados con éxito');
                    console.log(response);
                    window.location.href = '{{ route('adm.propiedades.index') }}';
                    // Aquí puedes agregar cualquier acción adicional en caso de éxito
                },
                error: function(error) {
                    alert('Hubo un error al enviar los datos');
                    console.error(error);
                    $('#frmAgregarInmueble input').removeClass('is-invalid');
                    $('#frmAgregarInmueble2 input').removeClass('is-invalid');
                    $('#frmAgregarInmueble3 input').removeClass('is-invalid');
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
        function abrirCitas(){
            window.location.href = '{{ route('adm.propiedades.citas', $propiedad->id) }}';
        }
        function abrirServicios(){
            window.location.href = '{{ route('adm.servicios.agregar', $propiedad->id) }}';
        }
        function redireccionar(url) {
            window.location.href = url;
        }
</script>
@include('admin::propiedades.includes.propietario_agregar_js')
@include('admin::propiedades.includes.tipo_agregar_js')
@include('admin::propiedades.includes.venta_tipo_agregar_js')

<script src="/assets/js/leaflet/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ciudades = @json($ciudades);

        // Tomar coordenadas de la propiedad desde Blade
        let propiedadCoords = {
            lat: parseFloat('{{ $propiedad->latitud ?? -19.589277 }}'),
            lng: parseFloat('{{ $propiedad->longitud ?? -65.753506 }}')
        };

        let map, marker;
        let cityMarkers = [];

        // Ícono personalizado para el marcador
        const customIcon = L.icon({
            iconUrl: 'https://cdn-icons-png.flaticon.com/512/18751/18751801.png',
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            popupAnchor: [0, -40]
        });

        function inicializarMapaEdit() {
            map = L.map('mapEdit').setView([propiedadCoords.lat, propiedadCoords.lng], 16);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 20,
                attribution: 'Casas'
            }).addTo(map);

            marker = L.marker([propiedadCoords.lat, propiedadCoords.lng], {
                icon: customIcon,
                draggable: true
            }).addTo(map);

            marker.on('dragend', function () {
                const { lat, lng } = marker.getLatLng();
                actualizarInputs(lat, lng);
            });

            map.on('click', function (e) {
                moverMarcador(e.latlng.lat, e.latlng.lng);
            });

            agregarMarcadoresCiudades();
        }

        function agregarMarcadoresCiudades() {
            cityMarkers.forEach(m => map.removeLayer(m));
            cityMarkers = [];

            for (const key in ciudades) {
                if (ciudades.hasOwnProperty(key)) {
                    const { latitud, longitud } = ciudades[key].coordenadas;
                    const cityMarker = L.marker([latitud, longitud])
                        .addTo(map)
                        .bindPopup(`<b>${ciudades[key].nombre}</b><br>Haz clic para acercarte.`);

                    cityMarker.on('click', function () {
                        acercarACiudad(latitud, longitud);
                    });

                    cityMarkers.push(cityMarker);
                }
            }
        }

        function acercarACiudad(lat, lng) {
            map.setView([lat, lng], 14);
            moverMarcador(lat, lng);
        }

        function moverMarcador(lat, lng) {
            marker.setLatLng([lat, lng]).bindPopup('Ubicación seleccionada').openPopup();
            actualizarInputs(lat, lng);
        }

        function actualizarInputs(lat, lng) {
            document.getElementById('latitud').value = lat.toFixed(6);
            document.getElementById('longitud').value = lng.toFixed(6);
        }

        document.getElementById('modalMapaEdit').addEventListener('shown.bs.modal', function () {
            if (!map) {
                inicializarMapaEdit();
            } else {
                map.invalidateSize();
            }
        });

        document.getElementById('ciudad').addEventListener('change', function () {
            const ciudadSeleccionada = this.value;
            if (ciudadSeleccionada in ciudades) {
                const { latitud, longitud } = ciudades[ciudadSeleccionada].coordenadas;
                acercarACiudad(latitud, longitud);
            }
        });
    });

    function abrirMapaEdit() {
        $('#modalMapaEdit').modal('show');
    }
</script>

@vite([
'resources/assets/js/app-ecommerce-product-add.js'
])
@endsection

@section('content')
<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Propiedad /</span><span> Editar</span>
</h4>

<div class="app-ecommerce">

    <!-- Add Product -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">

        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">Editar Propiedad</h4>
            {{-- <p>Orders placed across your store</p>--}}
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            {{-- <button type="button" onclick="abrirServicios();"
                class="btn btn-outline-secondary">Servicios</button>--}}
            <a href="{{ route('adm.subir.imagenes', $propiedad->id ) }}" class="btn btn-outline-secondary">Imagenes</a>
            <button type="button" onclick="abrirCitas();" class="btn btn-outline-primary">Citas</button>
            <button type="button" onclick="editarInmueble();" id="submitBtn" class="btn btn-primary">Actualizar</button>
        </div>
    </div>

    <div class="row">

        <!-- First column-->
        <div class="col-12 col-lg-8">
            <!-- Product Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-tile mb-0">Información de la propiedad existente </h5>
                </div>
                <div class="card-body">
                    <form id="frmAgregarInmueble">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="nombre" placeholder="Nombre de la propiedad"
                                name="nombre" aria-label="Nombre del inmueble" value="{{ $propiedad->nombre }}">
                            <div class="invalid-feedback" id="error-nombre"></div>
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <select id="ciudad" name="ciudad" class="select2 form-select" data-placeholder="Ciudad">
                                @foreach($ciudades as $ciudad)
                                <option value="{{ $ciudad['nombre'] }}" @if($ciudad['nombre']==$propiedad->ciudad)
                                    selected @endif>
                                    {{ $ciudad['nombre'] }}
                                </option>
                                @endforeach
                            </select>
                            <label for="ciudad">Ciudad</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="text" class="form-control" id="direccion" placeholder="Dirección"
                                name="direccion" aria-label="Dirección" value="{{ $propiedad->direccion }}">
                            <div class="invalid-feedback" id="error-direccion"></div>
                            <label for="direccion">Dirección</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <button type="button" onclick="abrirMapaEdit()" class="btn btn-primary">Abrir Mapa</button>
                        </div>
                        <div class="row">
                            <div class="form-floating form-floating-outline mb-4 col-12 col-md-6">
                                <input type="text" class="form-control" id="latitud" placeholder="latitud"
                                    name="latitud" aria-label="Latitud" value="{{ $propiedad->latitud }}" disabled>
                                <div class="invalid-feedback" id="error-latitud"></div>
                                <label for="latitud">Latitud</label>
                            </div>
                            <div class="form-floating form-floating-outline mb-4 col-12 col-md-6">
                                <input type="text" class="form-control" id="longitud" placeholder="Longitud"
                                    name="longitud" aria-label="Longitud" value="{{ $propiedad->longitud }}" disabled>
                                <div class="invalid-feedback" id="error-longitud"></div>
                                <label for="longitud">Longitud</label>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group input-group-lg" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Nº de Garajes">
                                    <span class="input-group-text" id="basic-addon42"><span
                                            class="mdi mdi-garage-open-variant"></span></span>
                                    <input type="number" name="num_garajes" id="num_garajes" min="0"
                                        class="form-control" aria-describedby="basic-addon42"
                                        value="{{ $propiedad->num_garajes }}">
                                    <div class="invalid-feedback" id="error-num_garajes"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-lg" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Nº de Baños">
                                    <span class="input-group-text" id="basic-addon45"><span
                                            class="mdi mdi-toilet"></span></span>
                                    <input type="number" name="num_banos" id="num_banos" min="0" class="form-control"
                                        placeholder="Baños" aria-label="Baños" aria-describedby="basic-addon45"
                                        value="{{ $propiedad->num_banos }}">
                                    <div class="invalid-feedback" id="error-num_banos"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group input-group-lg" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Nº de Dormitorios">
                                    <span class="input-group-text" id="basic-addon43"><span
                                            class="mdi mdi-bed-empty"></span></span>
                                    <input type="number" name="num_dormitorios" id="num_dormitorios" min="0"
                                        class="form-control" placeholder="Dormitorios" aria-label="Dormitorios"
                                        aria-describedby="basic-addon43" value="{{ $propiedad->num_dormitorios }}">
                                    <div class="invalid-feedback" id="error-num_dormitorios"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-lg" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Nº de Salas">
                                    <span class="input-group-text" id="basic-addon44"><span
                                            class="mdi mdi-sofa-single"></span></span>
                                    <input type="number" name="num_salas" id="num_salas" min="0" class="form-control"
                                        placeholder="Salas" aria-label="Salas" aria-describedby="basic-addon44"
                                        value="{{ $propiedad->num_salas }}">
                                    <div class="invalid-feedback" id="error-num_salas"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="input-group input-group-lg" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Nº de Ambientes">
                                    <span class="input-group-text" id="basic-addon41"><span
                                            class="mdi mdi-home-city-outline"></span></span>
                                    <input type="number" name="num_habitaciones" id="num_habitaciones" min="0"
                                        class="form-control" aria-describedby="basic-addon41"
                                        value="{{ $propiedad->num_habitaciones }}">
                                    <div class="invalid-feedback" id="error-num_habitaciones"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="input-group input-group-lg" data-bs-toggle="tooltip" data-bs-placement="top"
                                    data-bs-original-title="Nº de Cocinas">
                                    <span class="input-group-text" id="basic-addon46"><span
                                            class="mdi mdi-countertop"></span></span>
                                    <input type="number" name="num_cocinas" id="num_cocinas" class="form-control"
                                        min="0" aria-describedby="basic-addon46" value="{{ $propiedad->num_cocinas }}">
                                    <div class="invalid-feedback" id="error-num_cocinas"></div>
                                </div>
                            </div>
                        </div>
                        <!-- Comment -->
                        <div>
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control p-2 pt-1" id="descripcion" name="descripcion"
                                placeholder="Descripción corta de la propiedad"
                                rows="6">{{ $propiedad->descripcion }}</textarea>
                            <div class="invalid-feedback" id="error-descripcion"></div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Product Information -->
            <!-- Media -->
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 card-title">Subir Imagenes</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('adm.propiedades.imagenes.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id_propiedad_img" id="id_propiedad_img" value="{{ $propiedad->id }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Seleccionar Tipo de Imagen</label>
                                <select id="tipo" name="tipo" class="form-select">
                                    <option value="casa_fuera">Propiedad</option>
                                    <option value="360">Imagenes 360</option>
                                    <option value="dormitorio">Dormitorio</option>
                                    <option value="sala">Sala</option>
                                    <option value="baños">Baños</option>
                                    <option value="cocina">Cocinas</option>
                                    <option value="garaje">Garaje</option>
                                    <option value="ambiente">Ambiente</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subir Imágenes</label>
                                <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple>
                            </div>
                        </div>
                        <br>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 card-title">Imagenes</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-5">
                        @foreach ($imagenes as $imagen)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img class="card-img-top"
                                    src="{{ route('adm.propiedades.imagenes.showImage', $imagen->id) }}" alt="Imagen"
                                    height={{ 120 }}>
                                <div class="card-body d-flex justify-content-between">
                                    <h5 class="card-title">{{ ucfirst($imagen->tipo) }}</h5>
                                    <form action="{{ route('adm.propiedades.imagenes.destroy', $imagen->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-xs"
                                            onclick="return confirm('¿Eliminar imagen?')">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- /Media -->
        </div>
        <!-- /Second column -->

        <!-- Second column -->
        <div class="col-12 col-lg-4">
            <!-- Pricing Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Precio</h5>
                </div>
                <div class="card-body">
                    <!-- Base Price -->
                    <form id="frmAgregarInmueble2">
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control" id="precio" min="0" placeholder="Precio"
                                name="precio" aria-label="Precio" value="{{ $propiedad->precio }}">
                            <div class="invalid-feedback" id="error-precio"></div>
                            <label for="precio">Precio</label>
                        </div>
                        <!-- Discounted Price -->
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="moneda" name="moneda" aria-label="Default select example">
                                <option value="" disabled {{ is_null($propiedad->moneda) ? 'selected' : '' }}>Seleccione
                                    una opción</option>
                                <option value="USD" {{ $propiedad->moneda == 'USD' ? 'selected' : '' }}>Dolar</option>
                                <option value="Bs" {{ $propiedad->moneda == 'Bs' ? 'selected' : '' }}>Bolivianos
                                </option>
                            </select>
                            <label for="exampleFormControlSelect1">Moneda</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select" id="financiamiento_bancario" name="financiamiento_bancario"
                                aria-label="Financiamiento Bancario">
                                <option value="" disabled {{ is_null($propiedad->financiamiento_bancario) ? 'selected' :
                                    '' }}>Seleccione una opción</option>
                                <option value="No" {{ $propiedad->financiamiento_bancario == 'No' ? 'selected' : ''
                                    }}>No</option>
                                <option value="Si" {{ $propiedad->financiamiento_bancario == 'Si' ? 'selected' : ''
                                    }}>Sí</option>
                            </select>
                            <label for="financiamiento_bancario">Financiamiento Bancario</label>
                        </div>
                        <!-- Instock switch -->
                        <div class="border-top pt-3"></div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control" id="superficie_terreno"
                                placeholder="Superifica Terreno" min="0" name="superficie_terreno"
                                aria-label="Superifica Terreno" value="{{ $propiedad->superficie_terreno }}">
                            <div class="invalid-feedback" id="error-superficie_terreno"></div>
                            <label for="superficie_terreno">Superificie Terreno m²</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="number" class="form-control" id="superficie_construida"
                                placeholder="Superifica Construida" min="0" name="superficie_construida"
                                aria-label="Superifica Construida" value="{{ $propiedad->superficie_construida }}">
                            <div class="invalid-feedback" id="error-superficie_construida"></div>
                            <label for="superficie_construida">Superificie Construida m²</label>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Pricing Card -->
            <!-- Organize Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Organizar</h5>
                </div>
                <div class="card-body">
                    <!-- Category -->
                    <form id="frmAgregarInmueble3">
                        <div class="mb-4 col ecommerce-select2-dropdown d-flex justify-content-between">
                            <div class="form-floating form-floating-outline w-100 me-3">
                                <select id="id_propietario" name="id_propietario" class="select2 form-select"
                                    data-placeholder="Select Category">
                                    @foreach($propietarios as $p)
                                    <option value="{{ $p->id }}" @if($p->id == $propiedad->id_propietario) selected
                                        @endif>{{ $p->nombre }} {{ $p->apellido }}</option>
                                    @endforeach
                                </select>
                                <label for="category-org">Dueño</label>
                            </div>
                            <div>
                                <button onclick="abrirPropietario(event)"
                                    class="btn btn-outline-primary btn-icon btn-lg h-px-50">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Vendor -->
                        <div class="mb-4 col ecommerce-select2-dropdown d-flex justify-content-between">
                            <div class="form-floating form-floating-outline w-100 me-3">
                                <select id="tipo_propiedad" name="tipo_propiedad" class="select2 form-select"
                                    data-placeholder="Select Vendor">
                                    @foreach($tipopropiedad as $t)
                                    <option value="{{ $t->id }}" @if($t->id == $propiedad->tipo_propiedad) selected
                                        @endif>{{ $t->descripcion }}</option>
                                    @endforeach
                                </select>
                                <label for="vendor">Tipo de Propiedad</label>
                            </div>
                            <div>
                                <button onclick="abrirTipo(event)"
                                    class="btn btn-outline-primary btn-icon btn-lg h-px-50">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Collection -->
                        <div class="mb-4 col ecommerce-select2-dropdown d-flex justify-content-between">
                            <div class="form-floating form-floating-outline w-100 me-3">
                                <select id="tipo_traspaso" name="tipo_traspaso" class="select2 form-select"
                                    data-placeholder="Collection">
                                    @foreach($ventastipo as $t)
                                    <option value="{{ $t->id }}" @if($t->id == $propiedad->tipo_traspaso) selected
                                        @endif>{{ $t->descripcion }}</option>
                                    @endforeach
                                </select>
                                <label for="collection">Tipo de venta</label>
                            </div>
                            <div>
                                <button onclick="abrirVentaTipo(event)"
                                    class="btn btn-outline-primary btn-icon btn-lg h-px-50">
                                    <i class="mdi mdi-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" id="fecha_listado" placeholder="Fecha Inicio"
                                name="fecha_listado" aria-label="Fecha Inicio" value="{{ $propiedad->fecha_listado }}">
                            <div class="invalid-feedback" id="error-fecha_listado"></div>
                            <label for="fecha_inicio">Fecha Inicio</label>
                        </div>
                        <div class="form-floating form-floating-outline mb-4">
                            <input type="date" class="form-control" id="fecha_final" placeholder="Fecha Final"
                                name="fecha_final" aria-label="Fecha Final" value="{{ $propiedad->fecha_final }}">
                            <div class="invalid-feedback" id="error-fecha_final"></div>
                            <label for="fecha_fin">Fecha Final</label>
                        </div>
                        <!-- Tags -->
                        <div class="mb-4 col ecommerce-select2-dropdown">
                            <div class="form-floating form-floating-outline">
                                <select id="publicidad_estado" name="publicidad_estado" class="select2 form-select"
                                    data-placeholder="Select Status">
                                    <option value="no" @if('no'==$propiedad->publicidad_estado) selected @endif>No
                                    </option>
                                    <option value="publicitado" @if('publicitado'==$propiedad->publicidad_estado)
                                        selected @endif>Publicitado</option>
                                </select>
                                <label for="publicidad_estado">Con Publicidad</label>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 col ecommerce-select2-dropdown">
                            <div class="form-floating form-floating-outline">
                                <select id="estatus" name="estatus" class="select2 form-select"
                                    data-placeholder="Select Status">
                                    <option value="Disponible" @if('Disponible'==$propiedad->estatus) selected
                                        @endif>Disponible</option>
                                    <option value="Vendido" @if('Vendido'==$propiedad->estatus) selected @endif>Vendido
                                    </option>
                                    <option value="Alquilado" @if('Alquilado'==$propiedad->estatus) selected
                                        @endif>Alquilado</option>
                                </select>
                                <label for="estatus">Estado</label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Organize Card -->
        </div>
        <!-- /Second column -->
    </div>
</div>
<!-- Modal Mapa -->
<div class="modal fade" id="modalMapaEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Mapa</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Para seleccionar una ubicación, hacer doble clic cuando ubique la Propiedad</p>
                <div id="mapEdit" style="height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@include('admin::propiedades.includes.propietario_agregar')
@include('admin::propiedades.includes.tipo_agregar')
@include('admin::propiedades.includes.venta_tipo_agregar')
@endsection