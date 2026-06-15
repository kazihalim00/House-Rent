@extends('panel.layout')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">

                <h3 class="text-white mb-4 fw-bold">Account Settings</h3>

                <div class="card bg-dark text-white shadow-lg border-secondary border-opacity-50 mb-4"
                    style="border-radius: 15px;">
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="card bg-dark text-white shadow-lg border-secondary border-opacity-50 mb-4"
                    style="border-radius: 15px;">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="card bg-dark text-white shadow-lg border-secondary border-opacity-50"
                    style="border-radius: 15px;">
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection