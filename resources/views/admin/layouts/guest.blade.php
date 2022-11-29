<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Admin panel</title>
        <link href="/backend/css/styles.css" rel="stylesheet" />
        <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/nkar.png') }}">
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary" style="background-color: #6e8785 !important">
        <div id="layoutAuthentication">
            <a style="text-decoration: none;color:white !important;" href="{{ route('homepage')  }}"><img style="width: 12%;" src="{{ asset('assets/img/nkar.png') }}">LC-CITADEL</a>

            <div id="layoutAuthentication_content">
                @yield('content')
               
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="footer mt-auto footer-dark">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; LC-CITADEL </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="/backend/js/scripts.js"></script>
        @stack('script')
    </body>
</html>