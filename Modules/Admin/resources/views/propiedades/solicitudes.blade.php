@extends('layouts/layoutMaster')

@section('title', 'Propiedades - Solicitudes')

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
            const tablePrg = $('#dtServiciosPropiedad').DataTable({
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
                'ajax': '{{ route('adm.servicios.ajax.propiedad.list', $propiedad->id) }}',
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
<div class="app-ecommerce">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="mb-1 mt-3">Detalles de la propiedad <strong>{{ $propiedad->nombre }}</strong> </h4>
            </p>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <a href="{{ route('adm.servicios.agregar', $propiedad->id ) }}"
                class="btn btn-md btn-outline-primary">Registrar Servicio</a>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="container my-5">
                <h2 class="text-center">Solicitudes de servicios</h2>
                <table class="table table-bordered data-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Usuario</th>
                            <th>Fecha</th>
                            <th>Tipo de Servicio</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lista as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->usuario->client->nombre.' '.$item->usuario->client->apellido }}</td>
                                <td>{{ $item->fecha_fin }}</td>
                                <td>{{ $item->tipoServicio->nombre }}</td>
                                <td>{{ $item->servicios_detalle }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>

    <!-- Ajax Sourced Server-side -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between items-center">
                <h5>Servicios</h5>
                <!--a href="#" class="btn btn-md btn-primary">Nuevo</!--a-->
            </div>
        </div>
        <div class="card-datatable text-nowrap">
            <table id="dtServiciosPropiedad" class="datatables-ajax table table-bordered">
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

</div>
@endsection