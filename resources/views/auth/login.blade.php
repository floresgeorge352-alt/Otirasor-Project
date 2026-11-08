<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login | Otirasor Beach and Resort</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            background:
                linear-gradient(rgba(0, 50, 80, 0.6), rgba(0, 100, 150, 0.6)),
                url('{{ asset('images/Home-hero.jpeg.jpg') }}') center / cover no-repeat fixed;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            animation: fadeUp 0.6s ease-out forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            width: 95px;
            height: 95px;
            object-fit: contain;
            border-radius: 50%;
            background: white;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            border: 3px solid #0077b6;
        }

        h1 {
            text-align: center;
            color: #023e8a;
            font-family: 'Montserrat', sans-serif;
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .customer-label {
            text-align: center;
            color: #0077b6;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            margin-bottom: 25px;
            background: #eaf8fc;
            padding: 6px;
            border-radius: 20px;
        }

        .form-group { margin-bottom: 20px; }

        label {
            display: block;
            margin-bottom: 8px;
            color: #374151;
            font-size: 13px;
            font-weight: 600;
        }

        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            font-family: 'Poppins', sans-serif;
            outline: none;
            transition: 0.3s;
            background: #f9fafb;
        }

        input:focus {
            border-color: #0077b6;
            background: white;
            box-shadow: 0 0 0 4px rgba(0, 119, 182, 0.1);
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            color: #4b5563;
            font-size: 13px;
            cursor: pointer;
        }

        .remember input { width: auto; cursor: pointer; }

        .button {
            width: 100%;
            border: none;
            padding: 15px;
            border-radius: 10px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: white;
            font-size: 15px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0, 119, 182, 0.3);
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 119, 182, 0.4);
        }

        .links {
            text-align: center;
            margin-top: 20px;
        }

        .links a {
            color: #0077b6;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .links a:hover { text-decoration: underline; }

        .register {
            margin-top: 10px;
            color: #6b7280;
            font-size: 13px;
        }

        .register a { font-weight: 700; }

        .staff-access {
            border-top: 1px solid #e5e7eb;
            margin-top: 25px;
            padding-top: 20px;
            text-align: center;
        }

        .staff-title {
            color: #9ca3af;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 15px;
            letter-spacing: 1px;
        }

        .staff-links {
            display: flex;
            justify-content: center;
            gap: 12px;
        }

        .staff-link {
            flex: 1;
            padding: 11px 8px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 12px;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            color: white !important;
            transition: 0.3s;
        }

        .admin-link { background: #374151; }
        .admin-link:hover { background: #1f2937; transform: translateY(-2px); }

        .employee-link { background: #0077b6; }
        .employee-link:hover { background: #023e8a; transform: translateY(-2px); }

        @media (max-width: 480px) {
            .login-box { padding: 30px 20px; }
            h1 { font-size: 22px; }
            .staff-links { flex-direction: column; }
        }
    </style>
</head>
<body>

    <div class="login-box">
        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Beach and Resort Logo">
        </div>

        <!-- TITLE -->
        <h1>Customer Login</h1>
        <p class="subtitle">Otirasor Beach and Resort</p>
        <div class="customer-label">👤 CUSTOMER PORTAL</div>

        <!-- ERROR -->
        @if ($errors->any())
            <div class="error" style="text-align:center; margin-bottom:15px; padding:10px; background:#fee2e2; border-radius:8px;">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- LOGIN FORM -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <label class="remember">
                <input type="checkbox" name="remember"> Remember me
            </label>

            <button type="submit" class="button">Login as Customer</button>
        </form>

        <!-- LINKS -->
        <div class="links">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Forgot your password?</a>
            @endif
            @if (Route::has('register'))
                <div class="register">
                    Don't have an account? <a href="{{ route('register') }}">Register</a>
                </div>
            @endif
        </div>

        <!-- STAFF ACCESS -->
        <div class="staff-access">
            <div class="staff-title">STAFF ACCESS</div>
            <div class="staff-links">
                <a href="{{ url('/admin/login') }}" class="staff-link admin-link">Admin Portal</a>
                <a href="{{ url('/employee/login') }}" class="staff-link employee-link">Employee Portal</a>
            </div>
        </div>
    </div>

</body>
</html>