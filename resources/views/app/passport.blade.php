@extends('app.layouts.app')
@section('content')
    <link href="{{ asset('backend/css/passport.css') }}" rel="stylesheet">
    <section class="service-detail">
        <div class="container">
            <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);">
                @include('components.menu-profile')
                <div class="col-sm-8 mt-5 contact profile-top-mobile">
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">{{ config()->get('lang.' . App::getLocale() . '.passport') }}
                        </h5>
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        @if(auth()->user()['image_id'] == null)
                        <div class="alert alert-warning" role="alert">
                            {{ config()->get('lang.' . App::getLocale() . '.must-upload-passport') }}
                        </div>
                        @endif
                        <div class="php-email-form">
                            <div >
                                <div class="form-input">
                                    <div class="preview">
                                        @if ($image[0]->image_file_name)
                                            <img style="display: block"
                                                src="{{ asset('passport/' . $image[0]->image_file_name) }}">
                                        @endif
                                        <img id="file-ip-1-preview">
                                    </div>
                                    @if ($image[0]->image_file_name)
                                        <form action="{{ route('deleteImage') }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" value="{{ $image[0]->id }}" name="image_id">
                                            <div style="text-align: center"> <button style="background-color: red;" type="submit">{{ config()->get('lang.' . App::getLocale() . '.delete_image') }}</button></div>
                                        </form>
                                    @else
                                        <label for="file-ip-1">{{ config()->get('lang.' . App::getLocale() . '.upload_image') }}</label>
                                    @endif
                                    <form method="POST" enctype="multipart/form-data"
                                        action="{{ route('imagePassport') }}">
                                        @csrf
                                        <input type="file" id="file-ip-1" name="image" accept="image/*"
                                            onchange="showPreview(event);">
                                </div>
                                @if ($image[0]->image_file_name)
                                    <button style="display: none"
                                        type="submit">{{ config()->get('lang.' . App::getLocale() . '.save') }}</button>
                                @else
                                <div class="vit-lamg">
                                    <button
                                        type="submit">{{ config()->get('lang.' . App::getLocale() . '.save') }}</button>
                                </div>
                                        @endif
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        function showPreview(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
@endsection
