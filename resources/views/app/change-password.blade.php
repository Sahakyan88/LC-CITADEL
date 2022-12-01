@extends('app.layouts.app')
@section('content')
    <section class="service-detail">
        <div class="container">
            <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);" >
                @include('components.menu-profile')
                <div class="col-sm-8 mt-5 contact profile-top-mobile">
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">{{config()->get('lang.' . App::getLocale() . '.change_pass')}}</h5>
                        @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                        <form  method="POST" action="{{ route('changepassword') }}" class="php-email-form">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <input type="password" name="old_password" class="form-control font-cl"
                                        placeholder="{{config()->get('lang.' . App::getLocale() . '.old_pass')}} " required
                                        @if ($old = old('old_password')) value="{{ $old }}" @endif>
                                    @error('old_password')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new_password" class="form-control font-cl" required
                                        placeholder="{{config()->get('lang.' . App::getLocale() . '.new_pass')}}"
                                        @if ($old = old('new_password')) value="{{ $old }}" @endif>
                                    @error('new_password')
                                    <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control font-cl" required
                                    placeholder="{{config()->get('lang.' . App::getLocale() . '.confirm_pass')}}"
                                    @if ($old = old('confirm_password')) value="{{ $old }}" @endif>
                                @error('confirm_password')
                                <p class="error">{{ $message }}</p>

                                @enderror
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">{{config()->get('lang.' . App::getLocale() . '.save')}}</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
