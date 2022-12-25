@extends('app.layouts.app')
@section('content')
    <section class="service-detail">
        <div class="container">
            <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);">
                @include('components.menu-profile')
                <div class="col-sm-8 mt-5 contact profile-top-mobile">
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">{{ config()->get('lang.' . App::getLocale() . '.plans') }}</h5>
                        <div class="prof-order-block">
                            @if (count($packages) > 0)
                                @foreach ($packages as $package)
                                    <div class="php-email-form ">
                                        <div class="col-sm-12 title-order">{{ $package->title }}</div>
                                        <div class="col-sm-12 amount">{{ $package->amount }}
                                            {{ config()->get('lang.' . App::getLocale() . '.amd') }}</div>
                                        <div class="col-sm-2 mt-3 "></div>
                                        <hr>
                                        <div class="col-sm-12 date-prof">{{ config()->get('lang.' . App::getLocale() . '.got-package-at') }} {{ $package->date }}
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="php-email-form text-center">
                                    <p> {{ config()->get('lang.' . App::getLocale() . '.no-active-packages') }} </p>
                                    <a class="btn package-button" href="{{ route('service') }}" class="btn mt-4" type="submit">   {{ config()->get('lang.' . App::getLocale() . '.activate') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
