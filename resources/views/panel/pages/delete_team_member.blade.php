@extends('panel.layout')

@section('content')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container py-5">

  
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">

                <!-- Back Button (left aligned clean) -->
                <div class="mb-4 text-start">
                    <a href="{{ route('see-team-member') }}" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="fa-solid fa-arrow-left me-1"></i>
                        Back
                    </a>
                </div>

                <!-- Card -->
                <div class="card bg-dark text-white border-0 shadow-lg" style="border-radius: 22px;">

                    <div class="card-body p-5 text-center">

                        <!-- Image -->
                        <div class="d-flex justify-content-center mb-4">
                            <img src="{{ asset('upload/team/' . $member->image) }}" alt="{{ $member->name }}"
                                class="rounded-circle border border-3 border-secondary shadow"
                                style="width: 140px; height: 140px; object-fit: cover;">
                        </div>

                        <!-- Name -->
                        <h4 class="fw-bold mb-1">
                            {{ $member->name }}
                        </h4>

                        <p class="text-secondary mb-4 small">
                            Team Member Profile
                        </p>

                        <!-- Warning Box (modern soft red) -->
                        <div class="text-start p-3 rounded-3 mb-4" style="background: rgba(220,53,69,0.10);
                                                    border: 1px solid rgba(220,53,69,0.35);
                                                    backdrop-filter: blur(6px);">

                            <h6 class="fw-bold text-danger mb-2">
                                ⚠ Confirm Deletion
                            </h6>

                            <p class="mb-0 text-light small">
                                This action will permanently remove
                                <strong class="text-white">{{ $member->name }}</strong>
                                from the system. This cannot be undone.
                            </p>
                        </div>

                        <!-- Buttons -->
                        <form action="{{ route('delete-team-member', $member->id) }}" method="POST">
                            @csrf
                            @method('DELETE')

                            <div class="d-flex justify-content-center gap-3">

                                <a href="{{ route('see-team-member') }}"
                                    class="btn btn-outline-light btn-sm px-4 rounded-pill">
                                    Cancel
                                </a>

                                <button type="submit" class="btn btn-danger btn-sm px-4 rounded-pill shadow-sm">
                                    <i class="fa-solid fa-trash me-1"></i>
                                    Delete
                                </button>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection