<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-secondary navbar-dark">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>House Rent</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('upload/img/' . Auth::user()->user_image) }}" alt=""
                    style="width: 40px; height: 40px;">
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
            <a href="{{ url('/') }}" class="nav-item nav-link active">
                <i class="fa fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-laptop me-2"></i>House Module
                </a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ url('/add-house') }}" class="dropdown-item">Add House</a>
                    <a href="{{ url('/house-detail') }}" class="dropdown-item">House Detail</a>
                </div>
            </div>
            <a href="{{ url('/booking') }}" class="nav-item nav-link">
                <i class="fa fa-th me-2"></i>Booking
            </a>
            @if(Auth::user()->role == "Admin")
                <a href="{{ url('/add-user') }}" class="nav-item nav-link">
                    <i class="fa fa-th me-2"></i>Add User
                </a>
                <a href="{{ url('/user-list') }}" class="nav-item nav-link">
                    <i class="fa fa-th me-2"></i>User List
                </a>
                <a href=" {{ route('admin.pending_houses') }}" class="nav-item nav-link">
                    <i class="fa fa-th me-2"></i>Pending List
                </a>
            @endif
            <a href="form.html" class="nav-item nav-link"><i class="fa fa-keyboard me-2"></i>Review</a>
            <a href="{{url('/chat')}}" class="nav-item nav-link"><i class="fa fa-table me-2"></i>Chat</a>
        </div>
    </nav>
</div>