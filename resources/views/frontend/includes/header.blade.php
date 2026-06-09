<nav class="site-nav">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <a href="{{ url('/') }}" class="logo m-0 float-start">House Rent</a>

                <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu float-end align-items-center">
                    <li class="active"><a href="{{ url('/') }}">Home</a></li>

                    <li class="has-children">
                        <a href="{{ route('house-detail') }}">Properties</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('house-detail') }}">All Houses</a></li>
                            <li><a href="{{ route('house-detail') }}">Rent a House</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ url('/') }}#services">Services</a></li>
                    <li><a href="{{ url('/') }}#about">About</a></li>

                    @auth
                        <li class="has-children" style="margin-left: 15px;">
                            <a href="#"
                                class="btn btn-primary text-white py-2 px-4 rounded-pill d-inline-flex align-items-center shadow-sm"
                                style="line-height: normal;">
                                <i class="icon-person me-2"></i> {{ explode(' ', Auth::user()->name)[0] }}
                            </a>
                            <ul class="dropdown" style="min-width: 180px;">
                                <li>
                                    <a href="{{ url('/dashboard') }}" class="d-flex align-items-center">
                                        <i class="fas fa-tachometer-alt me-2 text-primary" style="width: 20px;"></i>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="d-flex align-items-center text-danger">
                                            <i class="fas fa-sign-out-alt me-2" style="width: 20px;"></i> Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li style="margin-left: 15px;"><a href="{{ route('login') }}" class="font-weight-bold">Login</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}"
                                class="btn btn-primary text-white py-2 px-4 rounded-pill shadow-sm"
                                style="line-height: normal;">
                                Sign up
                            </a>
                        </li>
                    @endauth
                </ul>

                <a href="#"
                    class="burger light me-auto float-end mt-1 site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
                    data-toggle="collapse" data-target="#main-navbar">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
</nav>