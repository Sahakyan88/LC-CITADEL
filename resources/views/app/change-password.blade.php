@extends('app.layouts.app')
@section('content')
    <section class="service-detail">
        <div class="container">
            <div class="row">
                @include('components.menu-profile')
                <div class="col-sm-8  contact">
                    <div data-aos="fade-up">
                        <h5 class="service-detail__title">Change Password</h5>
                        @if (Session::has('success'))
                        <div class="alert alert-success text-center">
                            <p>{{ Session::get('success') }}</p>
                        </div>
                    @endif
                        <form id="login-form" method="POST" action="{{ route('changepassword') }}" class="php-email-form auth-page-login auth-page">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <input type="password" name="old_password" class="form-control font-cl"
                                        placeholder="Old Password"
                                        @if ($old = old('old_password')) value="{{ $old }}" @endif>
                                    @error('old_password')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="new_password" class="form-control font-cl"
                                        placeholder="New Password"
                                        @if ($old = old('new_password')) value="{{ $old }}" @endif>
                                    @error('new_password')
                                        <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input type="password" name="confirm_password" class="form-control font-cl"
                                    placeholder="Confirm Password"
                                    @if ($old = old('confirm_password')) value="{{ $old }}" @endif>
                                @error('confirm_password')
                                    <p style="color: red">{{ $message }}</p>
                                @enderror
                                </div>
                            </div>
                            <div class="text-center"><button type="submit">Save</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
@endsection
