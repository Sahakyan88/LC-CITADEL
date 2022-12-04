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
                                    <div class="php-email-form order-profile">
                                        <div class="col-sm-12 title-order">{{ $order->title }}</div>
                                        <div class="col-sm-12 amount">{{ $order->amount }}$</div>
                                        @if ($order->status_been == 0)
                                            <div class="psecondary col-sm-2 mt-3">Not Done</div>
                                        @else
                                            <div class="psuccess col-sm-2 mt-3">Done</div>
                                        @endif
                                        <hr>
                                        <div class="col-sm-12 date-prof">{{ $order->date }}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
