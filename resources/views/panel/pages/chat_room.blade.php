@extends('panel.layout')

@section('content')
<div class="d-flex flex-column" style="height: calc(100vh - 130px); padding: 20px;">

    @php $other = $conversation->otherUser($user->id); @endphp

    {{-- Header --}}
    <div class="d-flex align-items-center gap-3 mb-3"
         style="background:#2d2d44; padding:15px 20px; border-radius:12px;">

        <a href="{{ route('chat.index') }}" style="color:#888; text-decoration:none;">
            <i class="fas fa-arrow-left"></i>
        </a>

        <div style="background:#c0392b; border-radius:50%;
                    width:42px; height:42px; flex-shrink:0;
                    display:flex; align-items:center;
                    justify-content:center;
                    color:white; font-weight:bold; font-size:18px;">
            {{ strtoupper(substr($other->name, 0, 1)) }}
        </div>

        <div>
            <div style="color:white; font-weight:600; font-size:15px;">
                {{ $other->name }}
            </div>
            <small style="color:#2ecc71;">● Online</small>
        </div>

    </div>

    {{-- Message Box --}}
    <div id="chat-box"
         style="flex:1;
                overflow-y:auto;
                background:#1a1a2e;
                border-radius:12px;
                padding:20px;
                margin-bottom:15px;
                border:1px solid #2d2d44;">

        @if($messages->isEmpty())
            <div class="empty-state" style="text-align:center; color:#555; margin-top:40px;">
                <i class="fas fa-comment-dots" style="font-size:35px; margin-bottom:10px;"></i>
                <p>No messages yet. Say hello! 👋</p>
            </div>
        @endif

        @foreach($messages as $msg)
            <div class="d-flex mb-3 {{ $msg->user_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                <div style="max-width:65%;">

                    @if($msg->user_id !== auth()->id())
                        <small style="color:#888; display:block; margin-bottom:4px; margin-left:5px;">
                            {{ $msg->user->name }}
                        </small>
                    @endif

                    <div style="background:{{ $msg->user_id === auth()->id() ? '#c0392b' : '#2d2d44' }};
                                color:white;
                                padding:10px 16px;
                                border-radius:{{ $msg->user_id === auth()->id() ? '18px 18px 4px 18px' : '18px 18px 18px 4px' }};
                                font-size:14px;
                                line-height:1.5;
                                word-break:break-word;">
                        {{ $msg->body }}
                    </div>

                    <small style="color:#555; display:block; margin-top:4px;
                                  {{ $msg->user_id === auth()->id() ? 'text-align:right;' : '' }}">
                        {{ $msg->created_at->format('h:i A') }}
                    </small>

                </div>
            </div>
        @endforeach

    </div>

    {{-- Send Message Form --}}
    <form action="{{ route('chat.send', $conversation->id) }}" method="POST" id="chat-form">
        @csrf
        <div class="d-flex gap-2 align-items-center">

            <input
                type="text"
                name="body"
                id="message-input"
                placeholder="Type a message..."
                autocomplete="off"
                required
                style="flex:1;
                       background:#2d2d44;
                       border:1px solid #3d3d5c;
                       color:white;
                       border-radius:25px;
                       padding:12px 20px;
                       outline:none;
                       font-size:14px;">

            <button type="submit"
                    style="background:#c0392b;
                           border:none;
                           color:white;
                           border-radius:50%;
                           width:48px;
                           height:48px;
                           display:flex;
                           align-items:center;
                           justify-content:center;
                           flex-shrink:0;
                           cursor:pointer;">
                <i class="fas fa-paper-plane"></i>
            </button>

        </div>
    </form>

</div>
@endsection

@section('scripts')
<script>
    let lastId = {{ $messages->last()?->id ?? 0 }};

    function scrollToBottom() {
        const box = document.getElementById('chat-box');
        box.scrollTop = box.scrollHeight;
    }

    function appendMessage(msg) {
        const box = document.getElementById('chat-box');

        const emptyState = box.querySelector('.empty-state');
        if (emptyState) emptyState.remove();

        const isMine = msg.is_mine;

        const wrapper = document.createElement('div');
        wrapper.className = `d-flex mb-3 ${isMine ? 'justify-content-end' : 'justify-content-start'}`;

        wrapper.innerHTML = `
            <div style="max-width:65%;">
                ${!isMine
                    ? `<small style="color:#888; display:block; margin-bottom:4px; margin-left:5px;">
                            ${msg.user_name}
                       </small>`
                    : ''
                }
                <div style="background:${isMine ? '#c0392b' : '#2d2d44'};
                            color:white;
                            padding:10px 16px;
                            border-radius:${isMine ? '18px 18px 4px 18px' : '18px 18px 18px 4px'};
                            font-size:14px;
                            line-height:1.5;
                            word-break:break-word;">
                    ${msg.body}
                </div>
                <small style="color:#555; display:block; margin-top:4px;
                              ${isMine ? 'text-align:right;' : ''}">
                    ${msg.created_at}
                </small>
            </div>
        `;

        box.appendChild(wrapper);
        lastId = msg.id;
        scrollToBottom();
    }

    function pollMessages() {
        fetch(`/chat/{{ $conversation->id }}/fetch?last_id=${lastId}`)
            .then(res => res.json())
            .then(messages => {
                messages.forEach(msg => appendMessage(msg));
            })
            .catch(err => console.error('Poll error:', err));
    }

    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();

        const input = document.getElementById('message-input');
        const body = input.value.trim();

        if (!body) return;

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => {
            if (response.ok) {
                input.value = '';
                input.focus();
            } else {
                console.error('Send failed:', response.status);
            }
        })
        .catch(err => console.error('Send error:', err));
    });

    setInterval(pollMessages, 3000);
    scrollToBottom();
</script>
@endsection