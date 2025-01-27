<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Soluciones Inmboliviarias - Encusta</title>
    <meta name="author" content="Realar">
    <meta name="description" content="Realar - Real Estate Apartment Complex HTML Template">
    <meta name="keywords" content="Realar - Real Estate Apartment Complex HTML Template">
    <meta name="robots" content="INDEX,FOLLOW">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="apple-touch-icon" sizes="57x57" href="/web/assets/img/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/web/assets/img/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/web/assets/img/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/web/assets/img/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/web/assets/img/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/web/assets/img/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/web/assets/img/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/web/assets/img/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/web/assets/img/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/web/assets/img/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/web/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/web/assets/img/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/web/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="/web/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/web/assets/img/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
    Google Fonts
  ============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap" rel="stylesheet">

    <!--==============================
      All CSS File
  ============================== -->
    <!-- Bootstrap -->
    <link rel="stylesheet" href="/web/assets/css/bootstrap.min.css">
    <!-- Fontawesome Icon -->
    <link rel="stylesheet" href="/web/assets/css/fontawesome.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="/web/assets/css/magnific-popup.min.css">
    <!-- Swiper Js -->
    <link rel="stylesheet" href="/web/assets/css/swiper-bundle.min.css">
    <!-- Theme Custom CSS -->
    <link rel="stylesheet" href="/web/assets/css/style.css">
</head>
<body class="bg-smoke">
<section class="position-relative" style="padding-top: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div>
                    @if(!empty($encuestas))
                        <form method="POST" action="{{ route('usuario.citas.encuesta_respuesta') }}">
                            @csrf
                            @php
                                $cad = "";
                                foreach ($encuestas as $encuesta){
                                    $cad.=$encuesta->id."|";
                                }
                            @endphp
                            <input type="hidden" name="cita_id" value="{{ $cita }}">
                            <input type="hidden" name="encuestas" value="{{ $cad }}">
                            <input type="hidden" name="propiedad" value="{{ $prop }}">
                            @foreach ($encuestas as $encuesta)
                                <h5>{{ $encuesta->nombre.'"'.$propiedad->nombre.'"?' }}</h5>
                                @php
                                    $preguntas = \App\Models\Pregunta::preguntasPorEncuesta($encuesta->id);
                                @endphp
                                <div>
                                    <ul class="woocommerce-shipping-methods list-unstyled">
                                        @foreach ($preguntas as $pregunta)
                                            <li>
                                                <input type="radio" id="pregunta_{{ $pregunta->id }}" name="respuesta_{{ $encuesta->id }}" class="shipping_method" value="{{ $pregunta->id }}" @if ($loop->first) checked @endif>
                                                <label for="pregunta_{{ $pregunta->id }}">{{ $pregunta->pregunta }}</label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                            <button class="th-btn" type="submit">Enviar</button>
                        </form>
                    @else
                        <h5>{{ session('success') }}</h5>
                        <h4>Resultado de su encuesta:</h4>
                        {!! $respuestas !!}
                        <button onclick="window.close();" class="th-btn" type="button">Cerrar</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
