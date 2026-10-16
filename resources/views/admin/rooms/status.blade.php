<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title }} - Otirasor Beach</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        nav {
            background: #0077b6;
            padding: 18px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 25px;
            padding: 11px 18px;
            background: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .back-btn:hover {
            background: #005f8f;
        }

        h1 {
            color: #0077b6;
            margin-bottom: 25px;
        }

        .room-card {
            background: white;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .room-card h2 {
            color: #0077b6;
            margin-bottom: 12px;
        }

        .room-card p {
            margin: 6px 0;
        }

        .available-room {
            border-left: 5px solid #28a745;
        }

        .reserved-room {
            border-left: 5px solid #f0ad4e;
        }

        .occupied-room {
            border-left: 5px solid #dc3545;
        }

        .status-available {
            color: #28a745;
            font-weight: bold;
        }

        .status-reserved {
            color: #d68910;
            font-weight: bold;
        }

        .status-occupied {
            color: #dc3545;
            font-weight: bold;
        }

        .empty {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            color: #666;
        }

        footer {
            background: #023e8a;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>

<body>

<nav>

    <div class="logo">
        Otirasor Beach Admin
    </div>

    <div>

        <a href="/admin/dashboard">
            Dashboard
        </a>

        <a href="/admin/bookings">
            Bookings
        </a>

    </div>

</nav>


<div class="container">

    <a
        href="/admin/dashboard"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>


    <h1>
        {{ $title }}
    </h1>


    @if(count($rooms) > 0)

        @foreach($rooms as $room)

            @if($type === 'available')

                <div class="room-card available-room">

                    <h2>
                        {{ $room }}
                    </h2>

                    <p class="status-available">
                        ✓ Available
                    </p>

                </div>


            @elseif($type === 'reserved')

                <div class="room-card reserved-room">

                    <h2>
                        {{ $room['room'] }}
                    </h2>

                    <p>
                        <strong>Guest:</strong>
                        {{ $room['guest_name'] }}
                    </p>

                    <p>
                        <strong>Check-in:</strong>
                        {{ $room['check_in'] }}
                    </p>

                    <p>
                        <strong>Check-out:</strong>
                        {{ $room['check_out'] }}
                    </p>

                    <p class="status-reserved">
                        Status: {{ $room['status'] }}
                    </p>

                </div>


            @elseif($type === 'occupied')

                <div class="room-card occupied-room">

                    <h2>
                        {{ $room['room'] }}
                    </h2>

                    <p>
                        <strong>Guest:</strong>
                        {{ $room['guest_name'] }}
                    </p>

                    <p>
                        <strong>Check-in:</strong>
                        {{ $room['check_in'] }}
                    </p>

                    <p>
                        <strong>Check-out:</strong>
                        {{ $room['check_out'] }}
                    </p>

                    <p class="status-occupied">
                        Status: {{ $room['status'] }}
                    </p>

                </div>

            @endif

        @endforeach

    @else

        <div class="empty">

            @if($type === 'available')

                No available rooms.

            @elseif($type === 'reserved')

                No reserved rooms.

            @elseif($type === 'occupied')

                No occupied rooms.

            @endif

        </div>

    @endif

</div>


<footer>

    <p>
        &copy; 2026 Otirasor Beach. All Rights Reserved.
    </p>

</footer>

</body>
</html>