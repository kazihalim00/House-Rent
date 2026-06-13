@extends('panel.layout')

@section('content')
<div style="padding: 20px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="text-white fw-bold mb-1">
            <i class="fas fa-users me-2 text-danger"></i> Start a New Chat
        </h5>
        <a href="{{ route('chat.index') }}" style="color:#888; text-decoration:none;">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse($users as $u)
        <form action="{{ route('chat.start', $u->id) }}" method="POST" style="margin-bottom:10px;">
            @csrf
            <button type="submit" style="width:100%; background:#2d2d44; border:1px solid #3d3d5c;
                    border-radius:12px; padding:15px 20px; display:flex; align-items:center;
                    gap:15px; cursor:pointer; text-align:left;"
                    onmouseover="this.style.border='1px solid #c0392b'"
                    onmouseout="this.style.border='1px solid #3d3d5c'">

                <div style="background:#c0392b; border-radius:50%; width:42px; height:42px;
                            display:flex; align-items:center; justify-content:center;
                            color:white; font-weight:bold; flex-shrink:0;">
                    {{ strtoupper(substr($u->name, 0, 1)) }}
                </div>

                <div>
                    <div style="color:white; font-weight:600; font-size:15px;">{{ $u->name }}</div>
                    <small style="color:#888;">{{ $u->role }}</small>
                </div>
            </button>
        </form>
    @empty
        <p style="color:#666;">No other users found.</p>
    @endforelse

</div>
@endsection