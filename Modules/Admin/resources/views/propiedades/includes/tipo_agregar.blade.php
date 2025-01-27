<div class="modal fade" id="modalAgregarTipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Agregar Tipo de Propiedad</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="card-body" action="#" method="POST" id="frmAgregarTipoPropiedad">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="tipo_descripcion" name="tipo_descripcion" class="@error('tipo_descripcion') is-invalid @enderror form-control" placeholder="Terreno" value="{{ old('tipo_descripcion') }}" />
                                <label for="tipo_descripcion">Descripción</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="tipo_detalle" name="tipo_detalle" class="@error('tipo_detalle') is-invalid @enderror form-control" placeholder="Detalle" value="{{ old('tipo_detalle') }}" />
                                <label for="tipo_detalle">Detalle</label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="button" onclick="agregarTipo()" class="btn btn-primary me-sm-3 me-1">Enviar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
