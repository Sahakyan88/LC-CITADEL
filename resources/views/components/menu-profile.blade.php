<?php
$lang = App::getLocale();
?>
<section id="features" class="features col-lg-4">
    <div class="container">
        <div class="profile-user">
            <div data-aos="fade-right">
                <ul class="nav nav-tabs flex-column">
                    <li class="nav-item">
                        <a class="nav-link  show {{ request()->is('personal-info') ? 'active' : '' }} {{ request()->is($lang . '/personal-info') ? 'active' : '' }}{{ request()->is($lang . '/login') ? 'active' : '' }}{{ request()->is($lang . '/register') ? 'active' : '' }}{{ request()->is('register') ? 'active' : '' }}{{ request()->is('login') ? 'active' : '' }}"
                            href="{{ route('personalinfo') }}" class="arrow icon-right-arrow">
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.personal_information') }}</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  show  {{ request()->is('profile-password') ? 'active' : '' }}{{ request()->is($lang . '/profile-password') ? 'active' : '' }}"
                            href=" {{ route('profilepassword') }}" class="arrow icon-right-arrow">
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.change_pass') }}</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  show  {{ request()->is('orders-profile') ? 'active' : '' }} {{ request()->is($lang . '/orders-profile') ? 'active' : '' }}"
                            href="{{ route('ordersprofile') }}" class="arrow icon-right-arrow">
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.services') }}</h4>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link acive show" href="{{ route('logout') }}" class="arrow icon-right-arrow">
                            <h4>{{ config()->get('lang.' . App::getLocale() . '.logout') }}</h4>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
