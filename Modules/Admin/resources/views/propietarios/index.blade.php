@extends('layouts/layoutMaster')

@section('title', 'Propietarios')

<!-- Vendor Styles -->
@section('vendor-style')
    @vite([
      'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
      'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
      'resources/assets/vendor/libs/flatpickr/flatpickr.scss'
    ])
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
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
{{--    @vite(['resources/assets/js/tables-datatables-advanced.js'])--}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js"></script>
    <script>
        // $(document).ready(function () {
        const tablePrg = $('#dtPropietarios').DataTable({
            'dom': '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-center justify-content-md-end"f>><"table-responsive"t><"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            'drawCallback': function(settings) {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl);
                });
            },
            'language': {
                'url': '/vendors/js/tables/datatable/spanish.json'
            },
            'order': [[1, 'asc'], [2, 'asc']],
            // "responsive": true,
            'serverSide': true,
            'processing': true,
            'ajax': '{{ route('adm.propietarios.ajax.index') }}',
            'columns': [
                { data: 'id', 'width': 50 },
                { data: 'nombre' },
                { data: 'apellido' },
                { data: 'email', 'width': 150 },
                { data: 'telefono', 'width': 100 },
                { data: 'botones', 'width': 60, 'searchable': false, 'orderable': false }
            ]
        });
        // });
    </script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Propietarios /</span> Lista
    </h4>

    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <h5 class="card-header">Propietarios</h5>
        <div class="card-datatable text-nowrap">
            <table id="dtPropietarios" class="datatables-ajax table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!--/ Ajax Sourced Server-side -->
@endsection
