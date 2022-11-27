<?php 
$lang =App::getLocale();
?>
<section id="features" class="features ">
    <div class="container">
        <div class="row" style="    width: 100%;
        padding: 30px;
        background: #fff;
        box-shadow: 0 0 24px 0 rgb(0 0 0 / 12%);
    }">
            <div class="col-lg-4 mb-5 mb-lg-0 " data-aos="fade-right">
                <ul class="nav nav-tabs flex-column">
                    <li class="nav-item">
                        <a class="nav-link  show {{ request()->is('personal-info') ? 'active' : '' }} {{ request()->is($lang.'/personal-info') ? 'active' : '' }}{{ request()->is($lang.'/login-user') ? 'active' : '' }}{{ request()->is($lang.'/register-user') ? 'active' : '' }}{{ request()->is('register-user') ? 'active' : '' }}{{ request()->is('login-user') ? 'active' : '' }}" href="{{ route('personalinfo') }}" class="arrow icon-right-arrow">
                            <h4>Personal Information</h4>
                        </a>
                    </li>
                    <li class="nav-item mt-2 ">
                        <a class="nav-link  show  {{ request()->is('profile-password') ? 'active' : '' }}{{ request()->is($lang.'/profile-password') ? 'active' : '' }}" href=" {{ route('profilepassword')  }}" class="arrow icon-right-arrow">
                            <h4>Change Password</h4>
                        </a>
                    </li>
                    <li class="nav-item mt-2 ">
                        <a class="nav-link  show  {{ request()->is('orders-profile') ? 'active' : '' }} {{ request()->is($lang.'/orders-profile') ? 'active' : '' }}" href="{{ route('ordersprofile') }}" class="arrow icon-right-arrow">
                            <h4>Services</h4>
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link acive show" href="{{ route('logout') }}" class="arrow icon-right-arrow">
                            <h4>Logout</h4>
                        </a>
                    </li>
                </ul>
            </div>

