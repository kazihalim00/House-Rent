@extends('panel.layout')

@section('content')
<div class="d-flex flex-column" style="height: calc(100vh - 130px); padding: 20px;">

    {{-- Chat Header --}}
    <div class="mb-3">
        <h5 class="text-white fw-bold">
            <i class="fas fa-comments me-2 text-danger"></i> Group Chat
        </h5>
        <small class="text-muted">All users and admins can chat here in real-time</small>
    </div>

    {{-- Message Box --}}
    <div id="chat-box"
         style="flex: 1;
                overflow-y: auto;
                background: #1a1a2e;
                border-radius: 12px;
                padding: 20px;
                margin-bottom: 15px;
                border: 1px solid #2d2d44;">

        {{-- Messages loaded from DB on page load --}}
        @foreach($messages as $msg)
            <div class="d-flex mb-3 {{ $msg->user_id === auth()->id() ? 'justify-content-end' : 'justify-content-start' }}">
                <div style="max-width: 65%;">
                    @if($msg->user_id !== auth()->id())
                        <small class="text-muted d-block mb-1 ms-1">
                            {{ $msg->user->name }}
                        </small>
                    @endif
                    <div style="background: {{ $msg->user_id === auth()->id() ? '#c0392b' : '#2d2d44' }};
                                color: white;
                                padding: 10px 15px;
                                border-radius: {{ $msg->user_id === auth()->id() ? '18px 18px 4px 18px' : '18px 18px 18px 4px' }};
                                font-size: 14px;">
                        {{ $msg->body }}
                    </div>
                    <small class="text-muted d-block mt-1 {{ $msg->user_id === auth()->id() ? 'text-end' : '' }}">
                        {{ $msg->created_at->format('h:i A') }}
                    </small>
                </div>
            </div>
        @endforeach

    </div>

    {{-- Send Message Form --}}
    <form action="{{ route('chat.send') }}" method="POST" id="chat-form">
        @csrf
        <div class="d-flex gap-2">
            <input
                type="text"
                name="body"
                id="message-input"
                class="form-control"
                placeholder="Type a message..."
                autocomplete="off"
                style="background: #2d2d44;
                       border: 1px solid #444;
                       color: white;
                       border-radius: 25px;
                       padding: 12px 20px;"
            >
            <button type="submit"
                    style="background: #c0392b;
                           border: none;
                           color: white;
                           border-radius: 50%;
                           width: 48px;
                           height: 48px;
                           display: flex;
                           align-items: center;
                           justify-content: center;
                           flex-shrink: 0;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </form>

</div>
@endsection

@section('scripts')
<script>
    // Track the last message ID we've seen
    let lastId = {{ $messages->last()?->id ?? 0 }};

    // Scroll chat box to bottom
    function scrollToBottom() {
        const box = document.getElementById('chat-box');
        box.scrollTop = box.scrollHeight;
    }

    // Add a new message bubble to the chat box
    function appendMessage(msg) {
        const box = document.getElementById('chat-box');
        const isMine = msg.is_mine;

        const wrapper = document.createElement('div');
        wrapper.className = `d-flex mb-3 ${isMine ? 'justify-content-end' : 'justify-content-start'}`;

        wrapper.innerHTML = `
            <div style="max-width: 65%;">
                ${!isMine ? `<small class="text-muted d-block mb-1 ms-1">${msg.user_name}</small>` : ''}
                <div style="background: ${isMine ? '#c0392b' : '#2d2d44'};
                            color: white;
                            padding: 10px 15px;
                            border-radius: ${isMine ? '18px 18px 4px 18px' : '18px 18px 18px 4px'};
                            font-size: 14px;">
                    ${msg.body}
                </div>
                <small class="text-muted d-block mt-1 ${isMine ? 'text-end' : ''}">
                    ${msg.created_at}
                </small>
            </div>
        `;

        box.appendChild(wrapper);
        lastId = msg.id;
        scrollToBottom();
    }

    // Poll the server every 3 seconds for new messages
    function pollMessages() {
        fetch(`/chat/fetch?last_id=${lastId}`)
            .then(res => res.json())
            .then(messages => {
                messages.forEach(msg => appendMessage(msg));
            })
            .catch(err => console.error('Poll error:', err));
    }

    // Start polling
    setInterval(pollMessages, 3000);

    // Scroll to bottom when page loads
    scrollToBottom();
</script>
@endsection