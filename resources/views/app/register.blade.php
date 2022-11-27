@extends('app.layouts.app')
@section('content')
    @if (!Auth::user())
        <section id="contact" class="contact services section-bg">
            <div class="container col-sm-6 ">
                <div class="row">
                    <div class="form-group ">
                        <div data-aos="fade-up">
                            <h2 class="text-center">Sign Up</h2>
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

                                <div class="text-center">
                                    <button type="submit">Sign Up</button>
                                </div>
                                <br>
                                <p>Already a member? <a href="{{url('/login-user')}}">Sign In</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="service-detail">
            <div class="container">
                @include('components.profile')

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
            $('.auth-page').submit(function (event) {
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
                    success: function (response) {
                        if (response.status == 1) {
                            location.reload();
                        }
                    },
                    error: function (response) {
                        if (response.responseJSON.errors) {
                            errors = response.responseJSON.errors
                            $.each(errors, function (key, value) {
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
            $('.auth-page-login').submit(function (event) {
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
                    success: function (response) {
                        if (response.status == 1) {
                            location.reload();
                        }
                    },
                    error: function (response) {
                        if (response.responseJSON.errors) {
                            errors = response.responseJSON.errors
                            $.each(errors, function (key, value) {
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
