<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Factor Authentication</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; background: #f5f7fa; color: #1f2937; padding: 30px; }
        .container { max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        h1 { color: #023e8a; margin-bottom: 8px; }
        p { color: #6b7280; margin-bottom: 20px; font-size: 14px; }
        .success { background: #d4edda; color: #155724; padding: 12px; border-radius: 6px; margin-bottom: 15px; }
        .error { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 6px; margin-bottom: 15px; }
        .btn { background: #023e8a; color: white; border: none; padding: 10px 20px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn:hover { background: #0077b6; }
        .btn-danger { background: #c62828; }
        .btn-danger:hover { background: #a82020; }
        .btn-secondary { background: #6c757d; }
        .qr-container { background: #f8fafc; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0; }
        .qr-container svg { max-width: 250px; height: auto; }
        .code-input { width: 100%; max-width: 300px; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 18px; letter-spacing: 4px; text-align: center; }
        .recovery-list { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; background: #f8fafc; padding: 20px; border-radius: 8px; margin: 15px 0; }
        .recovery-code { font-family: monospace; background: white; padding: 8px; border: 1px solid #e5e7eb; border-radius: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Two-Factor Authentication</h1>
        <p>Protect your account with an extra layer of security.</p>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="error">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        @if(! $user->two_factor_secret)
            {{-- Not enabled --}}
            <form method="POST" action="{{ route('two-factor.enable') }}">
                @csrf
                <button type="submit" class="btn">Enable 2FA</button>
            </form>
        @elseif(! $user->two_factor_confirmed_at)
            {{-- Enabled but not confirmed --}}
            <p>Scan this QR code with Google Authenticator or Authy:</p>

            <div class="qr-container">
                {!! $user->twoFactorQrCodeSvg() !!}
            </div>

            <p>Secret key (kung hindi mo ma-scan): <strong>{{ decrypt($user->two_factor_secret) }}</strong></p>

            <form method="POST" action="{{ route('two-factor.confirm') }}">
                @csrf
                <input type="text" name="code" class="code-input" placeholder="123456" required>
                <br><br>
                <button type="submit" class="btn">Confirm & Enable</button>
            </form>
        @else
            {{-- Fully enabled --}}
            <p style="color: #2e7d32; font-weight: bold;">✅ Two-factor authentication is enabled.</p>

            <h3 style="margin-top: 20px;">Recovery Codes</h3>
            <p>Save these in a safe place. If you lose access to your authenticator, you can use these codes.</p>

            <div class="recovery-list">
                @foreach($user->recoveryCodes() as $code)
                    <div class="recovery-code">{{ $code }}</div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('two-factor.regenerate-codes') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary">Regenerate Codes</button>
            </form>

            <form method="POST" action="{{ route('two-factor.disable') }}" style="display:inline;" onsubmit="return confirm('Disable 2FA?')">
                @csrf
                <button type="submit" class="btn btn-danger">Disable 2FA</button>
            </form>
        @endif
    </div>
</body>
</html>