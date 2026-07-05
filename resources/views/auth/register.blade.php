<x-guest-layout>
    <style>
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
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 8px;
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

        .bottom-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 24px;
        }

        .login-link {
            font-size: 14px;
            font-weight: 700;
            color: #94a3b8;
            text-decoration: underline;
        }

        .login-link:hover {
            color: #cbd5e1;
        }

        .submit-btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            background-color: #dc2626;
            color: #ffffff;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.25);
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background-color: #b91c1c;
        }
    </style>

    <div class="title">
        <h2>Create Account</h2>
        <p>Register to find or list your rental properties</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                placeholder="Your full name" class="form-input">
            @error('name')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                placeholder="enter@youremail.com" class="form-input">
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                placeholder="••••••••" class="form-input">
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                autocomplete="new-password" placeholder="••••••••" class="form-input">
            @error('password_confirmation')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="bottom-row">
            <a class="login-link" href="{{ route('login') }}">Already registered?</a>
            <button type="submit" class="submit-btn">Register</button>
        </div>
    </form>
</x-guest-layout>