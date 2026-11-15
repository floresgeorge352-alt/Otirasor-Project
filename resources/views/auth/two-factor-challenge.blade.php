<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication - Otirasor Beach</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f7fb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #1f2937;
        }

        .card {
            background: #ffffff;
            padding: 40px 35px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 420px;
            text-align: center;
            border-top: 5px solid #0077b6;
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        h2 {
            color: #023e8a;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .description {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .input-group {
            text-align: left;
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 18px;
            text-align: center;
            letter-spacing: 8px;
            outline: none;
            transition: 0.2s;
            font-family: monospace;
        }

        .input-group input:focus {
            border-color: #0077b6;
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.15);
        }

        .error-msg {
            color: #c62828;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: left;
            display: block;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #023e8a;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn:hover {
            background: #0077b6;
        }

        .recovery-link {
            display: inline-block;
            margin-top: 20px;
            font-size: 13px;
            color: #6b7280;
            text-decoration: none;
            cursor: pointer;
        }

        .recovery-link:hover {
            color: #0077b6;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="card">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Beach Logo" class="logo">

        <h2>Two-Factor Security</h2>
        
        <p class="description">
            Please enter the 6-digit authentication code from your Google Authenticator app to continue.
        </p>

        {{-- FORM PARA SA 6-DIGIT CODE --}}
        <form method="POST" action="/two-factor-challenge">
            @csrf

            <div class="input-group">
                <label for="code">Authentication Code</label>
                <input 
                    id="code" 
                    type="text" 
                    name="code" 
                    placeholder="000000" 
                    maxlength="6"
                    required 
                    autofocus 
                    autocomplete="one-time-code"
                >
                @if ($errors->has('code'))
                    <span class="error-msg">{{ $errors->first('code') }}</span>
                @endif
            </div>

            <button type="submit" class="btn">
                Verify Code
            </button>
        </form>

        {{-- LINK PARA SA RECOVERY CODE --}}
        <a href="#" onclick="document.getElementById('recovery-form').style.display='block'; this.style.display='none'; return false;" class="recovery-link" id="recovery-link">
            Use a recovery code
        </a>

        {{-- FORM PARA SA RECOVERY CODE (Hidden by default) --}}
        <form method="POST" action="/two-factor-challenge" id="recovery-form" style="display: none; margin-top: 20px;">
            @csrf
            <div class="input-group">
                <label for="recovery_code" style="text-align: center; display: block;">Recovery Code</label>
                <input 
                    id="recovery_code" 
                    type="text" 
                    name="recovery_code" 
                    placeholder="XXXX-XXXX" 
                    required
                    style="text-align: center; letter-spacing: 2px; font-size: 14px;"
                >
                @if ($errors->has('recovery_code'))
                    <span class="error-msg" style="text-align: center;">{{ $errors->first('recovery_code') }}</span>
                @endif
            </div>
            <button type="submit" class="btn" style="background: #64748b;">
                Use Recovery Code
            </button>
        </form>

        {{-- BACK TO LOGIN --}}
        <a href="{{ url('/login') }}" class="recovery-link" style="display: block; margin-top: 25px;">← Back to Login</a>
    </div>

</body>
</html>