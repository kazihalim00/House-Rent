<style>
    .site-nav {
        background-color: transparent !important;
        padding: 16px 0;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999;
    }

    .site-nav .menu-bg-wrap {
        background: rgba(22, 33, 62, 0.75) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(42, 58, 92, 0.6);
        border-radius: 12px;
        padding: 0 24px;
    }

    .site-navigation {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 !important;
        height: 60px;
    }

    /* Logo */
    .site-nav .logo {
        color: #f0f4ff !important;
        font-weight: 700;
        font-size: 20px;
        text-decoration: none;
        letter-spacing: -0.3px;
        flex-shrink: 0;
    }

    .site-nav .logo span {
        color: #e53935;
    }

    /* Nav menu */
    .site-nav .site-menu {
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none;
        gap: 2px;
    }

    .site-nav .site-menu>li>a {
        color: #b0bec5 !important;
        font-weight: 500;
        font-size: 15px;
        transition: color 0.2s;
        padding: 8px 14px !important;
        display: flex;
        align-items: center;
        white-space: nowrap;
        line-height: 1 !important;
    }

    .site-nav .site-menu>li>a:hover,
    .site-nav .site-menu>li.active>a {
        color: #e53935 !important;
    }

    /* Dropdown */
    .site-nav .site-menu .dropdown {
        background: #1e2a45 !important;
        border: 1px solid #2a3a5c !important;
        border-radius: 10px !important;
        padding: 8px !important;
        min-width: 170px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    }

    .site-nav .site-menu .dropdown li a {
        color: #b0bec5 !important;
        padding: 9px 14px !important;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        display: block;
        transition: background 0.15s, color 0.15s;
        line-height: 1.4 !important;
    }

    .site-nav .site-menu .dropdown li a:hover {
        background: rgba(229, 57, 53, 0.12) !important;
        color: #e53935 !important;
    }

    /* Auth buttons inline */
    .nav-login-btn {
        color: #b0bec5 !important;
        font-weight: 600;
        font-size: 15px;
        padding: 8px 14px !important;
        transition: color 0.2s;
        white-space: nowrap;
        line-height: 1 !important;
    }

    .nav-login-btn:hover {
        color: #e53935 !important;
    }

    .nav-signup-btn {
        background: #e53935 !important;
        border: none !important;
        color: #fff !important;
        padding: 8px 18px !important;
        border-radius: 8px !important;
        font-weight: 600;
        font-size: 14px;
        line-height: 1 !important;
        transition: background 0.2s;
        text-decoration: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
    }

    .nav-signup-btn:hover {
        background: #c62828 !important;
        color: #fff !important;
    }

    /* User dropdown */
    .user-dropdown {
        background: #1e2a45 !important;
        border: 1px solid #2a3a5c !important;
        border-radius: 10px !important;
        padding: 8px !important;
        min-width: 170px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    }

    .user-dropdown li a {
        display: block;
        padding: 9px 14px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.15s, color 0.15s;
        text-decoration: none;
        line-height: 1.4 !important;
    }

    .user-dropdown .dash-link {
        color: #b0bec5 !important;
    }

    .user-dropdown .dash-link:hover {
        background: rgba(176, 190, 197, 0.1) !important;
        color: #f0f4ff !important;
    }

    .user-dropdown .logout-link {
        color: #e53935 !important;
    }

    .user-dropdown .logout-link:hover {
        background: rgba(229, 57, 53, 0.12) !important;
    }

    /* Burger */
    .site-nav .burger span,
    .site-nav .burger span::before,
    .site-nav .burger span::after {
        background: #f0f4ff !important;
    }
</style>

<nav class="site-nav">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <a href="{{ url('/') }}" class="logo m-0">
                    House <span>Rent</span>
                </a>

                <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu align-items-center"
                    style="margin-left:auto;">
                    <li class="active"><a href="{{ url('/') }}">Home</a></li>

                    <li class="has-children">
                        <a href="{{ route('house-detail') }}">Properties</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('house-detail') }}">All Houses</a></li>
                            <li><a href="{{ route('house-detail') }}">Rent a House</a></li>
                            <li><a href="{{ url('/') }}#popularhouses">Popular Houses</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ url('/') }}#services">Services</a></li>
                    <li><a href="{{ url('/') }}#about">About</a></li>

                    @auth
                        <li class="has-children">
                            <a href="#" style="color:#b0bec5 !important; display:flex; align-items:center; gap:6px;">
                                <span class="icon-person" style="color:#e53935;"></span>
                                {{ explode(' ', Auth::user()->name)[0] }}
                            </a>
                            <ul class="dropdown user-dropdown">
                                <li>
                                    <a href="{{ url('/dashboard') }}" class="dash-link">Dashboard</a>
                                </li>
                                <li style="margin-top:4px;">
                                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                        @csrf
                                        <a href="#" class="logout-link"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="nav-login-btn">Login</a></li>
                        <li style="display:flex; align-items:center; padding-left:6px;">
                            <a href="{{ route('register') }}" class="nav-signup-btn">Sign up</a>
                        </li>
                    @endauth
                </ul>

                <a href="#" class="burger light ms-auto site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
                    data-toggle="collapse" data-target="#main-navbar">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
</nav>