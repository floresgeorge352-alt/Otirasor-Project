<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Tracking - Otirasor Beach</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; min-height: 100vh; }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        nav { background: #023e8a; padding: 15px 6%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: bold; }
        .brand img { width: 40px; height: 40px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        .nav-links { display: flex; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; }
        nav a:hover { text-decoration: underline; }

        .container { width: 1200px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 30px; font-size: 32px; }

        .summary-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 18px; margin-bottom: 30px; }
        .summary-card {
            background: white; border: 2px solid transparent; border-radius: 16px; padding: 22px;
            text-align: center; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
            text-decoration: none; color: inherit; display: block; cursor: pointer;
            transition: all 0.3s ease;
        }
        .summary-card:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08); border-color: #0077b6; }
        .summary-card.active { border-color: #0077b6; background: #f0fbfd; }

        .summary-card .icon { font-size: 30px; margin-bottom: 8px; }
        .summary-card h3 { color: #6c7a86; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .summary-card .value { color: #023e8a; font-size: 20px; font-weight: 800; }
        .summary-card .value.small { font-size: 16px; }

        .filter-label { text-align: center; margin-bottom: 20px; color: #6c7a86; font-size: 14px; }
        .clear-filter { color: #0077b6; text-decoration: none; font-weight: bold; }
        .clear-filter:hover { text-decoration: underline; }

        .table-wrapper { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border-bottom: 1px solid #edf1f5; font-size: 14px; }
        th { background: #f8fcfd; color: #023e8a; font-weight: 700; font-family: 'Montserrat', sans-serif; }
        tr:last-child td { border-bottom: none; }

        .booking-link { color: #0077b6; font-weight: bold; text-decoration: none; }
        .booking-link:hover { text-decoration: underline; }

        .status { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .status-verified { background: #e6f7ef; color: #147a4b; }
        .status-pending { background: #fff4d8; color: #a36a00; }
        .status-rejected { background: #ffe8ec; color: #b52d43; }
        .status-not-applicable { background: #e5e7eb; color: #4b5563; }

        .pagination-area { margin-top: 30px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .pagination-link {
            display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px;
            padding: 0 15px; border-radius: 8px; background: white; color: #023e8a; text-decoration: none; font-weight: 700;
            border: 1px solid #dce8ed; transition: 0.2s; font-size: 14px;
        }
        .pagination-link:hover { background: #eaf8fc; border-color: #0077b6; }
        .pagination-link.active { background: #0077b6; color: white; border-color: #0077b6; }
        .pagination-link.disabled { color: #adb5bd; background: #f8f9fa; cursor: not-allowed; border-color: #e9ecef; }

        @media (max-width: 1100px) {
            .summary-grid { grid-template-columns: repeat(3, 1fr); }
        }
        @media (max-width: 900px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
            .table-wrapper { overflow-x: auto; }
            nav { flex-direction: column; gap: 10px; }
        }
        @media (max-width: 600px) {
            .summary-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<nav>
    <div class="brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach Admin
    </div>
    <div class="nav-links">
        <a href="/admin/dashboard">Dashboard</a>
        <a href="/admin/bookings">Bookings</a>
        <a href="/admin/reports">Reports</a>
        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
    </div>
</nav>

<div class="container">
    <h1>Payment Tracking</h1>

    <div class="summary-grid">
        <a href="{{ route('admin.payments', ['status' => 'Booked']) }}" class="summary-card {{ $statusFilter === 'Booked' ? 'active' : '' }}">
            <div class="icon">💰</div>
            <h3>Booked Revenue</h3>
            <div class="value small">₱{{ number_format($bookedRevenue, 2) }}</div>
        </a>

        <a href="{{ route('admin.payments', ['status' => 'Realized']) }}" class="summary-card {{ $statusFilter === 'Realized' ? 'active' : '' }}">
            <div class="icon">✅</div>
            <h3>Realized Revenue</h3>
            <div class="value small">₱{{ number_format($realizedRevenue, 2) }}</div>
        </a>

        <a href="{{ route('admin.payments', ['status' => 'Verified']) }}" class="summary-card {{ $statusFilter === 'Verified' ? 'active' : '' }}">
            <div class="icon">🟢</div>
            <h3>Verified</h3>
            <div class="value">{{ $verifiedPayments }}</div>
        </a>

        <a href="{{ route('admin.payments', ['status' => 'For Verification']) }}" class="summary-card {{ $statusFilter === 'For Verification' ? 'active' : '' }}">
            <div class="icon">⏳</div>
            <h3>Pending</h3>
            <div class="value">{{ $pendingPayments }}</div>
        </a>

        <a href="{{ route('admin.payments', ['status' => 'Rejected']) }}" class="summary-card {{ $statusFilter === 'Rejected' ? 'active' : '' }}">
            <div class="icon">❌</div>
            <h3>Rejected</h3>
            <div class="value">{{ $rejectedPayments }}</div>
        </a>
    </div>

    @if($statusFilter)
        <div class="filter-label">
            Showing only <strong>{{ $statusFilter === 'For Verification' ? 'Pending' : $statusFilter }}</strong> payments. 
            <a href="{{ route('admin.payments') }}" class="clear-filter">Clear Filter</a>
        </div>
    @endif

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Booking #</th>
                    <th>Guest Name</th>
                    <th>Payment Method</th>
                    <th>Reference</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $booking)
                    <tr>
                        <td>
                            <a href="/admin/bookings?booking_id={{ $booking->id }}" class="booking-link">
                                #{{ $booking->id }}
                            </a>
                        </td>
                        <td>{{ $booking->guest_name }}</td>
                        <td>{{ $booking->payment_method }}</td>
                        <td>{{ $booking->gcash_reference ?? '—' }}</td>
                        <td>₱{{ number_format(($booking->accommodation_total ?? 0) + ($booking->facility_total ?? 0), 2) }}</td>
                        <td>
                            @if($booking->payment_status === 'Verified')
                                <span class="status status-verified">Verified</span>
                            @elseif($booking->payment_status === 'For Verification')
                                <span class="status status-pending">Pending</span>
                            @elseif($booking->payment_status === 'Rejected')
                                <span class="status status-rejected">Rejected</span>
                            @else
                                <span class="status status-not-applicable">{{ $booking->payment_status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: #6b7280;">No payments found for this filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($payments->hasPages())
        <div class="pagination-area">
            @if ($payments->onFirstPage())
                <span class="pagination-link disabled">← Previous</span>
            @else
                <a href="{{ $payments->previousPageUrl() }}" class="pagination-link">← Previous</a>
            @endif

            @foreach ($payments->getUrlRange(max(1, $payments->currentPage() - 2), min($payments->lastPage(), $payments->currentPage() + 2)) as $page => $url)
                @if ($page == $payments->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($payments->hasMorePages())
                <a href="{{ $payments->nextPageUrl() }}" class="pagination-link">Next →</a>
            @else
                <span class="pagination-link disabled">Next →</span>
            @endif
        </div>
    @endif

</div>

</body>
</html>