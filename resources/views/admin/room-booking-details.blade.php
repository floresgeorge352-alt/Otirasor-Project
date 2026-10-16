<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Room Booking Details - Otirasor Beach and Resort</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #333;
        }

        nav {
            background: #023e8a;
            color: white;
            padding: 18px 35px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            flex-wrap: wrap;
            gap: 15px;
        }

        .logo {
            font-size: 22px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            font-size: 15px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .logout-btn:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .back-btn {
            display: inline-block;

            margin-bottom: 20px;

            padding: 10px 16px;

            background: #0077b6;
            color: white;

            text-decoration: none;

            border-radius: 6px;

            font-size: 14px;
        }

        .back-btn:hover {
            background: #023e8a;
        }

        .page-header {
            background: white;
            padding: 28px;
            border-radius: 12px;
            margin-bottom: 30px;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .page-header h1 {
            color: #023e8a;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #666;
        }

        .section-title {
            color: #023e8a;
            margin: 30px 0 15px;
            font-size: 22px;
        }

        .table-container {
            background: white;

            border-radius: 12px;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.07);

            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th {
            background: #023e8a;
            color: white;

            padding: 14px;

            text-align: left;

            font-size: 14px;
        }

        td {
            padding: 14px;

            border-bottom: 1px solid #eee;

            font-size: 14px;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background: #f8fbff;
        }

        .status {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 12px;
            font-weight: bold;
        }

        .status-confirmed {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-pending {
            background: #fff3cd;
            color: #664d03;
        }

        .empty {
            background: white;

            padding: 30px;

            text-align: center;

            border-radius: 12px;

            color: #777;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.07);
        }

        footer {
            background: #023e8a;
            color: white;

            text-align: center;

            padding: 20px;

            margin-top: 50px;
        }

        @media (max-width: 700px) {

            nav {
                flex-direction: column;
                text-align: center;
            }

            .nav-links {
                justify-content: center;
            }

            .container {
                margin-top: 20px;
            }

            .page-header h1 {
                font-size: 24px;
            }

        }

    </style>

</head>


<body>


<nav>

    <div class="logo">
        Otirasor Beach and Resort - Admin
    </div>

    <div class="nav-links">

        <a href="/admin/dashboard">
            Dashboard
        </a>

        <a href="/admin/bookings">
            Bookings
        </a>

        <a href="/admin/notifications">
            Notifications
        </a>

        <form
            method="POST"
            action="/logout"
            style="display: inline;"
        >

            @csrf

            <button
                type="submit"
                class="logout-btn"
            >
                Logout
            </button>

        </form>

    </div>

</nav>


<div class="container">


    <a
        href="/admin/booking-information"
        class="back-btn"
    >
        ← Back to Booking Information
    </a>


    <div class="page-header">

        <h1>
            Room Booking Details
        </h1>

        <p>
            View currently occupied rooms and upcoming room reservations.
        </p>

    </div>


    <!-- =====================================================
         CURRENTLY OCCUPIED
    ====================================================== -->

    <h2 class="section-title">
        Currently Occupied
    </h2>


    @if (count($occupiedRoomDetails) > 0)

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Room
                        </th>

                        <th>
                            Guest
                        </th>

                        <th>
                            Check In
                        </th>

                        <th>
                            Check Out
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($occupiedRoomDetails as $room)

                        <tr>

                            <td>
                                {{ $room['room'] }}
                            </td>

                            <td>
                                {{ $room['guest_name'] }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($room['check_in'])->format('M d, Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($room['check_out'])->format('M d, Y') }}
                            </td>

                            <td>

                                <span class="status status-confirmed">
                                    Occupied
                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty">

            No rooms are currently occupied.

        </div>

    @endif


    <!-- =====================================================
         UPCOMING RESERVATIONS
    ====================================================== -->

    <h2 class="section-title">
        Upcoming Reservations
    </h2>


    @if (count($reservedRoomDetails) > 0)

        <div class="table-container">

            <table>

                <thead>

                    <tr>

                        <th>
                            Room
                        </th>

                        <th>
                            Guest
                        </th>

                        <th>
                            Check In
                        </th>

                        <th>
                            Check Out
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach ($reservedRoomDetails as $room)

                        <tr>

                            <td>
                                {{ $room['room'] }}
                            </td>

                            <td>
                                {{ $room['guest_name'] }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($room['check_in'])->format('M d, Y') }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($room['check_out'])->format('M d, Y') }}
                            </td>

                            <td>

                                @if ($room['status'] === 'Confirmed')

                                    <span class="status status-confirmed">
                                        Confirmed
                                    </span>

                                @else

                                    <span class="status status-pending">
                                        Pending
                                    </span>

                                @endif

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="empty">

            No upcoming room reservations.

        </div>

    @endif


</div>


<footer>

    <p>
        &copy; 2026 Otirasor Beach and Resort.
        All Rights Reserved.
    </p>

</footer>


</body>

</html>