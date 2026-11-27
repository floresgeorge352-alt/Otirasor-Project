<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Bookings - Otirasor Beach</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
@vite(['resources/js/app.js'])

<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Poppins',sans-serif;background:#f5f8fc;color:#243b4a}
h1,h2,h3,h4{font-family:'Montserrat',sans-serif}
nav{background:rgba(0,119,182,.97);padding:15px 50px;display:flex;justify-content:space-between;align-items:center;box-shadow:0 4px 20px rgba(0,0,0,.1);position:sticky;top:0;z-index:100}
.nav-brand{display:flex;align-items:center;gap:12px;color:white;font-size:18px;font-weight:800;font-family:'Montserrat',sans-serif}
.nav-brand img{width:45px;height:45px;object-fit:contain;border-radius:50%;background:white;padding:2px}
nav .nav-links{display:flex;align-items:center;gap:20px}
nav a{color:white;text-decoration:none;font-size:14px;font-weight:500}
.logout-btn{background:none;border:none;color:white;font-size:14px;cursor:pointer;font-family:'Poppins',sans-serif}
.container{width:min(1440px,94%);margin:42px auto 70px}
.container>h1{color:#023e8a;font-size:clamp(27px,3vw,36px);font-weight:800}
.message{padding:15px 20px;border-radius:10px;margin:20px 0;font-weight:600;font-size:14px}
.success{background:#ecfdf3;color:#166534;border:1px solid #bbf7d0}
.error{background:#fff1f2;color:#991b1b;border:1px solid #fecaca}
.booking-toolbar{display:flex;justify-content:space-between;align-items:flex-end;gap:22px;margin:26px 0 18px}
.booking-toolbar h2{color:#173b64;font-size:20px;margin-bottom:5px}
.booking-toolbar p{color:#718096;font-size:13px}
.booking-filters{display:flex;gap:10px;align-items:center}
.search-box{display:flex;align-items:center;gap:8px;background:white;border:1px solid #e2e8f0;border-radius:10px;padding:0 13px;min-width:260px;height:42px;color:#8492a6}
.search-box input{width:100%;border:0;outline:0;font:13px 'Poppins',sans-serif}
.booking-filters select{height:42px;padding:0 13px;border:1px solid #e2e8f0;border-radius:10px;background:white;font:13px 'Poppins',sans-serif}
.reservation-table-wrap{width:100%;overflow-x:auto;background:white;border:1px solid #e8eef5;border-radius:16px;box-shadow:0 8px 28px rgba(15,45,75,.06)}
.reservation-table{width:100%;min-width:1020px;border-collapse:separate;border-spacing:0;text-align:left}
.reservation-table thead th{background:#f1f5fa;color:#64748b;padding:16px 15px;font-size:11px;text-transform:uppercase;letter-spacing:.45px;white-space:nowrap;border-bottom:1px solid #e6edf5}
.reservation-table tbody .booking-row td{padding:17px 15px;color:#334155;font-size:12px;border-bottom:1px solid #edf1f6;vertical-align:middle;white-space:nowrap}
.reservation-table tbody .booking-row:hover td{background:#f8fbff}
.reservation-table td small{display:block;color:#8793a3;font-size:11px;margin-top:4px}
.booking-id{color:#174b7a;font-weight:700;font-size:13px}
.payment-method{font-weight:600}
.payment-state{position:relative;padding-left:12px}
.payment-state:before{content:'';position:absolute;left:0;top:6px;width:6px;height:6px;border-radius:50%;background:#94a3b8}
.status{display:inline-block;padding:6px 11px;border-radius:30px;font-size:10px;font-weight:700;text-transform:uppercase}
.pending{background:#fff4d8;color:#986300}
.confirmed{background:#e6f7ef;color:#147a4b}
.rejected{background:#ffe8ec;color:#b52d43}
.cancelled{background:#edf0f4;color:#586474}
.details-toggle{border:1px solid #dbe5ef;background:white;color:#1d5d91;padding:8px 11px;border-radius:8px;font:600 11px 'Poppins',sans-serif;cursor:pointer}
.details-toggle:hover{background:#edf6ff}
.booking-detail-row[hidden]{display:none!important}
/* FIX: removed backdrop-filter, it made the nested .modal-overlay position relative to this row instead of the screen */
.booking-detail-row:not([hidden]){display:block;position:fixed;inset:0;z-index:2000;overflow-y:auto;padding:25px 15px;background:rgba(12,32,55,.75)}
.booking-detail-row>td{display:block;width:100%;max-width:1000px;margin:10px auto;padding:0!important;background:transparent;border:0!important}
.booking-body{display:block;position:relative;padding:28px;border-radius:18px;background:#fff;box-shadow:0 22px 65px rgba(0,0,0,.24);animation:modalIn .22s ease}
@keyframes modalIn{from{opacity:0;transform:translateY(12px)}to{opacity:1;transform:translateY(0)}}
.detail-modal-heading{display:flex;align-items:center;justify-content:space-between;gap:15px;padding-bottom:18px;margin-bottom:22px;border-bottom:1px solid #e8eef5}
.detail-modal-heading h2{color:#123e68;font-size:21px}
.detail-modal-close{width:38px;height:38px;border:0;border-radius:50%;background:#f1f5f9;color:#475569;font-size:25px;cursor:pointer}
.detail-section{margin-top:22px}
.detail-section-title{display:flex;align-items:center;gap:9px;color:#174b7a;font-size:15px;font-weight:800;margin-bottom:13px}
.detail-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
.detail-card{padding:14px 16px;border:1px solid #e7edf4;border-radius:11px;background:#fbfdff;min-width:0}
.detail-card small{display:block;color:#8492a6;font-size:11px;margin-bottom:5px}
.detail-card strong{display:block;color:#243b4a;font-size:14px;overflow-wrap:anywhere}
.detail-card p{font-size:12px;color:#64748b;margin-top:5px}
.accommodation-card{display:flex;gap:17px;padding:15px;border:1px solid #e5edf5;border-radius:13px;margin-bottom:12px;background:#fbfdff}
.accommodation-card img{width:130px;height:105px;object-fit:cover;border-radius:10px;background:#edf2f7}
.accommodation-info{flex:1;min-width:0}
.accommodation-info h4{font-size:15px;color:#174b7a;margin-bottom:5px}
.accommodation-info p{font-size:12px;color:#64748b;margin:4px 0}
.amenities{display:flex;flex-wrap:wrap;gap:6px;margin-top:8px}
.amenity{font-size:10px;background:#eaf4fc;color:#1d5d91;padding:5px 9px;border-radius:20px}
.payment-table{width:100%;border-collapse:collapse;background:#fbfdff;border:1px solid #e7edf4;border-radius:10px;overflow:hidden}
.payment-table td{padding:11px 14px;font-size:13px;border-bottom:1px solid #edf1f6}
.payment-table td:last-child{text-align:right;font-weight:600;color:#243b4a}
.payment-table .grand-total td{background:#eaf4fc;color:#064b78;font-weight:800;font-size:15px}
.payment-history{border-left:2px solid #c9dceb;margin-left:8px;padding-left:18px}
.payment-log{position:relative;padding:0 0 17px}
.payment-log:before{content:'';position:absolute;left:-25px;top:5px;width:10px;height:10px;background:#1685bd;border-radius:50%;border:2px solid white;box-shadow:0 0 0 1px #1685bd}
.payment-log h4{font-size:13px;color:#174b7a}
.payment-log p{font-size:12px;color:#64748b;margin-top:3px}
.log-status{display:inline-block;padding:4px 8px;border-radius:15px;background:#eaf4fc;color:#1d5d91;font-size:10px;font-weight:700}
.proof-link{display:inline-block;margin-top:8px;color:#0876ad;font-size:12px;font-weight:700;text-decoration:none}
.info-box{padding:14px 16px;border-radius:11px;font-size:13px;margin-top:12px}
.info-blue{background:#eff8ff;border:1px solid #c9e5f7;color:#15547b}
.info-yellow{background:#fff8e8;border:1px solid #f0d79c;color:#856404}
.info-green{background:#ecfdf3;border:1px solid #bbf7d0;color:#166534}
.info-red{background:#fff1f2;border:1px solid #fecaca;color:#991b1b}
.action-buttons{margin-top:22px;display:flex;gap:10px;flex-wrap:wrap}
.receipt-btn,.request-btn,.review-btn,.invoice-btn,.refund-btn,.rewards-btn,.resubmit-btn{display:inline-block;padding:11px 17px;border:0;border-radius:8px;font-weight:700;font-size:12px;font-family:'Montserrat',sans-serif;cursor:pointer;text-decoration:none;text-align:center}
.receipt-btn{background:#0784bd;color:white}
.invoice-btn{background:#f59e0b;color:white}
.request-btn{background:#d99a32;color:white}
.review-btn{background:#fbbf24;color:#78350f}
.rewards-btn{background:#8b5cf6;color:white}
.refund-btn{background:#ef4444;color:white}
.resubmit-btn{background:#16a34a;color:white}
.resubmit-btn:hover{background:#15803d}
.cancel-form,.review-form,.refund-form{margin-top:15px;padding:18px;border-radius:12px}
.cancel-form{background:#fff8e8;border:1px solid #f0ad4e}
.review-form{background:#fffbeb;border:1px solid #fde68a}
.refund-form{background:#fef2f2;border:1px solid #fecaca}
.cancel-form label,.review-form label,.refund-form label{display:block;margin-bottom:8px;font-weight:700;font-size:13px}
.cancel-form textarea,.review-form textarea,.review-form select,.refund-form textarea{width:100%;padding:12px;border:1px solid #ccc;border-radius:8px;resize:vertical;font-family:'Poppins',sans-serif;font-size:13px}
.submit-request,.submit-review,.submit-refund{margin-top:12px;padding:11px 18px;color:white;border:0;border-radius:8px;cursor:pointer;font-weight:700}
.submit-request{background:#d99a32}
.submit-review{background:#f59e0b}
.submit-refund{background:#ef4444}
.cancellation-pending,.cancellation-rejected,.review-display,.rewards-applied-box,.refund-status-pending,.refund-status-approved,.refund-status-rejected{margin-top:13px;padding:14px;border-radius:10px;font-size:13px}
.cancellation-pending{background:#fff3cd;color:#856404;border:1px solid #ffeeba}
.cancellation-rejected{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}
.review-display{background:#f0fdf4;border:1px solid #bbf7d0}
.rewards-applied-box{background:#f3e8ff;border:1px solid #d8b4fe;color:#6b21a8}
.refund-status-pending{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
.refund-status-approved{background:#ecfdf3;color:#166534;border:1px solid #bbf7d0}
.refund-status-rejected{background:#f8d7da;color:#721c24;border:1px solid #f5c6cb}
.empty{background:white;padding:60px 30px;text-align:center;border-radius:16px;border:1px solid #e8eef5}
.empty h3{color:#023e8a;font-size:24px;margin-bottom:10px}
.empty p{color:#6b7280;margin-bottom:25px}
.back-btn{display:inline-block;padding:12px 25px;background:#0784bd;color:white;text-decoration:none;border-radius:8px;font-weight:700}
.pagination-area{margin-top:30px;display:flex;justify-content:center;gap:8px;flex-wrap:wrap}
.pagination-link{display:inline-flex;align-items:center;justify-content:center;min-width:40px;height:40px;padding:0 15px;border-radius:8px;background:white;color:#023e8a;text-decoration:none;font-weight:700;border:1px solid #dce8ed;font-size:14px}
.pagination-link.active{background:#0077b6;color:white}
.pagination-link.disabled{color:#adb5bd;background:#f8f9fa}
.modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:3000;justify-content:center;align-items:center}
.modal-overlay.active{display:flex}
.modal-content{background:white;border-radius:16px;width:90%;max-width:500px;padding:25px;box-shadow:0 10px 30px rgba(0,0,0,.2);position:relative}
.modal-close{position:absolute;top:12px;right:17px;font-size:24px;cursor:pointer;color:#6b7280;background:none;border:0}
.modal-content h3{color:#991b1b;margin-bottom:15px;font-size:19px}
.modal-content textarea{width:100%;padding:12px;border:1px solid #ccc;border-radius:8px;resize:vertical;font-family:'Poppins',sans-serif;margin-bottom:12px}
.modal-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:10px}
.modal-btn-cancel,.modal-btn-submit,.modal-btn-rewards{padding:10px 17px;border:0;border-radius:8px;font-weight:600;cursor:pointer}
.modal-btn-cancel{background:#e5e7eb;color:#374151}
.modal-btn-submit{background:#ef4444;color:white}
.modal-btn-rewards{background:#8b5cf6;color:white}
.proof-viewer{z-index:4000;background:rgba(0,0,0,.82)}
.proof-viewer-box{position:relative;width:min(900px,94vw);max-height:92vh;background:#fff;border-radius:14px;padding:14px;display:flex;flex-direction:column;box-shadow:0 20px 60px rgba(0,0,0,.4)}
.proof-viewer-bar{display:flex;justify-content:space-between;align-items:center;gap:10px;padding:2px 4px 12px}
.proof-viewer-bar strong{color:#174b7a;font-size:14px;font-family:'Montserrat',sans-serif}
.proof-viewer-actions{display:flex;gap:8px;align-items:center}
.proof-viewer-open{font-size:12px;font-weight:700;color:#0876ad;text-decoration:none;padding:8px 12px;border:1px solid #dbe5ef;border-radius:8px}
.proof-viewer-close{border:0;background:#ef4444;color:#fff;font-weight:700;font-size:13px;padding:9px 16px;border-radius:8px;cursor:pointer;font-family:'Poppins',sans-serif}
.proof-viewer-close:hover{background:#dc2626}
.proof-viewer-body{overflow:auto;display:flex;justify-content:center;align-items:flex-start;background:#f1f5f9;border-radius:10px;min-height:200px}
.proof-viewer-body img{max-width:100%;max-height:78vh;object-fit:contain}
.proof-viewer-body iframe{width:100%;height:78vh;border:0}
body.booking-modal-open{overflow:hidden}
@media(max-width:900px){.booking-toolbar{align-items:stretch;flex-direction:column}.booking-filters{width:100%}.search-box{flex:1;min-width:0}}
@media(max-width:768px){nav{padding:12px 20px;flex-direction:column;gap:10px}.nav-links{flex-wrap:wrap;justify-content:center}.detail-grid{grid-template-columns:1fr}.booking-body{padding:20px}.accommodation-card{flex-direction:column}.accommodation-card img{width:100%;height:170px}}
@media(max-width:600px){.container{margin:28px auto 45px}.booking-filters{flex-direction:column;align-items:stretch}.search-box,.booking-filters select{width:100%}.booking-detail-row{padding:10px 7px}.booking-detail-row>td{margin:5px auto}.booking-body{padding:16px}.detail-modal-heading h2{font-size:17px}}
</style>
</head>

<body>
<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach and Resort
    </div>
    <div class="nav-links">
        <a href="/">Dashboard</a>
        <a href="/accommodations">Book Now</a>
        <a href="/my-bookings">My Bookings</a>
        <a href="/my-requests">My Requests</a>
        <a href="/notifications">🔔 Notifications</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<div class="container">
<h1>My Bookings</h1>

@if(session('success'))
<div class="message success">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="message error">{{ session('error') }}</div>
@endif

@if($bookings->count())

<section class="booking-toolbar">
    <div>
        <h2>Your Reservations</h2>
        <p>Review your resort bookings and manage your reservations.</p>
    </div>
    <div class="booking-filters">
        <label class="search-box">
            <span>⌕</span>
            <input type="search" id="bookingSearch" placeholder="Search booking, accommodation...">
        </label>
        <select id="statusFilter">
            <option value="">All Statuses</option>
            <option value="Pending">Pending</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Rejected">Rejected</option>
            <option value="Cancelled">Cancelled</option>
            <option value="Pending Cancellation">Pending Cancellation</option>
        </select>
    </div>
</section>

<div class="reservation-table-wrap">
<table class="reservation-table">
<thead>
<tr>
    <th>Booking ID</th>
    <th>Accommodation</th>
    <th>Check-in</th>
    <th>Check-out</th>
    <th>Guests</th>
    <th>Payment</th>
    <th>Status</th>
    <th>Details</th>
</tr>
</thead>

<tbody id="bookingTableBody">
@foreach($bookings as $booking)

@php
    $accommodationRecords = $booking->relationLoaded('accommodations')
        ? $booking->getRelation('accommodations')
        : collect();

    $accommodationLabel = $booking->accommodations;
    $paymentLogs = $booking->paymentLogs ?? collect();

    $checkIn = $booking->check_in ? \Carbon\Carbon::parse($booking->check_in) : null;
    $checkOut = $booking->check_out ? \Carbon\Carbon::parse($booking->check_out) : null;
    $nights = ($checkIn && $checkOut) ? max(0, $checkIn->diffInDays($checkOut)) : 0;

    $accommodationTotal = (float) ($booking->accommodation_total ?? 0);
    $facilityTotal = (float) ($booking->facility_total ?? 0);
    $discountAmount = (float) ($booking->discount_amount ?? 0);
    $rewardDiscount = (float) ($booking->reward_discount ?? 0);
    $netTotal = $accommodationTotal + $facilityTotal - $discountAmount - $rewardDiscount;
@endphp

<tr class="booking-row"
    id="booking-card-{{ $booking->id }}"
    data-booking-status="{{ $booking->status }}"
    data-search="{{ strtolower('Booking '.$booking->id.' '.($booking->guest_name ?? '').' '.($accommodationLabel ?? '').' '.($booking->payment_method ?? '').' '.($booking->status ?? '')) }}">

    <td>
        <span class="booking-id">#{{ $booking->id }}</span>
        <small>{{ $booking->guest_name }}</small>
    </td>
    <td>{{ $accommodationLabel ?: 'N/A' }}</td>
    <td>{{ $checkIn ? $checkIn->format('M d, Y') : '—' }}</td>
    <td>{{ $checkOut ? $checkOut->format('M d, Y') : '—' }}</td>
    <td>{{ $booking->number_of_guests ?? 0 }}</td>
    <td>
        <span class="payment-method">{{ $booking->payment_method ?: '—' }}</span>
        <small class="payment-state">{{ $booking->payment_status ?: 'Unpaid' }}</small>
    </td>
    <td>
        @if($booking->status === 'Pending')
            <span class="status pending" id="status-{{ $booking->id }}">Pending</span>
        @elseif($booking->status === 'Confirmed')
            <span class="status confirmed" id="status-{{ $booking->id }}">Confirmed</span>
        @elseif($booking->status === 'Rejected')
            <span class="status rejected" id="status-{{ $booking->id }}">Rejected</span>
        @elseif($booking->status === 'Cancelled')
            <span class="status cancelled" id="status-{{ $booking->id }}">Cancelled</span>
        @elseif($booking->status === 'Pending Cancellation')
            <span class="status pending" id="status-{{ $booking->id }}">Pending Cancellation</span>
        @else
            <span class="status pending" id="status-{{ $booking->id }}">{{ $booking->status }}</span>
        @endif
    </td>
    <td>
        <button type="button" class="details-toggle"
            onclick="toggleBooking({{ $booking->id }})"
            aria-expanded="false"
            aria-controls="booking-details-{{ $booking->id }}">
            View details <span id="toggle-icon-{{ $booking->id }}">＋</span>
        </button>
    </td>
</tr>

<tr class="booking-detail-row" id="booking-details-{{ $booking->id }}" hidden>
<td colspan="8">
<div class="booking-body">

<div class="detail-modal-heading">
    <div>
        <h2>Reservation Details</h2>
        <small style="color:#8492a6">Booking Reference #{{ $booking->id }}</small>
    </div>
    <button type="button" class="detail-modal-close"
        onclick="toggleBooking({{ $booking->id }})"
        aria-label="Close booking details">&times;</button>
</div>

<div class="detail-section">
    <div class="detail-section-title">📋 Reservation Overview</div>
    <div class="detail-grid">
        <div class="detail-card">
            <small>Booking Reference</small>
            <strong>#{{ $booking->id }}</strong>
        </div>
        <div class="detail-card">
            <small>Booking Status</small>
            <strong>{{ $booking->status }}</strong>
        </div>
        <div class="detail-card">
            <small>Check-in Date</small>
            <strong>{{ $checkIn ? $checkIn->format('F d, Y') : '—' }}</strong>
        </div>
        <div class="detail-card">
            <small>Check-out Date</small>
            <strong>{{ $checkOut ? $checkOut->format('F d, Y') : '—' }}</strong>
        </div>
        <div class="detail-card">
            <small>Length of Stay</small>
            <strong>{{ $nights }} {{ $nights === 1 ? 'Night' : 'Nights' }}</strong>
        </div>
        <div class="detail-card">
            <small>Receipt Number</small>
            <strong>{{ $booking->receipt_number ?: 'Not yet generated' }}</strong>
        </div>
    </div>
</div>

<div class="detail-section">
    <div class="detail-section-title">🏡 Accommodation Details</div>

    @if($accommodationRecords->count())
        @foreach($accommodationRecords as $accommodation)
        <div class="accommodation-card">
            @if($accommodation->image)
                <img src="{{ asset('storage/' . $accommodation->image) }}"
                    alt="{{ $accommodation->name }}"
                    onerror="this.style.display='none'">
            @else
                <div style="width:130px;height:105px;display:grid;place-items:center;background:#edf2f7;border-radius:10px;color:#8492a6;font-size:12px">
                    No Image
                </div>
            @endif

            <div class="accommodation-info">
                <h4>{{ $accommodation->name }}</h4>
                <p><strong>Type:</strong> {{ $accommodation->type ?: ($accommodation->room_type ?: 'Not specified') }}</p>
                <p><strong>Capacity:</strong> {{ $accommodation->capacity ?? '—' }} guests</p>
                <p><strong>Price at Booking:</strong>
                    ₱{{ number_format((float) ($accommodation->pivot->price_at_booking ?? $accommodation->price ?? 0), 2) }}
                </p>
                @if($accommodation->description)
                    <p>{{ $accommodation->description }}</p>
                @endif

                @if(is_array($accommodation->amenities) && count($accommodation->amenities))
                    <div class="amenities">
                        @foreach($accommodation->amenities as $amenity)
                            <span class="amenity">{{ $amenity }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    @elseif($accommodationLabel)
        <div class="info-box info-blue">
            <strong>{{ $accommodationLabel }}</strong>
            <p style="margin-top:5px">Accommodation information is available, but detailed accommodation records are not linked to this booking.</p>
        </div>
    @else
        <div class="info-box info-yellow">
            Accommodation details are unavailable for this older booking.
        </div>
    @endif
</div>

<div class="detail-section">
    <div class="detail-section-title">👤 Guest Information</div>
    <div class="detail-grid">
        <div class="detail-card">
            <small>Guest Name</small>
            <strong>{{ $booking->guest_name ?: '—' }}</strong>
        </div>
        <div class="detail-card">
            <small>Contact Number</small>
            <strong>{{ $booking->contact_number ?: '—' }}</strong>
        </div>
        <div class="detail-card">
            <small>Adults</small>
            <strong>{{ $booking->number_of_adults ?? 0 }}</strong>
        </div>
        <div class="detail-card">
            <small>Kids</small>
            <strong>{{ $booking->number_of_kids ?? 0 }}</strong>
        </div>
        <div class="detail-card">
            <small>Total Guests</small>
            <strong>{{ $booking->number_of_guests ?? 0 }}</strong>
        </div>
        <div class="detail-card">
            <small>Booking Account</small>
            <strong>{{ auth()->user()->email }}</strong>
        </div>
    </div>
</div>

<div class="detail-section">
    <div class="detail-section-title">💳 Payment Breakdown</div>
    <table class="payment-table">
        <tr>
            <td>Accommodation Total</td>
            <td>₱{{ number_format($accommodationTotal, 2) }}</td>
        </tr>
        <tr>
            <td>Facility Total</td>
            <td>₱{{ number_format($facilityTotal, 2) }}</td>
        </tr>
        @if($discountAmount > 0)
        <tr>
            <td>Promo Discount</td>
            <td style="color:#15803d">− ₱{{ number_format($discountAmount, 2) }}</td>
        </tr>
        @endif
        @if($rewardDiscount > 0)
        <tr>
            <td>Rewards Discount</td>
            <td style="color:#15803d">− ₱{{ number_format($rewardDiscount, 2) }}</td>
        </tr>
        @endif
        <tr class="grand-total">
            <td>Net Total</td>
            <td>₱{{ number_format($netTotal, 2) }}</td>
        </tr>
    </table>

    @if($booking->promo_code)
        <div class="info-box info-blue">
            <strong>Promo Code:</strong> {{ $booking->promo_code }}
        </div>
    @endif
</div>

<div class="detail-section">
    <div class="detail-section-title">💰 Payment Information</div>
    <div class="detail-grid">
        <div class="detail-card">
            <small>Payment Method</small>
            <strong>{{ $booking->payment_method ?: 'Not specified' }}</strong>
        </div>
        <div class="detail-card">
            <small>Payment Status</small>
            <strong>{{ $booking->payment_status ?: 'Unpaid' }}</strong>
        </div>
        <div class="detail-card">
            <small>GCash Reference</small>
            <strong>{{ $booking->gcash_reference ?: '—' }}</strong>
        </div>
        <div class="detail-card">
            <small>Payment Amount</small>
            <strong>₱{{ number_format($netTotal, 2) }}</strong>
        </div>
    </div>

    @if($booking->gcash_proof)
        <div class="info-box info-blue">
            <strong>GCash Payment Proof</strong><br>
            <a class="proof-link"
                href="{{ asset('storage/' . $booking->gcash_proof) }}"
                target="_blank" rel="noopener"
                onclick="return openProofViewer(this.href)">
                View Uploaded Payment Proof ↗
            </a>
        </div>
    @endif

    @if($booking->payment_rejection_reason)
        <div class="info-box info-red">
            <strong>Payment Rejection Reason</strong>
            <p>{{ $booking->payment_rejection_reason }}</p>
        </div>
    @endif

    {{-- ============================================================ --}}
    {{-- RESUBMIT PAYMENT PROOF — shows when admin re-opened payment  --}}
    {{-- ============================================================ --}}
    @if($booking->payment_status === 'For Verification' && $booking->payment_method === 'GCash')
        <div class="info-box info-yellow" style="border-left:4px solid #f59e0b;">
            <strong>⚠️ Payment Needs Re-submission</strong>
            <p style="margin:8px 0;">Your payment was re-opened by the admin. Please upload a new proof of payment.</p>
            <button type="button" class="resubmit-btn"
                onclick="document.getElementById('resubmitModal-{{ $booking->id }}').classList.add('active')">
                📤 Resubmit Payment Proof
            </button>
        </div>

        {{-- Resubmit Proof Modal --}}
        <div class="modal-overlay" id="resubmitModal-{{ $booking->id }}">
            <div class="modal-content" style="border-top:4px solid #16a34a;">
                <button class="modal-close" type="button"
                    onclick="document.getElementById('resubmitModal-{{ $booking->id }}').classList.remove('active')">&times;</button>
                <h3 style="color:#166534;">📤 Resubmit Payment Proof</h3>
                <p style="font-size:13px;color:#4b5563;margin-bottom:15px;">
                    Booking <strong>#{{ $booking->id }}</strong> — Please upload your new GCash proof of payment.
                </p>

                <form action="{{ route('customer.payment.resubmit', $booking->id) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf

                    <label style="font-weight:700;margin-bottom:8px;display:block;">GCash Reference Number</label>
                    <input type="text" name="gcash_reference"
                        value="{{ $booking->gcash_reference }}"
                        required
                        style="width:100%;padding:12px;border:1px solid #ccc;border-radius:8px;margin-bottom:15px;font-family:'Poppins',sans-serif;font-size:13px;">

                    <label style="font-weight:700;margin-bottom:8px;display:block;">Proof of Payment (JPG / PNG / PDF)</label>
                    <input type="file" name="gcash_proof"
                        accept=".jpg,.jpeg,.png,.pdf"
                        required
                        style="width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-bottom:15px;font-family:'Poppins',sans-serif;font-size:13px;">

                    <div class="info-box info-blue">
                        <strong>Note:</strong> Max file size 5MB. Make sure the reference number and amount are clearly visible.
                    </div>

                    <div class="modal-actions">
                        <button type="button" class="modal-btn-cancel"
                            onclick="document.getElementById('resubmitModal-{{ $booking->id }}').classList.remove('active')">
                            Cancel
                        </button>
                        <button type="submit" class="modal-btn-rewards" style="background:#16a34a;">
                            Submit Proof
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>

<div class="detail-section">
    <div class="detail-section-title">🧾 Payment History</div>

    @if($paymentLogs->count())
        <div class="payment-history">
            @foreach($paymentLogs as $log)
            <div class="payment-log">
                <h4>{{ $log->payment_method ?: 'Payment Record' }}</h4>
                <p><span class="log-status">{{ $log->status }}</span></p>
                <p><strong>Reference:</strong> {{ $log->reference_number ?: '—' }}</p>
                @if($log->remarks)
                    <p><strong>Remarks:</strong> {{ $log->remarks }}</p>
                @endif
                <p><strong>Date:</strong> {{ $log->created_at ? $log->created_at->format('M d, Y h:i A') : '—' }}</p>
                @if(!empty($log->proof_path))
                    <a class="proof-link"
                        href="{{ asset('storage/' . $log->proof_path) }}"
                        target="_blank" rel="noopener"
                        onclick="return openProofViewer(this.href)">
                        📎 View Proof ↗
                    </a>
                @endif
            </div>
            @endforeach
        </div>
    @else
        <div class="info-box info-yellow">
            No payment history records are available for this booking yet.
        </div>
    @endif
</div>

@if(($booking->reward_points_used ?? 0) > 0)
<div class="detail-section">
    <div class="detail-section-title">🎁 Rewards Applied</div>
    <div class="rewards-applied-box">
        <strong>Rewards successfully applied to this booking.</strong>
        <p style="margin-top:7px">Points Used: {{ number_format($booking->reward_points_used) }}</p>
        <p>Rewards Discount: ₱{{ number_format($rewardDiscount, 2) }}</p>
    </div>
</div>
@endif

@if($booking->refund_status === 'Pending')
<div class="refund-status-pending">
    ⏳ Refund request pending. Waiting for admin approval.
    @if($booking->refund_request_reason)
        <p style="margin-top:7px"><strong>Your reason:</strong> {{ $booking->refund_request_reason }}</p>
    @endif
</div>
@elseif($booking->refund_status === 'Refunded')
<div class="refund-status-approved">
    <strong>✅ Refund Approved & Processed</strong>
    <p style="margin-top:7px">GCash Reference: {{ $booking->refund_reference ?: '—' }}</p>
    @if($booking->refunded_at)
        <p>Refund Date: {{ $booking->refunded_at->format('M d, Y h:i A') }}</p>
    @endif
    @if($booking->refund_message)
        <p>{{ $booking->refund_message }}</p>
    @endif
    @if($booking->refund_proof)
        <a class="proof-link" href="{{ asset('storage/' . $booking->refund_proof) }}" target="_blank" rel="noopener" onclick="return openProofViewer(this.href)">
            View Refund Proof ↗
        </a>
    @endif
</div>
@elseif($booking->refund_status === 'Rejected')
<div class="refund-status-rejected">
    ❌ Refund Request Rejected.
    @if($booking->refund_notes)
        <p style="margin-top:7px">Note: {{ $booking->refund_notes }}</p>
    @endif
</div>
@endif

@if($booking->cancellation_status === 'Pending')
<div class="info-box info-yellow">
    <strong>Cancellation Request Pending</strong>
    @if($booking->cancellation_reason)
        <p style="margin-top:5px">Reason: {{ $booking->cancellation_reason }}</p>
    @endif
    @if($booking->cancellation_requested_at)
        <p>Requested: {{ $booking->cancellation_requested_at->format('M d, Y h:i A') }}</p>
    @endif
</div>
@elseif($booking->cancellation_status === 'Rejected')
<div class="info-box info-red">
    <strong>Cancellation Request Rejected</strong>
</div>
@endif

<div class="detail-section">
    <div class="detail-section-title">⚙️ Booking Actions</div>
    <div class="action-buttons">

        @if($booking->status === 'Pending')
            <div class="info-box info-yellow" style="width:100%;margin:0">
                ⏳ Your booking is waiting for admin approval.
            </div>

            @if(($booking->reward_points_used ?? 0) == 0 && auth()->user()->reward_points >= 100)
                <button type="button" class="rewards-btn"
                    onclick="openRewardsModal({{ $booking->id }})">
                    🎁 Apply Rewards ({{ number_format(auth()->user()->reward_points) }} points available)
                </button>

                <div class="modal-overlay" id="rewardsModal-{{ $booking->id }}">
                    <div class="modal-content" style="border-top:4px solid #8b5cf6">
                        <button class="modal-close" type="button"
                            onclick="closeRewardsModal({{ $booking->id }})">&times;</button>
                        <h3 style="color:#6b21a8">🎁 Apply Rewards for Booking #{{ $booking->id }}</h3>
                        <p style="font-size:13px;color:#4b5563;margin-bottom:15px">
                            You have <strong>{{ number_format(auth()->user()->reward_points) }} points</strong> available.
                            <br><small>Conversion: 100 points = ₱5 discount</small>
                        </p>
                        <form method="POST" action="{{ route('customer.rewards.apply', $booking->id) }}">
                            @csrf
                            <label style="font-weight:700;margin-bottom:8px;display:block">Points to Use</label>
                            <input type="number" name="points_to_use" min="100"
                                max="{{ auth()->user()->reward_points }}"
                                value="{{ auth()->user()->reward_points }}"
                                step="100" required
                                style="width:100%;padding:12px;border:1px solid #ccc;border-radius:8px;margin-bottom:15px">
                            <div class="info-box info-blue">
                                <strong>Discount preview:</strong>
                                <span id="reward-preview-{{ $booking->id }}">
                                    ₱{{ number_format((auth()->user()->reward_points / 100) * 5, 2) }}
                                </span>
                            </div>
                            <div class="modal-actions">
                                <button type="button" class="modal-btn-cancel"
                                    onclick="closeRewardsModal({{ $booking->id }})">Cancel</button>
                                <button type="submit" class="modal-btn-rewards">Apply Rewards</button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif(($booking->reward_points_used ?? 0) > 0)
                <div class="rewards-applied-box" style="width:100%">
                    ✅ Rewards already applied to this booking.
                </div>
            @endif
        @endif

        @if($booking->status === 'Confirmed')
            <a href="{{ url('/my-bookings/'.$booking->id.'/receipt') }}" class="receipt-btn">
                View E-Receipt
            </a>
            <a href="{{ url('/my-bookings/'.$booking->id.'/invoice') }}" class="invoice-btn">
                Download Invoice
            </a>

            <div class="info-box info-yellow" style="width:100%">
                <strong>⚠️ Cancellation Policy</strong><br>
                • <strong>7+ days</strong> before check-in: 100% Refund<br>
                • <strong>3–6 days</strong> before check-in: 50% Refund<br>
                • <strong>Less than 3 days</strong>: No Refund
            </div>

            @if($booking->cancellation_status !== 'Pending')
            <details style="width:100%">
                <summary class="request-btn" style="display:inline-block;list-style:none">
                    ⚠️ Request Cancellation
                </summary>
                <form method="POST"
                    action="/my-bookings/{{ $booking->id }}/request-cancellation"
                    class="cancel-form">
                    @csrf
                    <label>Reason for Cancellation</label>
                    <textarea name="cancellation_reason"
                        placeholder="Please explain why you want to cancel..." required></textarea>
                    <button type="submit" class="submit-request">Submit Cancellation Request</button>
                </form>
            </details>
            @endif
        @endif

        @if($booking->payment_method === 'GCash'
            && $booking->payment_status === 'Verified'
            && in_array($booking->status, ['Confirmed', 'Checked Out', 'Cancelled', 'Pending Cancellation'])
            && $booking->refund_status !== 'Pending'
            && $booking->refund_status !== 'Refunded')

            <button type="button" class="refund-btn"
                onclick="openRefundModal({{ $booking->id }})">
                💸 Request Refund
            </button>

            <div class="modal-overlay" id="refundModal-{{ $booking->id }}">
                <div class="modal-content">
                    <button class="modal-close" type="button"
                        onclick="closeRefundModal({{ $booking->id }})">&times;</button>
                    <h3>Request Refund for Booking #{{ $booking->id }}</h3>
                    <form method="POST"
                        action="{{ route('customer.bookings.request-refund', $booking->id) }}">
                        @csrf
                        <label style="font-weight:700;margin-bottom:8px;display:block">Reason for Refund</label>
                        <textarea name="refund_request_reason" rows="4"
                            placeholder="Explain why you are requesting a refund..." required></textarea>
                        <div class="modal-actions">
                            <button type="button" class="modal-btn-cancel"
                                onclick="closeRefundModal({{ $booking->id }})">Cancel</button>
                            <button type="submit" class="modal-btn-submit">Submit Request</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        @if($booking->status === 'Confirmed')
            @if(!$booking->review)
                <details style="width:100%">
                    <summary class="review-btn" style="display:inline-block;list-style:none">
                        ⭐ Leave a Review
                    </summary>
                    <form method="POST" action="/my-bookings/{{ $booking->id }}/review" class="review-form">
                        @csrf
                        <label>Rating</label>
                        <select name="rating" required>
                            <option value="5">⭐⭐⭐⭐⭐ (Excellent)</option>
                            <option value="4">⭐⭐⭐⭐ (Very Good)</option>
                            <option value="3">⭐⭐⭐ (Good)</option>
                            <option value="2">⭐⭐ (Fair)</option>
                            <option value="1">⭐ (Poor)</option>
                        </select>
                        <label>Comment (Optional)</label>
                        <textarea name="comment" rows="3" placeholder="Tell us about your stay..."></textarea>
                        <button type="submit" class="submit-review">Submit Review</button>
                    </form>
                </details>
            @else
                <div class="review-display" style="width:100%">
                    <p style="font-weight:600;color:#166534">
                        ✅ You rated this stay: {{ str_repeat('⭐', $booking->review->rating) }}
                    </p>
                    @if($booking->review->comment)
                        <p style="margin-top:5px;font-size:13px;color:#4b5563">
                            "{{ $booking->review->comment }}"
                        </p>
                    @endif
                </div>
            @endif
        @endif

        @if($booking->status === 'Cancelled')
            <div class="info-box info-blue" style="width:100%">
                This booking has been cancelled.
            </div>
        @endif

        @if($booking->status === 'Rejected')
            <div class="info-box info-red" style="width:100%">
                This booking was rejected.
                @if($booking->rejection_reason)
                    <p style="margin-top:5px"><strong>Reason:</strong> {{ $booking->rejection_reason }}</p>
                @endif
            </div>
        @endif

    </div>
</div>

</div>
</td>
</tr>

@endforeach
</tbody>
</table>
</div>

@else
<div class="empty">
    <div style="font-size:35px;margin-bottom:15px">▤</div>
    <h3>No bookings found</h3>
    <p>You do not have any bookings yet. Explore our accommodations and make your first reservation.</p>
    <a href="/accommodations" class="back-btn">Explore Accommodations</a>
</div>
@endif

@if($bookings->hasPages())
<div class="pagination-area">
    @if($bookings->onFirstPage())
        <span class="pagination-link disabled">← Previous</span>
    @else
        <a href="{{ $bookings->previousPageUrl() }}" class="pagination-link">← Previous</a>
    @endif

    @foreach($bookings->getUrlRange(max(1,$bookings->currentPage()-2),min($bookings->lastPage(),$bookings->currentPage()+2)) as $page=>$url)
        @if($page == $bookings->currentPage())
            <span class="pagination-link active">{{ $page }}</span>
        @else
            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
        @endif
    @endforeach

    @if($bookings->hasMorePages())
        <a href="{{ $bookings->nextPageUrl() }}" class="pagination-link">Next →</a>
    @else
        <span class="pagination-link disabled">Next →</span>
    @endif
</div>
@endif

</div>

<!-- PROOF VIEWER -->
<div class="modal-overlay proof-viewer" id="proofViewer">
    <div class="proof-viewer-box">
        <div class="proof-viewer-bar">
            <strong>📎 Payment Proof</strong>
            <div class="proof-viewer-actions">
                <a id="proofViewerOpen" class="proof-viewer-open" href="#" target="_blank" rel="noopener">Open in new tab ↗</a>
                <button type="button" class="proof-viewer-close" onclick="closeProofViewer()">✕ Close</button>
            </div>
        </div>
        <div class="proof-viewer-body" id="proofViewerBody"></div>
    </div>
</div>

<script>
function openProofViewer(url) {
    const viewer = document.getElementById('proofViewer');
    const body = document.getElementById('proofViewerBody');
    const openLink = document.getElementById('proofViewerOpen');
    if (!viewer || !body) return true;

    body.innerHTML = '';
    const isPdf = /\.pdf($|\?)/i.test(url);
    const el = document.createElement(isPdf ? 'iframe' : 'img');
    el.src = url;
    if (!isPdf) el.alt = 'Payment proof';
    body.appendChild(el);

    if (openLink) openLink.href = url;
    viewer.classList.add('active');
    return false;
}

function closeProofViewer() {
    const viewer = document.getElementById('proofViewer');
    const body = document.getElementById('proofViewerBody');
    if (viewer) viewer.classList.remove('active');
    if (body) body.innerHTML = '';
}

document.getElementById('proofViewer')?.addEventListener('click', function(e) {
    if (e.target === this) closeProofViewer();
});

function toggleBooking(id) {
    const details = document.getElementById('booking-details-' + id);
    const button = document.querySelector('[aria-controls="booking-details-' + id + '"]');
    const icon = document.getElementById('toggle-icon-' + id);

    if (!details) return;

    const willOpen = details.hidden;

    document.querySelectorAll('.booking-detail-row:not([hidden])').forEach(row => {
        row.hidden = true;
    });

    document.querySelectorAll('.details-toggle[aria-expanded="true"]').forEach(btn => {
        btn.setAttribute('aria-expanded', 'false');
    });

    document.querySelectorAll('[id^="toggle-icon-"]').forEach(el => {
        el.textContent = '＋';
    });

    details.hidden = !willOpen;
    document.body.classList.toggle('booking-modal-open', willOpen);

    if (button) button.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    if (icon) icon.textContent = willOpen ? '−' : '＋';
}

document.addEventListener('click', function(event) {
    if (event.target.classList && event.target.classList.contains('booking-detail-row')) {
        const id = event.target.id.replace('booking-details-', '');
        toggleBooking(id);
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const viewer = document.getElementById('proofViewer');
        if (viewer && viewer.classList.contains('active')) {
            closeProofViewer();
            return;
        }

        const opened = document.querySelector('.booking-detail-row:not([hidden])');
        if (opened) toggleBooking(opened.id.replace('booking-details-', ''));

        document.querySelectorAll('.modal-overlay.active').forEach(modal => {
            modal.classList.remove('active');
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const search = document.getElementById('bookingSearch');
    const filter = document.getElementById('statusFilter');
    const rows = Array.from(document.querySelectorAll('.booking-row'));

    function filterBookings() {
        const term = (search?.value || '').trim().toLowerCase();
        const status = filter?.value || '';

        rows.forEach(row => {
            const matchesText = (row.dataset.search || '').includes(term);
            const matchesStatus = !status || row.dataset.bookingStatus === status;
            const visible = matchesText && matchesStatus;

            row.hidden = !visible;

            const id = row.id.replace('booking-card-', '');
            const detail = document.getElementById('booking-details-' + id);

            if (detail && !visible) {
                detail.hidden = true;
                document.body.classList.remove('booking-modal-open');

                const button = document.querySelector('[aria-controls="booking-details-' + id + '"]');
                if (button) button.setAttribute('aria-expanded', 'false');

                const icon = document.getElementById('toggle-icon-' + id);
                if (icon) icon.textContent = '＋';
            }
        });
    }

    search?.addEventListener('input', filterBookings);
    filter?.addEventListener('change', filterBookings);
});

function openRefundModal(id) {
    const modal = document.getElementById('refundModal-' + id);
    if (modal) modal.classList.add('active');
}

function closeRefundModal(id) {
    const modal = document.getElementById('refundModal-' + id);
    if (modal) modal.classList.remove('active');
}

function openRewardsModal(id) {
    const modal = document.getElementById('rewardsModal-' + id);
    if (modal) {
        modal.classList.add('active');
        attachRewardPreview(id);
    }
}

function closeRewardsModal(id) {
    const modal = document.getElementById('rewardsModal-' + id);
    if (modal) modal.classList.remove('active');
}

function attachRewardPreview(bookingId) {
    const modal = document.getElementById('rewardsModal-' + bookingId);
    if (!modal) return;

    const input = modal.querySelector('input[name="points_to_use"]');
    const preview = document.getElementById('reward-preview-' + bookingId);

    if (input && preview && !input.dataset.previewAttached) {
        input.dataset.previewAttached = 'true';

        input.addEventListener('input', function() {
            const points = parseInt(this.value) || 0;
            const discount = (points / 100) * 5;
            preview.textContent = '₱' + discount.toFixed(2);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (!window.Echo) {
        console.warn('Echo is not loaded.');
        return;
    }

    const userId = {{ auth()->id() }};

    window.Echo.private(`customer.${userId}`)
        .listen('BookingStatusUpdated', (e) => {
            console.log('Booking Status Updated:', e);

            const bookingCard = document.getElementById('booking-card-' + e.id);

            if (bookingCard) {
                const statusBadge = document.getElementById('status-' + e.id);

                if (statusBadge) {
                    statusBadge.textContent = e.status;
                    statusBadge.className = 'status';

                    if (e.status === 'Confirmed') {
                        statusBadge.classList.add('confirmed');
                    } else if (e.status === 'Rejected') {
                        statusBadge.classList.add('rejected');
                    } else if (e.status === 'Cancelled') {
                        statusBadge.classList.add('cancelled');
                    } else {
                        statusBadge.classList.add('pending');
                    }
                }

                bookingCard.dataset.bookingStatus = e.status;
                setTimeout(() => window.location.reload(), 1500);
            }
        });
});
</script>

</body>
</html>