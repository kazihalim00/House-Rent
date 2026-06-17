<style>
    .site-nav {
        background-color: transparent !important;
        padding: 16px 0;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        z-index: 999;
    }

    .site-nav .menu-bg-wrap {
        background: rgba(22, 33, 62, 0.75) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(42, 58, 92, 0.6);
        border-radius: 12px;
        padding: 0 24px;
    }

    .site-navigation {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 0 !important;
        height: 60px;
    }

    /* Logo */
    .site-nav .logo {
        color: #f0f4ff !important;
        font-weight: 700;
        font-size: 20px;
        text-decoration: none;
        letter-spacing: -0.3px;
        flex-shrink: 0;
    }

    .site-nav .logo span {
        color: #e53935;
    }

    /* Nav menu */
    .site-nav .site-menu {
        display: flex !important;
        align-items: center !important;
        margin: 0 !important;
        padding: 0 !important;
        list-style: none;
        gap: 2px;
    }

    .site-nav .site-menu>li>a {
        color: #b0bec5 !important;
        font-weight: 500;
        font-size: 15px;
        transition: color 0.2s;
        padding: 8px 14px !important;
        display: flex;
        align-items: center;
        white-space: nowrap;
        line-height: 1 !important;
    }

    .site-nav .site-menu>li>a:hover,
    .site-nav .site-menu>li.active>a {
        color: #e53935 !important;
    }

    /* Dropdown */
    .site-nav .site-menu .dropdown {
        background: #1e2a45 !important;
        border: 1px solid #2a3a5c !important;
        border-radius: 10px !important;
        padding: 8px !important;
        min-width: 170px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    }

    .site-nav .site-menu .dropdown li a {
        color: #b0bec5 !important;
        padding: 9px 14px !important;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        display: block;
        transition: background 0.15s, color 0.15s;
        line-height: 1.4 !important;
    }

    .site-nav .site-menu .dropdown li a:hover {
        background: rgba(229, 57, 53, 0.12) !important;
        color: #e53935 !important;
    }

    /* Auth buttons inline */
    .nav-login-btn {
        color: #b0bec5 !important;
        font-weight: 600;
        font-size: 15px;
        padding: 8px 14px !important;
        transition: color 0.2s;
        white-space: nowrap;
        line-height: 1 !important;
    }

    .nav-login-btn:hover {
        color: #e53935 !important;
    }

    .nav-signup-btn {
        background: #e53935 !important;
        border: none !important;
        color: #fff !important;
        padding: 8px 18px !important;
        border-radius: 8px !important;
        font-weight: 600;
        font-size: 14px;
        line-height: 1 !important;
        transition: background 0.2s;
        text-decoration: none;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
    }

    .nav-signup-btn:hover {
        background: #c62828 !important;
        color: #fff !important;
    }

    /* User dropdown */
    .user-dropdown {
        background: #1e2a45 !important;
        border: 1px solid #2a3a5c !important;
        border-radius: 10px !important;
        padding: 8px !important;
        min-width: 170px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4) !important;
    }

    .user-dropdown li a {
        display: block;
        padding: 9px 14px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.15s, color 0.15s;
        text-decoration: none;
        line-height: 1.4 !important;
    }

    .user-dropdown .dash-link {
        color: #b0bec5 !important;
    }

    .user-dropdown .dash-link:hover {
        background: rgba(176, 190, 197, 0.1) !important;
        color: #f0f4ff !important;
    }

    .user-dropdown .logout-link {
        color: #e53935 !important;
    }

    .user-dropdown .logout-link:hover {
        background: rgba(229, 57, 53, 0.12) !important;
    }

    /* Burger */
    .site-nav .burger span,
    .site-nav .burger span::before,
    .site-nav .burger span::after {
        background: #f0f4ff !important;
    }

    /* Filter Modal Styling */
    #filterModal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.6);
        backdrop-filter: blur(4px);
    }

    .modal-content-custom {
        background-color: #16213e;
        margin: 10% auto;
        padding: 0px;
        border: 1px solid #2a3a5c;
        width: 90%;
        max-width: 500px;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        color: #f0f4ff;
    }

    .modal-header-custom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        margin-bottom: 20px;
        padding-bottom: 10px;
    }

    .modal-header-custom h3 { margin: 0; font-size: 20px; color: #e53935; }
    
    .close-modal { color: #b0bec5; font-size: 28px; font-weight: bold; cursor: pointer; }
    .close-modal:hover { color: #fff; }

    .form-group-custom { margin-bottom: 15px; }
    .form-group-custom label { display: block; margin-bottom: 5px; font-size: 13px; font-weight: 600; color: #b0bec5; text-transform: uppercase; }
    .form-input-custom {
        width: 100%;
        padding: 10px;
        background: rgba(255,255,255,0.05);
        border: 1px solid #2a3a5c;
        border-radius: 8px;
        color: #fff;
        outline: none;
    }
    .form-input-custom:focus { border-color: #e53935; }

    .apply-btn-custom {
        background: #e53935;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 700;
        width: 100%;
        margin-top: 10px;
        cursor: pointer;
        transition: background 0.3s;
    }
    .apply-btn-custom:hover { background: #c62828; }
</style>

<nav class="site-nav">
    <div class="container">
        <div class="menu-bg-wrap">
            <div class="site-navigation">
                <a href="{{ url('/') }}" class="logo m-0">
                    House <span>Rent</span>
                </a>

                <ul class="js-clone-nav d-none d-lg-inline-block text-start site-menu align-items-center"
                    style="margin-left:auto;">
                    <li class="active"><a href="{{ url('/') }}">Home</a></li>

                    <li class="has-children">
                        <a href="{{ route('house-detail') }}">Properties</a>
                        <ul class="dropdown">
                            <li><a href="{{ route('house-detail') }}">All Houses</a></li>
                            <li><a href="{{ route('house-detail') }}">Rent a House</a></li>
                            <li><a href="{{ url('/') }}#popularhouses">Popular Houses</a></li>
                        </ul>
                    </li>

                    <li><a href="{{ url('/') }}#services">Services</a></li>
                    <li><a href="javascript:void(0)" onclick="openFilterModal()">Filters</a></li>
                    <li><a href="{{ url('/') }}#team">Team</a></li>
                    <li><a href="{{ url('/') }}#about">About</a></li>

                    @auth
                        <li class="has-children">
                            <a href="#" style="color:#b0bec5 !important; display:flex; align-items:center; gap:6px;">
                                <span class="icon-person" style="color:#e53935;"></span>
                                {{ explode(' ', Auth::user()->name)[0] }}
                            </a>
                            <ul class="dropdown user-dropdown">
                                <li>
                                    <a href="{{ url('/dashboard') }}" class="dash-link">Dashboard</a>
                                </li>
                                <li style="margin-top:4px;">
                                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                                        @csrf
                                        <a href="#" class="logout-link"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                            Logout
                                        </a>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li><a href="{{ route('login') }}" class="nav-login-btn">Login</a></li>
                        <li style="display:flex; align-items:center; padding-left:6px;">
                            <a href="{{ route('register') }}" class="nav-signup-btn">Sign up</a>
                        </li>
                    @endauth
                </ul>

                <a href="#" class="burger light ms-auto site-menu-toggle js-menu-toggle d-inline-block d-lg-none"
                    data-toggle="collapse" data-target="#main-navbar">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
</nav>

<div id="filterModal" class="modal-backdrop-custom">
    <div class="modal-content-custom">
        
        <div class="modal-header-custom">
            <div class="modal-title-layout">
                <svg class="header-filter-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 5C4 4.44772 4.44772 4 5 4H19C19.5523 4 20 4.44772 20 5V7.17157C20 7.70201 19.7893 8.21071 19.4142 8.58579L14.5858 13.4142C14.2107 13.7893 14 14.298 14 14.8284V19L10 21V14.8284C10 14.298 9.78929 13.7893 9.41421 13.4142L4.58579 8.58579C4.21071 8.21071 4 7.70201 4 7.17157V5Z" fill="#5F33FF"/>
                </svg>
                <h3>Advanced Search</h3>
            </div>
            <span class="close-modal" onclick="closeFilterModal()">&times;</span>
        </div>

        <form action="{{ route('house-detail') }}" method="GET" class="modal-form-custom">
            
            <div class="form-group-custom">
                <label>LOCATION</label>
                <div class="input-icon-wrapper">
                    <span class="input-inner-icon">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9A9EA9" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                    </span>
                    <input type="text" name="location" value="{{ request('location') }}" class="form-input-custom icon-padding" placeholder="City or area...">
                </div>
            </div>

            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label>MIN PRICE (৳)</label>
                    <input type="text" name="min_price" value="{{ request('min_price') }}" class="form-input-custom" placeholder="e.g. 5000">
                </div>
                <div class="form-group-custom">
                    <label>MAX PRICE (৳)</label>
                    <input type="text" name="max_price" value="{{ request('max_price') }}" class="form-input-custom" placeholder="e.g. 20000">
                </div>
            </div>

            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label>BEDROOMS</label>
                    <div class="select-wrapper-custom">
                        <select name="rooms" class="form-input-custom select-custom">
                            <option value="" {{ request('rooms') == '' ? 'selected' : '' }}>Any Rooms</option>
                            <option value="1" {{ request('rooms') == '1' ? 'selected' : '' }}>1 Room</option>
                            <option value="2" {{ request('rooms') == '2' ? 'selected' : '' }}>2 Rooms</option>
                            <option value="3" {{ request('rooms') == '3' ? 'selected' : '' }}>3+ Rooms</option>
                        </select>
                    </div>
                </div>
                <div class="form-group-custom">
                    <label>AVAILABILITY</label>
                    <div class="date-wrapper-custom">
                        <input type="date" name="date" value="{{ request('date') }}" class="form-input-custom date-custom">
                    </div>
                </div>
            </div>

            <div class="modal-footer-divider"></div>

            <div class="modal-footer-custom">
                <button type="button" class="clear-filters-btn" onclick="window.location.href='{{ route('house-detail') }}'">
                    <span class="clear-x-icon">&times;</span> Clear Filters
                </button>
                <div class="footer-actions-right">
                    <button type="button" class="btn-custom btn-cancel" onclick="closeFilterModal()">Cancel</button>
                    <button type="submit" class="btn-custom btn-apply">Apply Filters</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
:root {
    --modal-bg: #ffffff;
    --header-bg: #121624;
    --text-dark: #1E232F;
    --text-muted: #848A9C;
    --text-placeholder: #9A9EA9;
    --border-color: #2F3341;
    
    --color-purple: #5F33FF;
    --color-cancel-bg: #E8EBF1;
    --color-cancel-text: #464C59;
    --color-clear-text: #F2380A;
}

/* Outer Backdrop Setup */
.modal-backdrop-custom {
    display: none; 
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.4);
    align-items: center;
    justify-content: center;
}

.modal-backdrop-custom[style*="display: block"] {
    display: flex !important;
}

/* Primary Card Container Frame */
.modal-content-custom {
    background-color: var(--modal-bg);
    width: 100%;
    max-width: 740px; /* Marginally widened for ideal proportion matching */
    border-radius: 18px;
    box-shadow: 0px 16px 40px rgba(0, 0, 0, 0.12);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
}

/* Header Banner - Top Curves explicitly added */
.modal-header-custom {
    background-color: var(--header-bg);
    padding: 26px 38px; /* Perfectly aligned to match the expanded left/right form alignment */
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 18px 18px 0 0; /* Ensures top corners map card perfectly */
}

.modal-title-layout {
    display: flex;
    align-items: center;
    gap: 14px;
}

.header-filter-icon {
    width: 20px;
    height: 20px;
}

.modal-header-custom h3 {
    color: #ffffff;
    margin: 0;
    font-size: 21px;
    font-weight: 700;
    letter-spacing: -0.3px;
}

.close-modal {
    font-size: 26px;
    color: #8E94A5;
    cursor: pointer;
    line-height: 1;
    font-weight: 300;
}

.close-modal:hover {
    color: #ffffff;
}

/* Expanded Form Layout */
.modal-form-custom {
    padding: 40px 38px 34px 38px; /* Significantly expanded internal canvas space */
    margin: 0;
}

.form-group-custom {
    margin-bottom: 32px; /* Amplified separation between horizontal structural rows */
    display: flex;
    flex-direction: column;
}

.form-row-custom {
    display: flex;
    gap: 32px; /* Wider spacing gap between multi-column inputs */
}

.form-row-custom .form-group-custom {
    flex: 1;
}

.form-group-custom label {
    font-size: 11.5px;
    font-weight: 700;
    color: var(--text-muted);
    margin-bottom: 12px;
    letter-spacing: 0.6px;
}

/* Input Fields Adjustments */
.form-input-custom {
    width: 100%;
    height: 54px; /* Increased slightly for premium spatial layout look */
    padding: 12px 18px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    font-size: 15px;
    color: var(--text-dark);
    background-color: #ffffff;
    box-sizing: border-box;
}

.form-input-custom::placeholder {
    color: var(--text-placeholder);
}

.form-input-custom:focus {
    outline: none;
    border-color: var(--color-purple);
}

/* Custom Location Icon Padding rules */
.input-icon-wrapper {
    position: relative;
    width: 100%;
}

.input-inner-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    display: flex;
    align-items: center;
    pointer-events: none;
}

.icon-padding {
    padding-left: 48px !important;
}

/* Custom dropdown and select arrows layout overrides */
.select-custom {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%231E232F' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 18px center;
    background-size: 15px;
    padding-right: 44px;
    cursor: pointer;
}

.date-custom {
    cursor: pointer;
}

/* Bottom separator line */
.modal-footer-divider {
    height: 1px;
    background-color: #F0F2F6;
    margin: 16px 0 32px 0;
}

/* Footer Section spacing metrics mapping */
.modal-footer-custom {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.clear-filters-btn {
    background: none;
    border: none;
    color: var(--color-clear-text);
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 0;
}

.clear-x-icon {
    font-size: 18px;
    font-weight: 800;
    line-height: 1;
}

.footer-actions-right {
    display: flex;
    gap: 16px;
}

.btn-custom {
    height: 50px;
    padding: 0 32px;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-cancel {
    background-color: var(--color-cancel-bg);
    color: var(--color-cancel-text);
}

.btn-cancel:hover {
    background-color: #DDE2EC;
}

.btn-apply {
    background-color: var(--color-purple);
    color: #ffffff;
}

.btn-apply:hover {
    background-color: #4C24DF;
}
</style>
<script>
    function openFilterModal() {
        document.getElementById('filterModal').style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeFilterModal() {
        document.getElementById('filterModal').style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside background element wrapper
    window.onclick = function(event) {
        var modal = document.getElementById('filterModal');
        if (event.target == modal) {
            closeFilterModal();
        }
    }
    
    // Close cleanly via the Escape hardware trigger sequence
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeFilterModal();
        }
    });
</script>