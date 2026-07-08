<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="{{ url('/') }}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Rent Cloud</h3>
        </a>
        @auth
            <div class="d-flex align-items-center ms-4 mb-4">
                <div class="position-relative">
                    <img class="rounded-circle"
                        src="{{ !empty(Auth::user()->user_image) ? asset('upload/img/' . Auth::user()->user_image) : asset('upload/img/default.png') }}"
                        style="width: 40px; height: 40px; object-fit:cover;"
                        onerror="this.onerror=null; this.src='{{ asset('upload/img/default.png') }}';">
                    <div
                        class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1">
                    </div>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                    <span>{{ Auth::user()->role }}</span>
                </div>
            </div>
            <div class="navbar-nav w-100">
                @if(Auth::user()->role == "Admin")
                    <a href="{{ url('/dashboard') }}"
                        class="nav-item nav-link {{  request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fa fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                @endif

                <div class="nav-item dropdown">
                    <a href="#"
                        class="nav-link dropdown-toggle {{ request()->is('add-house', 'house-detail', 'appointments') ? 'active' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fa fa-laptop me-2"></i>House Module
                    </a>
                    <div
                        class="dropdown-menu bg-transparent border-0 {{ request()->is('add-house', 'house-detail', 'appointments') ? 'show' : '' }}">
                        <a href="{{ url('/add-house') }}"
                            class="dropdown-item {{ request()->is('add-house') ? 'active' : '' }}">Add House</a>
                        <a href="{{ url('/house-detail') }}"
                            class="dropdown-item {{ request()->is('house-detail') ? 'active' : '' }}">House Detail</a>
                        <a href="{{ url('/appointments') }}"
                            class="dropdown-item {{ request()->is('appointments') ? 'active' : '' }}">Appointments</a>
                    </div>
                </div>

                <div class="nav-item dropdown">
                    <a href="#"
                        class="nav-link dropdown-toggle {{ request()->is('booking', 'booking-list') ? 'active' : '' }}"
                        data-bs-toggle="dropdown">
                        <i class="fa fa-calendar me-2"></i>Booking
                    </a>
                    <div
                        class="dropdown-menu bg-transparent border-0 {{ request()->is('booking', 'booking-list') ? 'show' : '' }}">
                        <a href="{{ url('/booking') }}"
                            class="dropdown-item {{ request()->is('booking') ? 'active' : '' }}">Booking Calendar</a>
                        <a href="{{ url('/booking-list') }}"
                            class="dropdown-item {{ request()->is('booking-list') ? 'active' : '' }}">Booking List</a>
                    </div>
                </div>

                @if(Auth::user()->role == "Admin")

                    <a href="{{ url('/add-user') }}" class="nav-item nav-link {{ request()->is('add-user') ? 'active' : '' }}">
                        <i class="fa fa-th me-2"></i>Add User
                    </a>
                    <a href="{{ url('/user-list') }}"
                        class="nav-item nav-link {{ request()->is('user-list') ? 'active' : '' }}">
                        <i class="fa fa-th me-2"></i>User List
                    </a>
                    {{-- <a href="{{ route('admin.pending_houses') }}"
                        class="nav-item nav-link {{ request()->routeIs('admin.pending_houses') ? 'active' : '' }}">
                        <i class="fa fa-th me-2"></i>Pending List
                    </a> --}}
                    <div class="nav-item dropdown">
                        <a href="#"
                            class="nav-link dropdown-toggle {{ request()->is('add-team-member', 'see-team-member') ? 'active' : '' }}"
                            data-bs-toggle="dropdown">
                            <i class="fa fa-laptop me-2"></i>Team Members
                        </a>
                        <div
                            class="dropdown-menu bg-transparent border-0 {{ request()->is('add-team-member', 'see-team-member') ? 'show' : '' }}">
                            <a href="{{ url('/add-team-member') }}"
                                class="dropdown-item {{ request()->is('add-team-member') ? 'active' : '' }}">Add
                                Team Member</a>
                            <a href="{{ url('/see-team-member') }}"
                                class="dropdown-item {{ request()->is('see-team-member') ? 'active' : '' }}">See team
                                members</a>

                        </div>
                    </div>
                @endif

                <a href="{{url('/review')}}" class="nav-item nav-link {{ request()->is('review') ? 'active' : '' }}">
                    <i class="fa fa-keyboard me-2"></i>Review
                </a>
                <a href="{{url('/chat')}}" class="nav-item nav-link {{ request()->is('chat') ? 'active' : '' }}">
                    <i class="fa fa-table me-2"></i>Chat
                </a>
            </div>
        @else
            <div class="navbar-nav w-100">
                <a href="{{ url('/') }}" class="nav-item nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fa fa-home me-2"></i>Home
                </a>
                <a href="{{ route('house-detail') }}"
                    class="nav-item nav-link {{ request()->is('house-detail') ? 'active' : '' }}">
                    <i class="fa fa-search me-2"></i>Browse Houses
                </a>
            </div>
        @endauth
    </nav>
</div>