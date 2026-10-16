<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Otirasor Beach and Resort</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            color: #1f2937;
        }

        nav {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            color: #023e8a;
            font-size: 18px;
            font-weight: bold;
        }

        .brand-subtitle {
            color: #6b7280;
            font-size: 12px;
            margin-top: 2px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links a,
        .logout-btn {
            border: none;
            background: transparent;
            color: #374151;
            text-decoration: none;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .nav-links a:hover,
        .logout-btn:hover {
            background: #eff6ff;
            color: #0077b6;
        }

        .container {
            max-width: 1180px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }

        .page-header h1 {
            color: #023e8a;
            font-size: 28px;
            margin-bottom: 7px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e5e7eb;
            color: #374151;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
        }

        .back-btn:hover {
            background: #d1d5db;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .summary-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        a.summary-card,
        a.payment-box {
            color: inherit;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        a.summary-card:hover,
        a.payment-box:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
        }

        a.summary-card:focus-visible,
        a.payment-box:focus-visible,
        .booking-id-link:focus-visible {
            outline: 3px solid #0077b6;
            outline-offset: 3px;
        }

        .summary-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .blue-icon { background: #eff6ff; }
        .green-icon { background: #ecfdf3; }
        .orange-icon { background: #fff7ed; }
        .gray-icon { background: #f3f4f6; }
        .red-icon { background: #fef2f2; }
        .purple-icon { background: #f5f3ff; }

        .summary-content {
            min-width: 0;
        }

        .summary-label {
            color: #6b7280;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-bottom: 5px;
        }

        .summary-number {
            color: #023e8a;
            font-size: 28px;
            font-weight: bold;
        }

        .section {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .section-header {
            padding: 19px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .section-header h2 {
            color: #023e8a;
            font-size: 18px;
        }

        .section-description {
            color: #6b7280;
            font-size: 12px;
            margin-top: 4px;
        }

        .section-body {
            padding: 20px;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 15px;
        }

        .payment-box {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-icon {
            width: 45px;
            height: 45px;
            border-radius: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            background: #eff6ff;
        }

        .payment-content h3 {
            color: #374151;
            font-size: 15px;
            margin-bottom: 4px;
        }

        .payment-number {
            color: #023e8a;
            font-size: 25px;
            font-weight: bold;
        }

        .payment-content p {
            color: #9ca3af;
            font-size: 12px;
            margin-top: 3px;
        }

        .table-scroll {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th {
            background: #f8fafc;
            color: #374151;
            padding: 13px 15px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 1px solid #e5e7eb;
        }

        td {
            padding: 14px 15px;
            border-bottom: 1px solid #eef0f3;
            font-size: 14px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8fbff;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .booking-id,
        .booking-id-link {
            color: #0077b6;
            font-weight: bold;
        }

        .booking-id-link {
            text-decoration: none;
        }

        .booking-id-link:hover {
            text-decoration: underline;
        }

        .guest-name {
            font-weight: bold;
            color: #111827;
        }

        .guest-count,
        .accommodation,
        .date {
            color: #4b5563;
        }

        .accommodation {
            max-width: 220px;
        }

        .date {
            white-space: nowrap;
        }

        .status {
            display: inline-flex;
            align-items: center;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fff7ed;
            color: #c2410c;
        }

        .confirmed {
            background: #ecfdf3;
            color: #15803d;
        }

        .rejected {
            background: #fef2f2;
            color: #b91c1c;
        }

        .cancelled {
            background: #f3f4f6;
            color: #4b5563;
        }

        .empty {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .empty-title {
            color: #374151;
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .empty-text {
            font-size: 13px;
        }

        .clear-filter {
            display: inline-block;
            background: #eff6ff;
            color: #0077b6;
            text-decoration: none;
            padding: 9px 13px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
        }

        .clear-filter:hover {
            background: #dbeafe;
        }

        footer {
            text-align: center;
            color: #9ca3af;
            font-size: 12px;
            padding: 25px 20px;
        }

        @media (max-width: 850px) {
            nav {
                padding: 13px 18px;
                flex-direction: column;
                align-items: stretch;
            }

            .brand {
                justify-content: center;
            }

            .nav-links {
                justify-content: center;
                flex-wrap: wrap;
            }

            .summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .container {
                margin: 22px auto;
                padding: 0 12px;
            }

            .page-header {
                flex-direction: column;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .back-btn {
                width: 100%;
            }

            .summary-grid,
            .payment-grid {
                grid-template-columns: 1fr;
            }

            .section-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .brand-title {
                font-size: 16px;
            }

            .brand-subtitle {
                font-size: 11px;
            }

            .nav-links a,
            .logout-btn {
                font-size: 12px;
                padding: 8px 9px;
            }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
            alt="Otirasor Beach and Resort Logo"
        >

        <div class="brand-text">
            <div class="brand-title">Otirasor Beach and Resort</div>
            <div class="brand-subtitle">Admin Panel</div>
        </div>
    </div>

    <div class="nav-links">
        <a href="/admin/dashboard">🏠 Dashboard</a>
        <a href="/admin/bookings">📋 Bookings</a>
        <a href="/admin/notifications">🔔 Notifications</a>

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <div>
            <h1>📊 Reports</h1>
            <p>Booking and payment summary for Otirasor Beach and Resort.</p>
        </div>

        <a href="/admin/management" class="back-btn">← Management</a>
    </div>

    <!-- BOOKING SUMMARY -->

    <div class="summary-grid">

        <a href="{{ url('/admin/reports') }}?details=all" class="summary-card">
            <div class="summary-icon blue-icon">📋</div>
            <div class="summary-content">
                <div class="summary-label">Total Bookings</div>
                <div class="summary-number">{{ $totalBookings }}</div>
            </div>
        </a>

        <a href="{{ url('/admin/bookings') }}?filter=confirmed" class="summary-card">
            <div class="summary-icon green-icon">✅</div>
            <div class="summary-content">
                <div class="summary-label">Confirmed</div>
                <div class="summary-number">{{ $confirmedBookings }}</div>
            </div>
        </a>

        <a href="{{ url('/admin/bookings') }}?filter=pending" class="summary-card">
            <div class="summary-icon orange-icon">⏳</div>
            <div class="summary-content">
                <div class="summary-label">Pending</div>
                <div class="summary-number">{{ $pendingBookings }}</div>
            </div>
        </a>

        <a href="{{ url('/admin/bookings') }}?filter=cancelled" class="summary-card">
            <div class="summary-icon gray-icon">🚫</div>
            <div class="summary-content">
                <div class="summary-label">Cancelled</div>
                <div class="summary-number">{{ $cancelledBookings }}</div>
            </div>
        </a>

        <a href="{{ url('/admin/bookings') }}?filter=rejected" class="summary-card">
            <div class="summary-icon red-icon">❌</div>
            <div class="summary-content">
                <div class="summary-label">Rejected</div>
                <div class="summary-number">{{ $rejectedBookings }}</div>
            </div>
        </a>

        <a href="{{ url('/admin/reports') }}?details=guests" class="summary-card">
            <div class="summary-icon purple-icon">👥</div>
            <div class="summary-content">
                <div class="summary-label">Total Guests</div>
                <div class="summary-number">{{ $totalGuests }}</div>
            </div>
        </a>

    </div>

    <!-- PAYMENT SUMMARY -->

    <div class="section">
        <div class="section-header">
            <div>
                <h2>💳 Payment Summary</h2>
                <div class="section-description">
                    Select a payment method to view its bookings.
                </div>
            </div>
        </div>

        <div class="section-body">
            <div class="payment-grid">

                <a href="{{ url('/admin/reports') }}?payment_method=Cash" class="payment-box">
                    <div class="payment-icon">💵</div>
                    <div class="payment-content">
                        <h3>Cash</h3>
                        <div class="payment-number">{{ $cashBookings }}</div>
                        <p>Bookings — click to view</p>
                    </div>
                </a>

                <a href="{{ url('/admin/reports') }}?payment_method=GCash" class="payment-box">
                    <div class="payment-icon">📱</div>
                    <div class="payment-content">
                        <h3>GCash</h3>
                        <div class="payment-number">{{ $gcashBookings }}</div>
                        <p>Bookings — click to view</p>
                    </div>
                </a>

            </div>
        </div>
    </div>

    <!-- SELECTED REPORT DETAILS: ONLY WHEN A REPORT IS SELECTED -->

    @if($detailTitle)
        <div class="section" id="report-details">

            <div class="section-header">
                <div>
                    <h2>📑 {{ $detailTitle }}</h2>
                    <div class="section-description">
                        {{ $detailBookings->count() }} booking record(s) found.
                    </div>
                </div>

                <a href="{{ url('/admin/reports') }}" class="clear-filter">
                    Show All Reports
                </a>
            </div>

            @if($detailBookings->count() > 0)
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Guest</th>
                                <th>Guests</th>
                                <th>Accommodation</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($detailBookings as $booking)
                                <tr>
                                    <td>
                                        <a
                                            class="booking-id-link"
                                            href="{{ url('/admin/bookings') }}?booking_id={{ $booking->id }}"
                                        >
                                            #{{ $booking->id }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="guest-name">
                                            {{ $booking->guest_name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="guest-count">
                                            {{ $booking->number_of_guests }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="accommodation">
                                            {{ $booking->accommodations }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="date">
                                            {{ $booking->check_in }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="date">
                                            {{ $booking->check_out }}
                                        </span>
                                    </td>

                                    <td>{{ $booking->payment_method }}</td>

                                    <td>
                                        <span class="status {{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty">
                    <div class="empty-icon">📋</div>
                    <div class="empty-title">No matching bookings found.</div>
                    <div class="empty-text">
                        There are currently no records for this selection.
                    </div>
                </div>
            @endif
        </div>
    @endif

    <!-- RECENT BOOKINGS: SHOW ONLY WHEN NO REPORT FILTER IS SELECTED -->

    @if(!$detailTitle)
        <div class="section">
            <div class="section-header">
                <div>
                    <h2>📋 Recent Bookings</h2>
                    <div class="section-description">
                        Latest reservations recorded in the system.
                        Click a Booking ID to open that booking.
                    </div>
                </div>
            </div>

            @if($recentBookings->count() > 0)
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Booking ID</th>
                                <th>Guest</th>
                                <th>Guests</th>
                                <th>Accommodation</th>
                                <th>Check-in</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($recentBookings as $booking)
                                <tr>
                                    <td>
                                        <a
                                            class="booking-id-link"
                                            href="{{ url('/admin/bookings') }}?booking_id={{ $booking->id }}"
                                        >
                                            #{{ $booking->id }}
                                        </a>
                                    </td>

                                    <td>
                                        <span class="guest-name">
                                            {{ $booking->guest_name }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="guest-count">
                                            👥 {{ $booking->number_of_guests }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="accommodation">
                                            {{ $booking->accommodations }}
                                        </div>
                                    </td>

                                    <td>
                                        <span class="date">
                                            {{ $booking->check_in }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="status {{ strtolower($booking->status) }}">
                                            {{ $booking->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty">
                    <div class="empty-icon">📋</div>
                    <div class="empty-title">No bookings available yet.</div>
                    <div class="empty-text">
                        Booking records will appear here once customers make reservations.
                    </div>
                </div>
            @endif
        </div>
    @endif

</div>

<footer>
    © 2026 Otirasor Beach and Resort. All Rights Reserved.
</footer>

</body>
</html>