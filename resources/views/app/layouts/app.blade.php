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
    <header id="header" class="fixed-top d-flex align-items-center">
        <div class="container d-flex justify-content-between">

            <div class="logo">
                <h1><a href="{{ route('homepage') }}"><img src="{{ asset('assets/img/logo.jpg') }}"></a></h1>
            </div>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto {{ request()->is('/') ? 'active' : '' }}"
                            href="{{ route('homepage') }}">Home</a></li>
                    <li><a class="nav-link scrollto {{ request()->is('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">About</a></li>
                    <li><a class="nav-link scrollto {{ request()->is('services') ? 'active' : '' }}"
                            href="{{ route('service') }}">Services</a></li>
                    </li>
                    <li><a class="nav-link scrollto {{ request()->is('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">Contact</a></li>
                    @if (Auth::user())
                        <li><a class="nav-link scrollto {{ request()->is('auth') ? 'active' : '' }}"
                                href="{{ url('/login-user') }}">Profile</a></li>
                    @else
                        <li><a class="nav-link scrollto {{ request()->is('login-user') ? 'active' : '' }}"
                                href="{{ route('login-user') }}">Signin</a></li>
                        <li><a class="nav-link scrollto {{ request()->is('register-user') ? 'active' : '' }}"
                                href="{{ route('register-user') }}">Signup</a></li>
                    @endif
                    <li>
                        <div class="dropdown"> <button class="btn  dropdown-toggle" type="button"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                @if (App::getLocale() == 'am')
                                    <img class="lang-img" src="{{ asset('assets/img/arm.jpg') }}">
                                @elseif(App::getLocale() == 'ru')
                                    <img class="lang-img" src="{{ asset('assets/img/rus.png') }}">
                                @else
                                    <img class="lang-img" src="{{ asset('assets/img/eng.webp') }}">
                                @endif
                            </button>
                            <ul class="dropdown-menu lang" aria-labelledby="dropdownMenuButton1">
                                @foreach (config('app.active_langs') as $l => $language)
                                    @if ($l != App::getLocale())
                                        <?php $segment1 = Request::segment(1);
                                        if (app::getLocale() == 'am') {
                                            if (strlen($segment1) > 0) {
                                                $link = str_replace(Request::root() . '/' . $segment1, Request::root() . '/' . $l . '/' . $segment1, URL::current());
                                            } else {
                                                $link = str_replace(Request::root(), Request::root() . '/' . $l, URL::current());
                                            }
                                        } else {
                                            $link = str_replace(Request::root() . '/' . $segment1, Request::root() . '/' . $l . '/', URL::current());
                                        } ?> <a class="lang-a"
                                            href="{{ $link }}">{{ $language }}</a>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
        </div>
    </header>
    <main id="main">
        @yield('content')
        <footer id="footer">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="footer-info">
                                <h1><a href="{{ route('homepage') }}"><img
                                            src="{{ asset('assets/img/logo.jpg') }}"></a></h1>
                                <p>
                                    @if (isset($site_settings->address))
                                        {{ $site_settings->address }}
                                    @endif
                                    <br>
                                    <br>
                                    <strong>Phone:</strong>
                                    @if (isset($site_settings->phone))
                                        {{ $site_settings->phone }}
                                    @endif
                                    <br>
                                    <strong>Email:</strong>
                                    @if (isset($site_settings->email))
                                        {{ $site_settings->email }}
                                    @endif
                                    <br>
                                </p>
                                <div class="social-links mt-3">
                                    <a href="@if (isset($site_settings->twitter)) {{ $site_settings->twitter }} @endif"
                                        class="twitter"><i class="bx bxl-twitter"></i></a>
                                    <a href="@if (isset($site_settings->facebook)) {{ $site_settings->facebook }} @endif"
                                        class="facebook"><i class="bx bxl-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('homepage') }}">Home</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('about') }}">About us</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('service') }}">Services</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="{{ route('contact') }}">Contact</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#faq">F.A.Q</a></li>
                              
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 footer-links">
                            <h4>Newsletter</h4>
                            <ul>
                                @if (Auth::user())
                                <li><i class="bx bx-chevron-right"></i> <a href="{{ url('/login-user') }}">profile</a>
                                </li>
                            @else
                               <li> <i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('login-user') }}">Signin</a></li>
                               <li> <i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('register-user') }}">Signup</a></li>
                            @endif
                              
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    &copy; Copyright <strong><span>Maxim</span></strong>. All Rights Reserved
                </div>
            </div>
        </footer>
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>
        <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
        <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
        {{-- <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script> --}}
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        {{-- <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script> --}}
        @stack('script')
</body>

</html>
