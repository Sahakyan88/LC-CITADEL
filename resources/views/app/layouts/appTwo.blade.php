<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>LC-CITADEL</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    @if (!Auth::user())
        <style>
            body {
                overflow: hidden;
                background-color: #f2f9f8;
                
            }
            .fixed-top {
                background: #b8c2c1 !important;
            }
            .mobile-nav-toggle {
                    display: none;
                }
        </style>

        <header id="header" class="fixed-top d-flex align-items-center">
            <div class="container d-flex justify-content-between">

                <div class="logo">
                    <h1><a href="{{ route('homepage') }}"><img src="{{ asset('assets/img/nkar.png') }}">LC-Citadel</a>
                    </h1>
                </div>
                <nav id="navbar" class="navbar">

                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav>
            </div>
        </header>

        @yield('sectionTwo')

        <footer id="footer" class="footerTwo">

            <div class="container">
                <div class="copyright">
                    &copy; 2022 <strong><span>LC-CITADEL</span></strong>
                    {{ config()->get('lang.' . App::getLocale() . '.copyright') }}
                </div>
            </div>
        </footer>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        @stack('script')
    @else
        @yield('sectionTwo')
    @endif
</body>

</html>
