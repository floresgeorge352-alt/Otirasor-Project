<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Otirasor Beach</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Load Vite and Echo for Real-Time --}}
    @vite(['resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f8fc;
            color: #243b4a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        /* NAVIGATION (Glassmorphism) */
        nav {
            background: rgba(0, 119, 182, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 15px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 18px;
            font-weight: 800;
            font-family: 'Montserrat', sans-serif;
        }

        .nav-brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 50%;
            background: white;
            padding: 2px;
        }

        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
        }
        .logout-btn:hover { color: #dff8ff; }

        /* MAIN CONTAINER */
        .container {
            width: 1100px;
            max-width: 92%;
            margin: 50px auto;
            flex: 1;
        }

        /* WELCOME CARD */
        .welcome-card {
            background: linear-gradient(135deg, #ffffff, #f0fbfd);
            border: 1px solid #dce8ed;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 25px;
            border-left: 6px solid #0077b6;
        }

        .welcome-logo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            border-radius: 50%;
            background: white;
            padding: 5px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 3px solid #0077b6;
        }

        .welcome-text h1 {
            color: #023e8a;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome-text p {
            color: #6c7a86;
            font-size: 15px;
            font-weight: 300;
        }

        /* DASHBOARD SUMMARY (UPDATED TO 4 COLUMNS) */
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .summary-card {
            background: white;
            border: 1px solid #dce8ed;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .summary-card .icon { font-size: 35px; margin-bottom: 15px; }
        .summary-card h3 { color: #6c7a86; font-size: 13px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; font-weight: 700; }
        .summary-card .value { color: #023e8a; font-size: 28px; font-weight: 800; }

        /* DASHBOARD CARDS (Book Now / My Bookings) */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .dash-card {
            background: white;
            border: 1px solid #dce8ed;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .dash-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .dash-icon {
            font-size: 40px;
            margin-bottom: 20px;
            background: #eaf8fc;
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
        }

        .dash-card h2 {
            color: #023e8a;
            font-size: 22px;
            margin-bottom: 10px;
        }

        .dash-card p {
            color: #6c7a86;
            font-size: 14px;
            font-weight: 300;
            margin-bottom: 25px;
            flex: 1;
        }

        .dash-btn {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, #0077b6, #00b4d8);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25);
            text-align: center;
            width: 100%;
        }

        .dash-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 119, 182, 0.35);
        }

        /* LATEST BOOKING STATUS */
        .latest-booking-card {
            background: white;
            border: 1px solid #dce8ed;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .latest-booking-card h2 {
            color: #023e8a;
            font-size: 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid #edf1f5;
            padding-bottom: 15px;
        }
        
        .booking-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .booking-info h4 {
            color: #1f2937;
            font-size: 16px;
            margin-bottom: 5px;
        }

        .booking-info p {
            color: #6b7280;
            font-size: 13px;
        }
        
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-pending { background: #fff4d8; color: #a36a00; }
        .status-confirmed { background: #e6f7ef; color: #147a4b; }
        .status-rejected { background: #ffe8ec; color: #b52d43; }
        .status-cancelled { background: #e5e7eb; color: #4b5563; }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 25px;
            background: #023e8a;
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            letter-spacing: 1px;
            margin-top: auto;
        }

        /* MOBILE */
        @media (max-width: 992px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            nav { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .nav-brand { justify-content: center; }
            nav .nav-links { width: 100%; justify-content: center; flex-wrap: wrap; }
            .welcome-card { flex-direction: column; text-align: center; padding: 30px 20px; }
            .dashboard-grid { grid-template-columns: 1fr; }
            .dash-card { align-items: center; text-align: center; }
            .summary-grid { grid-template-columns: 1fr; }
            .booking-item { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>
</head>
<body>

<!-- NAVIGATION -->
<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach
    </div>

    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/dashboard">Dashboard</a>
        <a href="/reviews">Reviews</a>
        
        <!-- NOTIFICATION BELL -->
        <a href="{{ route('customer.notifications') }}" style="position: relative; display: inline-flex; align-items: center;">
            🔔 Notifications
            <span id="customer-notification-badge" style="position: absolute; top: -8px; right: -10px; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold; {{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'display: none;' }}">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </a>

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- WELCOME CARD -->
    <div class="welcome-card">
        <div class="welcome-logo">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        </div>
        <div class="welcome-text">
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p>Welcome to your Otirasor Beach customer dashboard. Manage your bookings and explore our resort.</p>
        </div>
    </div>

    @php
        $userBookings = App\Models\Booking::where('user_id', Auth::id())->get();
        $totalBookings = $userBookings->count();
        $latestBooking = $userBookings->sortByDesc('created_at')->first();
        
        // Get average rating and total reviews for the Resort
        $averageRating = App\Models\Review::avg('rating') ?? 0;
        $totalReviews = App\Models\Review::count();
    @endphp

    <!-- SUMMARY CARDS -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="icon">📊</div>
            <h3>Total Bookings</h3>
            <div class="value">{{ $totalBookings }}</div>
        </div>
        
        <div class="summary-card">
            <div class="icon">🏖️</div>
            <h3>Book Now</h3>
            <div class="value" style="font-size: 15px; margin-top: 10px;">
                <a href="/accommodations" class="dash-btn">Reserve</a>
            </div>
        </div>
        
        <div class="summary-card">
            <div class="icon">📋</div>
            <h3>My Bookings</h3>
            <div class="value" style="font-size: 15px; margin-top: 10px;">
                <a href="/my-bookings" class="dash-btn" style="background: #f0ad4e;">View All</a>
            </div>
        </div>

        <!-- RESORT RATING CARD -->
        <div class="summary-card" style="border: 2px solid #fbbf24; background: #fffbeb;">
            <div class="icon">⭐</div>
            <h3>Resort Rating</h3>
            <div class="value" style="color: #d97706; font-size: 26px;">
                {{ number_format($averageRating, 1) }} / 5
            </div>
            <div style="font-size: 13px; color: #92400e; margin-top: 5px; margin-bottom: 15px;">
                Based on {{ $totalReviews }} reviews
            </div>
            <a href="/reviews" class="dash-btn" style="background: #f59e0b; padding: 8px 15px;">View Reviews</a>
        </div>
    </div>

    <!-- LATEST BOOKING STATUS -->
    <div class="latest-booking-card">
        <h2>📌 Latest Booking Status</h2>
        
        @if($latestBooking)
            <div class="booking-item">
                <div class="booking-info">
                    <h4>Booking #{{ $latestBooking->id }}</h4>
                    <p>
                        @if($latestBooking->accommodations && $latestBooking->accommodations->isNotEmpty())
                            {{ $latestBooking->accommodations->pluck('name')->join(', ') }}
                        @else
                            <em style="color: #9ca3af;">N/A (Old Booking)</em>
                        @endif
                    </p>
                </div>
                <div>
                    @if($latestBooking->status === 'Pending')
                        <span class="status status-pending">Pending</span>
                    @elseif($latestBooking->status === 'Confirmed')
                        <span class="status status-confirmed">Confirmed</span>
                    @elseif($latestBooking->status === 'Rejected')
                        <span class="status status-rejected">Rejected</span>
                    @else
                        <span class="status status-cancelled">{{ $latestBooking->status }}</span>
                    @endif
                </div>
            </div>
        @else
            <p style="color: #6c7a86; font-size: 14px;">You haven't made any bookings yet. <a href="/accommodations" style="color: #0077b6; font-weight: bold; text-decoration: none;">Book your first stay!</a></p>
        @endif
    </div>

</div>

<!-- FOOTER -->
<footer>
    &copy; {{ date('Y') }} Otirasor Beach. All Rights Reserved.
</footer>

{{-- REAL-TIME CUSTOMER NOTIFICATION LISTENER --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
            console.warn('Echo is not loaded. Real-time updates disabled.');
            return;
        }

        const userId = {{ auth()->id() }};
        const badge = document.getElementById('customer-notification-badge');

        // Listen to the customer's private channel
        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification) => {
                console.log('New notification:', notification);

                // Update the badge count
                if (badge) {
                    let count = parseInt(badge.textContent.trim()) || 0;
                    badge.textContent = count + 1;
                    badge.style.display = 'inline-block';
                }

                // Show the dynamic Toast Notification
                if (window.showToast) {
                    let toastTitle = 'Booking Update';
                    
                    // Dynamically check the notification message
                    if (notification.message) {
                        if (notification.message.toLowerCase().includes('confirmed')) {
                            toastTitle = 'Booking Confirmed!';
                        } else if (notification.message.toLowerCase().includes('rejected')) {
                            toastTitle = 'Booking Rejected!';
                        } else if (notification.message.toLowerCase().includes('cancelled')) {
                            toastTitle = 'Booking Cancelled!';
                        }
                    }

                    window.showToast(
                        toastTitle, 
                        notification.message || `Update for Booking #${notification.booking_id}`, 
                        '/my-bookings'
                    );
                }
            });
    });
</script>

</body>
</html>