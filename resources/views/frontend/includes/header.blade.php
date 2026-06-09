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
                        <li class="has-children">
                            <a href="#" class="text-white font-weight-bold d-flex align-items-center">
                                <span class="icon-person me-2"></span> {{ explode(' ', Auth::user()->name)[0] }}
                            </a>

                            <ul class="dropdown shadow-lg"
                                style="min-width: 180px; padding: 10px; border-radius: 10px; background: #ffffff; border: none;">
                                <li style="margin: 0; padding: 0;">
                                    <a href="{{ url('/dashboard') }}"
                                        style="display: block; padding: 10px 15px; color: #333; font-weight: 600; font-size: 15px; border-radius: 6px; transition: all 0.3s ease;"
                                        onmouseover="this.style.background='#f0f8ff'; this.style.color='#087990'"
                                        onmouseout="this.style.background='transparent'; this.style.color='#333'">
                                        Dashboard
                                    </a>
                                </li>
                                <li style="margin: 0; padding: 0; margin-top: 5px;">
                                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                        @csrf
                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();"
                                            style="display: block; padding: 10px 15px; color: #dc3545; font-weight: 600; font-size: 15px; border-radius: 6px; transition: all 0.3s ease;"
                                            onmouseover="this.style.background='#ffe6e6'; this.style.color='#c82333'"
                                            onmouseout="this.style.background='transparent'; this.style.color='#dc3545'">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li style="margin-left: 15px;"><a href="{{ route('login') }}"
                                class="font-weight-bold text-white">Login</a></li>
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