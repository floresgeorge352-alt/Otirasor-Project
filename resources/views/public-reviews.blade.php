<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Reviews - Otirasor Beach Resort</title>
    
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

        .container { width: 900px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 20px; font-size: 32px; }

        /* SUMMARY CARD */
        .summary-card {
            background: white; border-radius: 16px; padding: 30px; text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 30px;
            border-top: 5px solid #0077b6;
        }
        .average-rating { font-size: 48px; font-weight: 800; color: #023e8a; margin-bottom: 5px; line-height: 1; }
        .stars-display { color: #fbbf24; font-size: 24px; margin-bottom: 10px; }
        .total-reviews { color: #6b7280; font-size: 14px; }

        /* FILTERS */
        .filter-container { display: flex; justify-content: center; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; }
        .filter-btn {
            background: white; color: #4b5563; padding: 8px 16px; border-radius: 30px; text-decoration: none;
            font-size: 13px; font-weight: 600; border: 1px solid #d1d5db; transition: 0.2s;
        }
        .filter-btn:hover, .filter-btn.active { background: #0077b6; color: white; border-color: #0077b6; }

        /* REVIEWS GRID */
        .review-grid { display: grid; gap: 20px; }
        .review-card {
            background: white; border: 1px solid #dce8ed; border-radius: 16px; padding: 25px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        }
        .review-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 15px; border-bottom: 1px solid #edf1f5; padding-bottom: 15px; }
        .guest-info h3 { color: #023e8a; font-size: 16px; margin-bottom: 5px; }
        .guest-info p { color: #6b7280; font-size: 12px; }
        .rating-badge { background: #fffbeb; color: #92400e; padding: 6px 12px; border-radius: 20px; font-weight: 700; font-size: 13px; border: 1px solid #fde68a; }
        .comment-box { font-size: 14px; color: #4b5563; font-style: italic; line-height: 1.6; }

        .empty { background: white; padding: 50px; text-align: center; border-radius: 16px; color: #6b7280; }

        @media (max-width: 768px) {
            nav { flex-direction: column; gap: 10px; }
            .review-header { flex-direction: column; gap: 10px; }
        }
    </style>
</head>
<body>

<nav>
    <div class="brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach Resort
    </div>
    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/gallery">Gallery</a>
        <a href="/reviews">Reviews</a>
        <a href="/contact">Contact</a>
    </div>
</nav>

<div class="container">
    <h1>Guest Reviews</h1>

    <!-- AVERAGE RATING SUMMARY -->
    <div class="summary-card">
        <div class="average-rating">{{ number_format($averageRating, 1) }}</div>
        <div class="stars-display">
            @for($i = 1; $i <= 5; $i++)
                @if($i <= round($averageRating))
                    ⭐
                @else
                    ☆
                @endif
            @endfor
        </div>
        <div class="total-reviews">Based on {{ $totalReviews }} customer reviews</div>
    </div>

    <!-- FILTERS -->
    <div class="filter-container">
        <a href="/reviews" class="filter-btn {{ !request('rating') ? 'active' : '' }}">All Reviews</a>
        @foreach([5, 4, 3, 2, 1] as $star)
            <a href="/reviews?rating={{ $star }}" class="filter-btn {{ request('rating') == $star ? 'active' : '' }}">
                {{ $star }} ⭐ ({{ $starCounts[$star] }})
            </a>
        @endforeach
    </div>

    <!-- REVIEWS LIST -->
    <div class="review-grid">
        @forelse($reviews as $review)
            <div class="review-card">
                <div class="review-header">
                    <div class="guest-info">
                        <h3>{{ $review->user->name ?? 'Guest' }}</h3>
                        <p>{{ $review->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="rating-badge">
                        {{ str_repeat('⭐', $review->rating) }} {{ $review->rating }}/5
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

{{-- REAL-TIME REVIEW LISTENER --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
            console.warn('Echo is not loaded.');
            return;
        }

        window.Echo.channel('public.reviews')
            .listen('ReviewCreated', (e) => {
                console.log('New Review Received:', e);
                
                // Reload the page to show the new review and update the average rating
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });
    });
</script>

</body>
</html>