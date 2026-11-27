<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Submitted - Otirasor Beach and Resort</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --primary: #0077b6; --primary-dark: #023e8a; --primary-light: #00b4d8;
            --bg: #f5f8fc; --text: #243b4a; --muted: #6c7a86; --border: #dce8ed;
            --white: #fff; --shadow: 0 10px 30px rgba(0, 0, 0, 0.05); --radius: 20px;
        }
        body { font-family: 'Poppins', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }
        h1, h2, h3, h4 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        nav {
            background: rgba(0, 119, 182, 0.95); backdrop-filter: blur(10px);
            padding: 15px 6%; display: flex; justify-content: space-between; align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: 800; }
        .nav-brand img { width: 45px; height: 45px; object-fit: contain; border-radius: 50%; background: white; padding: 2px; }
        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }

        .container { width: 800px; max-width: 92%; margin: 40px auto; }

        .confirmation-card {
            background: var(--white); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 40px; box-shadow: var(--shadow); text-align: center; margin-bottom: 25px;
        }
        .success-icon {
            width: 80px; height: 80px; background: #e6f7ef; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; font-size: 40px;
            margin: 0 auto 20px; border: 3px solid #147a4b; color: #147a4b;
        }
        .confirmation-card h1 { color: var(--primary-dark); font-size: 28px; margin-bottom: 10px; }
        .confirmation-card p { color: var(--muted); font-size: 14px; }
        .booking-ref { font-weight: 700; color: var(--primary); font-size: 16px; margin-top: 10px; }

        .details-card {
            background: var(--white); border: 1px solid var(--border); border-radius: var(--radius);
            padding: 30px; box-shadow: var(--shadow); margin-bottom: 25px;
        }
        .details-card h2 {
            color: var(--primary-dark); font-size: 18px; margin-bottom: 15px;
            border-bottom: 1px solid #edf1f5; padding-bottom: 15px;
        }
        .detail-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 12px 0; border-bottom: 1px dashed #edf1f5; font-size: 14px;
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: var(--muted); }
        .detail-value { font-weight: 600; color: var(--text); }

        /* UNIFIED SUMMARY TABLE */
        .summary-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .summary-table th {
            text-align: left; padding: 10px 0; color: var(--primary-dark); font-size: 13px;
            text-transform: uppercase; border-bottom: 2px solid var(--primary);
        }
        .summary-table td { padding: 12px 0; border-bottom: 1px dashed #edf1f5; font-size: 14px; color: var(--text); }
        .summary-table td:last-child { text-align: right; font-weight: 600; }
        .summary-table .subtotal-row td {
            background: #f8fbfd; font-weight: 700; color: var(--primary-dark);
            padding: 15px 10px; border-bottom: none;
        }
        .grand-total-box {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white; padding: 20px 25px; border-radius: 12px;
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 20px; box-shadow: 0 5px 15px rgba(0, 119, 182, 0.3);
        }
        .grand-total-box span:first-child { font-size: 18px; font-weight: 800; font-family: 'Montserrat', sans-serif; }
        .grand-total-box span:last-child { font-size: 28px; font-weight: 800; font-family: 'Montserrat', sans-serif; }

        .action-buttons { display: flex; gap: 15px; justify-content: center; margin-top: 30px; flex-wrap: wrap; }
        .btn {
            padding: 14px 30px; border: 0; border-radius: 10px; font: 700 14px 'Poppins', sans-serif;
            cursor: pointer; text-decoration: none; transition: 0.3s; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 4px 15px rgba(0, 119, 182, 0.3); }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
        .btn-secondary { background: #edf1f5; color: var(--primary-dark); border: 1px solid var(--border); }
        .btn-secondary:hover { background: #dce8ed; transform: translateY(-2px); }

        footer { text-align: center; padding: 25px; background: var(--primary-dark); color: rgba(255, 255, 255, 0.8); font-size: 13px; margin-top: 40px; }

        @media (max-width: 600px) {
            nav { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .confirmation-card { padding: 30px 20px; }
            .details-card { padding: 20px; }
            .grand-total-box span:last-child { font-size: 22px; }
            .action-buttons { flex-direction: column; }
            .btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<!-- NAVIGATION -->
<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach and Resort
    </div>
    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/dashboard">Dashboard</a>
        <a href="/my-bookings">My Bookings</a>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- SUCCESS HEADER -->
    <div class="confirmation-card">
        <div class="success-icon">✅</div>
        <h1>Booking Submitted Successfully!</h1>
        <p>Thank you for choosing Otirasor Beach and Resort. Your booking is now pending for admin approval.</p>
        <div class="booking-ref">Booking Reference #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</div>
    </div>

    <!-- UNIFIED SUMMARY CARD -->
    <div class="details-card">
        <h2>📝 Booking Summary</h2>
        
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Accommodation(s) -->
                @if(count($accommodationBreakdown) > 0)
                    @foreach($accommodationBreakdown as $acc)
                        <tr>
                            <td>🏠 {{ $acc['name'] }}</td>
                            <td>₱{{ number_format($acc['price'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>🏠 Accommodation</td>
                        <td>₱{{ number_format($booking->accommodation_total, 2) }}</td>
                    </tr>
                @endif

                <!-- Fees (Beach & Pool) -->
                @if($beachEntranceTotal > 0)
                    <tr>
                        <td>🌊 Beach Entrance ({{ $booking->number_of_adults }} Adults, {{ $booking->number_of_kids }} Kids)</td>
                        <td>₱{{ number_format($beachEntranceTotal, 2) }}</td>
                    </tr>
                @endif

                @if($poolTotal > 0)
                    <tr>
                        <td>🏊 Swimming Pool ({{ $booking->pool_adults }} Adults, {{ $booking->pool_kids }} Kids)</td>
                        <td>₱{{ number_format($poolTotal, 2) }}</td>
                    </tr>
                @endif

                <!-- Subtotal before discounts -->
                @php
                    $subtotal = $booking->accommodation_total + $booking->facility_total;
                @endphp
                <tr class="subtotal-row">
                    <td>Subtotal</td>
                    <td>₱{{ number_format($subtotal, 2) }}</td>
                </tr>

                <!-- Discounts -->
                @if($booking->discount_amount > 0)
                    <tr style="color: #e63946;">
                        <td>🎟️ Promo Code ({{ $booking->promo_code }})</td>
                        <td>- ₱{{ number_format($booking->discount_amount, 2) }}</td>
                    </tr>
                @endif

                @if($booking->reward_discount > 0)
                    <tr style="color: #e63946;">
                        <td>⭐ Reward Points Discount</td>
                        <td>- ₱{{ number_format($booking->reward_discount, 2) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <!-- GRAND TOTAL -->
        <div class="grand-total-box">
            <span>Grand Total</span>
            <span>₱{{ number_format($grandTotal, 2) }}</span>
        </div>
    </div>

    <!-- BOOKING DETAILS CARD -->
    <div class="details-card">
        <h2>📅 Stay Details</h2>
        
        <div class="detail-row">
            <span class="detail-label">Guest Name</span>
            <span class="detail-value">{{ $booking->guest_name }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Contact Number</span>
            <span class="detail-value">{{ $booking->contact_number }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Check-in Date</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_in)->format('F d, Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Check-out Date</span>
            <span class="detail-value">{{ \Carbon\Carbon::parse($booking->check_out)->format('F d, Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Total Guests</span>
            <span class="detail-value">{{ $booking->number_of_adults }} Adults, {{ $booking->number_of_kids }} Kids</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Payment Method</span>
            <span class="detail-value">{{ $booking->payment_method }}</span>
        </div>
        @if($booking->gcash_reference)
            <div class="detail-row">
                <span class="detail-label">GCash Reference</span>
                <span class="detail-value">{{ $booking->gcash_reference }}</span>
            </div>
        @endif
        <div class="detail-row">
            <span class="detail-label">Status</span>
            <span class="detail-value">
                @if($booking->status === 'Pending')
                    <span style="color: #a36a00; background: #fff4d8; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Pending</span>
                @elseif($booking->status === 'Confirmed')
                    <span style="color: #147a4b; background: #e6f7ef; padding: 4px 10px; border-radius: 20px; font-size: 12px;">Confirmed</span>
                @else
                    <span style="color: #b52d43; background: #ffe8ec; padding: 4px 10px; border-radius: 20px; font-size: 12px;">{{ $booking->status }}</span>
                @endif
            </span>
        </div>
    </div>

    <!-- NOTICE -->
    <div style="background: #fff8e6; border: 1px solid #f0d58a; border-left: 5px solid #e0a900; border-radius: 12px; padding: 17px 18px; color: #725600; font-size: 13px; line-height: 1.7; margin-bottom: 25px;">
        <strong>⏳ Waiting for Manager Approval</strong><br>
        Your booking is not yet confirmed. Please wait for the manager to review and approve your reservation.
    </div>

    <!-- ACTION BUTTONS -->
    <div class="action-buttons">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">🏠 Back to Dashboard</a>
        <a href="/my-bookings" class="btn btn-primary">📋 View My Bookings</a>
    </div>

</div>

<!-- FOOTER -->
<footer>
    &copy; {{ date('Y') }} Otirasor Beach and Resort. All Rights Reserved.
</footer>

</body>
</html>