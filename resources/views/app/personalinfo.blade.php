
@extends('app.layouts.app')
@section('content')
<section class="service-detail">
    <div class="container">
            <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);" >
                @include('components.menu-profile')
                <div class="col-sm-8 mt-5 profile-top-mobile" >
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">{{ config()->get('lang.' . App::getLocale() . '.personal_information') }}</h5>
                    <form  class="php-email-form ">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <input type="text" disabled class="form-control"
                                    value="{{ Auth::user()->first_name }}" >
                            </div>
                            <div class="form-group">
                                <input type="text" disabled class="form-control"
                                    value="{{ Auth::user()->last_name }}" >
                            </div>
                            <div class="form-group">
                                <input type="text" disabled  class="form-control" 
                                    value="{{ Auth::user()->phone }}">
                            </div>
                            <div class="form-group">
                                <input type="text" disabled class="form-control" 
                                    value="{{ Auth::user()->email }}" >
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
@endsection
