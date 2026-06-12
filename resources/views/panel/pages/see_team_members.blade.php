@extends('panel.layout')


@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .team-avatar {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;

            padding: 3px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .25),
                0 0 0 4px rgba(255, 255, 255, .05);

            transition: all .4s ease;
        }

        .team-avatar:hover {
            transform: translateY(-6px) scale(1.08);

            box-shadow:
                0 18px 35px rgba(59, 130, 246, .35),
                0 10px 20px rgba(0, 0, 0, .3);
        }

        .team-card {
            background: #1f2937;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
            transition: all .35s ease;
            overflow: hidden;
        }

        .team-card:hover {
            transform: translateY(-8px);

            border-color: rgba(59, 130, 246, .4);

            box-shadow:
                0 20px 40px rgba(0, 0, 0, .25),
                0 0 30px rgba(59, 130, 246, .12);
        }

        .team-name {
            font-weight: 700;
            letter-spacing: .5px;
            transition: .3s;
        }

        .team-card:hover .team-name {
            color: #60a5fa;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;

            width: 40px;
            height: 40px;

            border-radius: 50%;
            background: rgba(255, 255, 255, .06);

            transition: all .3s ease;
        }

        .social-links a:hover {
            transform: translateY(-4px);
            background: rgba(59, 130, 246, .15);
        }
    </style>
    <div class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-white">Team Members</h2>
                <p class="text-secondary mb-0">
                    Manage your development team
                </p>
            </div>

            <a href="{{ route('add_team_member') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Add Member
            </a>
        </div>

        <!-- Card -->
        <div class="card border-0 shadow-lg bg-dark">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Links</th>
                                <th>Status</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($members as $member)

                                <tr>

                                    <!-- Image -->
                                    <td>
                                        <img src="{{ asset('upload/team/' . $member->image) }}" class="team-avatar"
                                            alt="{{ $member->name }}">
                                    </td>

                                    <!-- Name -->
                                    <td>
                                        <strong>{{ $member->name }}</strong>
                                    </td>



                                    <!-- Social -->
                                    <td>
                                        <div class="d-flex gap-3">

                                            @if($member->github)
                                                <a href="{{ $member->github }}" target="_blank" class="text-light">
                                                    <i class="fa-brands fa-github fa-lg"></i>
                                                </a>
                                            @endif

                                            @if($member->linkedin)
                                                <a href="{{ $member->linkedin }}" target="_blank" class="text-info">
                                                    <i class="fa-brands fa-linkedin fa-lg"></i>
                                                </a>
                                            @endif

                                            @if($member->portfolio)
                                                <a href="{{ $member->portfolio }}" target="_blank" class="text-success">
                                                    <i class="fa-solid fa-globe fa-lg"></i>
                                                </a>
                                            @endif

                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        @if($member->status == 'active')
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td>
                                        <div class="d-flex gap-2">

                                            <a href="#" class="btn btn-sm btn-warning">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>

                                            <a href="#" class="btn btn-sm btn-danger">
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        No team members found.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>


@endsection