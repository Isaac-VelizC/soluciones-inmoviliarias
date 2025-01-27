<div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel4">Agregar Cliente</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="card-body" action="" method="POST" id="frmAgregarCliente">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cli_nombre" name="cli_nombre" class="@error('cli_nombre') is-invalid @enderror form-control" placeholder="Juan" value="{{ old('cli_nombre') }}" />
                                <label for="cli_nombre">Nombre propietario</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cli_apellido" name="cli_apellido" class="@error('cli_apellido') is-invalid @enderror form-control" placeholder="Perez" value="{{ old('cli_apellido') }}" />
                                <label for="cli_apellido">Apellido</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="email" id="cli_email" name="cli_email" class="@error('cli_email') is-invalid @enderror form-control" placeholder="juan@gmail.com" value="{{ old('cli_email') }}" />
                                <label for="cli_email">Correo</label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating form-floating-outline">
                                <input type="text" id="cli_telefono" name="cli_telefono" class="@error('cli_telefono') is-invalid @enderror form-control" placeholder="7777777" value="{{ old('cli_telefono') }}" />
                                <label for="cli_telefono">Telefono</label>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="button" onclick="agregarCliente()" class="btn btn-primary me-sm-3 me-1">Enviar</button>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
