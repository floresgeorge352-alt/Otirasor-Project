<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Login | Otirasor Beach and Resort</title>

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
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
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

        .admin-label {
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

        input {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 9px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
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

        .back {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            text-decoration: none;
            font-size: 14px;
        }

        .back:hover {
            color: #2563eb;
        }

        @media (max-width: 480px) {

            .login-box {
                padding: 25px 20px;
            }

            h1 {
                font-size: 24px;
            }

        }

    </style>

</head>


<body>

    <div class="login-box">

        <div class="logo">

            <img
                src="{{ asset('images/otirasor-logo.png') }}"
                alt="Otirasor Beach and Resort Logo"
            >

        </div>


        <h1>
            Admin Login
        </h1>


        <p class="subtitle">
            Otirasor Beach and Resort
        </p>


        <div class="admin-label">
            🔐 MANAGEMENT PORTAL
        </div>


        <form
            method="POST"
            action="{{ url('/admin/login') }}"
        >

            @csrf


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


            <button
                type="submit"
                class="button"
            >
                Login as Admin
            </button>

        </form>


        <a
            href="{{ url('/login') }}"
            class="back"
        >
            ← Customer Login
        </a>

    </div>

</body>

</html>