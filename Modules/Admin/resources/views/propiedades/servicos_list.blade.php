@extends('layouts/layoutMaster')

@section('title', 'Servicios - Propiedad')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
      'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
      'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
      'resources/assets/vendor/libs/flatpickr/flatpickr.scss'
    ])
@endsection

<!-- Vendor Scripts -->
@section('vendor-script')
    @vite([
      'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
      'resources/assets/vendor/libs/moment/moment.js',
      'resources/assets/vendor/libs/flatpickr/flatpickr.js'
    ])
@endsection

<!-- Page Scripts -->
@section('page-script')
    <script type="module">
        $(function () {
            const tablePrg = $('#dtServicios').DataTable({
                'dom': '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                'drawCallback': function(settings) {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl);
                    });
                },
                'language': {
                    'url': '/assets/js/spanish.json'
                },
                'order': [[4, 'desc'], [5, 'asc']],
                // "responsive": true,
                'serverSide': true,
                'processing': true,
                'ajax': '{{ route('adm.servicios.ajax.index') }}',
                'columns': [
                    { data: 'id', 'width': 50 },
                    { data: 'nombre_cliente' },
                    { data: 'tipo_de_servicio' },
                    { data: 'direccion', 'width': 150 },
                    { data: 'fecha_inicio', 'width': 100, 'searchable': false },
                    { data: 'estado', 'width': 100 },
                    { data: 'botones', 'width': 60, 'searchable': false, 'orderable': false }
                ]
            });
        });
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Servicios /</span> Lista
    </h4>

    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between items-center">
                <h5>Servicios</h5>
                <!--a href="#" class="btn btn-md btn-primary">Nuevo</!--a-->
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="dtServicios" class="datatables-ajax table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Tipo de servicio</th>
                    <th>Direccion</th>
                    <th>Fecha Inicio</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
@endsection
