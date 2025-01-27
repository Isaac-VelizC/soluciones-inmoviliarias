@extends('web.layouts.app')

@section('title', 'Nosotros')
@section('content')
    <div class="breadcumb-wrapper background-image" style="background-image: url(&quot;/web/assets/img/bg/breadcumb-bg.jpg&quot;);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-9">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Servicios</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="/">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="py-3 py-md-5">
        <div class="container">
            <div class="row gy-3 gy-md-4 gy-lg-0 align-items-lg-center">
                <div class="col-12 col-lg-6 col-xl-5">
                    <img class="img-fluid rounded" loading="lazy" src="https://espaciohr.com/wp-content/uploads/2024/05/Organigrama-de-una-inmobiliaria-1.jpg" alt="Sobre nosotros">
                </div>
                <div class="col-12 col-lg-6 col-xl-7">
                    <div class="row justify-content-xl-center">
                        <div class="col-12 col-xl-11">
                            <h2 class="mb-3">¿Quiénes Somos?</h2>
                            <p class="lead fs-4 text-secondary mb-3">En Soluciones Inmobiliarias, transformamos sueños en realidades. Nuestro compromiso es ofrecer un servicio excepcional y personalizado a cada cliente.</p>
                            <p class="mb-5">Como una empresa en crecimiento, nos mantenemos fieles a nuestros valores fundamentales: colaboración, innovación y satisfacción del cliente. Siempre estamos buscando nuevas formas de mejorar nuestros servicios y adaptarnos a tus necesidades.</p>
                            <div class="row gy-4 gy-md-0 gx-xxl-5X">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex">
                                        <div class="me-4 text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l .17-.31c-.698-1 .705 -2 .705zM8 10a3 3 0 100 -6a3 -3 -3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="h4 mb-3">Marca Versátil</h2>
                                            <p class="text-secondary mb-0">Creamos métodos digitales que dan vida a experiencias en todos los medios.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="d-flex">
                                        <div class="me-4 text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-fire" viewBox="0 0 16 16">
                                                <path d="M8 .5C6 .5,5 .5,5 .5C5 .5,5 .5,5 .5C5 .5,6 .5,8 .5C10 .5,11 .5,11 .5C11 .5,11 .5,11 .5C11 .5,10 .5,8 .5Z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="h4 mb-3">Agencia Digital</h2>
                                            <p class="text-secondary mb-0">Creemos en la innovación al fusionar ideas simples con conceptos elaborados.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection