<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Otirasor Beach and Resort</title>

    @vite(['resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, Helvetica, sans-serif; background: #f5f8fc; color: #263746; min-height: 100vh; }
        a { text-decoration: none; }

        nav { background: #023e8a; min-height: 76px; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; gap: 20px; color: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12); position: sticky; top: 0; z-index: 100; }
        .brand { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .brand-logo { width: 58px; height: 58px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; display: block; filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.18)); }
        .brand-text { color: white; min-width: 0; }
        .brand-title { font-size: 18px; font-weight: 700; line-height: 1.2; }
        .brand-subtitle { font-size: 11px; opacity: 0.8; margin-top: 4px; }
        .nav-links { display: flex; align-items: center; gap: 5px; flex-wrap: wrap; justify-content: flex-end; }
        nav a { color: white; padding: 10px 12px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: 0.2s ease; }
        nav a:hover { background: rgba(255, 255, 255, 0.13); }
        .notification-link { position: relative; }
        .notification-badge { position: absolute; top: 1px; right: 0; min-width: 18px; height: 18px; padding: 0 5px; background: #e63946; color: white; border-radius: 999px; font-size: 10px; font-weight: 700; display: flex; align-items: center; justify-content: center; line-height: 1; }
        .logout-btn { background: none; border: none; color: white; padding: 10px 12px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: Arial, Helvetica, sans-serif; transition: 0.2s ease; }
        .logout-btn:hover { background: rgba(255, 255, 255, 0.13); }

        .container { max-width: 1180px; margin: 34px auto; padding: 0 22px 45px; }
        .welcome { background: white; padding: 28px 30px; border-radius: 14px; margin-bottom: 30px; border: 1px solid #e3eaf1; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.055); border-left: 5px solid #0077b6; }
        .welcome h1 { color: #023e8a; font-size: 27px; line-height: 1.3; margin-bottom: 8px; }
        .welcome p { color: #687887; font-size: 14px; line-height: 1.6; }

        /* 3 Columns fixed layout */
        .live-stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 30px; }
        
        .stat-card { background: white; border: 1px solid #e3eaf1; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045); text-decoration: none; display: block; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease; cursor: pointer; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08); border-color: #0077b6; }
        .stat-card h3 { color: #687887; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .stat-card .number { color: #023e8a; font-size: 28px; font-weight: 800; }

        .section { margin-bottom: 30px; }
        .section-heading { margin-bottom: 17px; }
        .section-title { color: #023e8a; font-size: 21px; font-weight: 700; margin-bottom: 5px; }
        .section-description { color: #7a8793; font-size: 13px; line-height: 1.5; }

        .main-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; }
        .main-card { background: white; border: 1px solid #e1e9f0; border-radius: 14px; padding: 21px; min-height: 115px; display: flex; align-items: center; gap: 16px; color: #263746; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045); transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease; position: relative; }
        .main-card:hover { transform: translateY(-3px); border-color: #b7d5e9; box-shadow: 0 8px 22px rgba(0, 0, 0, 0.085); }
        .card-icon { width: 52px; height: 52px; flex-shrink: 0; background: #edf7fd; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 25px; }
        .card-content { flex: 1; min-width: 0; }
        .card-content h3 { color: #023e8a; font-size: 17px; font-weight: 700; margin-bottom: 6px; }
        .card-content p { color: #71808e; font-size: 13px; line-height: 1.5; }
        .card-arrow { color: #0077b6; font-size: 21px; font-weight: 700; flex-shrink: 0; }

        .recent-card { background: white; border: 1px solid #e1e9f0; border-radius: 14px; padding: 22px; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045); }
        .recent-header { display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-bottom: 10px; }
        .recent-header h3 { color: #023e8a; font-size: 19px; font-weight: 700; }
        .view-all { color: #0077b6; font-size: 13px; font-weight: 700; white-space: nowrap; }
        .view-all:hover { text-decoration: underline; }
        .booking-row { display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 15px 8px; border-bottom: 1px solid #edf1f5; color: inherit; transition: background 0.2s ease, padding 0.2s ease; }
        .booking-row:hover { background: #f7fbfe; padding-left: 14px; padding-right: 14px; }
        .booking-row:last-child { border-bottom: none; }
        .booking-info { min-width: 0; flex: 1; }
        .booking-name { color: #263746; font-size: 14px; font-weight: 700; margin-bottom: 4px; }
        .booking-details { color: #8a96a1; font-size: 11px; line-height: 1.4; }
        .status { flex-shrink: 0; padding: 5px 10px; border-radius: 999px; font-size: 10px; font-weight: 700; }
        .status-confirmed { background: #e6f7ef; color: #147a4b; }
        .status-pending { background: #fff4d8; color: #a36a00; }
        .status-rejected, .status-cancelled { background: #ffe8ec; color: #b52d43; }
        .booking-arrow { color: #0077b6; font-size: 20px; font-weight: 700; flex-shrink: 0; }
        .empty-bookings { text-align: center; padding: 28px 15px; color: #8995a0; font-size: 13px; }

        footer { background: #023e8a; color: white; text-align: center; padding: 18px; margin-top: 40px; }
        footer p { font-size: 12px; opacity: 0.9; }

        @media (max-width: 850px) {
            nav { padding: 12px 20px; flex-wrap: wrap; }
            .nav-links { width: 100%; justify-content: center; }
            .main-grid { grid-template-columns: 1fr; }
            .live-stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .container { margin-top: 22px; padding: 0 15px 35px; }
            .brand-title { font-size: 16px; }
            .brand-subtitle { font-size: 10px; }
            .brand-logo { width: 50px; height: 50px; }
            .welcome { padding: 22px; }
            .welcome h1 { font-size: 22px; }
            .main-card { padding: 18px; min-height: 105px; }
            .booking-row { align-items: flex-start; }
            .status { margin-top: 2px; }
            .live-stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('images/otirasor-logo.png') }}?v={{ file_exists(public_path('images/otirasor-logo.png')) ? filemtime(public_path('images/otirasor-logo.png')) : time() }}" alt="Otirasor Beach and Resort Logo">
        </div>
        <div class="brand-text">
            <div class="brand-title">Otirasor Beach and Resort</div>
            <div class="brand-subtitle">Administration Portal</div>
        </div>
    </div>

    <div class="nav-links">
        <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        <a href="/admin/bookings" style="position: relative; display: inline-flex; align-items: center;">
            📋 Bookings
            @if(($pendingBookings ?? 0) > 0)
                <span style="background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold; margin-left: 5px;">{{ $pendingBookings }}</span>
            @endif
        </a>
        <a href="/admin/notifications" class="notification-link">
            🔔 Notifications
            @if (($unreadNotificationsCount ?? 0) > 0)
                <span class="notification-badge">{{ $unreadNotificationsCount }}</span>
            @endif
        </a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="welcome">
        <h1>Welcome back, Otirasor Admin! 👋</h1>
        <p>Manage reservations, accommodations, room availability and resort operations from one place.</p>
    </div>

    <!-- 6 CARDS (3 Columns x 2 Rows) -->
    <div class="live-stats-grid">
        <a href="/admin/bookings" class="stat-card">
            <h3>Total Bookings</h3>
            <div class="number" id="total-bookings">{{ $totalBookings }}</div>
        </a>
        <a href="/admin/bookings?filter=pending" class="stat-card">
            <h3>Pending</h3>
            <div class="number" id="pending-count">{{ $pendingBookings }}</div>
        </a>
        <a href="/admin/bookings?filter=confirmed" class="stat-card">
            <h3>Confirmed</h3>
            <div class="number" id="confirmed-count">{{ $confirmedBookings }}</div>
        </a>
        <div class="stat-card" style="cursor: default;">
            <h3>Total Guests</h3>
            <div class="number" id="total-guests">{{ $totalGuests }}</div>
        </div>
        <a href="/admin/bookings?filter=refund_pending" class="stat-card" style="border-left: 4px solid #ea580c;">
            <h3>Pending Refunds</h3>
            <div class="number" style="color: #ea580c;">{{ $pendingRefundsCount ?? 0 }}</div>
        </a>
        <a href="/admin/bookings?filter=pending" class="stat-card" style="border-left: 4px solid #f59e0b;">
            <h3>Pending Cancellations</h3>
            <div class="number" style="color: #f59e0b;">{{ $pendingCancellationsCount ?? 0 }}</div>
        </a>
    </div>

    <div class="section">
        <div class="section-heading">
            <h2 class="section-title">Resort Management</h2>
            <p class="section-description">Select a section below to manage resort operations.</p>
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

            <a href="{{ route('admin.analytics') }}" class="main-card" style="border: 2px solid #00b4d8; background: #f0fbfd;">
                <div class="card-icon">📊</div>
                <div class="card-content">
                    <h3>View Analytics</h3>
                    <p>See booking trends and status distribution charts.</p>
                </div>
                <div class="card-arrow">→</div>
            </a>

            <a href="{{ route('admin.payments') }}" class="main-card" style="border: 2px solid #10b981; background: #f0fdf4;">
                <div class="card-icon">💰</div>
                <div class="card-content">
                    <h3>Payment Tracking</h3>
                    <p>View and verify GCash payments and track resort revenue.</p>
                </div>
                <div class="card-arrow">→</div>
            </a>

            <a href="{{ route('admin.reviews') }}" class="main-card" style="border: 2px solid #fbbf24; background: #fffbeb;">
                <div class="card-icon">⭐</div>
                <div class="card-content">
                    <h3>Guest Reviews</h3>
                    <p>View guest feedback, ratings, and comments.</p>
                </div>
                <div class="card-arrow">→</div>
            </a>

            <a href="/admin/promotions" class="main-card" style="border: 2px solid #ec4899; background: #fdf2f8;">
                <div class="card-icon">🎟️</div>
                <div class="card-content">
                    <h3>Promotions</h3>
                    <p>Create and manage promo codes for discounts.</p>
                </div>
                <div class="card-arrow">→</div>
            </a>

            <a href="{{ route('admin.transactions') }}" class="main-card" style="border: 2px solid #8b5cf6; background: #f5f3ff;">
                <div class="card-icon">💸</div>
                <div class="card-content">
                    <h3>Transaction Records</h3>
                    <p>View all payments, refunds, and net income (with CSV export).</p>
                </div>
                <div class="card-arrow">→</div>
                
                @if(($pendingRefundsCount ?? 0) > 0)
                    <span style="position: absolute; top: 15px; right: 15px; background: #ef4444; color: white; font-size: 12px; font-weight: bold; padding: 4px 10px; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        {{ $pendingRefundsCount }} Refund
                    </span>
                @endif
                @if(($pendingCancellationsCount ?? 0) > 0)
                    <span style="position: absolute; top: 15px; right: 120px; background: #f97316; color: white; font-size: 12px; font-weight: bold; padding: 4px 10px; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                        {{ $pendingCancellationsCount }} Cancel
                    </span>
                @endif
            </a>

            <!-- REFUND HISTORY CARD -->
            <a href="{{ route('admin.refunds.history') }}" class="main-card" style="border: 2px solid #ea580c; background: #fff7ed;">
                <div class="card-icon" style="background: #ffedd5;">📜</div>
                <div class="card-content">
                    <h3>Refund History</h3>
                    <p>View all successfully processed refunds with proofs and references.</p>
                </div>
                <div class="card-arrow" style="color: #ea580c;">→</div>
            </a>

            <!-- AUDIT LOGS CARD -->
            <a href="{{ route('admin.audit-logs') }}" class="main-card" style="border: 2px solid #4b5563; background: #f3f4f6;">
                <div class="card-icon" style="background: #e5e7eb;">📝</div>
                <div class="card-content">
                    <h3>Audit Logs</h3>
                    <p>Track all admin actions, approvals, and rejections for security.</p>
                </div>
                <div class="card-arrow" style="color: #4b5563;">→</div>
            </a>
        </div>
    </div>

    <div class="section">
        <div class="recent-card">
            <div class="recent-header">
                <h3>📅 Recent Bookings</h3>
                <a href="/admin/recent-bookings" class="view-all">View All →</a>
            </div>

            @forelse($recentBookings as $booking)
                <a href="/admin/bookings?booking_id={{ $booking->id }}" class="booking-row">
                    <div class="booking-info">
                        <div class="booking-name">{{ $booking->guest_name }}</div>
                        <div class="booking-details">Booking #{{ $booking->id }} • Check-in: {{ $booking->check_in }}</div>
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

                    <span class="status {{ $statusClass }}">{{ $booking->status }}</span>
                    <span class="booking-arrow">→</span>
                </a>
            @empty
                <div class="empty-bookings">📭 No recent bookings found.</div>
            @endforelse
        </div>
    </div>

</div>

<footer>
    <p>&copy; 2026 Otirasor Beach and Resort. All Rights Reserved.</p>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
            console.warn('Echo is not loaded.');
            return;
        }

        const userId = {{ auth()->id() }};
        const badge = document.querySelector('.notification-badge');
        const notificationLink = document.querySelector('.notification-link');

        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('New notification:', notification);

                if (badge) {
                    const currentCount = parseInt(badge.textContent.trim()) || 0;
                    badge.textContent = currentCount + 1;
                    badge.style.display = 'flex';
                } else if (notificationLink) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notification-badge';
                    newBadge.textContent = '1';
                    notificationLink.appendChild(newBadge);
                }

                if (notification.type === 'attendance_correction') {
                    alert(notification.message);
                    setTimeout(() => { window.location.reload(); }, 500);
                }

                if (window.showToast) {
                    const redirectUrl = notification.booking_id 
                        ? `/admin/bookings?booking_id=${notification.booking_id}` 
                        : '/admin/notifications';

                    window.showToast(
                        'New Notification',
                        notification.message || 'You have a new notification.',
                        'info',
                        redirectUrl
                    );
                }
            });

        window.Echo.private('admin.dashboard')
            .listen('DashboardStatsUpdated', (e) => {
                console.log('Dashboard Stats Updated:', e.stats);

                if (document.getElementById('pending-count')) {
                    document.getElementById('pending-count').textContent = e.stats.pendingBookings;
                }
                if (document.getElementById('confirmed-count')) {
                    document.getElementById('confirmed-count').textContent = e.stats.confirmedBookings;
                }
                if (document.getElementById('total-bookings')) {
                    document.getElementById('total-bookings').textContent = e.stats.totalBookings;
                }
                if (document.getElementById('total-guests')) {
                    document.getElementById('total-guests').textContent = e.stats.totalGuests;
                }
            });
    });
</script>

</body>
</html>