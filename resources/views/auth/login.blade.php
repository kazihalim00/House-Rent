<x-guest-layout>
    <style>
        .icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background-color: #0f172a;
            border: 1px solid #334155;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .icon-circle svg {
            width: 32px;
            height: 32px;
            color: #ef4444;
        }

        .title {
            text-align: center;
            margin-bottom: 32px;
        }

        .title h2 {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
        }

        .title p {
            font-size: 14px;
            font-weight: 500;
            color: #94a3b8;
            margin-top: 8px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 8px;
        }

        .row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .forgot-link {
            font-size: 14px;
            font-weight: 700;
            color: #ef4444;
            text-decoration: none;
        }

        .forgot-link:hover {
            color: #f87171;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            background-color: #0f172a;
            border: 1px solid #334155;
            color: #ffffff;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input::placeholder {
            color: #64748b;
        }

        .form-input:focus {
            border-color: #ef4444;
        }

        .error-text {
            color: #ef4444;
            font-size: 13px;
            margin-top: 8px;
        }

        .remember-row {
            display: flex;
            align-items: center;
            padding-top: 8px;
            margin-bottom: 8px;
        }

        .remember-row input {
            width: 16px;
            height: 16px;
            accent-color: #dc2626;
            cursor: pointer;
        }

        .remember-row label {
            margin-left: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #94a3b8;
            cursor: pointer;
        }

        .submit-btn {
            width: 100%;
            padding: 12px 16px;
            border-radius: 8px;
            border: none;
            background-color: #dc2626;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.25);
            transition: background-color 0.2s;
            margin-top: 8px;
        }

        .submit-btn:hover {
            background-color: #b91c1c;
        }

        .footer-text {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            font-weight: 500;
            color: #94a3b8;
        }

        .footer-text a {
            color: #ef4444;
            font-weight: 700;
            text-decoration: none;
            margin-left: 4px;
        }

        .footer-text a:hover {
            color: #f87171;
        }

        .status-msg {
            background-color: #064e3b;
            color: #6ee7b7;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
        }
    </style>

    @if (session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif

    <div class="icon-circle">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
            </path>
        </svg>
    </div>

    <div class="title">
        <h2>Welcome Back!</h2>
        <p>Login to find or manage your rental properties</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                autocomplete="username" placeholder="enter@youremail.com" class="form-input">
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div class="row-between">
                <label for="password" class="form-label" style="margin-bottom:0;">Password</label>

            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                placeholder="••••••••" class="form-input">
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="remember-row">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Remember me</label>
        </div>

        <button type="submit" class="submit-btn">Sign In</button>

        <div class="footer-text">
            Don't have an account?
            <a href="{{ route('register') }}">Register here</a>
        </div>
    </form>
</x-guest-layout>