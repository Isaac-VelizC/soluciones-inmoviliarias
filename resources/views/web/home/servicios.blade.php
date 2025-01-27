@extends('web.layouts.app')

@section('title', 'Servicios')
@section('css')
    <link rel="stylesheet" href="/web/assets/select2/dist/css/select2.min.css">
@endsection
@section('content')
    <div class="breadcumb-wrapper background-image" style="background-image: url(&quot;/web/assets/img/bg/breadcumb-bg.jpg&quot;);">
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
            <!--div-- class="row">
                <div class="col-12">
                    <form action="{{ route('citas.servicios.cliente.store') }}" id="frmServicios" class="woocommerce-form-login mb-3" method="post">
                        @if(session('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                        @endif
                        @csrf
                        <input type="hidden" id="id_usuario" name="id_usuario" value="{{ auth()->id() }}">
                        <div class="form-group">
                            <label for="nombre_cliente" class="form-label">Nombre</label>
                            <input type="text" class="@error('nombre_cliente') is-invalid @enderror form-control" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre" value="{{ old('nombre_cliente') }}">
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="form-label">Direccion</label>
                            <input type="text" class="@error('direccion') is-invalid @enderror form-control" name="direccion" id="direccion" placeholder="Direccion" value="{{ old('direccion') }}">
                        </div>
                        <div class="form-group">
                            <label for="tipo_de_servicio" class="form-label">Tipo de Servicio</label>
                            <select id="tipo_de_servicio" name="tipo_de_servicio" class="@error('tipo_de_servicio') is-invalid @enderror select2 form-select" data-allow-clear="true">
                                <option value="">Seleccionar</option>
                                <option value="mano_obra">Mano de obra</option>
                                <option value="maquinaria">Maquinaria</option>
                                <option value="material">Material</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="servicios_detalle" class="form-label">Detalle</label>
                            <select id="servicios_detalle" name="servicios_detalle[]" class="@error('servicios_detalle') is-invalid @enderror select2 form-select" multiple>
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
                        <div class="form-group">
                            <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                            <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" placeholder="Fecha inicio" value="{{ date("Y-m-d") }}">
                        </div>
                        <div class="form-group">
                            <label for="fecha_fin" class="form-label">Fecha fin</label>
                            <input type="date" class="@error('fecha_fin') is-invalid @enderror form-control" name="fecha_fin" id="fecha_fin" placeholder="Fecha fin" value="{{ old('fecha_fin') }}">
                        </div>
                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea class="@error('descripcion') is-invalid @enderror form-control" id="descripcion" name="descripcion" rows="4" placeholder="Escribe aquí tu texto...">{{ old('descripcion') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="th-btn">Registrar</button>
                        </div>
                    </form>
                </div>
            </!--div-->
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
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($servicios as $c)
                        <tr class="cart_item">
                            <td data-title="Name">
                                <span class="amount">{{ ucfirst($c->tipoServicio->nombre) }}</span>
                            </td>
                            <td data-title="Product">
                                <span class="amount"> {{ $c->usuario->client->nombre.' '.$c->usuario->client->apellido }}</span>
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
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="/web/assets/select2/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#servicios_detalle').select2();
        });
    </script>
@endsection
