@extends('app.layouts.app')
@section('content')
    <section id="contact" class="contact">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint
                    consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat
                    sit in iste officiis commodi quidem hic quas.</p>
            </div>
            <div class="row no-gutters justify-content-center" data-aos="fade-up">
                <div class="col-lg-5 d-flex align-items-stretch">
                    <div class="info">
                        <div class="address">
                            <i class="bi bi-geo-alt"></i>
                            <h4>Location:</h4>
                            <p>@if (isset($site_settings->address))
                                {{ $site_settings->address }}
                            @endif</p>
                        </div>
                        <div class="email mt-4">
                            <i class="bi bi-envelope"></i>
                            <h4>Email:</h4>
                            <p> @if (isset($site_settings->email))
                                {{ $site_settings->email }}
                            @endif</p>
                        </div>
                        <div class="phone mt-4">
                            <i class="bi bi-phone"></i>
                            <h4>Call:</h4>
                            <p>@if (isset($site_settings->phone))
                                {{ $site_settings->phone }}
                            @endif</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 d-flex align-items-stretch">
                    <iframe style="border:0; width: 100%; height: 270px;"
                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621"
                        frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
            <div class="row mt-5 justify-content-center" data-aos="fade-up">
                <div class="col-lg-10">
                    <form id="send-form"  method="post" class="php-email-form contact-page">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <input type="text" name="name" class="form-control" id="name"
                                    placeholder="Your Name" >
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Your Email" >
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject"
                                >
                        </div>
                        <div class="form-group mt-3">
                            <textarea class="form-control" name="message" rows="5" placeholder="Message" ></textarea>
                        </div>
                        <div class="text-center"><button type="submit">Send Message</button></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @push('script')
    <script src="{{ asset('assets/js/main.js') }}"></script>
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
