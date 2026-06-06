@extends('panel.layout')

@section('content')
<div style="padding: 20px;">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="text-white fw-bold mb-1">
                <i class="fas fa-comments me-2 text-danger"></i> Messages
            </h5>
            <small class="text-muted">
                @if($user->role === 'Admin')
                    All user conversations
                @else
                    Your private conversation with Admin
                @endif
            </small>
        </div>

        {{-- Only normal Users see "New Chat" button --}}
        @if($user->role !== 'Admin')
            <a href="{{ route('chat.start') }}"
               style="background:#c0392b;
                      color:white;
                      border:none;
                      padding:10px 22px;
                      border-radius:25px;
                      text-decoration:none;
                      font-size:14px;
                      font-weight:600;">
                <i class="fas fa-plus me-1"></i> New Chat
            </a>
        @endif
    </div>

    {{-- Conversation List --}}
    @forelse($conversations as $conv)
        <a href="{{ route('chat.show', $conv->id) }}"
           style="text-decoration:none;">
            <div style="background:#2d2d44;
                        border-radius:12px;
                        padding:15px 20px;
                        margin-bottom:10px;
                        border:1px solid #3d3d5c;
                        display:flex;
                        align-items:center;
                        gap:15px;
                        transition: border 0.2s;"
                 onmouseover="this.style.border='1px solid #c0392b'"
                 onmouseout="this.style.border='1px solid #3d3d5c'">

                {{-- Avatar --}}
                <div style="background:#c0392b;
                            border-radius:50%;
                            width:48px;
                            height:48px;
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            font-weight:bold;
                            color:white;
                            font-size:18px;
                            flex-shrink:0;">
                    @if($user->role === 'Admin')
                        {{ strtoupper(substr($conv->tenant->name, 0, 1)) }}
                    @else
                        A
                    @endif
                </div>

                {{-- Conversation Info --}}
                <div style="flex:1; min-width:0;">

                    {{-- Name --}}
                    <div style="color:white; font-weight:600; font-size:15px; margin-bottom:4px;">
                        @if($user->role === 'Admin')
                            {{ $conv->tenant->name }}
                        @else
                            Admin
                        @endif
                    </div>

                    {{-- Last message preview --}}
                    <div style="color:#888;
                                font-size:13px;
                                white-space:nowrap;
                                overflow:hidden;
                                text-overflow:ellipsis;">
                        @if($conv->messages->last())
                            {{ Str::limit($conv->messages->last()->body, 50) }}
                        @else
                            <em>No messages yet</em>
                        @endif
                    </div>

                </div>

                {{-- Time + Arrow --}}
                <div style="text-align:right; flex-shrink:0;">
                    <div style="color:#666; font-size:12px; margin-bottom:6px;">
                        {{ $conv->updated_at->diffForHumans() }}
                    </div>
                    <i class="fas fa-chevron-right" style="color:#555; font-size:12px;"></i>
                </div>

            </div>
        </a>
    @empty

        {{-- Empty State --}}
        <div style="text-align:center; color:#555; margin-top:80px;">
            <i class="fas fa-comment-slash"
               style="font-size:50px; margin-bottom:15px; color:#333;"></i>
            <p style="font-size:16px; margin-bottom:5px; color:#666;">
                No conversations yet
            </p>

            @if($user->role !== 'Admin')
                <p style="font-size:13px; color:#555; margin-bottom:20px;">
                    Start a chat with Admin
                </p>
                <a href="{{ route('chat.start') }}"
                   style="background:#c0392b;
                          color:white;
                          padding:10px 28px;
                          border-radius:25px;
                          text-decoration:none;
                          font-size:14px;
                          font-weight:600;">
                    <i class="fas fa-plus me-1"></i> Start a Chat
                </a>
            @else
                <p style="font-size:13px; color:#555;">
                    Waiting for users to start a conversation
                </p>
            @endif
        </div>

    @endforelse

</div>
@endsection