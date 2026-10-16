<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Recent Bookings - Otirasor Beach
    </title>

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
            font-size: 24px;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;

            margin-left: 25px;

            font-size: 16px;

            cursor: pointer;

            font-family: Arial, sans-serif;
        }

        .logout-btn:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .back-btn {
            display: inline-block;

            background: #6c757d;
            color: white;

            text-decoration: none;

            padding: 10px 18px;

            border-radius: 6px;

            margin-bottom: 25px;
        }

        .back-btn:hover {
            background: #545b62;
        }

        h1 {
            color: #023e8a;
            margin-bottom: 25px;
        }

        .booking {
            background: white;

            padding: 25px;

            margin-bottom: 15px;

            border-radius: 10px;

            box-shadow:
                0 3px 10px rgba(0,0,0,0.08);
        }

        .booking-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;
        }

        .booking-id {
            color: #0077b6;

            font-size: 15px;

            font-weight: bold;

            margin-bottom: 5px;
        }

        .guest-name {
            font-size: 19px;

            font-weight: bold;

            color: #333;
        }

        .view-btn {
            background: #0077b6;

            color: white;

            border: none;

            padding: 10px 18px;

            border-radius: 6px;

            cursor: pointer;

            font-size: 14px;

            font-weight: bold;
        }

        .view-btn:hover {
            background: #005f8f;
        }

        .details {
            display: none;

            border-top: 1px solid #ddd;

            margin-top: 20px;

            padding-top: 20px;
        }

        .details p {
            margin-bottom: 10px;

            line-height: 1.5;
        }

        .status {
            display: inline-block;

            padding: 5px 10px;

            border-radius: 15px;

            font-size: 13px;

            font-weight: bold;
        }

        .pending {
            background: #fff3cd;

            color: #856404;
        }

        .confirmed {
            background: #d4edda;

            color: #155724;
        }

        .rejected {
            background: #f8d7da;

            color: #721c24;
        }

        .cancelled {
            background: #e2e3e5;

            color: #383d41;
        }

        .close-btn {
            background: #6c757d;

            color: white;

            border: none;

            padding: 10px 18px;

            border-radius: 6px;

            cursor: pointer;

            margin-top: 10px;
        }

        .close-btn:hover {
            background: #545b62;
        }

        .empty {
            background: white;

            padding: 30px;

            border-radius: 10px;

            text-align: center;

            color: #777;
        }

        @media (max-width: 700px) {

            nav {
                padding: 15px 20px;

                flex-direction: column;

                gap: 15px;
            }

            nav a {
                margin-left: 10px;
            }

            .container {
                margin: 20px auto;

                padding: 15px;
            }

            .booking-header {
                flex-direction: column;

                align-items: flex-start;
            }

            .view-btn {
                width: 100%;
            }

        }

    </style>

</head>


<body>


<nav>

    <div class="logo">
        Otirasor Beach Admin
    </div>


    <div class="nav-links">

        <a href="/admin/dashboard">
            Dashboard
        </a>

        <a href="/admin/bookings">
            Bookings
        </a>


        <form
            method="POST"
            action="/logout"
            style="display:inline;"
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
        href="/admin/dashboard"
        class="back-btn"
    >
        ← Back to Dashboard
    </a>


    <h1>
        Recent Bookings
    </h1>


    @if($recentBookings->count() > 0)


        @foreach($recentBookings as $booking)


            <div class="booking">


                <div class="booking-header">


                    <div>

                        <div class="booking-id">
                            Booking #{{ $booking->id }}
                        </div>

                        <div class="guest-name">
                            {{ $booking->guest_name }}
                        </div>

                    </div>


                    <button
                        type="button"
                        class="view-btn"
                        onclick="toggleDetails({{ $booking->id }})"
                        id="button-{{ $booking->id }}"
                    >
                        View Details
                    </button>


                </div>


                <div
                    class="details"
                    id="details-{{ $booking->id }}"
                >


                    <p>

                        <strong>
                            Guest Name:
                        </strong>

                        {{ $booking->guest_name }}

                    </p>


                    <p>

                        <strong>
                            Contact Number:
                        </strong>

                        {{ $booking->contact_number }}

                    </p>


                    <p>

                        <strong>
                            Number of Guests:
                        </strong>

                        {{ $booking->number_of_guests }}

                    </p>


                    <p>

                        <strong>
                            Accommodation:
                        </strong>

                        {{ $booking->accommodations }}

                    </p>


                    <p>

                        <strong>
                            Check-in:
                        </strong>

                        {{ $booking->check_in }}

                    </p>


                    <p>

                        <strong>
                            Check-out:
                        </strong>

                        {{ $booking->check_out }}

                    </p>


                    <p>

                        <strong>
                            Payment Method:
                        </strong>

                        {{ $booking->payment_method }}

                    </p>


                    @if($booking->payment_method == 'GCash')

                        <p>

                            <strong>
                                GCash Reference:
                            </strong>

                            {{ $booking->gcash_reference }}

                        </p>

                    @endif


                    <p>

                        <strong>
                            Status:
                        </strong>


                        @if($booking->status == 'Pending')

                            <span class="status pending">
                                Pending
                            </span>

                        @elseif($booking->status == 'Confirmed')

                            <span class="status confirmed">
                                Confirmed
                            </span>

                        @elseif($booking->status == 'Rejected')

                            <span class="status rejected">
                                Rejected
                            </span>

                        @elseif($booking->status == 'Cancelled')

                            <span class="status cancelled">
                                Cancelled
                            </span>

                        @else

                            <span class="status">
                                {{ $booking->status }}
                            </span>

                        @endif

                    </p>


                    <button
                        type="button"
                        class="close-btn"
                        onclick="toggleDetails({{ $booking->id }})"
                    >
                        Close Details
                    </button>


                </div>

            </div>


        @endforeach


    @else


        <div class="empty">

            <h2>
                No recent bookings found.
            </h2>

        </div>


    @endif


</div>


<script>

    function toggleDetails(id) {

        const details =
            document.getElementById(
                'details-' + id
            );


        const button =
            document.getElementById(
                'button-' + id
            );


        if (
            details.style.display === 'block'
        ) {

            details.style.display = 'none';

            button.textContent =
                'View Details';

        } else {

            details.style.display = 'block';

            button.textContent =
                'Hide Details';

        }

    }

</script>


</body>
</html>