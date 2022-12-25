@extends('app.layouts.app')
@section('content')
    <section class="service-detail">
        <div class="container">
            <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);">
                @include('components.menu-profile')
                <div class="col-sm-8 mt-5 contact profile-top-mobile">
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">{{ config()->get('lang.' . App::getLocale() . '.services') }}</h5>
                        <div class="prof-order-block">
                            @if (count($order) > 0)
                                @foreach ($order as $order)
                                    <div class="php-email-form">
                                        <div class="col-sm-12 title-order">{{ $order->title }}</div>
                                        <div class="col-sm-12 amount">{{ $order->amount }}
                                            {{ config()->get('lang.' . App::getLocale() . '.amd') }}</div>
                                        @if ($order->status_been == 'upcoming')
                                            <div class="psuccess col-sm-2 mt-3"></div>
                                            <span class="badge bg-success">{{ config()->get('lang.' . App::getLocale() . '.upcoming') }}</span>
                                        @else
                                        <span class="badge bg-danger">{{ config()->get('lang.' . App::getLocale() . '.past') }}</span>
                                        @endif
                                        <hr>
                                        <div class="col-sm-12 date-prof">{{ config()->get('lang.' . App::getLocale() . '.paid_at') }}{{ $order->date }}</div>
                                    </div>
                                @endforeach
                            @else
                                <div class="php-email-form text-center">

                                    <p> {{ config()->get('lang.' . App::getLocale() . '.no-active-services') }} </p>
                                    <a class="btn package-button" href="{{ route('service') }}" class="btn mt-4"
                                        type="submit">{{ config()->get('lang.' . App::getLocale() . '.activate') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
