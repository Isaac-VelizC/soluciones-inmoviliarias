@extends('web.layouts.app')

@section('title', 'Servicios')
@section('css')
<link rel="stylesheet" href="/web/assets/select2/dist/css/select2.min.css">
@endsection
@section('content')
<div class="breadcumb-wrapper background-image"
    style="background-image: url(&quot;/web/assets/img/bg/breadcumb-bg.jpg&quot;);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-9">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Servicios</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="index.html">Home</a></li>
                        <li>Servicios</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="th-checkout-wrapper space-top space-extra-bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>Solicitar servicio Propiedad <strong>{{ $propiedad->nombre }}</strong></h4>
                <form action="{{ route('citas.servicios.solicitud.store') }}" class="woocommerce-form-login mb-3"
                    method="post">
                    @if(session('success'))
                    <div>
                        {{ session('success') }}
                    </div>
                    @endif
                    @csrf
                    <input type="hidden" id="id_propiedad" name="id_propiedad" value="{{ $propiedad->id }}">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="{{ auth()->id() }}">
                    <div class="row">
                        <div class="form-group col-6">
                            <label for="tipo_de_servicio" class="form-label">Tipo de Servicio</label>
                            <select id="tipo_de_servicio" name="tipo_de_servicio"
                                class="@error('tipo_de_servicio') is-invalid @enderror select2 form-select"
                                data-allow-clear="true">
                                <option value="" selected>Seleccionar</option>
                                @foreach ($tipoServicio as $item)
                                <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label for="servicios_detalle" class="form-label">Detalle</label>
                            <select id="servicios_detalle" name="servicios_detalle[]" class="form-select" multiple>
                                <option value="pintura">Pintura</option>
                                <option value="jardineria">Servicios de jardineria</option>
                                <option value="alabanileria">Albañileria</option>
                                <option value="construccion">Trabajos de construccion</option>
                                <option value="electricidad">Electricidad</option>
                                <option value="carpinteria">Carpinteria</option>
                                <option value="volqueta">Volqueta</option>
                                <option value="cemento">Cemento</option>
                                <option value="yeso">Yeso</option>
                            </select>
                        </div>
                    </div>
                    <label for="fecha_fin" class="form-label">Fecha fin</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" placeholder="Fecha fin">

                    <div class="form-group">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <textarea class="@error('descripcion') is-invalid @enderror form-control" id="descripcion"
                            name="descripcion" rows="4"
                            placeholder="Escribe aquí tu texto...">{{ old('descripcion') }}</textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="th-btn">Solicitar Registrar</button>
                    </div>
                </form>
            </div>
        </div>
        <h4 class="mt-4 pt-lg-2">Historial de servicios</h4>
        <form action="#" class="woocommerce-cart-form">
            <table class="cart_table mb-20">
                <thead>
                    <tr>
                        <th class="cart-col-productname">Servicio</th>
                        <th class="cart-col-image">Cliente</th>
                        <th class="cart-col-image">Direccion</th>
                        <th class="cart-col-price">Fecha Inicio</th>
                        <th class="cart-col-quantity">Fecha Fin</th>
                        <th class="cart-col-quantity">Estado</th>
                        <th class="cart-col-detalle">Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($servicios as $c)
                    <tr class="cart_item">
                        <td data-title="Name">
                            <span class="amount">{{ ucfirst($c->tipoServicio->nombre) }}</span>
                        </td>
                        <td data-title="Product">
                            <span class="amount"> {{ $c->usuario->client->nombre.' '.$c->usuario->client->apellido
                                }}</span>
                        </td>
                        <td data-title="Product">
                            <span class="amount"> {{ $c->direccion }}</span>
                        </td>
                        <td data-title="Price">
                            <span class="amount">{{ $c->fecha_inicio }}</span>
                        </td>
                        <td data-title="Quantity">
                            <strong class="product-quantity">{{ $c->fecha_fin }}</strong>
                        </td>
                        <td data-title="Quantity">
                            <strong class="product-quantity">{{ ucfirst($c->estado) }}</strong>
                        </td>
                        <td data-title="Detalle">
                            <a href="{{ route('usuario.servicios.detalle', $c->id) }}">Detalles</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>
</div>
@push('scripts')
<script src="/web/assets/select2/dist/js/select2.full.min.js"></script>
<script>
    $(document).ready(function() {
                $('#servicios_detalle').select2();
            });
</script>
@endpush
@endsection