<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Otirasor Beach and Resort - Booking</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        :root { --primary: #0077b6; --primary-dark: #005f8f; --secondary: #00b4d8; --dark: #023e8a; --light-blue: #eaf8fc; --white: #ffffff; --text: #243746; --muted: #6c7a86; --border: #dce8ed; --success-bg: #e9f8f0; --success: #168a52; --danger-bg: #fff0f0; --danger: #c0392b; --warning-bg: #fff8e6; --warning: #9a6a00; }
        body { font-family: 'Poppins', sans-serif; background: linear-gradient(180deg, #eaf9fd 0%, #f4fbfd 30%, #f7fbfc 100%); color: var(--text); min-height: 100vh; }
        h1, h2, h3, .brand-title { font-family: 'Montserrat', sans-serif; font-weight: 800; }
        nav { background: rgba(0, 119, 182, 0.95); backdrop-filter: blur(10px); padding: 12px 6%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(0, 119, 182, 0.15); position: sticky; top: 0; z-index: 100; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-logo { width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; filter: drop-shadow(0 3px 5px rgba(0,0,0,0.25)); }
        .brand-text { color: white; }
        .brand-title { font-size: 18px; line-height: 1.2; }
        .brand-subtitle { font-size: 11px; opacity: 0.85; margin-top: 4px; letter-spacing: 0.5px; }
        nav .nav-links { display: flex; align-items: center; gap: 15px; }
        nav a { color: white; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover { background: rgba(255,255,255,0.15); transform: translateY(-2px); }
        .page-header { max-width: 1000px; width: 92%; margin: 40px auto 25px; text-align: center; }
        .page-badge { display: inline-block; background: #dff6fb; color: var(--primary-dark); padding: 8px 16px; border-radius: 30px; font-size: 12px; font-weight: 700; margin-bottom: 15px; letter-spacing: 1px; }
        .page-header h1 { color: var(--dark); font-size: 36px; margin-bottom: 10px; }
        .page-header p { color: var(--muted); font-size: 16px; line-height: 1.6; font-weight: 300; }
        .container { width: 92%; max-width: 1000px; margin: 0 auto 60px; }
        .card { background: var(--white); border: 1px solid var(--border); border-radius: 20px; padding: 30px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(25, 72, 88, 0.06); }
        .section-heading { display: flex; align-items: center; gap: 15px; margin-bottom: 25px; border-bottom: 1px solid #edf2f4; padding-bottom: 15px; }
        .section-icon { width: 48px; height: 48px; border-radius: 12px; background: var(--light-blue); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; }
        .section-heading h2 { color: var(--dark); font-size: 22px; margin: 0; }
        .section-heading p { color: var(--muted); font-size: 13px; margin-top: 3px; font-weight: 300; }
        .error { background: var(--danger-bg); border: 1px solid #f2b8b5; color: var(--danger); padding: 16px 20px; border-radius: 12px; margin-bottom: 25px; font-size: 14px; }
        .error strong { display: block; margin-bottom: 8px; font-weight: 700; }
        .error p { margin: 4px 0; }
        .selected-box { background: linear-gradient(135deg, #effaff, #f7fdff); border: 1px solid #c9ebf4; border-radius: 15px; padding: 20px; }
        .selected-list { list-style: none; padding: 0; }
        .selected-item { display: flex; justify-content: space-between; align-items: center; gap: 15px; background: white; border: 1px solid #bfe4ed; padding: 15px 20px; border-radius: 12px; margin-bottom: 10px; }
        .selected-item:last-child { margin-bottom: 0; }
        .selected-item-name { color: var(--primary-dark); font-size: 15px; font-weight: 600; }
        .selected-item-price { color: var(--dark); font-size: 16px; font-weight: 800; white-space: nowrap; }
        .empty { text-align: center; padding: 20px; color: var(--muted); background: white; border-radius: 10px; font-size: 14px; }
        .date-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .date-item { background: #f8fcfd; border: 1px solid var(--border); padding: 20px; border-radius: 15px; }
        .date-label { display: block; color: var(--muted); font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
        .date-value { color: var(--dark); font-size: 18px; font-weight: 700; }
        .date-time { font-size: 13px; color: #0077b6; font-weight: 600; margin-top: 5px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .full-width { grid-column: 1 / -1; }
        .form-group { margin-bottom: 0; }
        label { display: block; color: #334e5c; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
        .required { color: #e05252; }
        input, select { width: 100%; height: 50px; padding: 0 15px; border: 1px solid var(--border); border-radius: 12px; background: #fbfdfe; color: var(--text); font-size: 15px; font-family: 'Poppins', sans-serif; outline: none; transition: 0.3s; }
        input:focus, select:focus { border-color: var(--secondary); background: white; box-shadow: 0 0 0 4px rgba(0,180,216,0.1); }
        input::placeholder { color: #9aa8b0; font-weight: 300; }
        input[type="file"] { height: auto; padding: 14px; cursor: pointer; background: white; }
        .upload-help { color: var(--muted); font-size: 12px; line-height: 1.5; margin-top: 8px; }
        .guest-section { grid-column: 1 / -1; background: linear-gradient(135deg, #f2fbfd, #ffffff); border: 1px solid #cfeaf0; border-radius: 16px; padding: 25px; }
        .guest-title { color: var(--dark); font-size: 16px; font-weight: 700; margin-bottom: 18px; font-family: 'Montserrat', sans-serif; }
        .guest-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .total-guests { margin-top: 20px; padding: 15px; border-radius: 12px; background: white; border: 1px solid #d9eaee; text-align: center; color: var(--muted); font-size: 14px; font-weight: 600; }
        .total-guests span { color: var(--primary); font-size: 20px; font-weight: 800; margin-left: 5px; }
        .facility-section { grid-column: 1 / -1; margin-top: 5px; }
        .facility-title { color: var(--dark); font-size: 16px; font-weight: 700; margin-bottom: 12px; font-family: 'Montserrat', sans-serif; }
        .facility-box { background: linear-gradient(135deg, #effaff, #f9fdff); border: 1px solid #bfe5ee; border-radius: 16px; padding: 25px; }
        .facility-description { color: var(--muted); font-size: 14px; line-height: 1.6; margin-bottom: 20px; }
        .entrance-box { background: white; border: 1px solid #dce8ed; border-radius: 12px; padding: 18px; margin-bottom: 20px; }
        .entrance-header { display: flex; justify-content: space-between; align-items: center; gap: 15px; }
        .entrance-header strong { color: var(--dark); font-size: 15px; }
        .entrance-header small { color: var(--muted); font-size: 13px; }
        .entrance-total { color: var(--primary); font-size: 20px; font-weight: 800; white-space: nowrap; }
        .pool-option { display: flex; align-items: flex-start; gap: 15px; padding: 18px; background: white; border: 1px solid #dce8ed; border-radius: 12px; cursor: pointer; transition: 0.3s; }
        .pool-option:hover { border-color: #9dd9e7; background: #fafdff; }
        .pool-option input[type="checkbox"] { width: 22px; height: 22px; flex-shrink: 0; margin-top: 2px; cursor: pointer; }
        .pool-option strong { color: var(--dark); font-size: 15px; }
        .pool-option small { color: var(--muted); font-size: 13px; }
        .pool-controls { display: none; margin-top: 20px; padding: 20px; background: #f8fcfd; border: 1px solid #d8e9ed; border-radius: 12px; }
        .pool-controls.active { display: block; }
        .pool-controls-title { color: var(--dark); font-size: 15px; font-weight: 700; margin-bottom: 15px; }
        .pool-count-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .pool-count-item { background: white; border: 1px solid var(--border); border-radius: 12px; padding: 15px; }
        .pool-count-item label { margin-bottom: 8px; }
        .pool-summary { margin-top: 20px; padding: 15px; background: white; border: 1px solid #bfe5ee; border-radius: 12px; }
        .pool-summary-row { display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 8px 0; }
        .pool-summary-row:not(:last-child) { border-bottom: 1px solid #edf2f4; }
        .pool-summary-row span:first-child { color: var(--muted); font-size: 14px; }
        .pool-summary-row strong { color: var(--dark); font-size: 15px; }
        .pool-total-row strong { color: var(--primary); font-size: 20px; }
        
        /* NEW SUMMARY TABLE */
        .summary-table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 10px; 
            margin-bottom: 20px; 
            table-layout: fixed; 
            word-wrap: break-word; 
        }
        .summary-table th { text-align: left; padding: 10px 0; color: var(--primary-dark); font-size: 13px; text-transform: uppercase; border-bottom: 2px solid var(--primary); }
        .summary-table td { padding: 12px 0; border-bottom: 1px dashed #edf1f5; font-size: 14px; color: var(--text); }
        .summary-table td:last-child { text-align: right; font-weight: 600; }
        .summary-table .subtotal-row td { background: #f8fbfd; font-weight: 700; color: var(--primary-dark); padding: 15px 10px; border-bottom: none; }
        .summary-table .discount-row td { color: #e63946; }

        .grand-total-preview { margin-top: 20px; padding: 25px; background: linear-gradient(135deg, var(--primary), #00a4cc); border-radius: 16px; display: flex; justify-content: space-between; align-items: center; gap: 15px; box-shadow: 0 8px 25px rgba(0,119,182,0.25); color: white; }
        .grand-total-preview span { font-size: 18px; font-weight: 800; font-family: 'Montserrat', sans-serif; }
        .grand-total-preview strong { font-size: 32px; font-weight: 900; white-space: nowrap; }

        .payment-section { grid-column: 1 / -1; margin-top: 5px; }
        .payment-title { color: var(--dark); font-size: 16px; font-weight: 700; margin-bottom: 12px; font-family: 'Montserrat', sans-serif; }
        .gcash-box { display: block; margin-top: 20px; padding: 25px; border-radius: 16px; background: linear-gradient(135deg, #effaff, #f9fdff); border: 1px solid #bfe5ee; }
        .gcash-header { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .gcash-icon { width: 48px; height: 48px; border-radius: 12px; background: #0077b6; color: white; display: flex; align-items: center; justify-content: center; font-size: 22px; font-weight: bold; }
        .gcash-header h3 { color: var(--dark); font-size: 19px; margin: 0; }
        .gcash-header p { color: var(--muted); font-size: 13px; margin-top: 3px; }
        .gcash-info { background: white; border: 1px solid #d8e9ed; border-radius: 12px; padding: 18px; margin-bottom: 20px; }
        .gcash-row { display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 10px 0; }
        .gcash-row:not(:last-child) { border-bottom: 1px solid #edf2f4; }
        .gcash-row span:first-child { color: var(--muted); font-size: 14px; }
        .gcash-row strong { color: var(--dark); font-size: 15px; }
        .proof-box { margin-top: 20px; background: white; border: 1px solid #d8e9ed; border-radius: 12px; padding: 20px; }
        .note { grid-column: 1 / -1; background: var(--warning-bg); border: 1px solid #f0d58a; padding: 20px; border-radius: 14px; color: #725600; font-size: 14px; line-height: 1.7; margin-top: 10px; }
        .note strong { color: #5f4800; }
        .button-area { grid-column: 1 / -1; margin-top: 10px; }
        .submit-btn { width: 100%; height: 55px; border: none; border-radius: 12px; background: linear-gradient(135deg, #0077b6, #00a4cc); color: white; cursor: pointer; font-size: 16px; font-weight: 700; font-family: 'Montserrat', sans-serif; box-shadow: 0 8px 20px rgba(0,119,182,0.25); transition: 0.3s; }
        .submit-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,119,182,0.35); }
        .back-btn { display: block; width: 100%; height: 52px; margin-top: 15px; padding: 15px; text-align: center; background: #f1f5f7; color: #52636d; text-decoration: none; border-radius: 12px; font-size: 15px; font-weight: 700; transition: 0.3s; }
        .back-btn:hover { background: #e5ecef; color: #263b45; }
        footer { text-align: center; color: #84939b; font-size: 13px; padding: 10px 20px 40px; }
        
        @media (max-width: 768px) { 
            nav { padding: 12px 20px; flex-direction: column; gap: 15px; text-align: center; } 
            .brand { justify-content: center; } 
            nav .nav-links { width: 100%; justify-content: center; flex-wrap: wrap; } 
            .page-header { margin-top: 30px; } 
            .page-header h1 { font-size: 30px; } 
            .card { padding: 20px; border-radius: 15px; } 
            .form-grid { grid-template-columns: 1fr; } 
            .full-width, .guest-section, .facility-section, .payment-section, .note, .button-area, .grand-total-preview { grid-column: auto; } 
            .guest-grid { grid-template-columns: 1fr; } 
            .pool-count-grid { grid-template-columns: 1fr; } 
            .date-grid { grid-template-columns: 1fr; } 
            .section-heading h2 { font-size: 19px; } 
            .gcash-row { align-items: flex-start; flex-direction: column; gap: 3px; } 
            .entrance-header, .facility-total-preview, .accommodation-total-preview, .grand-total-preview, .selected-item { align-items: flex-start; flex-direction: column; } 
            .summary-table td, .summary-table th { font-size: 13px; padding: 10px 0; }
            .grand-total-preview strong { font-size: 24px; }
        }
    </style>
</head>
<body>

<nav>
    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
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

<div class="page-header">
    <div class="page-badge">🌴 RESERVATION</div>
    <h1>Complete Your Booking</h1>
    <p>Provide your details below to submit your reservation at Otirasor Beach and Resort.</p>
    
    <div id="hold-timer-banner" style="display: none; margin: 20px auto 0; max-width: 500px; background: #fff3cd; border: 1px solid #ffc107; padding: 15px; border-radius: 12px; font-weight: 600; color: #856404;">
        ⏳ Your slots are reserved for: <span id="hold-countdown" style="font-family: monospace; font-size: 18px; font-weight: bold; color: #d93025;">15:00</span>
    </div>
</div>

<div class="container">
    @if ($errors->any())
        <div class="error">
            <strong>⚠ Please check the following:</strong>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    @if (session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    <!-- ACCOMMODATION CARD -->
    <div class="card">
        <div class="section-heading">
            <div class="section-icon">🏡</div>
            <div>
                <h2>Selected Accommodations</h2>
                <p>Your chosen accommodation and current price</p>
            </div>
        </div>
        <div class="selected-box">
            @if(count($accommodations) > 0)
                <ul class="selected-list">
                    @foreach($accommodations as $accommodation)
                        @php $selectedAccommodation = $selectedAccommodations->firstWhere('name', $accommodation); @endphp
                        <li class="selected-item">
                            <span class="selected-item-name">✓ {{ $accommodation }}</span>
                            <span class="selected-item-price">
                                @if($selectedAccommodation) ₱{{ number_format($selectedAccommodation->price, 2) }} @else Price unavailable @endif
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <div class="empty">No accommodation selected.</div>
            @endif
        </div>
    </div>

    <!-- DATES CARD -->
    <div class="card">
        <div class="section-heading">
            <div class="section-icon">📅</div>
            <div>
                <h2>Booking Dates & Time</h2>
                <p>Your selected check-in and check-out schedule</p>
            </div>
        </div>
        <div class="date-grid">
            <div class="date-item">
                <span class="date-label">Check-in</span>
                <div class="date-value">{{ $checkIn ? \Carbon\Carbon::parse($checkIn)->format('M d, Y') : 'Not selected' }}</div>
                @if($checkIn) <div class="date-time">Time: {{ (isset($roomType) && $roomType === 'day_use') ? '8:00 AM' : '2:00 PM' }}</div> @endif
            </div>
            <div class="date-item">
                <span class="date-label">Check-out</span>
                <div class="date-value">{{ $checkOut ? \Carbon\Carbon::parse($checkOut)->format('M d, Y') : 'Not selected' }}</div>
                @if($checkOut) <div class="date-time">Time: {{ (isset($roomType) && $roomType === 'day_use') ? '5:00 PM' : '12:00 NN (Noon)' }}</div> @endif
            </div>
        </div>
    </div>

    <!-- MAIN FORM CARD -->
    <div class="card">
        <div class="section-heading">
            <div class="section-icon">👤</div>
            <div>
                <h2>Guest Information</h2>
                <p>Please provide the information needed for your reservation</p>
            </div>
        </div>
        <form method="POST" action="/booking" enctype="multipart/form-data" id="booking_form">
            @csrf

            @foreach($accommodations as $accommodation)
                <input type="hidden" name="accommodations[]" value="{{ $accommodation }}">
            @endforeach

            <div class="form-grid">
                <!-- 1. GUEST DETAILS -->
                <div class="form-group">
                    <label for="guest_name">Guest Name <span class="required">*</span></label>
                    <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" placeholder="Enter guest name" required>
                </div>
                <div class="form-group">
                    <label for="contact_number">Contact Number <span class="required">*</span></label>
                    <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" placeholder="Enter contact number" required>
                </div>

                <div class="guest-section">
                    <div class="guest-title">👥 Number of Guests</div>
                    <div class="guest-grid">
                        <div class="form-group">
                            <label for="number_of_adults">Adults <span class="required">*</span></label>
                            <select id="number_of_adults" name="number_of_adults" required>
                                @for($i = 1; $i <= 50; $i++) <option value="{{ $i }}" {{ old('number_of_adults', 1) == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="number_of_kids">Kids</label>
                            <select id="number_of_kids" name="number_of_kids" required>
                                @for($i = 0; $i <= 50; $i++) <option value="{{ $i }}" {{ old('number_of_kids', 0) == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                            </select>
                        </div>
                    </div>
                    <div class="total-guests">Total Guests: <span id="total_guests">{{ old('number_of_adults', 1) + old('number_of_kids', 0) }}</span></div>
                    <input type="hidden" id="number_of_guests" name="number_of_guests" value="{{ old('number_of_adults', 1) + old('number_of_kids', 0) }}">
                </div>

                <div class="form-group">
                    <label for="check_in">Check-in Date <span class="required">*</span></label>
                    <input type="date" id="check_in" name="check_in" value="{{ old('check_in', $checkIn) }}" required>
                </div>
                <div class="form-group">
                    <label for="check_out">Check-out Date <span class="required">*</span></label>
                    <input type="date" id="check_out" name="check_out" value="{{ old('check_out', $checkOut) }}" required>
                </div>

                <!-- 2. BEACH & SWIMMING POOL -->
                <div class="facility-section">
                    <div class="facility-title">🏖️ Beach / Swimming Pool</div>
                    <div class="facility-box">
                        <p class="facility-description">Beach entrance is automatically included based on the number of guests. Swimming pool use is optional.</p>
                        
                        <div class="entrance-box">
                            <div class="entrance-header">
                                <div>
                                    <strong>🏖️ Beach Entrance</strong><br>
                                    <small>Adults ₱{{ number_format($entranceAdultFee, 2) }} • Kids ₱{{ number_format($entranceChildFee, 2) }} • Automatically charged</small>
                                </div>
                                <div class="entrance-total">₱<span id="entrance_total">0.00</span></div>
                            </div>
                        </div>
                        
                        <label class="pool-option">
                            <input type="checkbox" name="swimming_pool" value="1" id="swimming_pool" {{ old('swimming_pool') ? 'checked' : '' }}>
                            <span>
                                <strong>🏊 Add Swimming Pool</strong><br>
                                <small>Adult ₱{{ number_format($swimmingAdultFee, 2) }} • Kids ₱{{ number_format($swimmingChildFee, 2) }}</small>
                            </span>
                        </label>
                        
                        <div id="pool-controls" class="pool-controls {{ old('swimming_pool') ? 'active' : '' }}">
                            <div class="pool-controls-title">👥 Who will use the swimming pool?</div>
                            <div class="pool-count-grid">
                                <div class="pool-count-item">
                                    <label for="pool_adults">Adults Swimming</label>
                                    <select id="pool_adults" name="pool_adults">
                                        @for($i = 0; $i <= 50; $i++) <option value="{{ $i }}" {{ old('pool_adults', 0) == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                                    </select>
                                </div>
                                <div class="pool-count-item">
                                    <label for="pool_kids">Kids Swimming</label>
                                    <select id="pool_kids" name="pool_kids">
                                        @for($i = 0; $i <= 50; $i++) <option value="{{ $i }}" {{ old('pool_kids', 0) == $i ? 'selected' : '' }}>{{ $i }}</option> @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="pool-summary">
                                <div class="pool-summary-row"><span>Adult Pool Fee</span><strong>₱<span id="pool_adult_total">0.00</span></strong></div>
                                <div class="pool-summary-row"><span>Kids Pool Fee</span><strong>₱<span id="pool_kid_total">0.00</span></strong></div>
                                <div class="pool-summary-row pool-total-row"><span>Swimming Pool Total</span><strong>₱<span id="pool_total">0.00</span></strong></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. PROMO & REWARDS -->
                @if($hasActivePromos)
                <div class="payment-section" style="margin-bottom: 20px;">
                    <div class="payment-title">🎟️ Have a Promo Code?</div>
                    <div style="display: flex; gap: 10px; align-items: flex-start;">
                        <div style="flex: 1;">
                            <input type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}" 
                                   onkeydown="if(event.key === 'Enter'){ event.preventDefault(); applyPromo(); }" 
                                   placeholder="Enter promo code (e.g., OTIRASOR)" 
                                   style="width: 100%; height: 50px; padding: 0 15px; border: 1px solid var(--border); border-radius: 12px; font-family: 'Poppins', sans-serif;">
                        </div>
                        <button type="button" onclick="applyPromo()" style="height: 50px; padding: 0 25px; background: #0077b6; color: white; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: 'Poppins', sans-serif; transition: 0.3s; box-shadow: 0 4px 10px rgba(0,119,182,0.2);">
                            Apply
                        </button>
                    </div>
                    <div id="promo_message" style="margin-top: 5px; font-size: 13px; font-weight: 600;"></div>
                </div>
                @endif

                @if(auth()->check() && $userRewardPoints >= 100)
                <div class="payment-section" style="background: #f3e8ff; border: 1px solid #d8b4fe; padding: 20px; border-radius: 12px; margin-bottom: 20px;">
                    <div class="payment-title" style="color: #6b21a8; margin-bottom: 10px;">🎁 Reward Points</div>
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 600; color: #6b21a8;">
                        <input type="checkbox" name="use_rewards" id="use_rewards" value="1" checked style="width: 20px; height: 20px; accent-color: #8b5cf6;">
                        Use my {{ number_format($userRewardPoints) }} points (₱{{ number_format(($userRewardPoints / 100) * 5, 2) }} off)
                    </label>
                    <small style="display: block; color: #7e22ce; margin-top: 5px; margin-left: 30px;">
                        Uncheck to save your points for a future booking.
                    </small>
                </div>
                @endif

                <!-- 4. BOOKING SUMMARY (Dito makikita ang final amount bago magbayad) -->
                <div class="full-width" style="margin-top: 10px; background: #f8fbfd; padding: 25px; border-radius: 16px; border: 1px solid #dce8ed;">
                    <div class="section-heading" style="margin-bottom: 15px; border-bottom: none; padding-bottom: 0;">
                        <div class="section-icon">🧾</div>
                        <div>
                            <h2>Booking Summary</h2>
                            <p>Review your total amount before proceeding to payment</p>
                        </div>
                    </div>
                    
                    <table class="summary-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($accommodations as $accommodation)
                                @php $selected = $selectedAccommodations->firstWhere('name', $accommodation); @endphp
                                <tr>
                                    <td>🏠 {{ $accommodation }}</td>
                                    <td>₱{{ $selected ? number_format($selected->price, 2) : '0.00' }}</td>
                                </tr>
                            @endforeach

                            <tr>
                                <td>🌊 Beach Entrance</td>
                                <td>₱<span id="summary_beach_entrance">0.00</span></td>
                            </tr>

                            <tr>
                                <td>🏊 Swimming Pool</td>
                                <td>₱<span id="summary_pool_total">0.00</span></td>
                            </tr>

                            <tr class="subtotal-row">
                                <td>Subtotal</td>
                                <td>₱<span id="summary_subtotal">0.00</span></td>
                            </tr>

                            <tr class="discount-row" id="summary_promo_row" style="display: none;">
                                <td>🎟️ Promo Discount</td>
                                <td>- ₱<span id="summary_promo_discount">0.00</span></td>
                            </tr>
                            <tr class="discount-row" id="summary_rewards_row" style="display: none;">
                                <td>⭐ Rewards Discount</td>
                                <td>- ₱<span id="summary_rewards_discount">0.00</span></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="grand-total-preview">
                        <span>💰 Grand Total</span>
                        <strong>₱<span id="summary_grand_total">0.00</span></strong>
                    </div>
                </div>

                <!-- 5. GCASH PAYMENT (Huling step) -->
                <div class="payment-section" style="margin-top: 20px;">
                    <div class="payment-title">💳 Payment Method</div>
                    
                    <input type="hidden" name="payment_method" id="payment_method" value="GCash">

                    <div class="gcash-box" style="display: block;">
                        <div class="gcash-header">
                            <div class="gcash-icon">₱</div>
                            <div><h3>GCash Payment</h3><p>Send your payment using the account below.</p></div>
                        </div>
                        <div class="gcash-info">
                            <div class="gcash-row"><span>GCash Number</span><strong>09945598510</strong></div>
                            <div class="gcash-row"><span>Account Name</span><strong>Otirasor Beach</strong></div>
                        </div>
                        <div class="form-group">
                            <label for="gcash_reference">GCash Reference Number <span class="required">*</span></label>
                            <input type="text" id="gcash_reference" name="gcash_reference" value="{{ old('gcash_reference') }}" placeholder="Enter 13-digit reference number" maxlength="13" minlength="13" pattern="[0-9]{13}" inputmode="numeric" required>
                        </div>
                        <div class="proof-box">
                            <label for="gcash_proof">GCash Payment Proof <span class="required">*</span></label>
                            <input type="file" id="gcash_proof" name="gcash_proof" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required>
                            <div class="upload-help">Upload a screenshot or photo. Max: 5 MB.</div>
                        </div>
                    </div>
                </div>

                <div class="note">
                    <strong>Important:</strong> Your booking will be submitted as <strong>Pending</strong> and will still require manager approval before it becomes confirmed.
                </div>

                <div class="button-area">
                    <button type="submit" class="submit-btn">Continue Booking</button>
                    
                    <button type="button" id="cancel-hold-btn" onclick="cancelHold()" style="display: none; width: 100%; height: 52px; margin-top: 10px; background: #fff0f0; color: #c0392b; border: 1px solid #f2b8b5; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s;">
                        Cancel & Release Slot
                    </button>

                    <a href="/accommodations" class="back-btn">← Back to Accommodations</a>
                </div>
            </div>
        </form>
    </div>
</div>

<footer>
    © {{ date('Y') }} Otirasor Beach and Resort • Reservation System
</footer>

<script>
    const accommodationTotal = {{ (float) $accommodationTotal }};
    const beachAdultRate = {{ (float) $entranceAdultFee }};
    const beachKidRate = {{ (float) $entranceChildFee }};
    const poolAdultRate = {{ (float) $swimmingAdultFee }};
    const poolKidRate = {{ (float) $swimmingChildFee }};
    
    const userRewardPoints = {{ auth()->check() ? ($userRewardPoints ?? 0) : 0 }};
    const useRewardsCheckbox = document.getElementById('use_rewards');

    const adultsSelect  = document.getElementById('number_of_adults');
    const kidsSelect    = document.getElementById('number_of_kids');
    const totalGuestsEl = document.getElementById('total_guests');
    const hiddenGuests  = document.getElementById('number_of_guests');

    const entranceTotalEl  = document.getElementById('entrance_total');
    const poolTotalEl      = document.getElementById('pool_total');
    const poolAdultTotalEl = document.getElementById('pool_adult_total');
    const poolKidTotalEl   = document.getElementById('pool_kid_total');

    const poolCheckbox  = document.getElementById('swimming_pool');
    const poolControls  = document.getElementById('pool-controls');
    const poolAdultsSel = document.getElementById('pool_adults');
    const poolKidsSel   = document.getElementById('pool_kids');

    const promoInput   = document.getElementById('promo_code');
    const promoMessage = document.getElementById('promo_message');
    let appliedDiscountPercent = 0;

    function formatMoney(n) {
        return Number(n).toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function recalc() {
        const adults = parseInt(adultsSelect?.value || 0);
        const kids   = parseInt(kidsSelect?.value || 0);
        const total  = adults + kids;

        if (totalGuestsEl) totalGuestsEl.textContent = total;
        if (hiddenGuests)  hiddenGuests.value = total;

        const beachTotal = (adults * beachAdultRate) + (kids * beachKidRate);
        if (entranceTotalEl) entranceTotalEl.textContent = formatMoney(beachTotal);

        let poolAdults = 0;
        let poolKids   = 0;
        if (poolCheckbox && poolCheckbox.checked) {
            poolAdults = parseInt(poolAdultsSel?.value || 0);
            poolKids   = parseInt(poolKidsSel?.value || 0);
        }

        const poolAdultTotal = poolAdults * poolAdultRate;
        const poolKidTotal   = poolKids * poolKidRate;
        const poolTotal      = poolAdultTotal + poolKidTotal;

        if (poolAdultTotalEl) poolAdultTotalEl.textContent = formatMoney(poolAdultTotal);
        if (poolKidTotalEl)   poolKidTotalEl.textContent   = formatMoney(poolKidTotal);
        if (poolTotalEl)      poolTotalEl.textContent      = formatMoney(poolTotal);

        const subtotal = accommodationTotal + beachTotal + poolTotal;
        const promoDiscount = subtotal * (appliedDiscountPercent / 100);
        
        let rewardsDiscount = 0;
        if (useRewardsCheckbox && useRewardsCheckbox.checked && userRewardPoints >= 100) {
            rewardsDiscount = (userRewardPoints / 100) * 5;
        }

        const totalDiscount = Math.min(promoDiscount + rewardsDiscount, subtotal);
        const grandTotal = subtotal - totalDiscount;

        document.getElementById('summary_beach_entrance').textContent = formatMoney(beachTotal);
        document.getElementById('summary_pool_total').textContent = formatMoney(poolTotal);
        document.getElementById('summary_subtotal').textContent = formatMoney(subtotal);
        
        if (promoDiscount > 0) {
            document.getElementById('summary_promo_row').style.display = 'table-row';
            document.getElementById('summary_promo_discount').textContent = formatMoney(promoDiscount);
        } else {
            document.getElementById('summary_promo_row').style.display = 'none';
        }

        if (rewardsDiscount > 0) {
            document.getElementById('summary_rewards_row').style.display = 'table-row';
            document.getElementById('summary_rewards_discount').textContent = formatMoney(rewardsDiscount);
        } else {
            document.getElementById('summary_rewards_row').style.display = 'none';
        }

        document.getElementById('summary_grand_total').textContent = formatMoney(grandTotal);
    }

    function applyPromo() {
        const code = (promoInput?.value || '').trim().toUpperCase();
        if (!code) {
            appliedDiscountPercent = 0;
            if (promoMessage) promoMessage.textContent = '';
            recalc();
            return;
        }

        fetch('/check-promo?code=' + encodeURIComponent(code))
            .then(r => r.json())
            .then(data => {
                if (data.valid) {
                    appliedDiscountPercent = parseFloat(data.discount) || 0;
                    if (promoMessage) {
                        promoMessage.style.color = '#168a52';
                        promoMessage.textContent = '✓ Promo applied: ' + appliedDiscountPercent + '% off';
                    }
                } else {
                    appliedDiscountPercent = 0;
                    if (promoMessage) {
                        promoMessage.style.color = '#c0392b';
                        promoMessage.textContent = '✗ Invalid or expired promo code';
                    }
                }
                recalc();
            })
            .catch(() => {
                appliedDiscountPercent = 0;
                if (promoMessage) {
                    promoMessage.style.color = '#c0392b';
                    promoMessage.textContent = '✗ Could not verify promo code';
                }
                recalc();
            });
    }

    [adultsSelect, kidsSelect, poolAdultsSel, poolKidsSel].forEach(el => {
        if (el) el.addEventListener('change', recalc);
    });

    if (poolCheckbox && poolControls) {
        poolCheckbox.addEventListener('change', function () {
            if (this.checked) {
                poolControls.classList.add('active');
            } else {
                poolControls.classList.remove('active');
                if (poolAdultsSel) poolAdultsSel.value = 0;
                if (poolKidsSel)   poolKidsSel.value   = 0;
            }
            recalc();
        });
    }

    if (useRewardsCheckbox) useRewardsCheckbox.addEventListener('change', recalc);

    recalc();
    if (promoInput && promoInput.value.trim() !== '') applyPromo();

    let holdTimerInterval = null;
    let currentHoldId = null;

    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/active-hold')
            .then(res => res.json())
            .then(data => {
                if (data.active && data.hold) {
                    currentHoldId = data.hold.id;
                    const timerBanner = document.getElementById('hold-timer-banner');
                    const cancelBtn = document.getElementById('cancel-hold-btn');
                    if (timerBanner) timerBanner.style.display = 'block';
                    if (cancelBtn) cancelBtn.style.display = 'block';

                    const expiresAt = new Date(data.hold.expires_at).getTime();
                    
                    function updateTimer() {
                        const now = new Date().getTime();
                        const distance = expiresAt - now;

                        if (distance < 0) {
                            clearInterval(holdTimerInterval);
                            const countdownEl = document.getElementById('hold-countdown');
                            if (countdownEl) {
                                countdownEl.textContent = "EXPIRED";
                                countdownEl.style.color = "#c0392b";
                            }
                            alert('Your hold has expired. Please select your accommodations again.');
                            window.location.href = '/accommodations';
                            return;
                        }

                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        const countdownEl = document.getElementById('hold-countdown');
                        if (countdownEl) {
                            countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
                            if (minutes < 1) countdownEl.style.color = "#c0392b";
                        }
                    }

                    updateTimer();
                    holdTimerInterval = setInterval(updateTimer, 1000);
                }
            })
            .catch(err => console.error('Error fetching hold status:', err));
    });

    function cancelHold() {
        if (!currentHoldId) return;
        if (!confirm('Are you sure you want to cancel? Your slot will be released.')) return;

        fetch('/reservation-holds/' + currentHoldId, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            clearInterval(holdTimerInterval);
            window.location.href = '/accommodations';
        })
        .catch(err => {
            console.error('Cancel error:', err);
            alert('Could not release hold. Please try again.');
        });
    }
</script>
</body>
</html>