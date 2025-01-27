@extends('web.layouts.app')

@section('title', 'Citas')

@section('content')
    <div class="breadcumb-wrapper background-image" style="background-image: url(&quot;/web/assets/img/bg/breadcumb-bg.jpg&quot;);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Usuario</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="index.html">Home</a></li>
                            <li>Usuario</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="space">
        <div class="container">
            <div class="row gx-40 gy-40">
                <div class="col-xl-4 col-lg-5 col-md-8">
                    <div class="th-team team-card style4">
                        <div class="img-wrap">
                            <div class="team-img">
                                <img src="/web/assets/img/team/user.jpg" alt="Team">
                            </div>
                        </div>
                        <div class="team-card-content">
                            <div class="media-left">
                                <h3 class="box-title"><a href="#">{{ $user->name }}</a></h3>
                                <span class="team-desig">{{ $user->email }}</span>
                            </div>
                            @role('admin')
                            <a class="icon-btn" href="{{ route('adm.propiedades.index') }}"><img src="/web/assets/img/icon/service-icon3-1.svg" alt="img"></a>
                            @endrole
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-lg-7">
                    <div class="about-card">
                        <h2 class="about-card_title text-theme mb-45">Usuario Registrado</h2>
                        <p><a href="{{ route('usuario.servicios.index') }}">Servicios</a></p>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
