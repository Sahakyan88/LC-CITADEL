@extends('app.layouts.appTwo')
@section('sectionTwo')
    @if (!Auth::user())
        <section style="height: 87vh" class="contact  section-bg mt-5">
            <style>
                .mobile-nav-toggle {
                    display: none;
                }
            </style>
            <div class="container col-sm-4">
                <div class="form-group">
                    <div data-aos="fade-up">
                        <h2 class="text-center">Sign In</h2>
                        <form method="post" action="{{ route('signin') }}" role="form"
                            class="php-email-form auth-page-login">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="Your Email"@if ($old = old('email')) value="{{ $old }}" @endif>
                                    @error('email')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Password"@if ($old = old('password')) value="{{ $old }}" @endif>
                                    @error('password')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group chekc-terms">
                                    <input class="custom-control-input" id="rememberPasswordCheck" name="remember"
                                        type="checkbox" value="1" />
                                    <label style="margin-left: 10px" class="custom-control-label"
                                        for="rememberPasswordCheck">Remember me</label>
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Sign In</button></div>
                            <br>
                            <p>Don't have an account yet? <a href="{{ route('register-user') }}">Sign Up</a> </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
