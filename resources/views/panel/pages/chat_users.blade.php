@extends('panel.layout')

@section('content')
<div class="chat-container">

    <div class="chat-header">
        <h5 class="chat-title">
            <i class="fas fa-comments text-danger"></i> Start a New Chat
        </h5>
        <span class="chat-badge">
            {{ $users->count() }} {{ Str::plural('user', $users->count()) }}
        </span>
    </div>
    <p class="chat-subtitle">Pick someone below to start a conversation.</p>

    @if(session('error'))
        <div class="alert alert-danger" style="border-radius: 8px;">{{ session('error') }}</div>
    @endif

    @if($users->count() > 0)
        <div class="chat-search-wrapper">
            <i class="fas fa-search chat-search-icon"></i>
            <input type="text" id="userSearch" class="chat-search-input" placeholder="Search by name or role...">
        </div>
    @endif

    @if($users->count() > 0)
        <div class="chat-list">
            @foreach($users as $u)
                <form action="{{ route('chat.start', $u->id) }}" method="POST"
                      class="chat-user-row" data-name="{{ strtolower($u->name) }}"
                      data-role="{{ strtolower($u->role) }}">
                    @csrf
                    <button type="submit" class="chat-user-btn">
                        
                        <div class="chat-user-avatar">
                            {{ strtoupper(substr($u->name, 0, 1)) }}
                        </div>

                        <div class="chat-user-info">
                            <span class="chat-user-name">{{ $u->name }}</span>
                            <span class="chat-user-role">{{ $u->role }}</span>
                        </div>

                        <i class="fas fa-chevron-right chat-chevron"></i>
                    </button>
                </form>
            @endforeach
        </div>
    @else
        <div class="chat-empty-state">
            <i class="fas fa-user-slash"></i>
            <p>No other users found.</p>
        </div>
    @endif

</div>

<style>
    /* Container limits the width so items don't stretch awkwardly across wide screens */
    .chat-container {
        padding: 24px;
        max-width: 550px; 
    }

    /* Header Styles */
    .chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 6px;
    }
    .chat-title {
        color: #ffffff;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chat-badge {
        background: #2d2d44;
        color: #a3a3c2;
        border: 1px solid #3d3d5c;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 11px;
        font-weight: 600;
    }
    .chat-subtitle {
        color: #8a8a9e;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* Search Input Styles */
    .chat-search-wrapper {
        position: relative;
        margin-bottom: 20px;
    }
    .chat-search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c6c8e;
        font-size: 13px;
    }
    .chat-search-input {
        width: 100%;
        background: #22223a;
        border: 1px solid #3d3d5c;
        border-radius: 8px;
        padding: 10px 14px 10px 38px;
        color: #ffffff;
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
    }
    .chat-search-input::placeholder {
        color: #6c6c8e;
    }
    .chat-search-input:focus {
        border-color: #c0392b;
        box-shadow: 0 0 0 3px rgba(192, 57, 43, 0.15);
    }

    /* List & Row Styles */
    .chat-list {
        background: #252538;
        border: 1px solid #3d3d5c;
        border-radius: 12px;
        overflow: hidden;
    }
    .chat-user-row {
        margin: 0;
    }
    .chat-user-row:not(:last-child) .chat-user-btn {
        border-bottom: 1px solid #35354e;
    }
    .chat-user-btn {
        width: 100%;
        background: transparent;
        border: none;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
        text-align: left;
        transition: background 0.15s ease;
    }
    .chat-user-btn:hover {
        background: #2d2d44;
    }
    .chat-user-btn:focus-visible {
        outline: 2px solid #c0392b;
        outline-offset: -2px;
        background: #2d2d44;
    }

    /* Avatar & Info Typography */
    .chat-user-avatar {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        border-radius: 50%;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .chat-user-info {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column; /* Stacks name and role vertically */
        justify-content: center;
        gap: 2px;
    }
    .chat-user-name {
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .chat-user-role {
        color: #8a8a9e;
        font-size: 12px;
        text-transform: capitalize;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .chat-chevron {
        color: #4d4d66;
        font-size: 12px;
        flex-shrink: 0;
        transition: transform 0.2s ease, color 0.2s ease;
    }
    .chat-user-btn:hover .chat-chevron {
        color: #a3a3c2;
        transform: translateX(2px); /* Subtle animation on hover */
    }

    /* Empty State */
    .chat-empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c6c8e;
        background: #252538;
        border: 1px dashed #3d3d5c;
        border-radius: 12px;
    }
    .chat-empty-state i {
        font-size: 28px;
        margin-bottom: 12px;
        opacity: 0.7;
    }
    .chat-empty-state p {
        margin: 0;
        font-size: 14px;
    }
</style>

<script>
    document.getElementById('userSearch')?.addEventListener('input', function (e) {
        const term = e.target.value.toLowerCase().trim();
        document.querySelectorAll('.chat-user-row').forEach(function (row) {
            const match = row.dataset.name.includes(term) || row.dataset.role.includes(term);
            row.style.display = match ? '' : 'none';
        });
    });
</script>
@endsection