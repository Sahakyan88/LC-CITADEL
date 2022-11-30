<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>LC-CITADEL</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/nkar.png') }}">
    <link href="{!! asset('backend/css/styles.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    <link href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" rel="stylesheet"
          crossorigin="anonymous"/>
    <script data-search-pseudo-elements defer
            src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js"
            crossorigin="anonymous"></script>
    <link href="{!! asset('backend/vendor/bootstrap-toastr/toastr.min.css') !!}" media="all" rel="stylesheet"
          type="text/css"/>
    <link href="{!! asset('backend/css/custom.css') !!}" media="all" rel="stylesheet" type="text/css"/>
    @stack('css')
</head>
<body class="nav-fixed">
@include('admin.blocks.editor')
<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white"
     id="sidenavAccordion">
    <!-- Navbar Brand-->
    <!-- * * Tip * * You can use text or an image for your navbar brand.-->
    <!-- * * * * * * When using an image, we recommend the SVG format.-->
    <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
    <a class="navbar-brand" href="{{ route('dashboard') }}">
        <img style="width: 20%" src="{{ asset('assets/img/nkar.png') }}">
        LC-CITADEL
        <?php /* <!-- <img src="{!! asset('backend/img/logo.png') !!}" style="height: 25px;" /> --> */ ?>
    </a>
    <!-- Sidenav Toggle Button-->
    <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle"><i
            data-feather="menu"></i></button>

    <!-- Navbar Items-->
    <ul class="navbar-nav align-items-center ml-auto">
        <!-- User Dropdown-->
        <li class="nav-item dropdown no-caret mr-3 mr-lg-0 dropdown-user">
            <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage"
               href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false"><img class="img-fluid"
                                          src="/backend/assets/img/illustrations/profiles/profile-1.png"/></a>
            <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up"
                 aria-labelledby="navbarDropdownUserImage">
                <h6 class="dropdown-header d-flex align-items-center">
                    <img class="dropdown-user-img" src="/backend/assets/img/illustrations/profiles/profile-1.png"/>
                    <div class="dropdown-user-details">
                        <div
                            class="dropdown-user-details-name admin_name_lbl">{{auth()->guard('admin')->user()->name}}</div>
                    </div>
                </h6>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ route('adminProfile') }}">
                    <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                    Account
                </a>
                <a class="dropdown-item" href="{{ route('adminLogout') }}">
                    <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sidenav shadow-right sidenav-light">
            <div class="sidenav-menu">
                <div class="nav accordion" id="accordionSidenav">

                        <!-- Sidenav Menu Heading (Core)-->
                    <div class="sidenav-menu-heading">Main</div>
                    <!-- Sidenav Accordion (Dashboard)-->
                    <a class="nav-link @if(isset($menu) && $menu == 'dashboard') active @endif"
                       href="{{ route('dashboard') }}">
                        <div class="nav-link-icon"><i data-feather="activity"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link @if(isset($menu) && ($menu =='slider')) active @endif"
                       href="{{ route('adminHome') }}">
                        <div class="nav-link-icon"><i data-feather="home"></i></div>
                        Home Page
                    </a>
                    <a class="nav-link @if(isset($menu) && $menu == 'users') active @endif"
                       href="{{ route('ausers') }}">
                        <div class="nav-link-icon"><i data-feather="users"></i></div>
                        Users
                    </a>
                    <a class="nav-link @if(isset($menu) && $menu == 'about') active @endif"
                       href="{{ route('aAbout') }}">
                        <div class="nav-link-icon"><i data-feather="menu"></i></div>
                        About us
                    </a>
                    <a class="nav-link @if(isset($menu) && $menu == 'team') active @endif" href="{{ route('ateam') }}">
                        <div class="nav-link-icon"><i data-feather="users"></i></div>
                        Our Team
                    </a>
                    <a class="nav-link @if(isset($menu) && $menu == 'services') active @endif"
                       href="{{ route('adminServices') }}">
                        <div class="nav-link-icon"><i data-feather="dollar-sign"></i></div>
                        Services
                    </a>
                    <a class="nav-link @if(isset($menu) && ($menu =='faq')) active @endif"
                       href="{{ route('adminFaq') }}">
                        <div class="nav-link-icon"><i data-feather="help-circle"></i></div>
                        F.A.Q.
                    </a>
                    <a class="nav-link @if(isset($menu) && ($menu =='settings')) active @endif"
                       href="{{ route('adminSettings') }}">
                        <div class="nav-link-icon"><i data-feather="info"></i></div>
                        General info
                    </a>
                    <a class="nav-link @if(isset($menu) && ($menu =='dictionary')) active @endif"
                    href="{{ route('adminDictionary') }}">
                     <div class="nav-link-icon"><i data-feather="help-circle"></i></div>
                     Dictionary
                 </a>

                </div>
            </div>
            <!-- Sidenav Footer-->
            <div class="sidenav-footer">
                <div class="sidenav-footer-content">
                    <div class="sidenav-footer-subtitle">Logged in as:</div>
                    <div class="sidenav-footer-title admin_name_lbl">{{auth()->guard('admin')->user()->name}}</div>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        @yield('content')
        <footer class="footer mt-auto footer-light">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; LC-CITADEL 2022</div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script src="{!! asset('backend/vendor/bootstrap-toastr/toastr.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/vendor/bootbox/bootbox.min.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/vendor/popup.js') !!}" type="text/javascript"></script>
<script src="{!! asset('backend/js/scripts.js') !!}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" crossorigin="anonymous"></script>
@stack('script')
</body>
<div id="modal-container"></div>
</html>
