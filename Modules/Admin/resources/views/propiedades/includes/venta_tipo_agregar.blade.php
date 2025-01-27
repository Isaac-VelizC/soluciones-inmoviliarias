<div class="modal fade" id="modalAgregarVentaTipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Agregar Tipo de Venta</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="card-body" action="#" method="POST" id="frmAgregarVentaTipo">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="vetipo_descripcion" name="vetipo_descripcion" class="@error('vetipo_descripcion') is-invalid @enderror form-control" placeholder="Terreno" value="{{ old('vetipo_descripcion') }}" />
                                <label for="vetipo_descripcion">Descripción</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="vetipo_detalle" name="vetipo_detalle" class="@error('vetipo_detalle') is-invalid @enderror form-control" placeholder="Detalle" value="{{ old('vetipo_detalle') }}" />
                                <label for="vetipo_detalle">Detalle</label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="button" onclick="agregarVentaTipo()" class="btn btn-primary me-sm-3 me-1">Enviar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
