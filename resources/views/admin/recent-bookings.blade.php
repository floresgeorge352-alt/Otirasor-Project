<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Recent Bookings - Otirasor Beach and Resort</title>

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

        nav {
            background: #023e8a;
            color: white;
            padding: 18px 35px;

            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 21px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .back-button {
            display: inline-block;

            background: #0077b6;
            color: white;

            text-decoration: none;

            padding: 10px 16px;

            border-radius: 6px;

            margin-bottom: 20px;
        }

        .back-button:hover {
            background: #023e8a;
        }

        h1 {
            color: #023e8a;
            margin-bottom: 8px;
        }

        .description {
            color: #666;
            margin-bottom: 25px;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            overflow-x: auto;

            box-shadow:
                0 2px 8px rgba(0, 0, 0, 0.07);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #023e8a;
            color: white;
            padding: 13px;
            text-align: left;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
        }

        .pending {
            color: #fd7e14;
            font-weight: bold;
        }

        .confirmed {
            color: #198754;
            font-weight: bold;
        }

        .rejected {
            color: #dc3545;
            font-weight: bold;
        }

        .cancelled {
            color: #6c757d;
            font-weight: bold;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #777;
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
                gap: 10px;
                text-align: center;
            }

            th,
            td {
                white-space: nowrap;
            }

        }

    </style>

</head>


<body>


<nav>

    <div class="logo">
        Otirasor Beach and Resort - Admin
    </div>

    <a href="/admin/dashboard">
        Dashboard
    </a>

</nav>


<div class="container">


    <a
        href="/admin/booking-information"
        class="back-button"
    >
        ← Back to Booking Information
    </a>


    <h1>
        Recent Bookings
    </h1>


    <p class="description">
        View the latest customer reservations recorded in the system.
    </p>


    <div class="table-container">

        <table>

            <thead>

                <tr>

                    <th>Guest</th>

                    <th>Contact</th>

                    <th>Guests</th>

                    <th>Accommodation</th>

                    <th>Check In</th>

                    <th>Check Out</th>

                    <th>Payment</th>

                    <th>Status</th>

                </tr>

            </thead>


            <tbody>

                @forelse ($recentBookings as $booking)

                    <tr>

                        <td>
                            {{ $booking->guest_name }}
                        </td>

                        <td>
                            {{ $booking->contact_number }}
                        </td>

                        <td>
                            {{ $booking->number_of_guests }}
                        </td>

                        <td>
                            {{ $booking->accommodations }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                        </td>

                        <td>
                            {{ $booking->payment_method }}
                        </td>

                        <td>

                            @if ($booking->status === 'Pending')

                                <span class="pending">
                                    Pending
                                </span>

                            @elseif ($booking->status === 'Confirmed')

                                <span class="confirmed">
                                    Confirmed
                                </span>

                            @elseif ($booking->status === 'Rejected')

                                <span class="rejected">
                                    Rejected
                                </span>

                            @elseif ($booking->status === 'Cancelled')

                                <span class="cancelled">
                                    Cancelled
                                </span>

                            @else

                                {{ $booking->status }}

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="empty"
                        >
                            No recent bookings found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


</div>


<footer>

    <p>
        &copy; 2026 Otirasor Beach and Resort.
        All Rights Reserved.
    </p>

</footer>


</body>

</html>