@extends('admin.layouts.guest')
@section('content')

    <main  style="background-color: #f2f9f8 !important">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <!-- Basic login form-->
                    <div class="card shadow-lg border-0 rounded-lg mt-5 mb-10">
                        <div class="card-header justify-content-center"><h3 class="font-weight-light my-4"><a style="text-decoration: none" href="{{ route('homepage')  }}">Login Admin
                            Panel</a></h3>        
                            </div>
                        <div class="card-body">
                            <!-- Login form-->
                            <form id="admin_login" method="post" action="{{ route('adminLoginPost') }}">
                                <!-- Form Group (email address)-->
                                @csrf
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">Username</label>
                                    <input class="form-control" name="username" id="inputEmailAddress" type="text"
                                           placeholder="Username" required>
                                </div>
                                <!-- Form Group (password)-->
                                <div class="form-group">
                                    <label class="small mb-1" for="inputPassword">Password</label>
                                    <input class="form-control" name="password" id="inputPassword" type="password"
                                           placeholder="Enter password" required/>
                                </div>
                                <!-- Form Group (remember password checkbox)-->

                                @if(Session::has('error'))
                                <div class="alert alert-red text-center">
                                    <p><?php echo(Session::get('error')); ?></p>
                                </div>
                                @endif

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" id="rememberPasswordCheck" name="remember" type="checkbox" value="1"/>
                                        <label class="custom-control-label" for="rememberPasswordCheck">Remember
                                            password</label>
                                    </div>
                                </div>
                                <!-- Form Group (login box)-->
                                <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
