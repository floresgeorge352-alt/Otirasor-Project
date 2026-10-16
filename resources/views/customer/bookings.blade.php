<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Bookings - Otirasor Beach</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
        }

        nav {
            background: #0077b6;
            padding: 18px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            width: 1000px;
            max-width: 90%;
            margin: 40px auto;
        }

        h1 {
            color: #023e8a;
            text-align: center;
            margin-bottom: 30px;
        }

        .message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .booking-card {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .booking-card h3 {
            color: #0077b6;
            margin-top: 0;
        }

        .booking-card p {
            margin: 8px 0;
        }

        .guest-summary {
            background: #f1f9ff;
            border: 1px solid #0077b6;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }

        .guest-summary p {
            margin: 6px 0;
        }

        .total-guests {
            color: #0077b6;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 5px;
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

        .request-btn {
            margin-top: 20px;
            padding: 10px 18px;
            background: #f0ad4e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .request-btn:hover {
            background: #ec971f;
        }

        .receipt-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 18px;
            background: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .receipt-btn:hover {
            background: #005f8f;
        }

        .cancel-form {
            margin-top: 15px;
            padding: 15px;
            background: #fff8e8;
            border: 1px solid #f0ad4e;
            border-radius: 8px;
        }

        .cancel-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .cancel-form textarea {
            width: 100%;
            min-height: 90px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .submit-request {
            margin-top: 10px;
            padding: 10px 18px;
            background: #f0ad4e;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .submit-request:hover {
            background: #ec971f;
        }

        .cancellation-pending {
            margin-top: 15px;
            padding: 12px;
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
            border-radius: 6px;
            font-weight: bold;
        }

        .cancellation-rejected {
            margin-top: 15px;
            padding: 12px;
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            font-weight: bold;
        }

        .empty {
            background: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-btn:hover {
            background: #005f8f;
        }

    </style>
</head>

<body>

<nav>

    <strong style="color:white;">
        Otirasor Beach
    </strong>

    <div>

        <a href="/dashboard">
            Dashboard
        </a>

        <a href="/accommodations">
            Book Now
        </a>

        <a href="/my-bookings">
            My Bookings
        </a>

        <form
            method="POST"
            action="/logout"
            style="display:inline;"
        >

            @csrf

            <button
                type="submit"
                style="
                    background:none;
                    border:none;
                    color:white;
                    cursor:pointer;
                    margin-left:20px;
                    font-size:16px;
                "
            >
                Logout
            </button>

        </form>

    </div>

</nav>


<div class="container">

    <h1>
        My Bookings
    </h1>


    @if(session('success'))

        <div class="message success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="message error">
            {{ session('error') }}
        </div>

    @endif


    @if($bookings->count() > 0)

        @foreach($bookings as $booking)

            <div class="booking-card">

                <h3>
                    Booking #{{ $booking->id }}
                </h3>


                <p>
                    <strong>Guest Name:</strong>
                    {{ $booking->guest_name }}
                </p>


                <p>
                    <strong>Contact Number:</strong>
                    {{ $booking->contact_number }}
                </p>


                <div class="guest-summary">

                    <p>
                        <strong>Adults:</strong>
                        {{ $booking->number_of_adults }}
                    </p>

                    <p>
                        <strong>Kids:</strong>
                        {{ $booking->number_of_kids }}
                    </p>

                    <p class="total-guests">
                        Total Guests:
                        {{ $booking->number_of_guests }}
                    </p>

                </div>


                <p>
                    <strong>Accommodation:</strong>
                    {{ $booking->accommodations }}
                </p>


                <p>
                    <strong>Check-in:</strong>
                    {{ $booking->check_in }}
                </p>


                <p>
                    <strong>Check-out:</strong>
                    {{ $booking->check_out }}
                </p>


                <p>
                    <strong>Payment Method:</strong>
                    {{ $booking->payment_method }}
                </p>


                @if($booking->payment_method === 'GCash')

                    <p>
                        <strong>GCash Reference:</strong>
                        {{ $booking->gcash_reference }}
                    </p>

                @endif


                <p>
                    <strong>Status:</strong>

                    @if($booking->status === 'Pending')

                        <span class="status pending">
                            Pending
                        </span>

                    @elseif($booking->status === 'Confirmed')

                        <span class="status confirmed">
                            Confirmed
                        </span>

                    @elseif($booking->status === 'Rejected')

                        <span class="status rejected">
                            Rejected
                        </span>

                    @elseif($booking->status === 'Cancelled')

                        <span class="status cancelled">
                            Cancelled
                        </span>

                    @else

                        <span class="status">
                            {{ $booking->status }}
                        </span>

                    @endif

                </p>


                {{-- =====================================================
                     PENDING BOOKING
                ====================================================== --}}

                @if($booking->status === 'Pending')

                    <div class="cancellation-pending">

                        Your booking is still waiting for admin approval.

                    </div>

                @endif


                {{-- =====================================================
                     CONFIRMED BOOKING
                ====================================================== --}}

                @if($booking->status === 'Confirmed')

                    {{-- ELECTRONIC RECEIPT --}}

                    <a
                        href="/my-bookings/{{ $booking->id }}/receipt"
                        class="receipt-btn"
                    >
                        View E-Receipt
                    </a>


                    @if($booking->cancellation_status === 'Pending')

                        <div class="cancellation-pending">

                            Cancellation Request Pending

                            <br>

                            Waiting for admin approval.

                        </div>

                    @elseif($booking->cancellation_status === 'Rejected')

                        <div class="cancellation-rejected">

                            Cancellation request was rejected.

                            <br>

                            Your booking remains confirmed.

                        </div>


                        <details style="margin-top: 15px;">

                            <summary
                                class="request-btn"
                                style="
                                    display:inline-block;
                                    list-style:none;
                                "
                            >
                                Request Cancellation Again
                            </summary>


                            <form
                                method="POST"
                                action="/my-bookings/{{ $booking->id }}/request-cancellation"
                                class="cancel-form"
                            >

                                @csrf


                                <label>
                                    Reason for Cancellation
                                </label>


                                <textarea
                                    name="cancellation_reason"
                                    placeholder="Please enter your reason..."
                                    required
                                ></textarea>


                                <button
                                    type="submit"
                                    class="submit-request"
                                >
                                    Submit Cancellation Request
                                </button>

                            </form>

                        </details>

                    @else

                        <details style="margin-top: 15px;">

                            <summary
                                class="request-btn"
                                style="
                                    display:inline-block;
                                    list-style:none;
                                "
                            >
                                Request Cancellation
                            </summary>


                            <form
                                method="POST"
                                action="/my-bookings/{{ $booking->id }}/request-cancellation"
                                class="cancel-form"
                            >

                                @csrf


                                <label>
                                    Reason for Cancellation
                                </label>


                                <textarea
                                    name="cancellation_reason"
                                    placeholder="Please enter your reason..."
                                    required
                                ></textarea>


                                <button
                                    type="submit"
                                    class="submit-request"
                                >
                                    Submit Cancellation Request
                                </button>

                            </form>

                        </details>

                    @endif

                @endif


                {{-- =====================================================
                     CANCELLED BOOKING
                ====================================================== --}}

                @if($booking->status === 'Cancelled')

                    <div
                        class="cancellation-rejected"
                        style="
                            background:#e2e3e5;
                            color:#383d41;
                            border-color:#d6d8db;
                        "
                    >

                        This booking has been cancelled.

                    </div>

                @endif

            </div>

        @endforeach

    @else

        <div class="empty">

            <h3>
                No bookings found.
            </h3>

            <p>
                You do not have any bookings yet.
            </p>

            <a
                href="/accommodations"
                class="back-btn"
            >
                Make a Booking
            </a>

        </div>

    @endif

</div>

</body>
</html>