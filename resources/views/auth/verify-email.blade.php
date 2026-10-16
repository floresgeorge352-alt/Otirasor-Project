<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

```
<title>Verify Your Email | Otirasor Beach and Resort</title>

<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
        min-height: 100vh;
        background: linear-gradient(
            135deg,
            #e0f7fa,
            #ffffff,
            #dff6ff
        );
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .card {
        width: 100%;
        max-width: 480px;
        background: white;
        border-radius: 24px;
        padding: 40px 35px;
        text-align: center;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .logo {
        width: 120px;
        height: 120px;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    h1 {
        color: #164e63;
        font-size: 28px;
        margin-bottom: 12px;
    }

    .subtitle {
        color: #64748b;
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .email-box {
        background: #f0f9ff;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 25px;
        color: #0369a1;
        font-size: 14px;
        word-break: break-word;
    }

    .success {
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        border-radius: 10px;
        padding: 12px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .btn {
        width: 100%;
        border: none;
        border-radius: 12px;
        padding: 14px;
        background: linear-gradient(
            135deg,
            #0096c7,
            #0077b6
        );
        color: white;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(0, 119, 182, 0.25);
    }

    .login-btn {
        display: block;
        width: 100%;
        margin-top: 12px;
        padding: 13px;
        border-radius: 12px;
        border: 1px solid #cbd5e1;
        background: white;
        color: #164e63;
        text-decoration: none;
        font-size: 15px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.2s;
    }

    .login-btn:hover {
        background: #f0f9ff;
        border-color: #0096c7;
    }

    .footer {
        margin-top: 28px;
        color: #94a3b8;
        font-size: 12px;
    }
</style>
```

</head>

<body>

```
<div class="card">

    <div class="logo">
        <img
            src="{{ asset('images/otirasor-logo.png') }}"
            alt="Otirasor Beach and Resort Logo"
        >
    </div>

    <h1>Verify Your Email</h1>

    <p class="subtitle">
        Welcome to
        <strong>Otirasor Beach and Resort!</strong>

        <br><br>

        Before you continue, please verify your email address
        by clicking the verification link we sent to your email.
    </p>

    <div class="email-box">
        📧 {{ Auth::user()->email }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="success">
            ✓ A new verification link has been sent
            to your email address.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf

        <button type="submit" class="btn">
            Resend Verification Email
        </button>
    </form>

    <!-- Logout first, then go to Customer Login -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="login-btn">
            ← Back to Customer Login
        </button>
    </form>

    <div class="footer">
        © {{ date('Y') }} Otirasor Beach and Resort
    </div>

</div>
```

</body>
</html>
