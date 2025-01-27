<div class="modal fade" id="modalAgregarPropietario" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Agregar Propietario</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="card-body" action="{{ route('adm.propietarios.store') }}" method="POST" id="frmAgregarPropietario">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="pro_nombre" name="pro_nombre" class="@error('pro_nombre') is-invalid @enderror form-control" placeholder="Juan" value="{{ old('pro_nombre') }}" />
                                <label for="pro_nombre">Nombre propietario</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="pro_apellido" name="pro_apellido" class="@error('pro_apellido') is-invalid @enderror form-control" placeholder="Perez" value="{{ old('pro_apellido') }}" />
                                <label for="pro_apellido">Apellido</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="pro_email" name="pro_email" class="@error('pro_email') is-invalid @enderror form-control" placeholder="juan@gmail.com" value="{{ old('pro_email') }}" />
                                <label for="pro_email">Correo</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="pro_telefono" name="pro_telefono" class="@error('pro_telefono') is-invalid @enderror form-control" placeholder="7777777" value="{{ old('pro_telefono') }}" />
                                <label for="pro_telefono">Telefono</label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="button" onclick="agregarPropietario()" class="btn btn-primary me-sm-3 me-1">Enviar</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
