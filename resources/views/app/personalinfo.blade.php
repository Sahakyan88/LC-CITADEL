@extends('app.layouts.app')
@section('content')
    @if (Auth::user())
        <section class="service-detail">
            <div class="container">
                <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);">
                    @include('components.menu-profile')
                    <div class="col-sm-8 mt-5 profile-top-mobile">
                        <div data-aos="fade-up">
                            <h5 class="service-detail__title">
                                {{ config()->get('lang.' . App::getLocale() . '.personal_information') }}</h5>
                            @if (Session::has('success'))
                                <div class="alert alert-success text-center">
                                    <p>{{ Session::get('success') }}</p>
                                </div>
                            @endif
                            <form class="php-email-form " method="post" action="{{ route('edUserinfo') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group">
                                        <input type="text" name="first_name" class="form-control"
                                            value="{{ Auth::user()->first_name }}"
                                            @if ($old = old('first_name')) value="{{ $old }}" @endif>
                                        @error('first_name')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="last_name" class="form-control"
                                            value="{{ Auth::user()->last_name }}"
                                            @if ($old = old('last_name')) value="{{ $old }}" @endif>
                                        @error('last_name')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ Auth::user()->phone }}"
                                            @if ($old = old('phone')) value="{{ $old }}" @endif>
                                        @error('phone')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input disabled type="text" name="email" class="form-control"
                                            value="{{ Auth::user()->email }}"
                                            @if ($old = old('email')) value="{{ $old }}" @endif>
                                        @error('email')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="text-center"><button
                                        type="submit">{{ config()->get('lang.' . App::getLocale() . '.save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
