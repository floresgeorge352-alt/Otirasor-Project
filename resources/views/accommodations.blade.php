<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otirasor Beach and Resort - Book Now</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background: #f2fbfc; color: #243b4a; min-height: 100vh; }
        h1, h2, h3, .brand-title { font-family: 'Montserrat', sans-serif; }

        nav { background: rgba(0, 105, 148, 0.95); backdrop-filter: blur(10px); padding: 10px 55px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(0, 70, 100, 0.15); position: sticky; top: 0; z-index: 100; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand { display: flex; align-items: center; gap: 12px; color: white; }
        .brand-logo { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 3px 5px rgba(0,0,0,0.25)); }
        .brand-title { color: white; font-size: 19px; font-weight: 800; line-height: 1.2; }
        .brand-subtitle { color: rgba(255,255,255,0.85); font-size: 11px; margin-top: 3px; letter-spacing: 0.5px; }
        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }

        .page-hero { background: linear-gradient(135deg, #0077a8, #00a6c7); color: white; text-align: center; padding: 60px 20px 80px; position: relative; overflow: hidden; }
        .page-hero::before { content: "🌴"; position: absolute; left: 7%; top: 25px; font-size: 60px; opacity: 0.15; transform: rotate(-10deg); }
        .page-hero::after { content: "🌊"; position: absolute; right: 8%; bottom: 15px; font-size: 70px; opacity: 0.15; }
        .hero-icon { font-size: 45px; margin-bottom: 15px; }
        .page-hero h1 { font-size: 40px; margin-bottom: 15px; font-weight: 800; }
        .page-hero p { font-size: 17px; opacity: 0.9; max-width: 650px; margin: auto; line-height: 1.6; font-weight: 300; }

        .container { max-width: 1200px; margin: -40px auto 0; padding: 0 25px 60px; position: relative; z-index: 2; }
        .category-intro { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 40px rgba(0, 80, 100, 0.08); text-align: center; margin-bottom: 30px; }
        .category-intro h2 { color: #006994; font-size: 30px; margin-bottom: 10px; font-weight: 800; }
        .category-intro p { color: #6a7d87; font-size: 16px; font-weight: 300; }

        .selection-summary { background: linear-gradient(135deg, #e5f8f3, #effcf9); border: 1px solid #8edbc7; color: #126b59; padding: 18px 25px; border-radius: 14px; margin-bottom: 30px; text-align: center; font-weight: 600; box-shadow: 0 4px 15px rgba(0, 120, 100, 0.05); }
        #selectedCount { display: inline-flex; align-items: center; justify-content: center; min-width: 30px; height: 30px; padding: 0 10px; margin-left: 8px; border-radius: 20px; background: #008f73; color: white; font-weight: 700; }

        .category-buttons { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; margin-top: 30px; }
        .category-btn { border: none; border-radius: 20px; padding: 40px 20px; min-height: 200px; background: white; color: #006994; cursor: pointer; box-shadow: 0 8px 25px rgba(0, 70, 100, 0.06); transition: all 0.3s ease; position: relative; overflow: hidden; }
        .category-btn::after { content: ""; position: absolute; width: 100px; height: 100px; border-radius: 50%; background: #e7f8fb; right: -30px; bottom: -30px; transition: 0.3s; }
        .category-btn:hover { transform: translateY(-8px); background: linear-gradient(135deg, #0077a8, #00a6c7); color: white; box-shadow: 0 15px 35px rgba(0, 100, 140, 0.2); }
        .category-btn:hover::after { background: rgba(255,255,255,0.1); transform: scale(1.5); }
        .category-icon { display: block; font-size: 50px; margin-bottom: 15px; position: relative; z-index: 2; }
        .category-name { display: block; font-size: 22px; font-weight: 800; position: relative; z-index: 2; font-family: 'Montserrat', sans-serif; }
        .category-description { display: block; font-size: 14px; margin-top: 10px; opacity: 0.75; position: relative; z-index: 2; }

        .continue-area { text-align: center; margin-top: 40px; }
        .continue-btn { padding: 16px 40px; background: linear-gradient(135deg, #008f73, #00ad8a); color: white; border: none; border-radius: 50px; cursor: pointer; font-size: 16px; font-weight: 700; font-family: 'Montserrat', sans-serif; box-shadow: 0 8px 20px rgba(0, 130, 100, 0.25); transition: 0.3s; }
        .continue-btn:hover { transform: translateY(-4px); box-shadow: 0 12px 25px rgba(0, 130, 100, 0.35); }

        .back-btn { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 25px; padding: 12px 20px; background: white; color: #006994; text-decoration: none; border-radius: 10px; font-weight: 600; box-shadow: 0 3px 12px rgba(0, 70, 100, 0.08); transition: 0.3s; }
        .back-btn:hover { background: #006994; color: white; transform: translateX(-4px); }
        .category-title { text-align: center; color: #006994; margin: 10px 0 30px; font-size: 35px; font-weight: 800; }

        .room-type-box { max-width: 750px; margin: 0 auto 35px; background: white; padding: 30px; border-radius: 20px; box-shadow: 0 8px 25px rgba(0, 70, 100, 0.08); text-align: center; }
        .room-type-box h2 { color: #006994; font-size: 24px; margin-bottom: 10px; font-weight: 700; }
        .room-type-box p { color: #71818a; font-size: 15px; margin-bottom: 25px; }
        .room-type-buttons { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .room-type-btn { border: 2px solid #d7e8ed; background: #f8fcfd; color: #006994; padding: 20px; border-radius: 15px; cursor: pointer; font-size: 17px; font-weight: 700; transition: 0.3s; }
        .room-type-btn:hover { border-color: #00a6c7; transform: translateY(-3px); }
        .room-type-btn.active { background: linear-gradient(135deg, #0077a8, #00a6c7); border-color: #0077a8; color: white; box-shadow: 0 8px 20px rgba(0, 120, 160, 0.2); }
        .room-type-icon { display: block; font-size: 32px; margin-bottom: 8px; }

        .date-box, .search-box, .capacity-box, .date-summary { background: white; border-radius: 16px; box-shadow: 0 6px 20px rgba(0, 70, 100, 0.06); margin-bottom: 25px; }
        .date-box { max-width: 650px; margin: 0 auto 30px; padding: 35px; }
        .date-box-header { text-align: center; margin-bottom: 25px; }
        .date-box-header h2 { color: #006994; font-size: 24px; margin-bottom: 8px; font-weight: 700; }
        .date-box label { display: block; font-weight: 600; margin-bottom: 8px; color: #405864; font-size: 14px; }
        .date-box input { width: 100%; padding: 14px 15px; margin-bottom: 20px; border: 1px solid #d4e1e6; border-radius: 10px; font-size: 15px; background: #f9fcfd; color: #334e5a; outline: none; transition: 0.3s; font-family: 'Poppins', sans-serif; }
        .date-box input:focus { border-color: #00a6c7; box-shadow: 0 0 0 4px rgba(0,166,199,0.1); background: white; }
        .date-btn, .search-btn { width: 100%; padding: 15px; background: linear-gradient(135deg, #0077a8, #00a6c7); color: white; border: none; border-radius: 10px; cursor: pointer; font-weight: 700; font-size: 15px; font-family: 'Montserrat', sans-serif; transition: 0.3s; box-shadow: 0 5px 15px rgba(0, 120, 160, 0.2); }
        .date-btn:hover, .search-btn:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 120, 160, 0.3); }
        .date-error { color: #d93025; text-align: center; margin-top: 15px; font-weight: 600; font-size: 14px; }

        .date-summary { padding: 20px 25px; display: flex; justify-content: center; gap: 50px; flex-wrap: wrap; }
        .date-summary p { color: #516873; font-weight: 500; }
        .date-summary strong { color: #006994; font-weight: 700; }

        .search-box { padding: 20px; }
        .search-form { display: flex; gap: 12px; align-items: center; }
        .search-input { flex: 1; min-width: 0; padding: 14px 18px; border: 1px solid #d4e1e6; border-radius: 10px; font-size: 15px; background: #f9fcfd; color: #334e5a; outline: none; font-family: 'Poppins', sans-serif; transition: 0.3s; }
        .search-input:focus { border-color: #00a6c7; box-shadow: 0 0 0 4px rgba(0,166,199,0.1); background: white; }
        .search-btn { width: auto; padding: 14px 25px; }
        .clear-search { padding: 14px 20px; background: #edf5f7; color: #006994; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s; white-space: nowrap; }
        .clear-search:hover { background: #dceef2; }

        .capacity-box { padding: 25px; text-align: center; }
        .capacity-title { color: #006994; font-weight: 700; font-size: 17px; margin-bottom: 15px; font-family: 'Montserrat', sans-serif; }
        .capacity-buttons { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }
        .capacity-btn { padding: 12px 22px; border: 1px solid #d4e5e9; background: #f7fbfc; color: #006994; border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s; }
        .capacity-btn:hover { background: #e7f7fa; border-color: #00a6c7; transform: translateY(-2px); }
        .capacity-btn.active { background: linear-gradient(135deg, #0077a8, #00a6c7); border-color: #0077a8; color: white; box-shadow: 0 5px 15px rgba(0,120,160,0.15); }

        .results-info { color: #71818a; font-size: 15px; margin-bottom: 20px; text-align: center; }

        .rooms { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }
        .room { background: white; border-radius: 20px; overflow: hidden; border: 1px solid #e6f0f3; box-shadow: 0 8px 25px rgba(0, 70, 100, 0.06); transition: all 0.3s ease; }
        .room:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0, 70, 100, 0.12); }

        .room-image { width: 100%; height: 240px; background: #edf5f7; overflow: hidden; position: relative; }
        .room-image img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.5s ease; }
        .room:hover .room-image img { transform: scale(1.05); }
        .no-room-image { display: flex; align-items: center; justify-content: center; height: 100%; color: #7a8d96; font-size: 15px; }

        .room-content { padding: 25px; }
        .room h3 { color: #006994; margin-bottom: 12px; font-size: 22px; font-weight: 800; }
        .room-content p { line-height: 1.6; color: #667983; font-size: 14px; margin-bottom: 10px; font-weight: 300; }
        .price { font-size: 22px !important; font-weight: 800 !important; color: #008f73 !important; margin-top: 15px; margin-bottom: 5px; }
        
        .available { display: inline-block; background: #e5f8ef; color: #16805d !important; padding: 8px 14px; border-radius: 30px; font-weight: 700; font-size: 13px !important; }
        .maintenance { display: inline-block; background: #fff3cd; color: #856404 !important; padding: 8px 14px; border-radius: 30px; font-weight: 700; font-size: 13px !important; }
        .unavailable { display: inline-block; background: #e2e3e5; color: #383d41 !important; padding: 8px 14px; border-radius: 30px; font-weight: 700; font-size: 13px !important; }
        .booked { display: inline-block; background: #fff0f0; color: #d33b3b !important; padding: 8px 14px; border-radius: 30px; font-weight: 700; font-size: 13px !important; }

        .select-box { margin-top: 20px; padding-top: 20px; border-top: 1px solid #edf2f4; }
        .select-box label { display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 600; color: #006994; font-size: 15px; }
        .select-box input { appearance: none; width: 22px; height: 22px; border: 2px solid #9bb8c2; border-radius: 6px; cursor: pointer; position: relative; transition: 0.2s; background: white; }
        .select-box input:checked { background: #008f73; border-color: #008f73; }
        .select-box input:checked::after { content: "✓"; color: white; position: absolute; font-size: 14px; font-weight: bold; left: 4px; top: 0px; }

        .pagination-area { margin-top: 40px; display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
        .pagination-link { display: inline-flex; align-items: center; justify-content: center; min-width: 45px; height: 45px; padding: 0 15px; border-radius: 10px; background: white; color: #006994; text-decoration: none; font-weight: 700; border: 1px solid #d9e9ed; transition: 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .pagination-link:hover { background: #006994; color: white; border-color: #006994; }
        .pagination-link.active { background: linear-gradient(135deg, #0077a8, #00a6c7); color: white; border-color: #0077a8; }
        .pagination-link.disabled { color: #a4b4ba; background: #f1f5f6; cursor: not-allowed; border-color: transparent; }
        .empty { text-align: center; background: white; padding: 50px; border-radius: 20px; color: #667983; grid-column: 1 / -1; box-shadow: 0 8px 25px rgba(0, 70, 100, 0.06); }

        footer { text-align: center; padding: 30px; background: #034b63; color: rgba(255,255,255,0.8); margin-top: 40px; font-size: 13px; letter-spacing: 1px; }

        @media (max-width: 950px) { .rooms { grid-template-columns: repeat(2, 1fr); } .category-buttons { grid-template-columns: 1fr; } nav { padding: 10px 25px; } }
        @media (max-width: 600px) {
            nav { flex-direction: column; gap: 15px; text-align: center; padding: 15px 20px; }
            .brand { justify-content: center; }
            nav .nav-links { width: 100%; justify-content: center; }
            .page-hero { padding: 50px 20px 70px; }
            .page-hero h1 { font-size: 32px; }
            .container { padding: 0 15px 45px; }
            .rooms { grid-template-columns: 1fr; }
            .date-summary { flex-direction: column; gap: 15px; align-items: center; }
            .room-type-buttons { grid-template-columns: 1fr; }
            .search-form { flex-direction: column; }
            .search-input, .search-btn, .clear-search { width: 100%; }
            .capacity-buttons { flex-direction: column; }
            .capacity-btn { width: 100%; }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Beach and Resort Logo">
        </div>
        <div class="brand-text">
            <div class="brand-title">Otirasor Beach and Resort</div>
            <div class="brand-subtitle">Relax • Enjoy • Create Memories</div>
        </div>
    </div>

    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/accommodations">Book Now</a>
    </div>
</nav>

<section class="page-hero">
    <div class="hero-icon">🏖️</div>
    <h1>Plan Your Stay</h1>
    <p>Choose your preferred accommodation and select your dates for a relaxing stay at Otirasor Beach and Resort.</p>
</section>

<div class="container">
    @php
        $currentCategory = request('category', '');
        $roomType = request('room_type', 'day_use');
        $capacity = request('capacity', '');
        $selectedAccommodations = array_filter(explode(',', request('selected', '')));
        $search = request('search', '');
    @endphp

    @if($currentCategory === '')
        <div class="category-intro">
            <h2>What Would You Like to Book?</h2>
            <p>Select an accommodation category to explore your available options.</p>
        </div>

        <div class="selection-summary">
            Selected accommodations: <span id="selectedCount">{{ count($selectedAccommodations) }}</span>
        </div>

        <div class="category-buttons">
            <button type="button" class="category-btn" onclick="openCategory('rooms')">
                <span class="category-icon">🛏️</span>
                <span class="category-name">Rooms</span>
                <span class="category-description">Day Use & Overnight</span>
            </button>
            <button type="button" class="category-btn" onclick="openCategory('cottages')">
                <span class="category-icon">🏡</span>
                <span class="category-name">Cottages</span>
                <span class="category-description">Relax with family and friends</span>
            </button>
            <button type="button" class="category-btn" onclick="openCategory('halls')">
                <span class="category-icon">🎉</span>
                <span class="category-name">Function Halls</span>
                <span class="category-description">Perfect for gatherings and events</span>
            </button>
        </div>

        <div class="continue-area">
            <button type="button" class="continue-btn" onclick="goToBooking()">Continue to Booking →</button>
        </div>

    @else
        <div class="category-page">
            <a href="#" class="back-btn" onclick="goBackToCategories(event)">← Back to Categories</a>

            @if($currentCategory === 'rooms')
                <h1 class="category-title">🛏️ Rooms</h1>
                <div class="room-type-box">
                    <h2>Choose Your Room Type</h2>
                    <p>Select whether you want a Day Use or Overnight room.</p>
                    <div class="room-type-buttons">
                        <button type="button" class="room-type-btn {{ $roomType === 'day_use' ? 'active' : '' }}" onclick="changeRoomType('day_use')">
                            <span class="room-type-icon">☀️</span><small>Day stay</small>
                        </button>
                        <button type="button" class="room-type-btn {{ $roomType === 'overnight' ? 'active' : '' }}" onclick="changeRoomType('overnight')">
                            <span class="room-type-icon">🌙</span><small>Overnight stay</small>
                        </button>
                    </div>
                </div>
            @elseif($currentCategory === 'cottages')
                <h1 class="category-title">🏡 Cottages</h1>
            @elseif($currentCategory === 'halls')
                <h1 class="category-title">🎉 Function Halls</h1>
            @endif

            {{-- DATE SELECTION --}}
            @if(!$checkIn || !$checkOut)
                <div class="date-box">
                    <div class="date-box-header">
                        <h2>📅 Select Your Dates</h2>
                        <p>Choose your check-in and check-out dates.</p>
                    </div>
                    <form method="GET" action="/accommodations" onsubmit="return validateDateForm()">
                        <input type="hidden" name="category" value="{{ $currentCategory }}">
                        @if($currentCategory === 'rooms')
                            <input type="hidden" name="room_type" value="{{ $roomType }}">
                        @endif
                        @if($currentCategory === 'cottages' && $capacity !== '')
                            <input type="hidden" name="capacity" value="{{ $capacity }}">
                        @endif
                        @if(count($selectedAccommodations) > 0)
                            <input type="hidden" name="selected" value="{{ implode(',', $selectedAccommodations) }}">
                        @endif

                        <label for="check_in">Check-in Date</label>
                        <input type="text" id="check_in" name="check_in" value="{{ $checkIn }}" required placeholder="Select date">

                        <label for="check_out">Check-out Date</label>
                        <input type="text" id="check_out" name="check_out" value="{{ $checkOut }}" required placeholder="Select date">

                        <button type="submit" class="date-btn">Check Availability</button>
                        <div id="date-error" class="date-error"></div>
                    </form>
                </div>
            @else
                <div class="date-summary">
                    <p>📅 <strong>Check-in:</strong> {{ $checkIn }}</p>
                    <p>📅 <strong>Check-out:</strong> {{ $checkOut }}</p>
                </div>

                <div class="selection-summary">
                    Selected accommodations: <span id="selectedCount">{{ count($selectedAccommodations) }}</span>
                </div>

                @if($currentCategory === 'cottages')
                    <div class="capacity-box">
                        <div class="capacity-title">👥 Choose Cottage Capacity</div>
                        <div class="capacity-buttons">
                            <a href="{{ url('/accommodations') }}?category=cottages&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}" class="capacity-btn {{ $capacity === '' ? 'active' : '' }}">All Cottages</a>
                            <a href="{{ url('/accommodations') }}?category=cottages&capacity=15&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}" class="capacity-btn {{ $capacity === '15' ? 'active' : '' }}">15 Persons</a>
                            <a href="{{ url('/accommodations') }}?category=cottages&capacity=20&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}" class="capacity-btn {{ $capacity === '20' ? 'active' : '' }}">20 Persons</a>
                        </div>
                    </div>
                @endif

                <div class="search-box">
                    <form method="GET" action="/accommodations" class="search-form">
                        <input type="hidden" name="category" value="{{ $currentCategory }}">
                        @if($currentCategory === 'rooms')
                            <input type="hidden" name="room_type" value="{{ $roomType }}">
                        @endif
                        @if($currentCategory === 'cottages' && $capacity !== '')
                            <input type="hidden" name="capacity" value="{{ $capacity }}">
                        @endif
                        <input type="hidden" name="check_in" value="{{ $checkIn }}">
                        <input type="hidden" name="check_out" value="{{ $checkOut }}">
                        @if(count($selectedAccommodations) > 0)
                            <input type="hidden" name="selected" value="{{ implode(',', $selectedAccommodations) }}">
                        @endif

                        <input type="search" name="search" class="search-input" value="{{ $search }}" placeholder="🔎 Search accommodation..." autocomplete="off">
                        <button type="submit" class="search-btn">Search</button>

                        @if($search !== '')
                            <a href="{{ url('/accommodations') }}?category={{ urlencode($currentCategory) }}{{ $currentCategory === 'rooms' ? '&room_type=' . urlencode($roomType) : '' }}{{ $currentCategory === 'cottages' && $capacity !== '' ? '&capacity=' . urlencode($capacity) : '' }}&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}" class="clear-search">Clear</a>
                        @endif
                    </form>
                </div>

                @if($accommodations->total() > 0)
                    <div class="results-info">
                        Showing <strong>{{ $accommodations->firstItem() }}</strong> to <strong>{{ $accommodations->lastItem() }}</strong> of <strong>{{ $accommodations->total() }}</strong> accommodations
                        @if($search !== '') matching <strong>"{{ $search }}"</strong> @endif
                        @if($currentCategory === 'cottages' && $capacity !== '') · <strong>{{ $capacity }} persons</strong> @endif
                    </div>
                @endif

                <div class="rooms">
                    @forelse($accommodations as $accommodation)
                        <div class="room">
                            <div class="room-image">
                                @if(!empty($accommodation['image']))
                                    <img src="{{ asset('storage/' . $accommodation['image']) }}" alt="{{ $accommodation['name'] }}">
                                @else
                                    <div class="no-room-image">No photo available</div>
                                @endif
                            </div>

                            <div class="room-content">
                                <h3>{{ $accommodation['name'] }}</h3>
                                @if(!empty($accommodation['description']))
                                    <p>{{ $accommodation['description'] }}</p>
                                @endif
                                @if($accommodation['capacity'] > 0)
                                    <p>👥 Capacity: {{ $accommodation['capacity'] }} persons</p>
                                @endif

                                {{-- AMENITIES DISPLAY --}}
                                @if(!empty($accommodation['amenities']) && is_array($accommodation['amenities']))
                                    <div style="margin: 10px 0; font-size: 13px; color: #006994;">
                                        <strong>Amenities:</strong>
                                        @foreach($accommodation['amenities'] as $amenity)
                                            <span style="display: inline-block; background: #e6f7ff; padding: 3px 8px; border-radius: 12px; margin: 2px; font-size: 11px; border: 1px solid #bce0ed;">
                                                {{ $amenity }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="price">
                                    ₱{{ number_format($accommodation['price'], 2) }}
                                    @if($currentCategory === 'rooms' && $roomType === 'overnight') / night @endif
                                    @if($currentCategory === 'rooms' && $roomType === 'day_use') / day @endif
                                </p>

                                @if($accommodation['status'] == 'maintenance')
                                    <p class="maintenance">🚧 Under Maintenance</p>
                                    @if(!empty($accommodation['maintenance_reason']))
                                        <p style="font-size: 12px; color: #856404; margin-top: 5px;"><strong>Reason:</strong> {{ $accommodation['maintenance_reason'] }}</p>
                                    @endif
                                    @if(!empty($accommodation['maintenance_end']))
                                        <p style="font-size: 12px; color: #856404;"><strong>Returning on:</strong> {{ \Carbon\Carbon::parse($accommodation['maintenance_end'])->format('M d, Y') }}</p>
                                    @endif
                                @elseif($accommodation['status'] == 'unavailable')
                                    <p class="unavailable">❌ Unavailable</p>
                                @elseif(!$accommodation['available'])
                                    <p class="booked">✕ Already Booked</p>
                                @else
                                    <p class="available">✓ Available</p>
                                    <div class="select-box">
                                        <label>
                                            <input type="checkbox" name="accommodations[]" value="{{ $accommodation['name'] }}" @checked(in_array($accommodation['name'], $selectedAccommodations))>
                                            Select this accommodation
                                        </label>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty">
                            @if($search !== '')
                                <h3>No accommodations found</h3>
                                <p style="margin-top: 10px;">No accommodations matched your search for <strong>"{{ $search }}"</strong>.</p>
                                <div style="margin-top: 20px;">
                                    <a href="{{ url('/accommodations') }}?category={{ urlencode($currentCategory) }}{{ $currentCategory === 'rooms' ? '&room_type=' . urlencode($roomType) : '' }}{{ $currentCategory === 'cottages' && $capacity !== '' ? '&capacity=' . urlencode($capacity) : '' }}&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}" class="clear-search">Clear Search</a>
                                </div>
                            @elseif($currentCategory === 'rooms')
                                <h3>No rooms found</h3>
                                <p style="margin-top: 10px;">There are no {{ $roomType === 'day_use' ? 'Day Use' : 'Overnight' }} rooms available in the system yet.</p>
                            @elseif($currentCategory === 'cottages')
                                <h3>No cottages found</h3>
                                <p style="margin-top: 10px;">
                                    @if($capacity === '15') No 15-person cottages have been added yet.
                                    @elseif($capacity === '20') No 20-person cottages have been added yet.
                                    @else No cottages have been added yet. @endif
                                </p>
                            @else
                                <h3>No function halls found</h3>
                                <p style="margin-top: 10px;">No function halls have been added yet.</p>
                            @endif
                        </div>
                    @endforelse
                </div>

                @if($accommodations->hasPages())
                    <div class="pagination-area">
                        @if($accommodations->onFirstPage())
                            <span class="pagination-link disabled">← Previous</span>
                        @else
                            <a href="{{ $accommodations->previousPageUrl() }}" class="pagination-link">← Previous</a>
                        @endif

                        @foreach($accommodations->getUrlRange(max(1, $accommodations->currentPage() - 2), min($accommodations->lastPage(), $accommodations->currentPage() + 2)) as $page => $url)
                            @if($page == $accommodations->currentPage())
                                <span class="pagination-link active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                            @endif
                        @endforeach

                        @if($accommodations->hasMorePages())
                            <a href="{{ $accommodations->nextPageUrl() }}" class="pagination-link">Next →</a>
                        @else
                            <span class="pagination-link disabled">Next →</span>
                        @endif
                    </div>
                @endif

                <div class="continue-area">
                    <button type="button" class="continue-btn" onclick="goToBooking()">Continue to Booking →</button>
                </div>
            @endif
        </div>
    @endif
</div>

<footer>
    © 2026 Otirasor Beach and Resort · Enjoy your stay 🌊
</footer>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const fpCheckIn = flatpickr("#check_in", {
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
            onChange: function(selectedDates, dateStr) {
                if (selectedDates.length > 0) {
                    const nextDay = new Date(selectedDates[0]);
                    nextDay.setDate(nextDay.getDate() + 1);
                    fpCheckOut.set('minDate', nextDay);
                }
            }
        });

        const fpCheckOut = flatpickr("#check_out", {
            minDate: "today",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "F j, Y",
        });
    });

    function getSelected() {
        const params = new URLSearchParams(window.location.search);
        const selected = params.get('selected');
        if (!selected) return [];
        return selected.split(',').filter(Boolean);
    }

    function openCategory(category) {
        const params = new URLSearchParams(window.location.search);
        const checkIn = params.get('check_in');
        const checkOut = params.get('check_out');
        const selected = params.get('selected');

        let url = '/accommodations?category=' + encodeURIComponent(category);
        if (category === 'rooms') url += '&room_type=day_use';
        if (checkIn && checkOut) url += '&check_in=' + encodeURIComponent(checkIn) + '&check_out=' + encodeURIComponent(checkOut);
        if (selected) url += '&selected=' + encodeURIComponent(selected);

        window.location.href = url;
    }

    function changeRoomType(roomType) {
        const params = new URLSearchParams(window.location.search);
        const checkIn = params.get('check_in');
        const checkOut = params.get('check_out');
        const selected = params.get('selected');

        let url = '/accommodations?category=rooms&room_type=' + encodeURIComponent(roomType);
        if (checkIn && checkOut) url += '&check_in=' + encodeURIComponent(checkIn) + '&check_out=' + encodeURIComponent(checkOut);
        if (selected) url += '&selected=' + encodeURIComponent(selected);

        window.location.href = url;
    }

    function goBackToCategories(event) {
        event.preventDefault();
        const params = new URLSearchParams(window.location.search);
        const checkIn = params.get('check_in');
        const checkOut = params.get('check_out');
        const selected = params.get('selected');

        let query = [];
        if (checkIn) query.push('check_in=' + encodeURIComponent(checkIn));
        if (checkOut) query.push('check_out=' + encodeURIComponent(checkOut));
        if (selected) query.push('selected=' + encodeURIComponent(selected));

        let url = '/accommodations';
        if (query.length > 0) url += '?' + query.join('&');

        window.location.href = url;
    }

    document.addEventListener('change', function(event) {
        if (!event.target.matches('input[name="accommodations[]"]')) return;

        let selected = getSelected();
        const value = event.target.value;

        if (event.target.checked) {
            if (!selected.includes(value)) selected.push(value);
        } else {
            selected = selected.filter(function(item) { return item !== value; });
        }

        updateSelectedInUrl(selected);
    });

    function updateSelectedInUrl(selected) {
        const params = new URLSearchParams(window.location.search);
        if (selected.length > 0) params.set('selected', selected.join(','));
        else params.delete('selected');

        const newUrl = window.location.pathname + '?' + params.toString();
        window.history.replaceState({}, '', newUrl);
        updateSelectedCount(selected);
    }

    function updateSelectedCount(selected) {
        const elements = document.querySelectorAll('#selectedCount');
        elements.forEach(function(element) { element.textContent = selected.length; });
    }

    function validateDateForm() {
        const checkIn = document.getElementById('check_in').value;
        const checkOut = document.getElementById('check_out').value;
        const error = document.getElementById('date-error');
        error.textContent = '';

        if (!checkIn || !checkOut) {
            error.textContent = 'Please select check-in and check-out dates.';
            return false;
        }
        if (checkOut <= checkIn) {
            error.textContent = 'Check-out date must be after check-in date.';
            return false;
        }
        return true;
    }

    function goToBooking() {
        const selected = getSelected();
        if (selected.length === 0) {
            alert('Please select at least one available accommodation.');
            return;
        }

        const params = new URLSearchParams(window.location.search);
        const checkIn = params.get('check_in');
        const checkOut = params.get('check_out');

        if (!checkIn || !checkOut) {
            alert('Please choose a category and select your dates first.');
            return;
        }

        window.location.href = '/booking?accommodations=' + encodeURIComponent(selected.join(',')) + '&check_in=' + encodeURIComponent(checkIn) + '&check_out=' + encodeURIComponent(checkOut);
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selected = getSelected();
        updateSelectedCount(selected);
    });
</script>

</body>
</html>