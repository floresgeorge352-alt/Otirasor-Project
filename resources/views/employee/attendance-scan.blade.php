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
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .attendance-card {
            background: white;
            width: 90%;
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

        {{-- Success Message --}}
        @if(session('success'))

            <div class="alert success">
                {{ session('success') }}
            </div>

        @endif

        {{-- Error Message --}}
        @if(session('error'))

            <div class="alert error">
                {{ session('error') }}
            </div>

        @endif

        {{-- Time In --}}
        <form
            method="POST"
            action="https://trigger-nest-welfare-geo.trycloudflare.com/employee/attendance/scan/{{ $employee->id }}/time-in"
        >

            @csrf

            <button
                type="submit"
                class="time-btn time-in"
            >
                Time In
            </button>

        </form>

        {{-- Time Out --}}
        <form
            method="POST"
            action="https://trigger-nest-welfare-geo.trycloudflare.com/employee/attendance/scan/{{ $employee->id }}/time-out"
        >

            @csrf

            <button
                type="submit"
                class="time-btn time-out"
            >
                Time Out
            </button>

        </form>

    </div>

</body>
</html>