@extends('app.layouts.appTwo')
@section('sectionTwo')
    @if (!Auth::user())
        <section class="contact  mt-5">
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
                                <div>
                                    <div class="form-group chekc-terms ">
                                        <div>
                                        <label class="rember"><input class="input-remeber" id="rememberPasswordCheck" name="remember"
                                            type="checkbox" value="1" />Remember me</label>
                                        </div>
                                        <div><a class="mt-4" href="{{ route('forget.password.get') }}">Forgot password ?</a></div>
                                    </div>
                                </div>
                                <div class="text-center"><button type="submit">Sign In</button></div>
                            </div>
                            <br>
                            <p class="text-center" >Don't have an account yet? <a href="{{ route('register-user') }}">Sign
                                    Up</a> </p>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
