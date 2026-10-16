<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Otirasor Beach and Resort</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f8fc;
            color: #263746;
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        nav {
            background: #023e8a;
            min-height: 76px;
            padding: 0 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            color: white;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12);
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
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.18));
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
            background: rgba(255, 255, 255, 0.13);
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
            font-family: Arial, Helvetica, sans-serif;
            transition: 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.13);
        }

        .container {
            max-width: 1180px;
            margin: 34px auto;
            padding: 0 22px 45px;
        }

        .welcome {
            background: white;
            padding: 28px 30px;
            border-radius: 14px;
            margin-bottom: 30px;
            border: 1px solid #e3eaf1;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.055);
            border-left: 5px solid #0077b6;
        }

        .welcome h1 {
            color: #023e8a;
            font-size: 27px;
            line-height: 1.3;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #687887;
            font-size: 14px;
            line-height: 1.6;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-heading {
            margin-bottom: 17px;
        }

        .section-title {
            color: #023e8a;
            font-size: 21px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .section-description {
            color: #7a8793;
            font-size: 13px;
            line-height: 1.5;
        }

        .main-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .main-card {
            background: white;
            border: 1px solid #e1e9f0;
            border-radius: 14px;
            padding: 21px;
            min-height: 115px;
            display: flex;
            align-items: center;
            gap: 16px;
            color: #263746;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045);
            transition: transform 0.2s ease,
                        box-shadow 0.2s ease,
                        border-color 0.2s ease;
        }

        .main-card:hover {
            transform: translateY(-3px);
            border-color: #b7d5e9;
            box-shadow: 0 8px 22px rgba(0, 0, 0, 0.085);
        }

        .card-icon {
            width: 52px;
            height: 52px;
            flex-shrink: 0;
            background: #edf7fd;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
        }

        .card-content {
            flex: 1;
            min-width: 0;
        }

        .card-content h3 {
            color: #023e8a;
            font-size: 17px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card-content p {
            color: #71808e;
            font-size: 13px;
            line-height: 1.5;
        }

        .card-arrow {
            color: #0077b6;
            font-size: 21px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .recent-card {
            background: white;
            border: 1px solid #e1e9f0;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045);
        }

        .recent-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 10px;
        }

        .recent-header h3 {
            color: #023e8a;
            font-size: 19px;
            font-weight: 700;
        }

        .view-all {
            color: #0077b6;
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
        }

        .view-all:hover {
            text-decoration: underline;
        }

        .booking-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 8px;
            border-bottom: 1px solid #edf1f5;
            color: inherit;
            transition: background 0.2s ease, padding 0.2s ease;
        }

        .booking-row:hover {
            background: #f7fbfe;
            padding-left: 14px;
            padding-right: 14px;
        }

        .booking-row:last-child {
            border-bottom: none;
        }

        .booking-info {
            min-width: 0;
            flex: 1;
        }

        .booking-name {
            color: #263746;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .booking-details {
            color: #8a96a1;
            font-size: 11px;
            line-height: 1.4;
        }

        .status {
            flex-shrink: 0;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 700;
        }

        .status-confirmed {
            background: #e6f7ef;
            color: #147a4b;
        }

        .status-pending {
            background: #fff4d8;
            color: #a36a00;
        }

        .status-rejected,
        .status-cancelled {
            background: #ffe8ec;
            color: #b52d43;
        }

        .booking-arrow {
            color: #0077b6;
            font-size: 20px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .empty-bookings {
            text-align: center;
            padding: 28px 15px;
            color: #8995a0;
            font-size: 13px;
        }

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

        @media (max-width: 850px) {
            nav {
                padding: 12px 20px;
                flex-wrap: wrap;
            }

            .nav-links {
                width: 100%;
                justify-content: center;
            }

            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 600px) {
            .container {
                margin-top: 22px;
                padding: 0 15px 35px;
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

            .welcome {
                padding: 22px;
            }

            .welcome h1 {
                font-size: 22px;
            }

            .main-card {
                padding: 18px;
                min-height: 105px;
            }

            .booking-row {
                align-items: flex-start;
            }

            .status {
                margin-top: 2px;
            }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <div class="brand-logo">
            <img
                src="{{ asset('images/otirasor-logo.png') }}?v={{ file_exists(public_path('images/otirasor-logo.png')) ? filemtime(public_path('images/otirasor-logo.png')) : time() }}"
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
        <a href="{{ route('admin.dashboard') }}">
            🏠 Dashboard
        </a>

        <a href="/admin/bookings">
            📋 Bookings
        </a>

        <a href="/admin/notifications" class="notification-link">
            🔔 Notifications

            @if (($unreadNotificationsCount ?? 0) > 0)
                <span class="notification-badge">
                    {{ $unreadNotificationsCount }}
                </span>
            @endif
        </a>

        <form method="POST" action="/logout" style="display:inline;">
            @csrf

            <button type="submit" class="logout-btn">
                🚪 Logout
            </button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="welcome">
        <h1>Welcome back, Otirasor Admin! 👋</h1>

        <p>
            Manage reservations, accommodations,
            room availability and resort operations
            from one place.
        </p>
    </div>

    <div class="section">
        <div class="section-heading">
            <h2 class="section-title">Resort Management</h2>

            <p class="section-description">
                Select a section below to manage resort operations.
            </p>
        </div>

        <div class="main-grid">

            <a href="/admin/room-status" class="main-card">
                <div class="card-icon">🏨</div>

                <div class="card-content">
                    <h3>Room Status</h3>
                    <p>View room availability, reservations and occupancy.</p>
                </div>

                <div class="card-arrow">→</div>
            </a>

            <a href="/admin/management" class="main-card">
                <div class="card-icon">⚙️</div>

                <div class="card-content">
                    <h3>Management</h3>
                    <p>Manage accommodations, reports and resort operations.</p>
                </div>

                <div class="card-arrow">→</div>
            </a>

            <a href="{{ route('admin.employees.index') }}" class="main-card">
                <div class="card-icon">👥</div>

                <div class="card-content">
                    <h3>Employees</h3>
                    <p>Manage employee accounts and employee information.</p>
                </div>

                <div class="card-arrow">→</div>
            </a>

            <a href="/admin/attendance" class="main-card">
                <div class="card-icon">🕒</div>

                <div class="card-content">
                    <h3>Attendance</h3>
                    <p>View employee time-in, time-out and attendance records.</p>
                </div>

                <div class="card-arrow">→</div>
            </a>

            <a href="/admin/booking-information" class="main-card">
                <div class="card-icon">📋</div>

                <div class="card-content">
                    <h3>Booking Information</h3>
                    <p>View booking summaries, guests and reservation details.</p>
                </div>

                <div class="card-arrow">→</div>
            </a>

            <!-- FIXED: EMPLOYEE SHIFT REQUESTS -->

            <a
                href="{{ route('admin.extra-shift-requests.employee-index') }}"
                class="main-card"
            >
                <div class="card-icon">📝</div>

                <div class="card-content">
                    <h3>Employee Requests</h3>

                    <p>
                        Review, approve or reject
                        extra-shift requests submitted by employees.
                    </p>
                </div>

                <div class="card-arrow">→</div>
            </a>

            <!-- FIXED: ADMIN SHIFT OFFERS -->

            <a
                href="{{ route('admin.extra-shift-requests.offer-index') }}"
                class="main-card"
            >
                <div class="card-icon">📨</div>

                <div class="card-content">
                    <h3>Admin Shift Offers</h3>

                    <p>
                        View shift offers sent to employees
                        and review their responses.
                    </p>
                </div>

                <div class="card-arrow">→</div>
            </a>

        </div>
    </div>

    <div class="section">
        <div class="recent-card">

            <div class="recent-header">
                <h3>📅 Recent Bookings</h3>

                <a href="/admin/recent-bookings" class="view-all">
                    View All →
                </a>
            </div>

            @forelse($recentBookings as $booking)

                <a
                    href="/admin/bookings?booking_id={{ $booking->id }}"
                    class="booking-row"
                >
                    <div class="booking-info">
                        <div class="booking-name">
                            {{ $booking->guest_name }}
                        </div>

                        <div class="booking-details">
                            Booking #{{ $booking->id }}
                            • Check-in: {{ $booking->check_in }}
                        </div>
                    </div>

                    @php
                        $statusClass = match ($booking->status) {
                            'Confirmed' => 'status-confirmed',
                            'Pending' => 'status-pending',
                            'Rejected' => 'status-rejected',
                            'Cancelled' => 'status-cancelled',
                            default => 'status-pending',
                        };
                    @endphp

                    <span class="status {{ $statusClass }}">
                        {{ $booking->status }}
                    </span>

                    <span class="booking-arrow">→</span>
                </a>

            @empty

                <div class="empty-bookings">
                    📭 No recent bookings found.
                </div>

            @endforelse

        </div>
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