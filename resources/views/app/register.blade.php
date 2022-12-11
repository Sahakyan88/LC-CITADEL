@extends('app.layouts.appTwo')
@section('sectionTwo')
    @if (!Auth::user())
        <section style="height: 90vh;overflow:auto" class="contact  section-bg mt-4">
            <style>
                .mobile-nav-toggle {
                    display: none;
                }
            </style>
            <div class="container col-sm-4 ">
                <div class="row">
                    <div class="form-group ">
                        <div data-aos="fade-up">
                            <h2 class="text-center">Sign Up</h2>
                            <form method="POST" action="{{ route('signup') }}" class="php-email-form ">
                                @csrf
                                <div class="row">
                                    <div class="form-group ">
                                        <input type="text" name="first_name" class="form-control" id="first_name"
                                            placeholder="Your First Name"@if ($old = old('first_name')) value="{{ $old }}" @endif>
                                        @error('first_name')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <input type="text" name="last_name" class="form-control" id="last_name"
                                            placeholder="Your Last Name"@if ($old = old('last_name')) value="{{ $old }}" @endif>
                                        @error('last_name')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <input type="text" name="phone" class="form-control" id="phone"
                                            placeholder="Your Phone Number"@if ($old = old('phone')) value="{{ $old }}" @endif>
                                        @error('phone')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <input type="email" class="form-control" name="email" id="email"
                                            placeholder="Your Email"@if ($old = old('email')) value="{{ $old }}" @endif>
                                        @error('email')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group ">
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="Password"
                                            @if ($old = old('password')) value="{{ $old }}" @endif>
                                        @error('password')
                                            <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                   
                                    <div class="form-group chekc-terms">

                                        <input type="checkbox" name="checkbox"
                                            @if ($old = old('checkbox')) value="{{ $old }}" @endif>
                                        <span style="margin-left: 10px"><span>I agree to the<span> <a target="_blank"
                                                        class="pdf" href="{{ asset('assets/pdf/terms.pdf') }}">Terms and
                                                        Conditions</a></span>

                                    </div>
                                    @error('checkbox')
                                        <p class="error">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="text-center">
                                    <button type="submit">Sign Up</button>
                                </div>
                                <br>
                                <p>Already a member? <a href="{{ route('login-user') }}">Sign In</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
