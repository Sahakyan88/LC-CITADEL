@extends('app.layouts.app')
@section('content')
    <section id="contact" class="contact services section-bg">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>{{ config()->get('lang.' . App::getLocale() . '.contact') }}</h2>
                @if (count($dictionary) > 0)
                    <p>{{ $dictionary[0]->contact }}</p>
                @endif
            </div>
            <div class="row no-gutters justify-content-center" data-aos="fade-up">
                <div class="col-lg-5 d-flex align-items-stretch">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.address') }}:</h4>
                            <p>
                                @if (isset($site_settings->address_am) && App::getLocale() == 'am')
                                    {{ $site_settings->address_am }}
                                @elseif(isset($site_settings->address_ru) && App::getLocale() == 'ru')
                                    {{ $site_settings->address_ru }}
                                @else
                                    {{ $site_settings->address_en }}
                                @endif
                            </p>
                        </div>
                        <div class="email mt-4">
                            <i class="bi bi-envelope"></i>
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.email') }}:</h4>
                            <p>
                                @if (isset($site_settings->email))
                                    {{ $site_settings->email }}
                                @endif
                            </p>
                        </div>
                        <div class="phone mt-4">
                            <i class="bi bi-phone"></i>
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.phone') }}:</h4>
                            <p>
                                @if (isset($site_settings->phone))
                                    {{ $site_settings->phone }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-stretch">
                    <iframe frameborder="0" allowfullscreen
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d380.98403136106884!2d44.522032860334235!3d40.18965637049697!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x406abcdf9481fba5%3A0x87d321a93f5a37e2!2z1ZHVq9W_1aHVpNWl1aw!5e0!3m2!1shy!2s!4v1669730474394!5m2!1shy!2s"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
            <div>
                <div class="row mt-5 justify-content-center" data-aos="fade-up">
                    <div class="text-center" id="thank-you">
                        <div>&#10004;</div>
                    </div>
                    <div class="text-center" id="error-you">
                        <span>&#10006;</span>
                    </div>
                    <div class="col-lg-10">

                        <form id="send-form" method="post" class="php-email-form contact-page">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control"
                                        placeholder="{{ config()->get('lang.' . App::getLocale() . '.name') }}">
                                </div>
                                <div class="col-md-6 form-group mt-3 mt-md-0">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="{{ config()->get('lang.' . App::getLocale() . '.email') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" name="phone"
                                        placeholder="{{ config()->get('lang.' . App::getLocale() . '.phone') }}">
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="text" class="form-control" name="subject"
                                        placeholder="{{ config()->get('lang.' . App::getLocale() . '.subject') }}">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <textarea class="form-control" name="message" rows="5"
                                    placeholder="{{ config()->get('lang.' . App::getLocale() . '.message') }}"></textarea>
                            </div>
                            <div class="text-center"><button
                                    type="submit">{{ config()->get('lang.' . App::getLocale() . '.send') }}</button></div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
    @push('script')
        <script src="{{ asset('assets/vendor/jquery/jquery-v3.6.0.js') }}"></script>
        <script src="{{ asset('assets/vendor/validate/js/validate.js') }}"></script>
        <script src="{{ asset('assets/js/script.js') }}"></script>
        <script>
            $('.contact-page').submit(function(event) {
                event.preventDefault();
                var formData = new FormData(this);
                $('.owner-form .error').remove();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('send') }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 1) {
                            $('#thank-you').show();
                            location.reload();
                        }
                    },
                    error: function(response) {
                        if (response.responseJSON.errors) {
                            $('#error-you').show();
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
