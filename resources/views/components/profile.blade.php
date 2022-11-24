<div class="row">
    @include('components.menu-profile')
    <div class="col-sm-8  contact">
            <div data-aos="fade-up">
                <h5 class="service-detail__title">Personal Information</h5>
                <form id="login-form" method="post" role="form"
                    class="php-email-form auth-page-login auth-page">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <input type="text" disabled id="first_name" class="form-control" name="first_name"
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
                        <div class="form-group">
                            <input type="text"  disabled id="first_name" class="form-control" name="first_name"
                            value="{{ Auth::user()->address }}" placeholder="First Name">
                        </div>
                    </div>
                </form>
            </div>
    </div>
</div>
