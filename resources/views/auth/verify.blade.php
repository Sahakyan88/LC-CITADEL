@extends('app.layouts.app')

@section('content')
    <section id="contact" class=" services section-bg ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
                    <div class="card">
                        <div class="card-header">{{ __('Verify Your Email Address') }}</div>
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('A fresh verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            {{ __('Before proceeding, please check your email for a verification link.') }}
                            {{ __('If you did not receive the email') }},
                            <form method="POST" action="{{ route('verification.resend') }}" class="php-email-form ">
                                @csrf
                                <div class="text-center mt-2">
                                    <button type="submit" class="reset-p">click here to request another</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
