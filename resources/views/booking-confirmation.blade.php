<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Booking Submitted - Otirasor Beach and Resort
    </title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #0077b6;
            --primary-dark: #023e8a;
            --secondary: #00b4d8;
            --light-blue: #eaf8fc;
            --white: #ffffff;
            --text: #243746;
            --muted: #6c7a86;
            --border: #dce8ed;
            --success: #168a52;
            --success-light: #e9f8f0;
            --warning: #9a6a00;
            --warning-light: #fff8e6;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;

            background: linear-gradient(
                180deg,
                #eaf9fd 0%,
                #f4fbfd 40%,
                #f7fbfc 100%
            );

            color: var(--text);
            min-height: 100vh;
        }

        /* =========================
           NAVIGATION
        ========================= */

        nav {
            width: 100%;
            min-height: 78px;

            background: linear-gradient(
                135deg,
                #0077b6,
                #0096c7,
                #00b4d8
            );

            padding: 10px 6%;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow:
                0 5px 20px rgba(0, 119, 182, 0.20);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* =========================
           OTIRASOR LOGO
        ========================= */

        .brand-logo {
            width: 62px;
            height: 62px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            overflow: hidden;
            border-radius: 50%;
        }

        .brand-logo img {
            width: 62px;
            height: 62px;

            display: block;

            object-fit: contain;

            border: 0;
            outline: 0;

            filter: drop-shadow(
                0 3px 5px rgba(0, 0, 0, 0.25)
            );
        }

        .brand-text {
            color: #ffffff;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 700;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 11px;
            opacity: 0.9;
            margin-top: 4px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .nav-links a {
            color: #ffffff;
            text-decoration: none;

            padding: 10px 14px;

            border-radius: 9px;

            font-size: 14px;
            font-weight: 600;

            transition: 0.2s ease;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.18);
        }

        /* =========================
           MAIN
        ========================= */

        .container {
            width: 92%;
            max-width: 850px;

            margin: 45px auto 55px;
        }

        .confirmation-box {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 22px;

            padding: 35px;

            box-shadow:
                0 10px 35px rgba(25, 72, 88, 0.08);
        }

        /* =========================
           SUCCESS
        ========================= */

        .success-area {
            text-align: center;

            padding: 10px 10px 30px;
        }

        .success-icon {
            width: 78px;
            height: 78px;

            margin: 0 auto 18px;

            border-radius: 50%;

            background: var(--success-light);

            border: 2px solid #b9e6cc;

            color: var(--success);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 43px;
            font-weight: bold;
        }

        .success-badge {
            display: inline-block;

            background: var(--success-light);
            color: var(--success);

            padding: 7px 14px;

            border-radius: 30px;

            font-size: 12px;
            font-weight: 700;

            margin-bottom: 12px;
        }

        h1 {
            color: var(--primary-dark);

            font-size: 30px;

            margin-bottom: 10px;
        }

        .message {
            color: var(--muted);

            font-size: 14px;

            line-height: 1.7;

            max-width: 600px;

            margin: auto;
        }

        /* =========================
           BOOKING ID
        ========================= */

        .booking-id {
            margin: 0 0 25px;

            padding: 17px;

            background: var(--light-blue);

            border: 1px solid #c8e9f1;

            border-radius: 13px;

            text-align: center;
        }

        .booking-id-label {
            display: block;

            color: var(--muted);

            font-size: 11px;

            text-transform: uppercase;

            letter-spacing: 0.8px;

            font-weight: 700;

            margin-bottom: 5px;
        }

        .booking-id-number {
            color: var(--primary-dark);

            font-size: 22px;

            font-weight: 800;
        }

        /* =========================
           DETAILS CARD
        ========================= */

        .details-card {
            border: 1px solid var(--border);

            border-radius: 16px;

            overflow: hidden;

            background: #ffffff;
        }

        .details-header {
            padding: 19px 21px;

            background: linear-gradient(
                135deg,
                #f0fbfd,
                #ffffff
            );

            border-bottom: 1px solid var(--border);

            display: flex;

            align-items: center;

            gap: 12px;
        }

        .details-icon {
            width: 42px;
            height: 42px;

            border-radius: 11px;

            background: var(--light-blue);

            color: var(--primary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
        }

        .details-header h2 {
            color: var(--primary-dark);

            font-size: 19px;
        }

        .details-header p {
            color: var(--muted);

            font-size: 12px;

            margin-top: 3px;
        }

        .details-body {
            padding: 20px;
        }

        .detail {
            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 20px;

            padding: 13px 0;

            border-bottom: 1px solid #edf2f4;

            line-height: 1.5;
        }

        .detail:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: var(--muted);

            font-size: 13px;

            font-weight: 600;

            min-width: 150px;
        }

        .detail-value {
            color: var(--text);

            font-size: 14px;

            font-weight: 700;

            text-align: right;
        }

        /* =========================
           TOTALS
        ========================= */

        .total-detail {
            margin-top: 10px;

            padding: 17px;

            background: var(--light-blue);

            border: 1px solid #c8e9f1;

            border-radius: 13px;
        }

        .total-detail .detail-label {
            color: var(--primary-dark);

            font-size: 15px;

            font-weight: 800;
        }

        .total-detail .detail-value {
            color: var(--primary-dark);

            font-size: 20px;

            font-weight: 900;
        }

        /* =========================
           FACILITY BREAKDOWN
        ========================= */

        .facility-detail {
            background: #f8fcfd;

            border: 1px solid #dce8ed;

            border-radius: 13px;

            padding: 15px;

            margin-top: 10px;
        }

        .facility-detail .detail {
            border-bottom: 1px solid #edf2f4;
        }

        .facility-detail .detail:last-child {
            border-bottom: none;
        }

        .facility-title {
            color: var(--primary-dark);

            font-size: 15px;

            font-weight: 800;

            margin-bottom: 8px;
        }

        .facility-subtitle {
            color: var(--muted);

            font-size: 12px;

            margin-bottom: 5px;
        }

        .facility-breakdown {
            margin-top: 8px;
        }

        .facility-breakdown .detail {
            padding: 9px 0;
        }

        .facility-total-row {
            margin-top: 8px;

            padding-top: 12px;

            border-top: 2px solid #dce8ed;
        }

        .facility-total-row .detail-label,
        .facility-total-row .detail-value {
            color: var(--primary-dark);

            font-weight: 900;
        }

        .pool-selected {
            color: var(--success);

            font-weight: 800;
        }

        .pool-not-selected {
            color: var(--muted);

            font-weight: 700;
        }

        /* =========================
           GRAND TOTAL
        ========================= */

        .grand-total {
            margin-top: 15px;

            padding: 20px;

            background: linear-gradient(
                135deg,
                #0077b6,
                #00a4cc
            );

            border-radius: 14px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            color: #ffffff;
        }

        .grand-total-label {
            font-size: 17px;
            font-weight: 800;
        }

        .grand-total-value {
            font-size: 25px;
            font-weight: 900;
        }

        /* =========================
           GUEST INFORMATION
        ========================= */

        .guest-summary {
            margin: 15px 0;

            padding: 17px;

            background: #f8fcfd;

            border: 1px solid var(--border);

            border-radius: 13px;
        }

        .guest-title {
            color: var(--primary-dark);

            font-size: 14px;

            font-weight: 700;

            margin-bottom: 10px;
        }

        .guest-row {
            display: flex;

            justify-content: space-between;

            padding: 6px 0;

            color: var(--muted);

            font-size: 13px;
        }

        .guest-row strong {
            color: var(--text);
        }

        .guest-total {
            border-top: 1px solid #dce8ed;

            margin-top: 7px;

            padding-top: 10px;

            color: var(--primary);

            font-weight: 800;

            font-size: 14px;
        }

        /* =========================
           STATUS
        ========================= */

        .status {
            display: inline-block;

            padding: 7px 14px;

            background: var(--warning-light);

            color: var(--warning);

            border: 1px solid #f0d58a;

            border-radius: 30px;

            font-size: 12px;

            font-weight: 800;
        }

        /* =========================
           NOTICE
        ========================= */

        .notice {
            margin-top: 20px;

            padding: 17px 18px;

            background: var(--warning-light);

            border: 1px solid #f0d58a;

            border-left: 5px solid #e0a900;

            border-radius: 12px;

            color: #725600;

            font-size: 13px;

            line-height: 1.7;
        }

        .notice strong {
            color: #5f4800;
        }

        /* =========================
           BUTTONS
        ========================= */

        .buttons {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 12px;

            margin-top: 25px;
        }

        .btn {
            display: flex;

            justify-content: center;
            align-items: center;

            min-height: 50px;

            padding: 12px 18px;

            background: linear-gradient(
                135deg,
                #0077b6,
                #00a4cc
            );

            color: #ffffff;

            text-decoration: none;

            border-radius: 11px;

            font-size: 14px;

            font-weight: 700;

            transition: 0.2s ease;

            box-shadow:
                0 7px 17px rgba(0,119,182,0.16);
        }

        .btn:hover {
            transform: translateY(-1px);

            box-shadow:
                0 10px 22px rgba(0,119,182,0.22);
        }

        .secondary-btn {
            background: #f1f5f7;

            color: #52636d;

            box-shadow: none;

            border: 1px solid var(--border);
        }

        .secondary-btn:hover {
            background: #e5ecef;

            color: #263b45;

            box-shadow: none;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            text-align: center;

            color: #84939b;

            font-size: 12px;

            padding: 5px 20px 35px;
        }

        /* =========================
           MOBILE
        ========================= */

        @media (max-width: 700px) {

            nav {
                min-height: auto;

                padding: 12px 5%;

                flex-direction: column;

                gap: 10px;
            }

            .brand {
                width: 100%;

                justify-content: flex-start;
            }

            .brand-logo {
                width: 54px;
                height: 54px;
            }

            .brand-logo img {
                width: 54px;
                height: 54px;
            }

            .brand-title {
                font-size: 16px;
            }

            .brand-subtitle {
                font-size: 10px;
            }

            .nav-links {
                width: 100%;

                justify-content: flex-start;

                flex-wrap: wrap;
            }

            .nav-links a {
                padding: 8px 11px;

                font-size: 12px;
            }

            .container {
                width: 94%;

                margin-top: 28px;
            }

            .confirmation-box {
                padding: 22px 18px;

                border-radius: 17px;
            }

            h1 {
                font-size: 25px;
            }

            .success-icon {
                width: 68px;
                height: 68px;

                font-size: 36px;
            }

            .detail {
                flex-direction: column;

                gap: 4px;
            }

            .detail-value {
                text-align: left;
            }

            .total-detail .detail-value {
                font-size: 18px;
            }

            .grand-total {
                flex-direction: column;

                align-items: flex-start;

                gap: 6px;
            }

            .grand-total-value {
                font-size: 22px;
            }

            .buttons {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 420px) {

            .brand-logo {
                width: 50px;
                height: 50px;
            }

            .brand-logo img {
                width: 50px;
                height: 50px;
            }

            .brand-title {
                font-size: 15px;
            }

            .brand-subtitle {
                font-size: 9px;
            }

            .details-body {
                padding: 16px;
            }

            .booking-id-number {
                font-size: 20px;
            }
        }

    </style>

</head>

<body>

<!-- =========================
     NAVIGATION
========================= -->

<nav>

    <div class="brand">

        <div class="brand-logo">

            <img
                src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
                alt="Otirasor Beach and Resort Logo"
            >

        </div>

        <div class="brand-text">

            <div class="brand-title">
                Otirasor Beach and Resort
            </div>

            <div class="brand-subtitle">
                Relax • Enjoy • Create Memories
            </div>

        </div>

    </div>


    <div class="nav-links">

        <a href="/">
            Home
        </a>

        <a href="/accommodations">
            Book Now
        </a>

        <a href="/my-bookings">
            My Bookings
        </a>

    </div>

</nav>


<!-- =========================
     MAIN
========================= -->

<div class="container">

    <div class="confirmation-box">

        <!-- SUCCESS -->

        <div class="success-area">

            <div class="success-icon">
                ✓
            </div>

            <div class="success-badge">
                ✓ BOOKING SUBMITTED
            </div>

            <h1>
                Booking Submitted Successfully!
            </h1>

            <p class="message">
                Your reservation has been submitted and is now waiting
                for manager approval.
            </p>

        </div>


        <!-- BOOKING ID -->

        <div class="booking-id">

            <span class="booking-id-label">
                Booking ID
            </span>

            <div class="booking-id-number">
                #{{ $booking->id }}
            </div>

        </div>


        <!-- BOOKING DETAILS -->

        <div class="details-card">

            <div class="details-header">

                <div class="details-icon">
                    📋
                </div>

                <div>

                    <h2>
                        Booking Details
                    </h2>

                    <p>
                        Summary of your submitted reservation
                    </p>

                </div>

            </div>


            <div class="details-body">

                <!-- GUEST NAME -->

                <div class="detail">

                    <div class="detail-label">
                        Guest Name
                    </div>

                    <div class="detail-value">
                        {{ $booking->guest_name }}
                    </div>

                </div>


                <!-- CONTACT -->

                <div class="detail">

                    <div class="detail-label">
                        Contact Number
                    </div>

                    <div class="detail-value">
                        {{ $booking->contact_number }}
                    </div>

                </div>


                <!-- GUEST SUMMARY -->

                <div class="guest-summary">

                    <div class="guest-title">
                        👥 Guest Information
                    </div>

                    <div class="guest-row">

                        <span>
                            Adults
                        </span>

                        <strong>
                            {{ $booking->number_of_adults }}
                        </strong>

                    </div>

                    <div class="guest-row">

                        <span>
                            Kids
                        </span>

                        <strong>
                            {{ $booking->number_of_kids }}
                        </strong>

                    </div>

                    <div class="guest-row guest-total">

                        <span>
                            Total Guests
                        </span>

                        <strong>
                            {{ $booking->number_of_guests }}
                        </strong>

                    </div>

                </div>


                <!-- ACCOMMODATION -->

                <div class="detail">

                    <div class="detail-label">
                        Accommodation
                    </div>

                    <div class="detail-value">
                        {{ $booking->accommodations }}
                    </div>

                </div>


                <!-- ACCOMMODATION TOTAL -->

                <div class="detail total-detail">

                    <div class="detail-label">
                        Accommodation Total
                    </div>

                    <div class="detail-value">
                        ₱{{ number_format($booking->accommodation_total, 2) }}
                    </div>

                </div>


                <!-- BEACH / SWIMMING POOL -->

                <div class="facility-detail">

                    <div class="facility-title">
                        🏖️ Beach & Swimming Pool
                    </div>

                    <div class="facility-subtitle">
                        Entrance is automatically charged for all guests.
                        Swimming pool use is optional.
                    </div>


                    <!-- BEACH ENTRANCE -->

                    <div class="facility-breakdown">

                        <div class="detail">

                            <div class="detail-label">
                                🏖️ Beach Entrance - Adults
                            </div>

                            <div class="detail-value">
                                {{ $booking->number_of_adults }}
                                × ₱20 =
                                ₱{{ number_format($booking->number_of_adults * 20, 2) }}
                            </div>

                        </div>


                        <div class="detail">

                            <div class="detail-label">
                                🏖️ Beach Entrance - Kids
                            </div>

                            <div class="detail-value">
                                {{ $booking->number_of_kids }}
                                × ₱10 =
                                ₱{{ number_format($booking->number_of_kids * 10, 2) }}
                            </div>

                        </div>


                        <div class="detail">

                            <div class="detail-label">
                                Beach Entrance Total
                            </div>

                            <div class="detail-value">
                                ₱{{
                                    number_format(
                                        ($booking->number_of_adults * 20) +
                                        ($booking->number_of_kids * 10),
                                        2
                                    )
                                }}
                            </div>

                        </div>

                    </div>


                    <!-- SWIMMING POOL -->

                    @if(($booking->pool_adults ?? 0) > 0 || ($booking->pool_kids ?? 0) > 0)

                        <div class="facility-breakdown">

                            <div class="detail">

                                <div class="detail-label">
                                    🏊 Swimming Pool
                                </div>

                                <div class="detail-value pool-selected">
                                    Selected
                                </div>

                            </div>


                            <div class="detail">

                                <div class="detail-label">
                                    Pool - Adults
                                </div>

                                <div class="detail-value">
                                    {{ $booking->pool_adults ?? 0 }}
                                    × ₱70 =
                                    ₱{{
                                        number_format(
                                            ($booking->pool_adults ?? 0) * 70,
                                            2
                                        )
                                    }}
                                </div>

                            </div>


                            <div class="detail">

                                <div class="detail-label">
                                    Pool - Kids
                                </div>

                                <div class="detail-value">
                                    {{ $booking->pool_kids ?? 0 }}
                                    × ₱50 =
                                    ₱{{
                                        number_format(
                                            ($booking->pool_kids ?? 0) * 50,
                                            2
                                        )
                                    }}
                                </div>

                            </div>


                            <div class="detail">

                                <div class="detail-label">
                                    Swimming Pool Total
                                </div>

                                <div class="detail-value">
                                    ₱{{
                                        number_format(
                                            (($booking->pool_adults ?? 0) * 70) +
                                            (($booking->pool_kids ?? 0) * 50),
                                            2
                                        )
                                    }}
                                </div>

                            </div>

                        </div>

                    @else

                        <div class="detail">

                            <div class="detail-label">
                                🏊 Swimming Pool
                            </div>

                            <div class="detail-value pool-not-selected">
                                Not Selected
                            </div>

                        </div>

                    @endif


                    <!-- FACILITY TOTAL -->

                    <div class="detail facility-total-row">

                        <div class="detail-label">
                            Facility Total
                        </div>

                        <div class="detail-value">
                            ₱{{ number_format($booking->facility_total ?? 0, 2) }}
                        </div>

                    </div>

                </div>


                <!-- GRAND TOTAL -->

                <div class="grand-total">

                    <div class="grand-total-label">
                        Grand Total
                    </div>

                    <div class="grand-total-value">

                        ₱{{
                            number_format(
                                ($booking->accommodation_total ?? 0) +
                                ($booking->facility_total ?? 0),
                                2
                            )
                        }}

                    </div>

                </div>


                <!-- CHECK-IN -->

                <div class="detail">

                    <div class="detail-label">
                        Check-in
                    </div>

                    <div class="detail-value">
                        {{ $booking->check_in }}
                    </div>

                </div>


                <!-- CHECK-OUT -->

                <div class="detail">

                    <div class="detail-label">
                        Check-out
                    </div>

                    <div class="detail-value">
                        {{ $booking->check_out }}
                    </div>

                </div>


                <!-- PAYMENT -->

                <div class="detail">

                    <div class="detail-label">
                        Payment Method
                    </div>

                    <div class="detail-value">
                        {{ $booking->payment_method }}
                    </div>

                </div>


                <!-- GCASH REFERENCE -->

                @if($booking->payment_method === 'GCash')

                    <div class="detail">

                        <div class="detail-label">
                            GCash Reference
                        </div>

                        <div class="detail-value">
                            {{ $booking->gcash_reference }}
                        </div>

                    </div>

                @endif


                <!-- STATUS -->

                <div class="detail">

                    <div class="detail-label">
                        Booking Status
                    </div>

                    <div class="detail-value">

                        <span class="status">
                            {{ $booking->status }}
                        </span>

                    </div>

                </div>

            </div>

        </div>


        <!-- NOTICE -->

        <div class="notice">

            <strong>
                ⏳ Waiting for Manager Approval
            </strong>

            <br>

            Your booking is not yet confirmed.
            Please wait for the manager to review and approve your reservation.

        </div>


        <!-- BUTTONS -->

        <div class="buttons">

            <a
                href="/my-bookings"
                class="btn"
            >
                📋 View My Bookings
            </a>

            <a
                href="/accommodations"
                class="btn secondary-btn"
            >
                + Make Another Booking
            </a>

        </div>

    </div>

</div>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <p>
        © {{ date('Y') }} Otirasor Beach and Resort
        • Reservation System
    </p>

</footer>

</body>
</html>