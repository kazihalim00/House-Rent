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
            box-shadow: 0 10px 25px rgba(0, 0, 0, .25), 0 0 0 4px rgba(255, 255, 255, .05);
            transition: all .4s ease;
        }

        .team-avatar:hover {
            transform: translateY(-6px) scale(1.08);
            box-shadow: 0 18px 35px rgba(59, 130, 246, .35), 0 10px 20px rgba(0, 0, 0, .3);
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
            box-shadow: 0 20px 40px rgba(0, 0, 0, .25), 0 0 30px rgba(59, 130, 246, .12);
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
        <div class="mb-4">
            <h2 class="text-3xl font-bold mb-2 text-white pb-1">
                Team Members
            </h2>
            <p class="text-white fw-semibold fs-6 mb-0" style="opacity: 0.85; letter-spacing: 0.3px;">
                Manage your development team efficiently
            </p>
        </div>

        @section('page-action')
            <a href="{{ route('add_team_member') }}" class="btn-panel-action">
                <i class="fa-solid fa-plus me-1"></i> Add Member
            </a>
        @endsection

        <!-- Card -->
        <!-- Changed bg-dark to bg-white, and added rounded borders -->
        <div class="card border-0 shadow-lg bg-white overflow-hidden" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <!-- Removed table-dark -->
                    <table class="table table-hover align-middle mb-0">
                        <!-- Added dark header exactly like User List page -->
                        <thead style="background-color: #1f2937; color: #f8fafc;">
                            <tr>
                                <th class="text-left border-0 py-3 ps-4">Photo</th>
                                <th class="text-left border-0 py-3">Name</th>
                                <th class="text-left border-0 py-3">Role</th>
                                <th class="text-center border-0 py-3">Social</th>
                                <th class="text-center border-0 py-3">Status</th>
                                <th class="text-center border-0 py-3 pe-4" width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($members as $member)
                                <tr>
                                    <!-- Image -->
                                    <td class="align-middle ps-4">
                                        <img src="{{ asset('upload/team/' . $member->image) }}" class="team-avatar"
                                            alt="{{ $member->name }}">
                                    </td>

                                    <!-- Name (Changed text to dark) -->
                                    <td class="align-middle">
                                        <strong class="text-dark">{{ $member->name }}</strong>
                                    </td>

                                    <!-- Role -->
                                    <td class="align-middle">
                                        @php
                                            $roleColors = [
                                                'Full Stack Developer' => '#3b82f6',
                                                'Frontend Developer' => '#06b6d4',
                                                'Backend Developer' => '#22c55e',
                                                'UI/UX Designer' => '#f59e0b',
                                                'Project Manager' => '#ef4444',
                                                'QA Engineer' => '#a855f7',
                                            ];
                                            $color = $roleColors[$member->role] ?? '#3b82f6';
                                        @endphp
                                        <span class="px-3 py-2 rounded-pill fw-semibold text-white"
                                            style="font-size: 0.8rem; letter-spacing: 0.5px; background-color: {{ $color }};">
                                            {{ $member->role }}
                                        </span>
                                    </td>

                                    <!-- Social (Changed text-light to text-dark for Github) -->
                                    <td class="align-middle text-center">
                                        <div class="d-flex gap-3 justify-content-center align-items-center">
                                            @if($member->github)
                                                <a href="{{ $member->github }}" target="_blank" class="text-dark">
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

                                    <!-- Status Badge -->
                                    <td class="align-middle text-center">
                                        @if($member->status == 'active')
                                            <span class="badge bg-success text-white px-3 py-2 rounded-pill"
                                                style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger text-white px-3 py-2 rounded-pill"
                                                style="font-size: 0.8rem; letter-spacing: 0.5px;">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <!-- Actions -->
                                    <td class="align-middle text-center pe-4">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ url('/edit-team-member/' . $member->id) }}"
                                                class="btn btn-sm btn-primary">
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
                                    <td colspan="6" class="text-center py-5 text-muted">
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