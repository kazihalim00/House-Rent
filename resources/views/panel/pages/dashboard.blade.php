@extends('panel.layout')

@section('content')
    <div class="pt-4 px-4">
        <h2>My Dashboard</h2>
        <p style="color: #fff;">Welcome to your admin control panel.</p>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">

            <div class="col-sm-6 col-xl-3">
                <div
                    class="bg-secondary rounded d-flex align-items-center justify-content-between p-4 border border-success">
                    <i class="fa fa-chart-line fa-3x text-success"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-2 text-white">This Month Revenue</p>
                        <h6 class="mb-0 fs-4 text-success">৳ {{ number_format($monthly_revenue) }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-users fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-2">Total Users</p>
                        <h6 class="mb-0 fs-4">{{ $total_users }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-home fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-2">Total Houses</p>
                        <h6 class="mb-0 fs-4">{{ $total_houses }}</h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-xl-3">
                <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                    <i class="fa fa-calendar-check fa-3x text-primary"></i>
                    <div class="ms-3 text-end">
                        <p class="mb-2">Total Bookings</p>
                        <h6 class="mb-0 fs-4">{{ $total_bookings }}</h6>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Recently Registered Users</h6>
                <a href="{{ url('/user-list') }}">Show All</a>
            </div>
            <div class="table-responsive">
                <table class="table text-start align-middle table-bordered table-hover mb-0">
                    <thead>
                        <tr class="text-white">
                            <th scope="col">ID</th>
                            <th scope="col">Join Date</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recent_users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->created_at->format('d M, Y') }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge {{ $user->role == 'Admin' ? 'bg-danger' : 'bg-success' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection