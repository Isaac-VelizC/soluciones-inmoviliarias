<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('adm.propietarios.edit', $id) }}"><i class="mdi mdi-pencil-outline me-2"></i> Editar</a>
        <a class="dropdown-item" href="{{ route('adm.propiedades.usuarios.index', $id) }}"><i class="mdi mdi-home-city-outline me-2"></i> Ver Propiedades</a>
    </div>
</div>
