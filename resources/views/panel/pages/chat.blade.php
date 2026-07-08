{{--
    Minimal WhatsApp-style layout — NO JavaScript, NO AJAX.
    Clicking a conversation just reloads this same page with ?conversation={id}.

    Requires only:
    - controller_minimal_snippet.php changes (index() + send())
    - one new route for sending a message
--}}
@extends('panel.layout')

@section('content')
<div style="display:flex; height:calc(100vh - 100px); background:#1a1a2e; border-radius:12px; overflow:hidden; border:1px solid #3d3d5c;">

    {{-- ============ LEFT: Conversation List (your existing loop, links changed) ============ --}}
    <div style="width:340px; flex-shrink:0; border-right:1px solid #3d3d5c; overflow-y:auto;">

        <div style="padding:20px; border-bottom:1px solid #3d3d5c; display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h5 class="text-white fw-bold mb-1">
                    <i class="fas fa-comments me-2 text-danger"></i> Messages
                </h5>
                <small class="text-muted">Your conversations</small>
            </div>
            <a href="{{ route('chat.users') }}"
               style="background:#c0392b; color:white; padding:8px 18px; border-radius:25px; text-decoration:none; font-size:13px; font-weight:600;">
                <i class="fas fa-plus me-1"></i> New
            </a>
        </div>

        @forelse($conversations as $conv)
            @php
                $other = $conv->otherUser($user->id);
                $isActive = isset($activeConversation) && $activeConversation->id === $conv->id;
            @endphp

            {{-- Only change from your original file: href now points back to chat.index with ?conversation= --}}
            <a href="{{ route('chat.index', ['conversation' => $conv->id]) }}" style="text-decoration:none;">
                <div style="padding:15px 20px; display:flex; align-items:center; gap:12px; border-bottom:1px solid #26263f; background:{{ $isActive ? '#3d3d5c' : 'transparent' }};">

                    <div style="background:#c0392b; border-radius:50%; width:44px; height:44px; display:flex; align-items:center; justify-content:center; font-weight:bold; color:white; font-size:16px; flex-shrink:0;">
                        {{ strtoupper(substr($other->name, 0, 1)) }}
                    </div>

                    <div style="flex:1; min-width:0;">
                        <div style="color:white; font-weight:600; font-size:14px;">{{ $other->name }}</div>
                        <div style="color:#888; font-size:12px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                            @if($conv->messages->last())
                                {{ Str::limit($conv->messages->last()->body, 40) }}
                            @else
                                <em>No messages yet</em>
                            @endif
                        </div>
                    </div>

                    <div style="color:#666; font-size:11px;">{{ $conv->updated_at->diffForHumans(null, true) }}</div>
                </div>
            </a>
        @empty
            <div style="text-align:center; color:#555; margin-top:60px; padding:0 20px;">
                <i class="fas fa-comment-slash" style="font-size:40px; margin-bottom:12px; color:#333;"></i>
                <p style="font-size:14px; color:#666;">No conversations yet</p>
            </div>
        @endforelse
    </div>

    {{-- ============ RIGHT: Active Conversation ============ --}}
    <div style="flex:1; display:flex; flex-direction:column;">

        @if(isset($activeConversation) && $activeConversation)
            @php $other = $activeConversation->otherUser($user->id); @endphp

            <div style="padding:15px 20px; border-bottom:1px solid #3d3d5c; display:flex; align-items:center; gap:12px;">
                <div style="background:#c0392b; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; font-weight:bold; color:white; font-size:15px;">
                    {{ strtoupper(substr($other->name, 0, 1)) }}
                </div>
                <div style="color:white; font-weight:600; font-size:15px;">{{ $other->name }}</div>
            </div>

            <div style="flex:1; overflow-y:auto; padding:20px; display:flex; flex-direction:column; gap:8px; background:#16162a;">
                @forelse($messages as $msg)
                    @php $isMine = $msg->user_id === $user->id; @endphp
                    <div style="align-self:{{ $isMine ? 'flex-end' : 'flex-start' }}; max-width:65%; background:{{ $isMine ? '#c0392b' : '#2d2d44' }}; color:white; padding:10px 14px; border-radius:14px; font-size:14px;">
                        <div>{{ $msg->body }}</div>
                        <div style="font-size:11px; opacity:0.6; margin-top:4px; text-align:right;">{{ $msg->created_at->format('g:i A') }}</div>
                    </div>
                @empty
                    <div style="color:#555; text-align:center; margin-top:40px;">No messages yet — say hi!</div>
                @endforelse
            </div>

            {{-- Plain form POST, page reloads back to this same conversation after sending --}}
            <form action="{{ route('chat.send', $activeConversation->id) }}" method="POST"
                  style="padding:15px 20px; border-top:1px solid #3d3d5c; display:flex; gap:10px;">
                @csrf
                <input type="text" name="body" placeholder="Type a message" autocomplete="off" required
                       style="flex:1; background:#2d2d44; border:1px solid #3d3d5c; border-radius:20px; padding:10px 18px; color:white; font-size:14px; outline:none;">
                <button type="submit"
                        style="background:#c0392b; color:white; border:none; width:42px; height:42px; border-radius:50%; flex-shrink:0; cursor:pointer;">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>

        @else
            <div style="flex:1; display:flex; flex-direction:column; align-items:center; justify-content:center; color:#555;">
                <i class="fas fa-comments" style="font-size:60px; margin-bottom:15px; color:#333;"></i>
                <p style="font-size:15px;">Select a conversation to start chatting</p>
            </div>
        @endif
    </div>
</div>
@endsection