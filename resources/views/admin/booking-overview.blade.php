<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Booking Overview - Otirasor Beach and Resort
    </title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        body {
            font-family:
                Arial,
                Helvetica,
                sans-serif;

            background: #f5f8fc;

            color: #263746;

            min-height: 100vh;
        }


        a {
            text-decoration: none;
        }


        /* =====================================================
           NAVBAR
        ===================================================== */

        nav {
            background: #023e8a;

            min-height: 76px;

            padding: 0 5%;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            color: white;

            box-shadow:
                0 3px 12px
                rgba(0, 0, 0, 0.12);

            position: sticky;

            top: 0;

            z-index: 100;
        }


        .brand {
            display: flex;

            align-items: center;

            gap: 12px;

            min-width: 0;
        }


        .brand-logo {
            width: 58px;

            height: 58px;

            flex-shrink: 0;

            display: flex;

            align-items: center;

            justify-content: center;
        }


        .brand-logo img {
            width: 100%;

            height: 100%;

            object-fit: contain;

            display: block;

            filter:
                drop-shadow(
                    0 2px 4px
                    rgba(0, 0, 0, 0.18)
                );
        }


        .brand-text {
            color: white;

            min-width: 0;
        }


        .brand-title {
            font-size: 18px;

            font-weight: 700;

            line-height: 1.2;
        }


        .brand-subtitle {
            font-size: 11px;

            opacity: 0.8;

            margin-top: 4px;
        }


        .nav-links {
            display: flex;

            align-items: center;

            gap: 5px;

            flex-wrap: wrap;

            justify-content: flex-end;
        }


        nav a {
            color: white;

            padding: 10px 12px;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 600;

            transition: 0.2s ease;
        }


        nav a:hover {
            background:
                rgba(255, 255, 255, 0.13);
        }


        .notification-link {
            position: relative;
        }


        .notification-badge {
            position: absolute;

            top: 1px;

            right: 0;

            min-width: 18px;

            height: 18px;

            padding: 0 5px;

            background: #e63946;

            color: white;

            border-radius: 999px;

            font-size: 10px;

            font-weight: 700;

            display: flex;

            align-items: center;

            justify-content: center;

            line-height: 1;
        }


        .logout-btn {
            background: none;

            border: none;

            color: white;

            padding: 10px 12px;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            font-family:
                Arial,
                Helvetica,
                sans-serif;

            transition: 0.2s ease;
        }


        .logout-btn:hover {
            background:
                rgba(255, 255, 255, 0.13);
        }


        /* =====================================================
           MAIN CONTAINER
        ===================================================== */

        .container {
            max-width: 1180px;

            margin: 34px auto;

            padding:
                0 22px 45px;
        }


        /* =====================================================
           PAGE HEADER
        ===================================================== */

        .page-header {
            background: white;

            padding:
                28px 30px;

            border-radius: 14px;

            margin-bottom: 25px;

            border:
                1px solid #e3eaf1;

            border-left:
                5px solid #0077b6;

            box-shadow:
                0 3px 12px
                rgba(0, 0, 0, 0.055);
        }


        .page-header h1 {
            color: #023e8a;

            font-size: 27px;

            line-height: 1.3;

            margin-bottom: 8px;
        }


        .page-header p {
            color: #687887;

            font-size: 14px;

            line-height: 1.6;
        }


        /* =====================================================
           SUMMARY GRID
        ===================================================== */

        .cards {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 17px;

            margin-bottom: 28px;
        }


        /* =====================================================
           CLICKABLE CARD
        ===================================================== */

        .card {
            background: white;

            border:
                1px solid #e1e9f0;

            border-radius: 14px;

            padding: 22px;

            min-height: 165px;

            box-shadow:
                0 3px 12px
                rgba(0, 0, 0, 0.045);

            transition:
                transform 0.2s ease,
                box-shadow 0.2s ease,
                border-color 0.2s ease;

            position: relative;

            overflow: hidden;

            display: block;

            color: inherit;
        }


        .card::before {
            content: "";

            position: absolute;

            left: 0;

            top: 0;

            width: 4px;

            height: 100%;

            background: #0077b6;
        }


        .card:hover {
            transform:
                translateY(-3px);

            border-color: #b7d5e9;

            box-shadow:
                0 8px 22px
                rgba(0, 0, 0, 0.085);
        }


        .card-icon {
            width: 44px;

            height: 44px;

            background: #edf7fd;

            border-radius: 10px;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 21px;

            margin-bottom: 14px;
        }


        .card h3 {
            color: #61717f;

            font-size: 13px;

            font-weight: 700;

            margin-bottom: 8px;
        }


        .number {
            color: #023e8a;

            font-size: 32px;

            font-weight: 700;

            line-height: 1.1;

            margin-bottom: 8px;
        }


        .card p {
            color: #8995a0;

            font-size: 12px;

            line-height: 1.5;
        }


        .card-action {
            position: absolute;

            right: 20px;

            bottom: 18px;

            color: #0077b6;

            font-size: 19px;

            font-weight: 700;
        }


        /* =====================================================
           STATUS COLORS
        ===================================================== */

        .card.pending::before {
            background: #e0a100;
        }


        .card.pending .card-icon {
            background: #fff5d9;
        }


        .card.pending .number {
            color: #a36a00;
        }


        .card.confirmed::before {
            background: #2a9d67;
        }


        .card.confirmed .card-icon {
            background: #e7f7ef;
        }


        .card.confirmed .number {
            color: #147a4b;
        }


        .card.rejected::before {
            background: #e63946;
        }


        .card.rejected .card-icon {
            background: #ffecef;
        }


        .card.rejected .number {
            color: #b52d43;
        }


        .card.cancelled::before {
            background: #777f87;
        }


        .card.cancelled .card-icon {
            background: #eef0f2;
        }


        .card.cancelled .number {
            color: #59636c;
        }


        /* =====================================================
           BACK BUTTON
        ===================================================== */

        .back-section {
            display: flex;

            justify-content: flex-start;
        }


        .back {
            display: inline-flex;

            align-items: center;

            gap: 8px;

            background: #023e8a;

            color: white;

            padding:
                11px 18px;

            border-radius: 9px;

            font-size: 13px;

            font-weight: 700;

            transition:
                background 0.2s ease,
                transform 0.2s ease;
        }


        .back:hover {
            background: #0077b6;

            transform:
                translateY(-1px);
        }


        /* =====================================================
           FOOTER
        ===================================================== */

        footer {
            background: #023e8a;

            color: white;

            text-align: center;

            padding: 18px;

            margin-top: 40px;
        }


        footer p {
            font-size: 12px;

            opacity: 0.9;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            nav {
                padding:
                    12px 20px;

                flex-wrap: wrap;
            }


            .nav-links {
                width: 100%;

                justify-content: center;
            }


            .cards {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }


        @media (max-width: 600px) {

            .container {
                margin-top: 22px;

                padding:
                    0 15px 35px;
            }


            .brand-title {
                font-size: 16px;
            }


            .brand-subtitle {
                font-size: 10px;
            }


            .brand-logo {
                width: 50px;

                height: 50px;
            }


            .page-header {
                padding: 22px;
            }


            .page-header h1 {
                font-size: 22px;
            }


            .cards {
                grid-template-columns: 1fr;
            }


            .card {
                min-height: 150px;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVBAR
===================================================== -->

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
                Administration Portal
            </div>

        </div>


    </div>


    <div class="nav-links">


        <a href="/admin/dashboard">
            🏠 Dashboard
        </a>


        <a href="/admin/bookings">
            📋 Bookings
        </a>


        <a
            href="/admin/notifications"
            class="notification-link"
        >

            🔔 Notifications

            @if(($unreadNotificationsCount ?? 0) > 0)

                <span class="notification-badge">
                    {{ $unreadNotificationsCount }}
                </span>

            @endif

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
                🚪 Logout
            </button>

        </form>


    </div>


</nav>


<!-- =====================================================
     MAIN
===================================================== -->

<div class="container">


    <!-- =================================================
         PAGE HEADER
    ================================================= -->

    <div class="page-header">

        <h1>
            📊 Booking Overview
        </h1>

        <p>
            Review the overall booking activity and current
            reservation status of Otirasor Beach and Resort.
        </p>

    </div>


    <!-- =================================================
         BOOKING SUMMARY
    ================================================= -->

    <div class="cards">


        <!-- =================================================
             TOTAL BOOKINGS
        ================================================= -->

        <a
            href="/admin/bookings"
            class="card"
        >

            <div class="card-icon">
                📋
            </div>

            <h3>
                Total Bookings
            </h3>

            <div class="number">
                {{ $totalBookings }}
            </div>

            <p>
                View all recorded bookings
            </p>

            <span class="card-action">
                →
            </span>

        </a>


        <!-- =================================================
             TOTAL GUESTS
        ================================================= -->

        <div class="card">

            <div class="card-icon">
                👥
            </div>

            <h3>
                Total Guests
            </h3>

            <div class="number">
                {{ $totalGuests }}
            </div>

            <p>
                Guests with active bookings
            </p>

        </div>


        <!-- =================================================
             PENDING
        ================================================= -->

        <a
            href="/admin/bookings?filter=pending"
            class="card pending"
        >

            <div class="card-icon">
                ⏳
            </div>

            <h3>
                Pending
            </h3>

            <div class="number">
                {{ $pendingBookings }}
            </div>

            <p>
                View bookings waiting for approval
            </p>

            <span class="card-action">
                →
            </span>

        </a>


        <!-- =================================================
             CONFIRMED
        ================================================= -->

        <a
            href="/admin/bookings?filter=confirmed"
            class="card confirmed"
        >

            <div class="card-icon">
                ✅
            </div>

            <h3>
                Confirmed
            </h3>

            <div class="number">
                {{ $confirmedBookings }}
            </div>

            <p>
                View approved bookings
            </p>

            <span class="card-action">
                →
            </span>

        </a>


        <!-- =================================================
             REJECTED
        ================================================= -->

        <a
            href="/admin/bookings?filter=rejected"
            class="card rejected"
        >

            <div class="card-icon">
                ❌
            </div>

            <h3>
                Rejected
            </h3>

            <div class="number">
                {{ $rejectedBookings }}
            </div>

            <p>
                View all rejected bookings
            </p>

            <span class="card-action">
                →
            </span>

        </a>


        <!-- =================================================
             CANCELLED
        ================================================= -->

        <a
            href="/admin/bookings?filter=cancelled"
            class="card cancelled"
        >

            <div class="card-icon">
                🚫
            </div>

            <h3>
                Cancelled
            </h3>

            <div class="number">
                {{ $cancelledBookings }}
            </div>

            <p>
                View all cancelled bookings
            </p>

            <span class="card-action">
                →
            </span>

        </a>


    </div>


    <!-- =================================================
         BACK
    ================================================= -->

    <div class="back-section">

        <a
            href="/admin/booking-information"
            class="back"
        >
            ← Back to Booking Information
        </a>

    </div>


</div>


<!-- =====================================================
     FOOTER
===================================================== -->

<footer>

    <p>
        &copy; 2026 Otirasor Beach and Resort.
        All Rights Reserved.
    </p>

</footer>


</body>

</html>