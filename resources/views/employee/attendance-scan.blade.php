<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Attendance</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .attendance-card {
            background: white;
            width: 100%;
            max-width: 450px;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        h1 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .employee-name {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
            margin: 20px 0;
            overflow-wrap: anywhere;
        }

        .message {
            color: #555;
            margin-bottom: 25px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        form {
            margin: 0;
        }

        .time-btn {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .time-in {
            background: #27ae60;
        }

        .time-in:hover {
            background: #219150;
        }

        .time-out {
            background: #e74c3c;
        }

        .time-out:hover {
            background: #c0392b;
        }

        .time-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>

<div class="attendance-card">

    <h1>Employee Attendance</h1>

    <div class="employee-name">
        {{ $employee->name }}
    </div>

    <p class="message">
        Your QR Code has been scanned successfully.
    </p>

    @if(session('success'))
        <div class="alert success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- TIME IN --}}
    <form
        method="POST"
        action="{{ route('employee.attendance.qr-time-in', ['employee' => $employee->id]) }}"
        onsubmit="return confirm('Are you sure you want to record Time In?');"
    >
        @csrf

        <button
            type="submit"
            class="time-btn time-in"
        >
            TIME IN
        </button>
    </form>

    {{-- TIME OUT --}}
    <form
        method="POST"
        action="{{ route('employee.attendance.qr-time-out', ['employee' => $employee->id]) }}"
        onsubmit="return confirm('Are you sure you want to record Time Out?');"
    >
        @csrf

        <button
            type="submit"
            class="time-btn time-out"
        >
            TIME OUT
        </button>
    </form>

    <div class="footer">
        Oti Rasor Beach Employee Attendance System
    </div>

</div>

<script>
    // 1. Kapag binuksan mula sa back/forward cache (tulad ng in-app browser),
    // i-force reload para makakuha ng sariwang CSRF token.
    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });

    // 2. Kapag nag-419 Page Expired (CSRF mismatch), awtomatikong i-refresh
    // para makakuha ng bagong token mula sa server.
    document.addEventListener('DOMContentLoaded', function () {
        // Kung ang page ay nag-redirect pabalik dahil sa 419
        if (document.body.innerText.includes('419') || document.body.innerText.includes('Page Expired')) {
            window.location.reload();
        }

        // Auto-submit guard: pigilan ang double-click sa buttons
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                const btn = form.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.innerText = 'Processing...';
                }
            });
        });
    });
</script>

</body>
</html>