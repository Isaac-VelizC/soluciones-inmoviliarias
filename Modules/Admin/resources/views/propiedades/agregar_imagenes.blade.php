@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Imágenes')

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.css">
<script src="https://cdn.jsdelivr.net/npm/pannellum@2.5.6/build/pannellum.js"></script>
<style>
    #panorama {
        width: 100%;
        height: 400px;
    }

    .thumbnail-container {
        display: flex;
        overflow-x: auto;
        margin-top: 10px;
    }

    .thumbnail {
        width: 100px;
        cursor: pointer;
        margin: 5px;
    }

    .image-select-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .image-option {
        cursor: pointer;
        border: 2px solid transparent;
        padding: 5px;
        border-radius: 5px;
        text-align: center;
    }

    .image-option img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }

    .image-option.selected {
        border-color: blue;
    }
</style>

<h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Propiedad /</span> Subir Imágenes
</h4>

@if(session('success'))
<div id="myAlert" class="alert alert-left alert-success alert-dismissible fade show mb-3 alert-fade" role="alert">
    <span>{{ session('success') }}</span>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <strong>Errores:</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="app-ecommerce">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <h4 class="mb-1 mt-3">Subir Imágenes de la propiedad de {{ $propietario->nombre }} {{ $propietario->apellido }}
        </h4>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <a href="{{ route('adm.propiedades.show', $propiedad->id) }}" class="btn btn-outline-danger">Volver</a>
            <a href="{{ route('adm.propiedades.show', $propiedad->id) }}" class="btn btn-primary">Finalizar</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Subir Imágenes
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <form action="{{ route('adm.propiedades.imagenes.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id_propiedad_img" value="{{ $propiedad->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Seleccionar Tipo de Imagen</label>
                                    <select id="tipo" name="tipo" class="form-select">
                                        <option value="casa_fuera">Casa por fuera</option>
                                        <option value="360">Imagenes 360</option>
                                        <option value="cuarto">Cuartos</option>
                                        <option value="dormitorio">Dormitorios</option>
                                        <option value="cocina">Cocinas</option>
                                        <option value="baños">Baños</option>
                                        <option value="garaje">Garaje</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Subir Imágenes</label>
                                    <input class="form-control" type="file" id="imagenes" name="imagenes[]" multiple>
                                </div>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <strong>Imágenes</strong>
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row">
                            @foreach ($imagenes as $imagen)
                            <div class="col-md-3 mb-3">
                                <div class="card">
                                    <img class="card-img-top"
                                        src="{{ route('adm.propiedades.imagenes.showImage', $imagen->id) }}"
                                        alt="Imagen" height={{ 150 }} width={{ 60 }}>
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
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Imágenes 360: Registrar el Recorrido de la Propieda
                <strong>{{$propiedad->nombre}}</strong>
            </h5>
        </div>
        <div class="card-body">
            <!-- Miniaturas de imágenes -->
            @foreach ($imagenes360 as $image360)
            <img src="{{ route('adm.propiedades.imagenes.showImage', $image360->id) }}" class="thumbnail"
                alt="Imagen 360" width="100" onclick="changeScene({{ $image360->id }})">
            @endforeach
            <!-- Visor de imágenes 360° -->
            <div id="panorama"></div>
            <!-- Formulario para hotspots -->
            <br>
            <h3 class="text-title-personable">Crear Hotspot</h3>
            <form method="POST" action="{{ route('guardar.hotspot') }}">
                @csrf
                <input type="hidden" name="propiedad_id" value="{{ $propiedad->id }}">
                <div class="col-12">
                    <label for="nombre_hotspot" class="form-label">Nombre del Hotspot</label>
                    <input type="text" name="nombre_hotspot" id="nombre_hotspot" class="form-control">
                    @error('nombre_hotspot')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label class="form-label">Seleccionar imagen destino:</label>
                    <div class="image-select-container">
                        @foreach ($imagenes360 as $imageSelect)
                        <div class="image-option" onclick="selectImage(this, '{{ $imageSelect->id }}')">
                            <img src="{{ route('adm.propiedades.imagenes.showImage', $imageSelect->id) }}"
                                alt="{{ $imageSelect->tipo }}">
                            <p>{{ $imageSelect->tipo }}</p>
                        </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="targetScene" name="targetScene">
                    @error('targetScene')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" id="sceneId" name="sceneId" value="{{ $imagenes360->first()->id ?? '' }}">
                <input type="hidden" id="pitch" name="pitch">
                <input type="hidden" id="yaw" name="yaw">
                <div class="mt-3">
                    <button type="submit" class="btn btn-sm btn-secondary">Guardar Hotspot</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var scenes = {
        @foreach ($imagenes360 as $imagen)
            "scene_{{ $imagen->id }}": {
                "type": "equirectangular",
                "panorama": "{{ route('adm.propiedades.imagenes.showImage', $imagen->id) }}",
                "autoLoad": true
            },
        @endforeach
    };

    // Inicializa el visor con la primera imagen
    var viewer = pannellum.viewer('panorama', {
        default: {
            firstScene: "scene_{{ $imagenes360->first()->id ?? '' }}"
        },
        scenes: scenes
    });

    // Cambia la escena al hacer clic en una imagen
    function changeScene(id) {
        var sceneId = "scene_" + id;
        if (scenes[sceneId]) {
            viewer.loadScene(sceneId);
            document.getElementById('sceneId').value = id;
        } else {
            console.error("Escena no encontrada:", sceneId);
        }
    }

    // Captura la posición del clic en la imagen 360
    document.getElementById('panorama').addEventListener('click', function(event) {
        var coords = viewer.mouseEventToCoords(event);
        document.getElementById('pitch').value = coords[0];
        document.getElementById('yaw').value = coords[1];
    });

</script>

<script>
    function selectImage(element, imageId) {
        document.querySelectorAll('.image-option').forEach(img => img.classList.remove('selected'));
        element.classList.add('selected');
        document.getElementById('targetScene').value = imageId;
    }
</script>

@endsection