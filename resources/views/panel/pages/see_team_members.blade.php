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
                        @if (session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show shadow-sm mt-3" role="alert">
                                {{ session('success') }}

                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h2 class="fw-bold text-white mb-1">
                                Team Members
                            </h2>

    <p class="text-white fw-semibold fs-6 mb-0" style="opacity: 0.85; letter-spacing: 0.3px;">
        Manage your development team efficiently
    </p>
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
                                                <th>Role</th>
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

                                                    <!-- Role -->
                                                    <td>
                                                        @php
        $roleColors = [
            'Full Stack Developer' => '#3b82f6',  // blue
            'Frontend Developer' => '#06b6d4',  // cyan
            'Backend Developer' => '#22c55e',  // green
            'UI/UX Designer' => '#f59e0b',  // orange
            'Project Manager' => '#ef4444',  // red
            'QA Engineer' => '#a855f7',  // purple
        ];

        $color = $roleColors[$member->role] ?? '#3b82f6';
                                                        @endphp

                                                        <span class="px-3 py-2 rounded-pill fw-semibold text-white"
                                                            style="font-size: 0.8rem; letter-spacing: 0.5px; background-color: {{ $color }};">
                                                            {{ $member->role }}
                                                        </span>
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

                                                            <a href="{{ url('/edit-team-member/' . $member->id) }}"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </a>

                                                            <a href="{{ url('/delete-team-member/' . $member->id) }}"
                                                                class="btn btn-sm btn-danger">
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