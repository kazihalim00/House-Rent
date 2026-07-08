@extends('panel.layout')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="d-flex align-items-center mb-4 gap-2">
                    <i class="fa-solid fa-user-gear fs-3 text-white"></i>
                    <h3 class="text-white mb-0 fw-bold">Account Settings</h3>
                </div>

                <!-- Profile Info Card -->
                <div class="card bg-white shadow-lg border-0 mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold mb-1 text-dark">Profile Information</h4>
                        <p class="text-muted small mb-4">
                            Update your account's profile information and email address.
                        </p>

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Name</label>
                                <!-- bg-white text-dark border অ্যাড করা হয়েছে -->
                                <input type="text" name="name" class="form-control bg-white text-dark border"
                                    value="{{ old('name', $user->name) }}" required>
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Email</label>
                                <input type="email" name="email" class="form-control bg-white text-dark border"
                                    value="{{ old('email', $user->email) }}" required>
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="btn btn-primary px-4 rounded-pill">Save Changes</button>
                        </form>
                    </div>
                </div>

                <!-- Password Card -->
                <div class="card bg-white shadow-lg border-0 mb-4" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold mb-1 text-dark">Update Password</h4>
                        <p class="text-muted small mb-4">
                            Ensure your account is using a long, random password to stay secure.
                        </p>

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">Current Password</label>
                                <input type="password" name="current_password"
                                    class="form-control bg-white text-dark border" required>
                                @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-dark">New Password</label>
                                <input type="password" name="password" class="form-control bg-white text-dark border"
                                    required>
                                @error('password') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark">Confirm Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control bg-white text-dark border" required>
                            </div>

                            <button type="submit" class="btn btn-primary px-4 rounded-pill">Update Password</button>
                        </form>
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div class="card bg-white shadow-lg border-0" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-5">
                        <h4 class="fw-bold text-danger mb-1">Delete Account</h4>
                        <p class="text-muted small mb-4">
                            Once your account is deleted, all of its resources and data will be permanently deleted.
                        </p>

                        <form method="post" action="{{ route('profile.destroy') }}">
                            @csrf
                            @method('delete')

                            <div class="alert alert-danger bg-opacity-10 border-danger mb-4">
                                <label class="form-label text-danger fw-bold">Enter Password to Confirm Deletion</label>
                                <input type="password" name="password"
                                    class="form-control bg-white text-dark border border-danger" placeholder="Password"
                                    required>
                                @error('password') <span class="text-danger small mt-1 d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-danger px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-trash-can me-2"></i> Delete Account Permanently
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection