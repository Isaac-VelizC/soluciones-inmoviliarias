@extends('layouts/layoutMaster')

@section('title', 'Usuarios - Administracion')

<!-- Vendor Styles -->
@section('vendor-style')
@vite([
'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
'resources/assets/vendor/libs/select2/select2.scss',
'resources/assets/vendor/libs/@form-validation/form-validation.scss',
'resources/assets/vendor/libs/animate-css/animate.scss',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.scss'
])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
@vite([
'resources/assets/vendor/libs/moment/moment.js',
'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
'resources/assets/vendor/libs/select2/select2.js',
'resources/assets/vendor/libs/@form-validation/popular.js',
'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
'resources/assets/vendor/libs/@form-validation/auto-focus.js',
'resources/assets/vendor/libs/cleavejs/cleave.js',
'resources/assets/vendor/libs/cleavejs/cleave-phone.js',
'resources/assets/vendor/libs/sweetalert2/sweetalert2.js'
])
@endsection

<!-- Page Scripts -->
@section('page-script')
@vite(['resources/js/laravel-user-management.js'])
@endsection

@section('content')

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Usuarios</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">{{$totalUser}}</h3>
                            <small class="text-success">(100%)</small>
                        </div>
                        <small>Total Users</small>
                    </div>
                    <span class="avatar">
                        <span class="avatar-initial bg-label-primary rounded">
                            <i class="mdi mdi-account-outline mdi-24px"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Usuarios Verificados</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">{{$verified}}</h3>
                            <small class="text-success">(+95%)</small>
                        </div>
                        <small>Analiticas recientes </small>
                    </div>
                    <span class="avatar">
                        <span class="avatar-initial bg-label-success rounded">
                            <i class="mdi mdi-account-check-outline mdi-24px"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Usuarios duplicados</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">{{$userDuplicates}}</h3>
                            <small class="text-success">(0%)</small>
                        </div>
                        <small>Analiticas recientes</small>
                    </div>
                    <span class="avatar">
                        <span class="avatar-initial bg-label-danger rounded">
                            <i class="mdi mdi-account-multiple-outline mdi-24px"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="content-left">
                        <span>Pendientes de verificacion</span>
                        <div class="d-flex align-items-end mt-2">
                            <h3 class="mb-0 me-2">{{$notVerified}}</h3>
                            <small class="text-danger">(+6%)</small>
                        </div>
                        <small>Analiticas recientes</small>
                    </div>
                    <span class="avatar">
                        <span class="avatar-initial bg-label-warning rounded">
                            <i class="mdi mdi-account-circle-outline mdi-24px"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Users List Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Filtro</h5>
    </div>
    <div class="card-datatable table-responsive">
        <table class="datatables-users table">
            <thead class="table-light">
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Verificado</th>
                    <th>Accciones</th>
                </tr>
            </thead>
        </table>
    </div>
    <!-- Offcanvas to add new user -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Agregar Usuario</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0">
            <form class="add-new-user pt-0" id="addNewUserForm">
                <input type="hidden" name="id" id="user_id">
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" id="add-user-fullname" placeholder="John Doe" name="name"
                        aria-label="John Doe" />
                    <label for="add-user-fullname">Nombre Completo</label>
                </div>
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" id="add-user-email" class="form-control" placeholder="john.doe@example.com"
                        aria-label="john.doe@example.com" name="email" />
                    <label for="add-user-email">Email</label>
                </div>
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" id="add-user-contact" class="form-control phone-mask"
                        placeholder="+1 (609) 988-44-11" aria-label="john.doe@example.com" name="userContact" />
                    <label for="add-user-contact">Contacto</label>
                </div>
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" id="add-user-company" name="company" class="form-control"
                        placeholder="Web Developer" aria-label="jdoe1" />
                    <label for="add-user-company">Compañia</label>
                </div>
                <div class="form-floating form-floating-outline mb-4">
                    <select id="country" class="select2 form-select">
                        <option value="">Select</option>
                        <option value="Australia">Australia</option>
                        <option value="Bangladesh">Bangladesh</option>
                        <option value="Belarus">Belarus</option>
                        <option value="Bolivia">Bolivia</option>
                        <option value="Brazil">Brazil</option>
                        <option value="Canada">Canada</option>
                        <option value="China">China</option>
                        <option value="France">France</option>
                        <option value="Germany">Germany</option>
                        <option value="India">India</option>
                        <option value="Indonesia">Indonesia</option>
                        <option value="Israel">Israel</option>
                        <option value="Italy">Italy</option>
                        <option value="Japan">Japan</option>
                        <option value="Korea">Korea, Republic of</option>
                        <option value="Mexico">Mexico</option>
                        <option value="Philippines">Philippines</option>
                        <option value="Russia">Russian Federation</option>
                        <option value="South Africa">South Africa</option>
                        <option value="Thailand">Thailand</option>
                        <option value="Turkey">Turkey</option>
                        <option value="Ukraine">Ukraine</option>
                        <option value="United Arab Emirates">United Arab Emirates</option>
                        <option value="United Kingdom">United Kingdom</option>
                        <option value="United States">United States</option>
                    </select>
                    <label for="country">Pais</label>
                </div>
                <div class="form-floating form-floating-outline mb-4">
                    <select id="user-role" class="form-select">
                        <option value="subscriber">Subscriber</option>
                        <option value="editor">Editor</option>
                        <option value="maintainer">Maintainer</option>
                        <option value="author">Author</option>
                        <option value="admin">Admin</option>
                    </select>
                    <label for="user-role">Role</label>
                </div>
                <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Enviar</button>
                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancelar</button>
            </form>
        </div>
    </div>
</div>
@endsection