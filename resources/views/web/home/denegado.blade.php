@extends('web.layouts.app')

@section('title', 'Denegado')

@section('content')
    <section class="error-area-1 position-relative">
        <div class="container">
            <div class="error-img">
                <img src="/web/assets/img/normal/error_1_1.png" alt="404 image">
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="error-content">
                        <h2 class="error-title">403</h2>
                        <h3 class="error-subtitle">Esta página ha sido denegada.</h3>
                        <p class="error-text">Debe estar registrado y logeado.</p>
                        <a href="{{ route('login') }}" class="th-btn style-border2 th-btn-icon">Login</a>
                        <a href="{{ route('pages-home') }}" class="th-btn style-border2 th-btn-icon">Principal</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
