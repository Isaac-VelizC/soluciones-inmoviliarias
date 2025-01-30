<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Soluciones Inmboliviarias - @yield('og_title', 'Principal')</title>
    <meta name="author" content="Casas">
    <meta name="description"
        content="@yield('og_description', 'Empresa especializada en compra y venta de propiedades')">
    <meta name="keywords" content="@yield('og_keywords', 'propiedades, casas, terrenos, venta, compra')">
    <meta name="robots" content="INDEX,FOLLOW">
    <!-- Social Metas -->
    <meta property="og:title" content="@yield('og_title', 'Principal')">
    <meta property="og:description"
        content="@yield('og_description', 'Empresa especializada en compra y venta de propiedades')">
    <meta property="og:image" content="@yield('og_image', asset('web/Soluciones_Inmobiliarias.webp'))">
    <meta property="og:url" content="@yield('og_url', 'http://casas.test')">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'Principal')">
    <meta name="twitter:description"
        content="@yield('og_description', 'Empresa especializada en compra y venta de propiedades')">
    <meta name="twitter:image" content="@yield('og_image', asset('web/Soluciones_Inmobiliarias.webp'))">
    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons - Place favicon.ico in the root directory -->
    <link rel="icon" type="image/png" sizes="16x16" href="/web/assets/img/favicons/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/web/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/web/assets/img/favicons/favicon-192x192.png"/>
    <link rel="manifest" href="/web/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!--==============================
    Google Fonts
  ============================== -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet">

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
    @yield('css')
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=678faadfeec4bb0012d85463&product=inline-share-buttons&source=platform"
        async="async"></script>
</head>

<body class="bg-smoke">
    <!--============================== Preloader ==============================-->
    <div id="preloader" class="preloader ">
        <div id="loader" class="th-preloader">
            <div class="animation-preloader">
                <div class="txt-loading">
                    <span preloader-text="S" class="characters">S</span>
                    <span preloader-text="O" class="characters">O</span>
                    <span preloader-text="L" class="characters">L</span>
                    <span preloader-text="U" class="characters">U</span>
                    <span preloader-text="C" class="characters">C</span>
                    <span preloader-text="I" class="characters">I</span>
                    <span preloader-text="O" class="characters">O</span>
                    <span preloader-text="N" class="characters">N</span>
                    <span preloader-text="E" class="characters">E</span>
                    <span preloader-text="S" class="characters">S</span>
                    <br>
                    <span preloader-text="I" class="characters">I</span>
                    <span preloader-text="N" class="characters">N</span>
                    <span preloader-text="M" class="characters">M</span>
                    <span preloader-text="O" class="characters">O</span>
                    <span preloader-text="B" class="characters">B</span>
                    <span preloader-text="I" class="characters">I</span>
                    <span preloader-text="L" class="characters">L</span>
                    <span preloader-text="I" class="characters">I</span>
                    <span preloader-text="A" class="characters">A</span>
                    <span preloader-text="R" class="characters">R</span>
                    <span preloader-text="I" class="characters">I</span>
                    <span preloader-text="A" class="characters">A</span>
                    <span preloader-text="S" class="characters">S</span>

                </div>
            </div>
        </div>
    </div>
    <!--============================== Mobile Menu ============================== -->
    <div class="th-menu-wrapper onepage-nav">
        <div class="th-menu-area text-center">
            <button class="th-menu-toggle"><i class="fal fa-times"></i></button>
            <div class="mobile-logo">
                <a href="/">
                    <img src="/web/assets/img/logo-white.png" alt="Soluciones Inmobiliarias">
                </a>
            </div>
            <div class="th-mobile-menu">
                <ul>
                    <li>
                        <a href="/">
                            Principal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('propiedades.index') }}">
                            Propiedades
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('nosotros.index') }}">
                            Nosotros
                        </a>
                    </li>
                    @auth
                    @role('admin')
                    <li>
                        <a href="{{ route('adm.propiedades.index') }}" class="color: #E2B93B;">
                            Administración
                        </a>
                    </li>
                    @endrole
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Salir
                        </a>
                    </li>
                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    @else
                    <li>
                        <a href="{{ route('login') }}">
                            Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </div>
    <!--============================== Sidemenu ============================== -->
    <div class="sidemenu-wrapper sidemenu-info d-none d-lg-block ">
        <div class="sidemenu-content">
            <button class="closeButton sideMenuCls"><i class="far fa-times"></i></button>
            <div class="widget  ">
                <div class="th-widget-about">
                    <div class="about-logo">
                        <a href="/"><img src="/web/assets/img/logo.svg" alt="Realar"></a>
                    </div>
                    <p class="about-text"> Servicios Inmobiliaros</p>
                </div>
            </div>
            <div class="widget  ">
                <h3 class="widget_title">Get In Touch</h3>
                <div class="th-widget-contact">
                    <div class="info-box_text">
                        <div class="icon"><img src="/web/assets/img/icon/location-dot.svg" alt="img"></div>
                        <div class="details">
                            <p>789 Inner Lane, Holy park,</p>
                            <p>California, USA</p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="/web/assets/img/icon/phone.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="tel:+0123456789" class="info-box_link">+01 234 567 890</a></p>
                            <p><a href="tel:+09876543210" class="info-box_link">+09 876 543 210</a></p>
                        </div>
                    </div>
                    <div class="info-box_text">
                        <div class="icon">
                            <img src="/web/assets/img/icon/envelope.svg" alt="img">
                        </div>
                        <div class="details">
                            <p><a href="mailto:mailinfo00@realar.com" class="info-box_link">mailinfo00@realar.com</a>
                            </p>
                            <p><a href="mailto:support24@realar.com" class="info-box_link">support24@realar.com</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget newsletter-widget  ">
                <h3 class="widget_title">Subscribe Now</h3>
                <form class="newsletter-form">
                    <div class="form-group">
                        <input class="form-control" type="email" placeholder="Email Address" required="">
                        <button type="submit" class="th-btn"><i class="far fa-paper-plane text-theme"></i></button>
                    </div>
                </form>
                <div class="th-social style2">
                    <a href="https://www.facebook.com/profile.php?id=100076063382588"><i
                            class="fab fa-facebook-f"></i></a>
                    <a href="https://www.twitter.com/"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.behance.com/"><i class="fab fa-behance"></i></a>
                    <a href="https://www.vimeo.com/"><i class="fab fa-vimeo-v"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!--============================== Header Area ==============================-->
    <header class="th-header header-layout1">
        <div class="sticky-wrapper">
            <!-- Main Menu Area -->
            <div class="menu-area">
                <div class="container">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <div class="header-logo">
                                <a href="/">
                                    <img src="/web/assets/img/logo-white.png" alt="Soluciones Inmobiliarias">
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <nav class="main-menu d-none d-lg-inline-block">
                                <ul>
                                    <li>
                                        <a href="/">
                                            Principal
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('propiedades.index') }}">
                                            Propiedades
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('nosotros.index') }}">
                                            Nosotros
                                        </a>
                                    </li>
                                    @auth
                                    @role('admin')
                                    <li>
                                        <a href="{{ route('adm.propiedades.index') }}" class="color: orange;">
                                            <div style="color: #E2B93B">Administración</div>
                                        </a>
                                    </li>
                                    @endrole
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Salir
                                        </a>
                                    </li>
                                    <form method="POST" id="logout-form" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                    @else
                                    <li>
                                        <a href="{{ route('login') }}">
                                            Login
                                        </a>
                                    </li>
                                    @endauth
                                </ul>
                            </nav>
                            <div class="header-button d-flex d-lg-none">
                                <button type="button" class="th-menu-toggle sidebar-btn">
                                    <span class="line"></span>
                                    <span class="line"></span>
                                    <span class="line"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-auto d-none d-xl-block">
                            <div class="header-button">
                                <a href="#contact" class="th-btn btn-mask th-btn-icon">Contactenos</a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>

    <!-- Main view  -->
    @yield('content')

    <!--============================== Footer Area ==============================-->
    <footer id="contact" class="footer-wrapper footer-layout1 bg-theme">
        <div class="footer-wrap bg-smoke" data-mask-src="/web/assets/img/bg/footer-bg-mask.png">
            <div class="widget-area space">
                <div class="container">
                    <div class="row justify-content-between">
                        <div class="col-md-6 col-xl-4">
                            <div class="widget footer-widget">
                                <div class="th-widget-about">
                                    <div class="about-logo">
                                        <a href="/"><img src="/web/assets/img/logo.png" alt="Realar"></a>
                                    </div>
                                    <p class="about-text">soluciones Inmobiliarias: Expertos en propiedades, creamos
                                        hogares y oportunidades. Transformamos sueños en realidad con servicio
                                        personalizado e innovación inmobiliaria.</p>
                                    <div class="th-social style3">
                                        <a href="https://www.facebook.com/profile.php?id=100076063382588"><i
                                                class="fab fa-facebook-f"></i></a>
                                        <a href="#"><i
                                                class="fa-brands fa-whatsapp"></i></a>
                                        <a href="#"><i
                                                class="fab fa-instagram-square"></i></a>
                                        <a href="mailto:casagrupoinmobiliario@gmail.com"><i
                                                class="fa-solid fa-envelope"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="widget footer-widget">
                                <h3 class="widget_title">Ponerse en contacto</h3>
                                <div class="th-widget-contact">
                                    <div class="info-box_text">
                                        <div class="icon"><img src="/web/assets/img/icon/location-dot.svg" alt="img">
                                        </div>
                                        <div class="details">
                                            <p>Calle Padilla Nº66, Zona central</p>
                                            <p>Potosí, Bolivia</p>
                                        </div>
                                    </div>
                                    <div class="info-box_text">
                                        <div class="icon">
                                            <img src="/web/assets/img/icon/phone.svg" alt="img">
                                        </div>
                                        <div class="details">
                                            <p><a href="tel:+59176168889" class="info-box_link">+591 76168889</a></p>
                                        </div>
                                    </div>
                                    <div class="info-box_text">
                                        <div class="icon">
                                            <img src="/web/assets/img/icon/envelope.svg" alt="img">
                                        </div>
                                        <div class="details">
                                            <p><a href="mailto:casagrupoinmobiliario@gmail.com"
                                                    class="info-box_link">solucionesinmobiliario@gmail.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div class="copyright-wrap">
                <div class="container">
                    <div class="row gy-2 align-items-center">
                        <div class="col-lg-6">
                            <p class="copyright-text">
                                Copyright <i class="fal fa-copyright"></i> 2024 <a href="/">Soluciones Inmobiliarias</a>, Derechos
                                reservados.
                            </p>
                        </div>
                        <div class="col-lg-6">
                            <div class="th-social justify-content-lg-end justify-content-center">
                                <a href="#"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-whatsapp"></i></a>
                                <a href="#/"><i
                                        class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!--******************************** Code End  Here ******************************** -->

    <!-- Scroll To Top -->
    <div class="scroll-top">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"
                style="transition: stroke-dashoffset 10ms linear 0s; stroke-dasharray: 307.919, 307.919; stroke-dashoffset: 307.919;">
            </path>
        </svg>
    </div>

    <!--============================== All Js File ============================== -->
    <!-- Jquery -->
    <script src="/web/assets/js/vendor/jquery-3.7.1.min.js"></script>
    <!-- Swiper Js -->
    <script src="/web/assets/js/swiper-bundle.min.js"></script>
    <!-- Bootstrap -->
    <script src="/web/assets/js/bootstrap.min.js"></script>
    <!-- Magnific Popup -->
    <script src="/web/assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Counter Up -->
    <script src="/web/assets/js/jquery.counterup.min.js"></script>
    <!-- Range Slider -->
    <script src="/web/assets/js/jquery-ui.min.js"></script>
    <!-- Isotope Filter -->
    <script src="/web/assets/js/imagesloaded.pkgd.min.js"></script>
    <script src="/web/assets/js/isotope.pkgd.min.js"></script>
    <!-- Gsap -->
    <script src="/web/assets/js/gsap.min.js"></script>

    <!-- Main Js File -->
    <script src="/web/assets/js/main.js"></script>
</body>

</html>