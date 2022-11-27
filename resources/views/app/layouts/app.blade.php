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
                            href="{{ route('homepage') }}">{{ config()->get('lang.' . App::getLocale() . '.home') }}</a>
                    </li>
                    <li><a class="nav-link scrollto {{ request()->is('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">{{ config()->get('lang.' . App::getLocale() . '.about_us') }}</a>
                    </li>
                    <li><a class="nav-link scrollto {{ request()->is('services') ? 'active' : '' }}"
                            href="{{ route('service') }}">{{ config()->get('lang.' . App::getLocale() . '.services') }}
                        </a>
                    </li>
                    </li>
                    <li><a class="nav-link scrollto {{ request()->is('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">{{ config()->get('lang.' . App::getLocale() . '.contact_us') }}</a>
                    </li>
                    @if (Auth::user())
                        <li><a class="nav-link scrollto {{ request()->is('auth') ? 'active' : '' }}"
                                href="{{ route('personalinfo') }}">{{ config()->get('lang.' . App::getLocale() . '.profile') }}</a>
                        </li>
                    @else
                        <li><a class="nav-link scrollto {{ request()->is('register-user') ? 'active' : '' }}"
                                href="{{ route('login-user') }}">{{ config()->get('lang.' . App::getLocale() . '.sign_in') }}</a>
                        </li>
                    @endif
                    <li>
                        <div class="dropdown">
                            <button class="btn  dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
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
                                            if (strlen($segment1) > 1) {
                                                $link = str_replace(Request::root() . '/' . $segment1, Request::root() . '/' . $l . '/' . $segment1, URL::current());
                                            // dd($link);
                                            } else {
                                                $link = str_replace(Request::root(), Request::root() . '/' . $l, URL::current());
                                                // dd($link);
                                            }
                                        } else {
                                            $link = str_replace(Request::root() . '/' . $segment1, Request::root() . '/' . $l, URL::current());
                                        } ?>
                                        <a class="lang-a" href="{{ $link }}">{{ $language }}</a>
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
                                    @if (isset($site_settings->address_am) && App::getLocale() == 'am')
                                        {{ $site_settings->address_am }}
                                    @elseif(isset($site_settings->address_ru) && App::getLocale() == 'ru')
                                        {{ $site_settings->address_ru }}
                                    @else
                                        {{ $site_settings->address_en }}
                                    @endif
                                    <br>
                                    <br>
                                    @if (isset($site_settings->email))
                                        {{ $site_settings->email }}
                                    @endif
                                    <br>
                                    @if (isset($site_settings->phone))
                                        {{ $site_settings->phone }}
                                    @endif
                                    <br>
                                </p>
                                <div class="social-links mt-3">
                                    <a href="@if (isset($site_settings->instagram)) {{ $site_settings->instagram }} @endif"
                                        class="instagram"><i class="bx bxl-instagram"></i></a>
                                    <a href="@if (isset($site_settings->facebook)) {{ $site_settings->facebook }} @endif"
                                        class="facebook"><i class="bx bxl-facebook"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 footer-links">
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('homepage') }}">{{ config()->get('lang.' . App::getLocale() . '.home') }}</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('about') }}">{{ config()->get('lang.' . App::getLocale() . '.about_us') }}</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('service') }}">{{ config()->get('lang.' . App::getLocale() . '.services') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-6 footer-links">
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('contact') }}">{{ config()->get('lang.' . App::getLocale() . '.contact_us') }}</a>
                                </li>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="#faq">{{ config()->get('lang.' . App::getLocale() . '.faq') }}</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    &copy; 2022 <strong><span>LC-CITADEL</span></strong>
                    {{ config()->get('lang.' . App::getLocale() . '.copyright') }}
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
