@extends('app.layouts.app')
@section('content')
    @if (!Auth::user())
        <section id="contact" class="contact services section-bg">
            <div class="container col-sm-4">
                <div class="form-group">
                    <div data-aos="fade-up">
                        <h2 class="text-center">Signin</h2>
                        <form  id="register-form" method="post" role="form" class="php-email-form auth-page-login auth-page">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email" >
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password">
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Sign In</button></div>
                            <br>
                            <p>Don't have an account yet? <a href="{{route('register-user')}}">Sign Up</a>  </p>
                        </form>
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
                        console.log(response.responseJSON);
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
