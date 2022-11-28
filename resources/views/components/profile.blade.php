
@extends('app.layouts.app')
@section('content')
<section class="service-detail">
    <div class="container">
            <div class="row contact mt-5" style="box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);" >
                @include('components.menu-profile')
                <div class="col-sm-8 mt-5" >
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">{{ config()->get('lang.' . App::getLocale() . '.personal_information') }}
                            @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                    <form id="login-form" method="post" role="form" class="php-email-form auth-page-login auth-page">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <input type="text" disabled id="first_name" class="form-control  font-cl" name="first_name"
                                    value="{{ Auth::user()->first_name }}" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" disabled id="first_name" class="form-control" name="first_name"
                                    value="{{ Auth::user()->last_name }}" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" disabled id="first_name" class="form-control" name="first_name"
                                    value="{{ Auth::user()->phone }}" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="text" disabled id="first_name" class="form-control" name="first_name"
                                    value="{{ Auth::user()->email }}" placeholder="First Name">
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
