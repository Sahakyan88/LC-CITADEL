@extends('app.layouts.app')
@section('content')
    @if (!Auth::user())
        <section id="contact" class="contact"  >
            <div class="row">
                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <div data-aos="fade-up">
                        <h2 class="text-center">Signin</h2>
                        <form  id="login-form" method="post" role="form" class="php-email-form auth-page-login auth-page">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" >
                                </div>
                                <div class="form-group col-sm-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Signin</button></div>
                        </form>
                    </div>

                </div>
                <div class="form-group col-lg-8 col-md-6 col-sm-8">
                    <div data-aos="fade-up">
                        <h2 class="text-center">Signup</h2>
                        <form method="POST" id="register-form" class="php-email-form auth-page">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="first_name" class="form-control" id="first_name"
                                        placeholder="Your First Name">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" name="last_name" class="form-control" id="last_name"
                                        placeholder="Your Last Name">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="number" name="phone" class="form-control" id="phone"
                                        placeholder="Your Phone Number">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="text" class="form-control" name="address" id="address"
                                        placeholder="Your Address">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email">
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Signup</button></div>
                        </form>
                    </div>
                </div>

            </div>
        </section>
    @else
        <section class="service-detail">
            <div class="container">
                <div class="row clearfix">
                    @include('components.menu-profile')
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <h2 class="service-detail__title">Personal Information</h2>
                        <div class="service-detail__text">
                            <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                <div class="contact-form">
                                    @if (Session::has('success'))
                                        <div class="alert alert-success text-center">
                                            <p>{{ Session::get('success') }}</p>
                                        </div>
                                    @endif
                                    <!-- Contact Form -->
                                    <form class="contact-form " method="POST" action="">
                                        @csrf
                                        <div class="row clearfix">
                                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                                <input type="text" id="first_name" name="first_name"
                                                    value="{{ Auth::user()->first_name }}" placeholder="First Name">
                                                <label for="name" id="firstnameMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" id="last_name" name="last_name"
                                                    value="{{ Auth::user()->last_name }}" placeholder="Last Name">
                                                <label for="name" id="lastnameMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" id="address"
                                                    name="address"value="{{ Auth::user()->address }}"
                                                    placeholder="Address">
                                                <label for="name" id="addressMsg" class="error"></label>

                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="email" id="email"
                                                    name="email"value="{{ Auth::user()->email }}"
                                                    placeholder="Email Address">
                                                <label for="name" id="emailMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="tel" id="phone" name="phone" placeholder="Phone"
                                                    value="{{ Auth::user()->phone }}">
                                                <label for="name" id="phoneMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="text" id="company"
                                                    name="company"value="{{ Auth::user()->company }}"
                                                    placeholder="Company Name">
                                                <label for="name" id="companyMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <input type="number" id="licanece_number"
                                                    name="licanece_number"value="{{ Auth::user()->licanece_number }}"
                                                    placeholder="Licanece Number">
                                                <label for="name" id="licaneceMsg" class="error"></label>
                                            </div>
                                            <div class="form-group col-lg-6 col-md-6 col-sm-12">
                                                <button type="submit" class="theme-btn btn-style-two"><span
                                                        class="txt">Save
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                    <!-- End Contact Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    @push('script')
        <script src="{{ asset('assets/js/main.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery/jquery-v3.6.0.js') }}"></script>
        <script src="{{ asset('assets/vendor/validate/js/validate.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script>
            $('.auth-page').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $('.owner-form .error').remove();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/signup') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            location.reload();
                        }
                    },
                    error: function(response) {
                        if (response.responseJSON.errors) {
                            errors = response.responseJSON.errors
                            $.each(errors, function(key, value) {
                                if ($("#" + key).length > 0) {
                                    $("#" + key).after('<label class="error">' + value +
                                        '</label>');
                                }
                            });
                            $('html, body').animate({
                                scrollTop: $("html").offset().top
                            }, 500);
                        }
                        return;
                    }
                });

            });
            $('.auth-page-login').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $('.owner-form .error').remove();
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/signin') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            location.reload();
                        }
                    },
                    error: function(response) {
                        if (response.responseJSON.errors) {
                            errors = response.responseJSON.errors
                            $.each(errors, function(key, value) {
                                if ($("#" + key).length > 0) {
                                    $("#" + key).after('<label class="error">' + value +
                                        '</label>');
                                }
                            });
                            $('html, body').animate({
                                scrollTop: $("html").offset().top
                            }, 500);
                        }
                        return;
                    }
                });

            });
        </script>
    @endpush
@endsection
