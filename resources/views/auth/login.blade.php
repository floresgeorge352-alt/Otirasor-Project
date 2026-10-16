<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Customer Login | Otirasor Beach and Resort</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;

            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.45),
                    rgba(0, 0, 0, 0.45)
                ),
                url('{{ asset('images/Home-hero.jpeg.jpg') }}')
                center / cover no-repeat;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 420px;

            background: rgba(255, 255, 255, 0.97);

            border-radius: 18px;

            padding: 35px;

            box-shadow:
                0 15px 40px
                rgba(0, 0, 0, 0.25);
        }

        .logo {
            text-align: center;
            margin-bottom: 15px;
        }

        .logo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        h1 {
            text-align: center;

            color: #1f2937;

            font-size: 27px;

            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;

            color: #6b7280;

            font-size: 14px;

            margin-bottom: 28px;
        }

        .customer-label {
            text-align: center;

            color: #2563eb;

            font-size: 13px;

            font-weight: bold;

            margin-bottom: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;

            margin-bottom: 7px;

            color: #374151;

            font-size: 14px;

            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;

            padding: 13px 14px;

            border:
                1px solid #d1d5db;

            border-radius: 9px;

            font-size: 15px;

            outline: none;
        }

        input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px
                rgba(37, 99, 235, 0.10);
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

            margin-bottom: 18px;

            color: #4b5563;

            font-size: 14px;
        }

        .remember input {
            width: auto;
        }

        .button {
            width: 100%;

            border: none;

            padding: 14px;

            border-radius: 9px;

            background: #2563eb;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;
        }

        .button:hover {
            background: #1d4ed8;
        }

        .links {
            text-align: center;

            margin-top: 20px;
        }

        .links a {
            color: #2563eb;

            text-decoration: none;

            font-size: 14px;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .register {
            margin-top: 10px;

            color: #6b7280;

            font-size: 14px;
        }

        .register a {
            font-weight: bold;
        }

        /* =========================
           STAFF ACCESS
        ========================= */

        .staff-access {
            border-top:
                1px solid #e5e7eb;

            margin-top: 25px;

            padding-top: 18px;

            text-align: center;
        }

        .staff-title {
            color: #6b7280;

            font-size: 12px;

            font-weight: bold;

            margin-bottom: 12px;

            letter-spacing: 0.3px;
        }

        .staff-links {
            display: flex;

            justify-content: center;

            gap: 10px;
        }

        .staff-link {
            flex: 1;

            padding: 10px 8px;

            border-radius: 8px;

            text-decoration: none;

            font-size: 12px;

            font-weight: bold;

            color: white !important;
        }

        .admin-link {
            background: #374151;
        }

        .admin-link:hover {
            background: #1f2937;
        }

        .employee-link {
            background: #2563eb;
        }

        .employee-link:hover {
            background: #1d4ed8;
        }

        @media (max-width: 480px) {

            .login-box {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }

            .staff-links {
                flex-direction: column;
            }

        }

    </style>

</head>


<body>


    <div class="login-box">


        <!-- OTIRASOR LOGO -->

        <div class="logo">

            <img
                src="{{ asset('images/otirasor-logo.png') }}"
                alt="Otirasor Beach and Resort Logo"
            >

        </div>


        <!-- TITLE -->

        <h1>
            Customer Login
        </h1>


        <p class="subtitle">
            Otirasor Beach and Resort
        </p>


        <!-- CUSTOMER PORTAL -->

        <div class="customer-label">
            👤 CUSTOMER PORTAL
        </div>


        <!-- ERROR -->

        @if ($errors->any())

            <div class="error">

                {{ $errors->first() }}

            </div>

        @endif


        <!-- LOGIN FORM -->

        <form
            method="POST"
            action="{{ route('login') }}"
        >

            @csrf


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                >

                @error('email')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                >

                @error('password')

                    <div class="error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            <!-- REMEMBER ME -->

            <label class="remember">

                <input
                    type="checkbox"
                    name="remember"
                >

                Remember me

            </label>


            <!-- LOGIN BUTTON -->

            <button
                type="submit"
                class="button"
            >
                Login as Customer
            </button>


        </form>


        <!-- LINKS -->

        <div class="links">

            @if (Route::has('password.request'))

                <a href="{{ route('password.request') }}">
                    Forgot your password?
                </a>

            @endif


            @if (Route::has('register'))

                <div class="register">

                    Don't have an account?

                    <a href="{{ route('register') }}">
                        Register
                    </a>

                </div>

            @endif

        </div>


        <!-- STAFF ACCESS -->

        <div class="staff-access">

            <div class="staff-title">
                STAFF ACCESS
            </div>


            <div class="staff-links">

                <a
                    href="{{ url('/admin/login') }}"
                    class="staff-link admin-link"
                >
                    Admin Portal
                </a>


                <a
                    href="{{ url('/employee/login') }}"
                    class="staff-link employee-link"
                >
                    Employee Portal
                </a>

            </div>

        </div>


    </div>


</body>

</html>