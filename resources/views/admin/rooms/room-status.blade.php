<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Room Status - Otirasor Beach</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #333;
        }

        .navbar {
            background: #064b93;
            color: white;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            font-size: 22px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 15px;
        }

        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 25px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 25px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 6px;
        }

        .back-button:hover {
            background: #555;
        }

        .title {
            color: #064b93;
            margin-bottom: 25px;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .summary-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            text-align: center;
        }

        .summary-card h3 {
            margin-top: 0;
            color: #555;
        }

        .number {
            font-size: 38px;
            font-weight: bold;
            color: #168a4a;
            margin: 10px 0;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
        }

        .section h2 {
            color: #064b93;
            margin-top: 0;
        }

        .room-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
        }

        .room {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            background: #fafafa;
        }

        .room-name {
            font-weight: bold;
            font-size: 17px;
            color: #064b93;
        }

        .available {
            color: #168a4a;
            font-weight: bold;
        }

        .reserved {
            color: #d68910;
            font-weight: bold;
        }

        .occupied {
            color: #c0392b;
            font-weight: bold;
        }

        .empty {
            color: #777;
            padding: 10px 0;
        }

        @media (max-width: 768px) {
            .summary {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 18px 20px;
            }

            .navbar a {
                margin-left: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Otirasor Beach and Resort - Admin</h2>

        <div>
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/bookings">Bookings</a>
            <a href="/admin/notifications">Notifications</a>
        </div>
    </div>


    <div class="container">

        <a href="/admin/dashboard" class="back-button">
            ← Back to Dashboard
        </a>

        <h1 class="title">Room Status</h1>


        <!-- SUMMARY -->

        <div class="summary">

            <div class="summary-card">
                <h3>Available Rooms</h3>

                <div class="number">
                    {{ count($availableRooms) }}
                </div>

                <p class="available">
                    Currently Available
                </p>
            </div>


            <div class="summary-card">
                <h3>Reserved Rooms</h3>

                <div class="number">
                    {{ count($reservedRooms) }}
                </div>

                <p class="reserved">
                    Upcoming Reservations
                </p>
            </div>


            <div class="summary-card">
                <h3>Occupied Rooms</h3>

                <div class="number">
                    {{ count($occupiedRooms) }}
                </div>

                <p class="occupied">
                    Currently Occupied
                </p>
            </div>

        </div>


        <!-- AVAILABLE ROOMS -->

        <div class="section">

            <h2>Available Rooms</h2>

            @if(count($availableRooms) > 0)

                <div class="room-list">

                    @foreach($availableRooms as $room)

                        <div class="room">

                            <div class="room-name">
                                {{ $room }}
                            </div>

                            <p class="available">
                                ✓ Available
                            </p>

                        </div>

                    @endforeach

                </div>

            @else

                <p class="empty">
                    No rooms are currently available.
                </p>

            @endif

        </div>


        <!-- RESERVED ROOMS -->

        <div class="section">

            <h2>Reserved Rooms</h2>

            @if(count($reservedRooms) > 0)

                <div class="room-list">

                    @foreach($reservedRooms as $room)

                        <div class="room">

                            <div class="room-name">
                                {{ $room['room'] }}
                            </div>

                            <p class="reserved">
                                Reserved
                            </p>

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

                            <p>
                                <strong>Status:</strong>
                                {{ $room['status'] }}
                            </p>

                        </div>

                    @endforeach

                </div>

            @else

                <p class="empty">
                    No reserved rooms.
                </p>

            @endif

        </div>


        <!-- OCCUPIED ROOMS -->

        <div class="section">

            <h2>Occupied Rooms</h2>

            @if(count($occupiedRooms) > 0)

                <div class="room-list">

                    @foreach($occupiedRooms as $room)

                        <div class="room">

                            <div class="room-name">
                                {{ $room['room'] }}
                            </div>

                            <p class="occupied">
                                Currently Occupied
                            </p>

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

                            <p>
                                <strong>Status:</strong>
                                {{ $room['status'] }}
                            </p>

                        </div>

                    @endforeach

                </div>

            @else

                <p class="empty">
                    No occupied rooms.
                </p>

            @endif

        </div>

    </div>

</body>
</html>