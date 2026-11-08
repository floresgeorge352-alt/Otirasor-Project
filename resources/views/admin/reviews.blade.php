<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Reviews - Otirasor Beach</title>
    
    {{-- Load Vite and Echo for Real-Time --}}
    @vite(['resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; min-height: 100vh; }
        h1, h2 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        nav { background: #023e8a; padding: 15px 6%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
        .brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: bold; }
        .brand img { width: 40px; height: 40px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        .nav-links { display: flex; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; }
        nav a:hover { text-decoration: underline; }

        .container { width: 1000px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 30px; font-size: 32px; }

        /* STAR FILTER BUTTONS */
        .filter-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }
        .filter-btn {
            background: white;
            color: #4b5563;
            padding: 10px 18px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid #d1d5db;
            transition: 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .filter-btn:hover {
            background: #f3f4f6;
            border-color: #9ca3af;
        }
        .filter-btn.active {
            background: #0077b6;
            color: white;
            border-color: #0077b6;
        }
        .filter-btn .count-badge {
            background: rgba(0,0,0,0.1);
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 12px;
        }
        .filter-btn.active .count-badge {
            background: rgba(255,255,255,0.25);
        }

        .review-grid { display: grid; gap: 20px; }
        .review-card {
            background: white; border: 1px solid #dce8ed; border-radius: 16px; padding: 25px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
        }
        .review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; border-bottom: 1px solid #edf1f5; padding-bottom: 15px; }
        .guest-info h3 { color: #023e8a; font-size: 18px; margin-bottom: 5px; }
        .guest-info p { color: #6b7280; font-size: 13px; }
        
        .rating-badge { background: #fffbeb; color: #92400e; padding: 8px 12px; border-radius: 20px; font-weight: 700; font-size: 14px; border: 1px solid #fde68a; }
        
        .comment-box { font-size: 15px; color: #4b5563; font-style: italic; line-height: 1.6; }

        .empty { background: white; padding: 50px; text-align: center; border-radius: 16px; color: #6b7280; }

        @media (max-width: 768px) {
            nav { flex-direction: column; gap: 10px; }
            .review-header { flex-direction: column; gap: 10px; }
            .filter-container { justify-content: flex-start; }
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
    <h1>⭐ Guest Reviews</h1>

    <!-- STAR FILTER BUTTONS -->
    <div class="filter-container">
        <!-- All Reviews Button -->
        <a href="/admin/reviews" class="filter-btn {{ !request('rating') ? 'active' : '' }}">
            All Reviews
        </a>

        <!-- 5 to 1 Star Buttons -->
        @foreach([5, 4, 3, 2, 1] as $star)
            <a href="/admin/reviews?rating={{ $star }}" class="filter-btn {{ request('rating') == $star ? 'active' : '' }}">
                {{ $star }} ⭐ 
                <span class="count-badge">{{ $starCounts[$star] }}</span>
            </a>
        @endforeach
    </div>

    <!-- REVIEWS LIST -->
    <div class="review-grid">
        @forelse($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="guest-info">
                        <h3>{{ $review->user->name ?? 'Unknown Guest' }}</h3>
                        <p>Booking #{{ $review->booking_id }} • {{ $review->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="rating-badge">
                        {{ str_repeat('⭐', $review->rating) }} ({{ $review->rating }}/5)
                    </div>
                </div>
                <div class="comment-box">
                    {{ $review->comment ? '"' . $review->comment . '"' : 'No comment provided.' }}
                </div>
            </div>
        @empty
            <div class="empty">
                <h2>No reviews found.</h2>
                <p>There are no reviews for this filter yet.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- REAL-TIME REVIEW LISTENER FOR ADMIN --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) return;

        window.Echo.channel('public.reviews')
            .listen('ReviewCreated', (e) => {
                console.log('New Review Received:', e);
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });
    });
</script>

</body>
</html>