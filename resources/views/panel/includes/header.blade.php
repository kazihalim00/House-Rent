<nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
        <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
    </a>
    <a href="#" class="sidebar-toggler flex-shrink-0">
        <i class="fa fa-bars"></i>
    </a>
    <form action="{{ route('house-detail') }}" method="GET" class="d-none d-md-flex ms-4">
        <input id="searchInput" class="form-control bg-dark border-0" type="search" name="search" placeholder="Search"
            value="{{ request('search') }}">
    </form>
    <button type="button" onclick="openFilterModal()"
        class="ml-3 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md transition flex items-center" style="background-color: #e53935;" onmouseover="this.style.backgroundColor='#c62828'" onmouseout="this.style.backgroundColor='#e53935'">
        <i class="fas fa-sliders-h mr-2"></i> Filters
    </button>
    <div class="navbar-nav align-items-center ms-auto">
        @auth
        <div class="nav-item dropdown">
            <a href="/chat" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-envelope me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Message</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0" id="header-messages-menu">
                @forelse($latestMessages ?? collect() as $msg)
                    @php
                        $other = $msg->conversation->otherUser($user->id);
                        $avatar = $other->user_image
                            ? asset('upload/img/' . $other->user_image)
                            : asset('default.png');  
                    @endphp
                    <a href="{{ route('chat.show', $msg->conversation_id) }}" class="dropdown-item header-message-item">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle" src="{{ $avatar }}" alt="" style="width: 40px; height: 40px; object-fit:cover;">
                            <div class="ms-2" style="overflow:hidden;">
                                <h6 class="fw-normal mb-0" style="text-overflow:ellipsis; white-space:nowrap; overflow:hidden;">
                                    {{ $msg->is_mine ? 'You' : $other->name }}: {{ \Illuminate\Support\Str::limit($msg->body, 30) }}
                                </h6>
                                <small>{{ $msg->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </a>
                    @if(!$loop->last)
                        <hr class="dropdown-divider">
                    @endif
                @empty
                    <div class="dropdown-item text-center text-muted" id="header-no-messages">
                        <small>No new messages</small>
                    </div>
                @endforelse
                <hr class="dropdown-divider">
                <a href="{{ route('chat.index') }}" class="dropdown-item text-center">See all message</a>
            </div>
        </div>
        <!-- <div class="nav-item dropdown">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <i class="fa fa-bell me-lg-2"></i>
                <span class="d-none d-lg-inline-flex">Notificatin</span>
            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Profile updated</h6>
                    <small>15 minutes ago</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">New user added</h6>
                    <small>15 minutes ago</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item">
                    <h6 class="fw-normal mb-0">Password changed</h6>
                    <small>15 minutes ago</small>
                </a>
                <hr class="dropdown-divider">
                <a href="#" class="dropdown-item text-center">See all notifications</a>
            </div>
        </div> -->
        <div class="nav-item dropdown">
            <a href="/chat" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img class="rounded-circle me-lg-2"
                    src="{{ Auth::user()->user_image ? asset('upload/img/' . Auth::user()->user_image) : asset('default.png') }}"
                    style="width: 40px; height: 40px;">
                <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>

            </a>
            <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0 text-center">

                <div class="py-2">
                    <span class="badge
                    {{ Auth::user()->role == 'Admin' ? 'bg-success' : 'bg-warning' }}">
                        {{ Auth::user()->role }}
                    </span>
                </div>

                <a href="#" class="dropdown-item">My Profile</a>
                <a href=" {{ route('profile.edit') }}" class="dropdown-item">Settings</a>

                <hr class="dropdown-divider">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="dropdown-item" href="javascript:void(0);"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bx bx-power-off me-2"></i>
                        Log Out
                    </a>
                </form>

            </div>
        </div>
        @else
            <div class="nav-item">
                <a href="{{ route('login') }}" class="nav-link">Login</a>
            </div>
            <div class="nav-item">
                <a href="{{ route('register') }}" class="nav-link text-primary">Register</a>
            </div>
        @endauth
    </div>
</nav>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');

        if (searchInput) {
            searchInput.addEventListener('keyup', function (e) {
                if (this.value.trim() === '' && window.location.search !== '') {
                    window.location.href = window.location.pathname;
                }
            });

            searchInput.addEventListener('search', function () {
                if (this.value.trim() === '' && window.location.search !== '') {
                    window.location.href = window.location.pathname;
                }
            });
        }

        // Real-time header messages polling
        const menu = document.getElementById('header-messages-menu');
        if (menu) {
            const csrf = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '';
            const endpoint = '/chat/header/latest';

            function escapeHtml(str) {
                return String(str ?? '').replace(/[&<>"']/g, function (m) {
                    return ({
                        '&': '&amp;', '<': '&lt;', '>': '&gt;',
                        '"': '&quot;', "'": '&#39;'
                    })[m];
                });
            }

            function renderHeaderMessages(messages) {
                let html = '';
                if (!messages || messages.length === 0) {
                    html = '<div class="dropdown-item text-center text-muted"><small>No new messages</small></div><hr class="dropdown-divider">';
                } else {
                    messages.forEach(function (msg, idx) {
                        const img = msg.user_image
                            ? '/upload/img/' + msg.user_image
                            : '/default.png';
                        const body = (msg.body || '').length > 30
                            ? msg.body.substring(0, 30) + '…'
                            : msg.body;
                        html += '<a href="/chat/' + msg.conversation_id + '" class="dropdown-item header-message-item">' +
                            '<div class="d-flex align-items-center">' +
                                '<img class="rounded-circle" src="' + img + '" alt="" style="width: 40px; height: 40px; object-fit:cover;">' +
                                '<div class="ms-2" style="overflow:hidden;">' +
                                    '<h6 class="fw-normal mb-0" style="text-overflow:ellipsis; white-space:nowrap; overflow:hidden;">' +
                                        (msg.is_mine ? 'You' : escapeHtml(msg.user_name)) + ': ' + escapeHtml(body) +
                                    '</h6>' +
                                    '<small>' + escapeHtml(msg.time) + '</small>' +
                                '</div>' +
                            '</div>' +
                        '</a>';
                        if (idx < messages.length - 1) {
                            html += '<hr class="dropdown-divider">';
                        }
                    });
                    html += '<hr class="dropdown-divider">';
                }
                html += '<a href="/chat" class="dropdown-item text-center">See all message</a>';
                menu.innerHTML = html;
            }

            function pollHeaderMessages() {
                fetch(endpoint, {
                    method: 'GET',
                    headers: { 'X-CSRF-TOKEN': csrf, 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                })
                .then(res => res.ok ? res.json() : [])
                .then(data => renderHeaderMessages(Array.isArray(data) ? data : []))
                .catch(err => console.error('Header messages poll error:', err));
            }

            // Initial sync, then poll every 5 seconds
            pollHeaderMessages();
            setInterval(pollHeaderMessages, 5000);
        }
    });
</script>