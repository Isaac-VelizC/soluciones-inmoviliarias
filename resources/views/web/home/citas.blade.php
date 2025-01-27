@extends('web.layouts.app')

@section('title', 'Citas')

@section('content')
<div class="breadcumb-wrapper background-image"
    style="background-image: url(&quot;/web/assets/img/bg/breadcumb-bg.jpg&quot;);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Citas</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="/">Home</a></li>
                        <li>Citas</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .selected-day {
        background-color: #4CAF50 !important;
        color: white !important;
    }
</style>
<div class="th-checkout-wrapper space-top space-extra-bottom">
    <div class="container">
        <div class="woocommerce-form-login-toggle">
            <div class="woocommerce-info"><a href="{{ route('propiedades.detalle', $propiedad->id) }}">Propiedad: {{
                    $propiedad->nombre }}</a></div>
        </div>
        <div class="woocommerce-form-login-toggle">
            <div class="woocommerce-info">Horarios de atencion: 8:00 a 12:00 y 14:00 a 18:00</div>
        </div>
        @if(empty($controlpropiedad))
        <div class="row">
            <div class="col-12">
                <form action="{{ route('usuario.citas.agregar_nuevo') }}" id="frmCitas"
                    class="woocommerce-form-login mb-3" method="post">
                    @if(session('success'))
                    <div>
                        {{ session('success') }}
                    </div>
                    @endif
                    @csrf
                    <input type="hidden" id="id_propiedad" name="id_propiedad" value="{{ $id }}">
                    <input type="hidden" id="usuario_id" name="usuario_id" value="{{ auth()->id() }}">
                    <input type="hidden" id="fecha_de_cita" name="fecha_de_cita">

                    <div class="row">
                        <div class="col-md-6">
                            <div id="calendar"></div>
                        </div>
                        <div class="col-md-6">
                            @if($horas)
                            <div class="form-group">
                                <label for="hora_de_cita" class="form-label">Hora</label>
                                <select class="form-select" id="hora_de_cita" name="hora_de_cita" required>
                                    @foreach($horas as $hora)
                                    <option value="{{ $hora }}">{{ $hora }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="th-btn">Registrar</button>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
        <h4 class="mt-4 pt-lg-2">Tus Citas</h4>
        <form action="#" class="woocommerce-cart-form">
            <table class="cart_table mb-20">
                <thead>
                    <tr>
                        <th class="cart-col-productname">Propiedad</th>
                        <th class="cart-col-price">Fecha</th>
                        <th class="cart-col-quantity">Hora</th>
                        <th class="cart-col-quantity">Estado</th>
                        <th class="cart-col-quantity">Encuesta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $c)
                    <tr class="cart_item">
                        <td data-title="Name">{{$c->propiedad->nombre }}</td>
                        <td data-title="Price">
                            <span class="amount">{{ $c->fecha_de_cita }}</span>
                        </td>
                        <td data-title="Quantity">
                            <strong class="product-quantity">{{ $c->hora_de_cita }}</strong>
                        </td>
                        <td data-title="Quantity">
                            <strong class="product-quantity">{{ ucfirst($c->estado) }}</strong>
                        </td>
                        <td data-title="Quantity">
                            @if ($c->estado == "concretada")
                            <button onclick="VerEncuesta({{ $c->id }}, {{ $id }});" class="th-btn"
                                type="button">Encuesta</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let calendarEl = document.getElementById('calendar');
        let today = new Date();
        let todayStr = today.toISOString().split("T")[0]; // Fecha actual en formato YYYY-MM-DD

        let calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            selectable: true,
            editable: false,
            events: '/citas',
            dateClick: function(info) {
                let selectedDate = info.dateStr;

                if (selectedDate < todayStr) {
                    alert("No puedes seleccionar una fecha pasada.");
                    return;
                }

                alert("Has seleccionado: " + selectedDate);

                // Actualizar el valor del campo input para enviar la fecha al formulario
                document.getElementById('fecha_de_cita').value = selectedDate;

                // Agregar una clase a la fecha seleccionada
                document.querySelectorAll('.fc-day').forEach(function(day) {
                    day.classList.remove('selected-day'); // Eliminar clase de fecha previamente seleccionada
                });

                let selectedDateElement = document.querySelector(`[data-date="${selectedDate}"]`);
                if (selectedDateElement) {
                    selectedDateElement.classList.add('selected-day');
                }
            },
            select: {
                start: todayStr,
                end: todayStr,
                allDay: true
            },
            events: function(info, successCallback, failureCallback) {
                // Esto se puede personalizar si es necesario para mostrar eventos
            },
            // Configuración de diseño
            contentHeight: 'auto',
            eventLimit: true,
        });

        calendar.render();

        // Cambiar color de la fecha actual
        let currentDateElement = document.querySelector(`[data-date="${todayStr}"]`);
        if (currentDateElement) {
            currentDateElement.style.backgroundColor = "red";
            currentDateElement.style.color = "white";
        }
    });
    function VerEncuesta(id, idp) {
        var url = "{{ route('usuario.citas.encuesta') }}"+"/"+id+"/"+idp;
        var nombre = "Encuesta";
        var caracteristicas = "width=800,height=600";
        window.open(url, nombre, caracteristicas);
    }
</script>
@endsection