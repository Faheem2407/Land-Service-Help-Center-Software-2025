<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    @include('backend.partials.style')

    <style>
        body {
            background: #eef2f7;
            font-family: 'Inter', sans-serif;
        }

        .login-wrapper {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            background: white;
            border-radius: 12px;
            padding: 35px 40px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .login-title {
            font-size: 2rem;
            font-weight: 700;
            color: #1d3557;
            margin-bottom: 25px;
            text-align: center;
        }

        label {
            font-weight: 600;
            color: #4a5568;
        }

        .form-control {
            border-radius: 6px;
            padding: 12px;
            border: 1px solid #d4d8e0;
            transition: 0.2s ease;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
        }

        .btn-primary {
            padding: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 6px;
            background-color: #1d72b8;
            transition: 0.25s ease;
            border: none;
        }

        .btn-primary:hover {
            background-color: #125a94;
            transform: translateY(-2px);
        }

        .input-group button {
            border-radius: 0 6px 6px 0;
        }
    </style>
</head>

@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp

<body>
    <div class="login-wrapper">
        <div class="login-card">

            <h1 class="login-title">{{ $systemSetting->title }}</h1>

            {{-- If user is already logged in, show Go to Dashboard --}}
            @auth
                <div class="text-center mb-4">
                    <h3>You are already logged in</h3>
                    <p>Click below to access your dashboard.</p>
                </div>

                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-100">
                    Go to Dashboard
                </a>
            @else

                {{-- Show login form only for guests --}}
                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    {{-- Status message --}}
                    @if (session('status'))
                        <div class="alert alert-info mb-3">{{ session('status') }}</div>
                    @endif

                    {{-- Email --}}
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Enter your email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label>Password</label>
                        <div class="input-group">
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            <button class="btn btn-light" type="button" id="password-addon">
                                <i class="mdi mdi-eye-outline"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Submit button --}}
                    <div class="d-grid mt-4">
                        <button class="btn btn-primary">Log In</button>
                    </div>

                </form>
            @endauth

        </div>
    </div>

    @include('backend.partials.script')
</body>
</html>
