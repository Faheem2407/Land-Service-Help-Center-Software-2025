@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Land Service Help Center</title>

    <link rel="shortcut icon" type="image/x-icon"
        href="{{ isset($systemSetting->favicon) && !empty($systemSetting->favicon) ? asset($systemSetting->favicon) : asset('frontend/logo.png') }}" />

    <style>
        * {
            margin: 0; padding: 0; box-sizing: border-box;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eef2f7;
            font-family: 'Inter', Arial, sans-serif;
        }

        .wrapper {
            background: white;
            max-width: 700px;
            width: 100%;
            padding: 40px 40px 50px;
            border-radius: 14px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.10);
        }

        h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: #1d3557;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.1rem;
            color: #5c677d;
            margin-bottom: 35px;
        }

        .btn {
            padding: 12px 32px;
            font-size: 1.05rem;
            font-weight: 600;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: 0.25s ease;
            text-decoration: none;
            display: inline-block;
            color: white;
        }

        .btn-primary {
            background-color: #1d72b8;
        }

        .btn-primary:hover {
            background-color: #125a94;
            transform: translateY(-2px);
        }

        .icon {
            margin-right: 6px;
        }

        @media(max-width:600px){
            .wrapper { padding: 25px; }
            h1 { font-size: 2.1rem; }
            p { font-size: 1rem; }
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1>Welcome to Land Service Help Center</h1>
        <p>Please log in with your credentials to access your dashboard and manage your land services seamlessly.</p>

        @if(Route::has('login'))
            @auth
                <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                    <span class="icon">🏠</span> Go to Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <span class="icon">🔑</span> Log In
                </a>
            @endauth
        @endif
    </div>
</body>

</html>
