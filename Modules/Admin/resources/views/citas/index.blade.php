@extends('layouts/layoutMaster')

@section('title', 'Citas - Lista')

@section('vendor-style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">Citas /</span> Lista</h4>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <h5 class="card-header">Citas {{ $titulo ?? '' }}</h5>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Propiedad</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                @foreach($citas as $c)
                    @php
                    $css = "primary";
                    if($c->estado === 'concretada'){
                        $css = "success";
                    }
                    if($c->estado === 'cancelada'){
                        $css = "danger";
                    }
                    @endphp
                    <tr>
                        <td><span class="fw-medium">{{ $c->id }}</span></td>
                        <td><a href="{{ route('adm.propiedades.show', $c->id_propiedad) }}" target="_blank">{{ $c->propiedad->nombre }}</a></td>
                        <td>{{ $c->user->email }}</td>
                        <td>{{ $c->fecha_de_cita }}</td>
                        <td>{{ $c->hora_de_cita }}</td>
                        <td><span class="badge rounded-pill bg-label-{{ $css }} me-1">{{ ucfirst($c->estado) }}</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('adm.citas.edit', $c->id) }}"><i class="mdi mdi-pencil-outline me-2"></i> Editar</a>
                                    <a class="dropdown-item" href="javascript:void(0);" onclick="abrirEncuesta({{ $c->id }}, {{ $c->id_propiedad }});"><i class="mdi mdi-chart-box me-2"></i> Encuesta</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="mdi mdi-trash-can-outline me-2"></i> Borrar</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
    <div class="modal fade" id="modalEncuesta" tabindex="-1" aria-labelledby="modalEncuestaLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEncuestaLabel">Encuesta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoEncuesta">
                    Cargando...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function cargaEncuesta(idCita2, idProp2) {
            $.ajax({
                type: 'POST', // o POST si lo prefieres
                url: '{{ route('adm.citas.encuesta') }}',
                data: { idCita: idCita2, idProp: idProp2, _token: '{{ csrf_token() }}' },
                dataType: 'html', // Esperamos HTML de respuesta
                success: function(data) {
                    $('#contenidoEncuesta').html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#contenidoEncuesta').html('<p>Error al cargar la encuesta: ' + textStatus + '</p>');
                    console.error("Error AJAX:", textStatus, errorThrown); // Para depuración
                }
            });
        }

        function abrirEncuesta(idCita, idProp) {
            cargaEncuesta(idCita, idProp);
            $('#modalEncuesta').modal('show');
        }
    </script>
@endsection
