<div class="dropdown">
    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('adm.servicios.editar', $id) }}"><i class="mdi mdi-pencil-outline me-2"></i> Editar</a>
        <a class="dropdown-item" href="{{ route('adm.servicios.show', $id) }}"><i class="mdi mdi-information-outline"></i> Detalle</a>
    </div>
</div>
