@extends('app.layouts.app')

@section('content')
<style>
.bottom-language{
    display: none;
}
</style>
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
                            {{ __('If you did not receive the email') }}
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('verification.resend') }}",
                dataType: 'JSON',
                data: {
                    _token: "<?php echo csrf_token(); ?>",
                },
                success: function(response) {
                }
            });
        });
    </script>
@endsection
