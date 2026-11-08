<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Otirasor Beach</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; }

        nav { background: rgba(0, 119, 182, 0.95); backdrop-filter: blur(10px); padding: 15px 50px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); position: sticky; top: 0; z-index: 100; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
        .nav-brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: 800; font-family: 'Montserrat', sans-serif; }
        .nav-brand img { width: 45px; height: 45px; object-fit: contain; border-radius: 50%; background: white; padding: 2px; }
        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }
        .logout-btn { background: none; border: none; color: white; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif; transition: 0.3s; }
        .logout-btn:hover { color: #dff8ff; }

        .container { width: 1000px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 35px; font-size: 32px; font-weight: 800; }

        .message { padding: 15px 20px; border-radius: 10px; margin-bottom: 20px; font-weight: 600; font-size: 14px; }
        .success { background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fff1f2; color: #991b1b; border: 1px solid #fecaca; }

        .booking-card { background: white; margin-bottom: 15px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border-left: 6px solid #0077b6; overflow: hidden; }
        .booking-header { padding: 20px 30px; display: flex; justify-content: space-between; align-items: center; cursor: pointer; background: white; transition: background 0.2s; }
        .booking-header:hover { background: #f8fcfd; }
        .booking-header h3 { color: #0077b6; font-size: 20px; font-weight: 800; margin: 0; display: flex; align-items: center; gap: 10px; }
        .booking-header h3::before { content: '👆'; font-size: 16px; }
        .booking-body { display: none; padding: 0 30px 30px; border-top: 1px solid #edf1f5; }
        .booking-card.open .booking-body { display: block; animation: fadeIn 0.3s ease; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 20px 0; }
        .detail-item { font-size: 14px; color: #4b5563; }
        .detail-item strong { color: #1f2937; font-weight: 600; display: block; margin-bottom: 3px; }

        .guest-summary { background: #f8fcfd; border: 1px solid #dce8ed; padding: 15px 20px; border-radius: 12px; margin-bottom: 20px; }
        .guest-summary p { margin: 6px 0; font-size: 14px; color: #4b5563; }
        .total-guests { color: #0077b6; font-weight: 700; margin-top: 10px !important; padding-top: 10px; border-top: 1px dashed #b5d4e0; }

        .status { display: inline-block; padding: 8px 16px; border-radius: 30px; font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; }
        .pending { background: #fff4d8; color: #a36a00; }
        .confirmed { background: #e6f7ef; color: #147a4b; }
        .rejected { background: #ffe8ec; color: #b52d43; }
        .cancelled { background: #e5e7eb; color: #4b5563; }

        .action-buttons { margin-top: 20px; display: flex; gap: 12px; flex-wrap: wrap; }
        .receipt-btn, .request-btn, .review-btn, .invoice-btn, .refund-btn, .rewards-btn {
            display: inline-block; padding: 12px 24px; border: none; border-radius: 8px;
            font-weight: 700; font-size: 14px; font-family: 'Montserrat', sans-serif;
            cursor: pointer; transition: 0.3s; text-align: center; text-decoration: none;
        }
        .receipt-btn { background: linear-gradient(135deg, #0077b6, #00b4d8); color: white; box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25); }
        .receipt-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 119, 182, 0.35); }
        .invoice-btn { background: linear-gradient(135deg, #f59e0b, #fbbf24); color: white; box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25); }
        .invoice-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35); }
        .request-btn { background: #f0ad4e; color: white; box-shadow: 0 4px 15px rgba(240, 173, 78, 0.25); }
        .request-btn:hover { background: #ec971f; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(240, 173, 78, 0.35); }
        .review-btn { background: #fbbf24; color: #78350f; box-shadow: 0 4px 15px rgba(251, 191, 36, 0.25); }
        .review-btn:hover { background: #f59e0b; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(251, 191, 36, 0.35); }
        
        /* Rewards Button */
        .rewards-btn { background: linear-gradient(135deg, #8b5cf6, #a78bfa); color: white; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.25); }
        .rewards-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.35); }
        
        /* Refund Button */
        .refund-btn { background: #ef4444; color: white; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.25); }
        .refund-btn:hover { background: #dc2626; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.35); }

        .cancel-form, .review-form, .refund-form { margin-top: 20px; padding: 20px; border-radius: 12px; }
        .cancel-form { background: #fff8e8; border: 1px solid #f0ad4e; }
        .review-form { background: #fffbeb; border: 1px solid #fde68a; }
        .refund-form { background: #fef2f2; border: 1px solid #fecaca; }
        
        .cancel-form label, .review-form label, .refund-form label { display: block; margin-bottom: 10px; font-weight: 700; font-size: 14px; }
        .cancel-form label { color: #856404; }
        .review-form label { color: #92400e; }
        .refund-form label { color: #991b1b; }
        
        .cancel-form textarea, .review-form textarea, .review-form select, .refund-form textarea { width: 100%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; resize: vertical; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none; }
        .review-form select { margin-bottom: 15px; }

        .submit-request, .submit-review, .submit-refund { margin-top: 15px; padding: 12px 24px; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; font-family: 'Montserrat', sans-serif; transition: 0.3s; }
        .submit-request { background: #f0ad4e; }
        .submit-request:hover { background: #ec971f; }
        .submit-review { background: #f59e0b; }
        .submit-review:hover { background: #d97706; }
        .submit-refund { background: #ef4444; }
        .submit-refund:hover { background: #dc2626; }

        .cancellation-pending { margin-top: 20px; padding: 15px; background: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 10px; font-weight: 600; font-size: 14px; }
        .cancellation-rejected { margin-top: 20px; padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 10px; font-weight: 600; font-size: 14px; }
        .review-display { margin-top: 15px; padding: 15px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; }

        /* Rewards Applied Box */
        .rewards-applied-box { margin-top: 15px; padding: 15px; background: #f3e8ff; border: 1px solid #d8b4fe; border-radius: 10px; }
        .rewards-applied-box h4 { color: #6b21a8; font-size: 14px; margin-bottom: 5px; }
        .rewards-applied-box p { font-size: 13px; color: #7e22ce; margin: 3px 0; }

        /* Refund Status Badges */
        .refund-status-pending { margin-top: 15px; padding: 15px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; border-radius: 10px; font-weight: 600; font-size: 14px; }
        .refund-status-approved { margin-top: 15px; padding: 15px; background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; border-radius: 10px; font-weight: 600; font-size: 14px; }
        .refund-status-rejected { margin-top: 15px; padding: 15px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 10px; font-weight: 600; font-size: 14px; }

        .empty { background: white; padding: 60px 30px; text-align: center; border-radius: 16px; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05); }
        .empty h3 { color: #023e8a; font-size: 24px; margin-bottom: 10px; }
        .empty p { color: #6b7280; margin-bottom: 25px; }
        .back-btn { display: inline-block; padding: 12px 25px; background: linear-gradient(135deg, #0077b6, #00b4d8); color: white; text-decoration: none; border-radius: 8px; font-weight: 700; font-family: 'Montserrat', sans-serif; transition: 0.3s; box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25); }
        .back-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 119, 182, 0.35); }

        .pagination-area { margin-top: 30px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .pagination-link { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 15px; border-radius: 8px; background: white; color: #023e8a; text-decoration: none; font-weight: 700; border: 1px solid #dce8ed; transition: 0.2s; font-size: 14px; }
        .pagination-link:hover { background: #eaf8fc; border-color: #0077b6; }
        .pagination-link.active { background: #0077b6; color: white; border-color: #0077b6; }
        .pagination-link.disabled { color: #adb5bd; background: #f8f9fa; cursor: not-allowed; border-color: #e9ecef; }

        /* Modal Styles */
        .modal-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; justify-content: center; align-items: center; }
        .modal-overlay.active { display: flex; }
        .modal-content { background: white; border-radius: 16px; width: 90%; max-width: 500px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.2); position: relative; animation: slideDown 0.3s ease; }
        @keyframes slideDown { from { transform: translateY(-30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
        .modal-close { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: #6b7280; background: none; border: none; }
        .modal-content h3 { color: #991b1b; margin-bottom: 15px; font-size: 20px; }
        .modal-content textarea { width: 100%; padding: 15px; border: 1px solid #ccc; border-radius: 8px; resize: vertical; font-family: 'Poppins', sans-serif; font-size: 14px; outline: none; margin-bottom: 15px; }
        .modal-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 10px; }
        .modal-btn-cancel { background: #e5e7eb; color: #374151; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
        .modal-btn-submit { background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
        .modal-btn-submit:hover { background: #dc2626; }
        .modal-btn-rewards { background: #8b5cf6; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; }
        .modal-btn-rewards:hover { background: #7c3aed; }

        @media (max-width: 768px) {
            nav { padding: 12px 20px; flex-direction: column; gap: 10px; }
            .nav-links { flex-wrap: wrap; justify-content: center; }
            .details-grid { grid-template-columns: 1fr; }
            .booking-header { flex-direction: column; gap: 10px; align-items: flex-start; padding: 15px 20px; }
            .booking-body { padding: 0 20px 20px; }
            .modal-content { padding: 20px; }
        }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach and Resort
    </div>
    <div class="nav-links">
        <a href="/dashboard">Dashboard</a>
        <a href="/accommodations">Book Now</a>
        <a href="/my-bookings">My Bookings</a>
        <a href="/my-requests">My Requests</a>
        
        <a href="{{ route('customer.notifications') }}" style="position: relative; display: inline-flex; align-items: center;">
            🔔 Notifications
            @if(auth()->user()->unreadNotifications->count() > 0)
                <span style="position: absolute; top: -8px; right: -10px; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold;">
                    {{ auth()->user()->unreadNotifications->count() }}
                </span>
            @endif
        </a>

        <form method="POST" action="/logout" style="display:inline;">
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

    @if($bookings->count() > 0)
        @foreach($bookings as $booking)
            <div class="booking-card" id="booking-card-{{ $booking->id }}">
                <div class="booking-header" onclick="toggleBooking({{ $booking->id }})">
                    <h3>Booking #{{ $booking->id }}</h3>
                    
                    @if($booking->status === 'Pending')
                        <span class="status pending" id="status-{{ $booking->id }}">Pending</span>
                    @elseif($booking->status === 'Confirmed')
                        <span class="status confirmed" id="status-{{ $booking->id }}">Confirmed</span>
                    @elseif($booking->status === 'Rejected')
                        <span class="status rejected" id="status-{{ $booking->id }}">Rejected</span>
                    @elseif($booking->status === 'Cancelled')
                        <span class="status cancelled" id="status-{{ $booking->id }}">Cancelled</span>
                    @endif
                </div>

                <div class="booking-body">
                    <div class="details-grid">
                        <div class="detail-item">
                            <strong>Guest Name</strong>
                            {{ $booking->guest_name }}
                        </div>
                        <div class="detail-item">
                            <strong>Contact Number</strong>
                            {{ $booking->contact_number }}
                        </div>
                        <div class="detail-item">
                            <strong>Accommodation</strong>
                            @if($booking->accommodations && $booking->accommodations->isNotEmpty())
                                {{ $booking->accommodations->pluck('name')->join(', ') }}
                            @else
                                <em style="color: #9ca3af;">N/A (Old Booking)</em>
                            @endif
                        </div>
                        <div class="detail-item">
                            <strong>Payment Method</strong>
                            {{ $booking->payment_method }} 
                            @if($booking->payment_method === 'GCash') (Ref: {{ $booking->gcash_reference }}) @endif
                        </div>
                        <div class="detail-item">
                            <strong>Check-in</strong>
                            {{ \Carbon\Carbon::parse($booking->check_in)->format('M d, Y') }}
                        </div>
                        <div class="detail-item">
                            <strong>Check-out</strong>
                            {{ \Carbon\Carbon::parse($booking->check_out)->format('M d, Y') }}
                        </div>
                    </div>

                    <div class="guest-summary">
                        <p><strong>Adults:</strong> {{ $booking->number_of_adults }}</p>
                        <p><strong>Kids:</strong> {{ $booking->number_of_kids }}</p>
                        <p class="total-guests">Total Guests: {{ $booking->number_of_guests }}</p>
                    </div>

                    <!-- REWARDS APPLIED BOX -->
                    @if($booking->reward_points_used > 0)
                        <div class="rewards-applied-box">
                            <h4>🎁 Rewards Applied</h4>
                            <p><strong>Points Used:</strong> {{ number_format($booking->reward_points_used) }}</p>
                            <p><strong>Discount:</strong> - ₱{{ number_format($booking->reward_discount, 2) }}</p>
                        </div>
                    @endif

                    <!-- REFUND STATUS INDICATORS -->
                    @if($booking->refund_status === 'Pending')
                        <div class="refund-status-pending">
                            ⏳ Refund Request Pending. Waiting for admin approval.
                        </div>
                    @elseif($booking->refund_status === 'Refunded')
                        <div class="refund-status-approved">
                            <strong>✅ Refund Approved & Processed</strong><br>
                            <span style="font-size: 14px;">GCash Ref No: <strong>{{ $booking->refund_reference }}</strong></span>
                            @if($booking->refund_message)
                                <br><span style="font-size: 14px; font-style: italic;">"{{ $booking->refund_message }}"</span>
                            @endif
                        </div>
                    @elseif($booking->refund_status === 'Rejected')
                        <div class="refund-status-rejected">
                            ❌ Refund Request Rejected.
                            @if($booking->refund_notes)
                                <br><small>Note: {{ $booking->refund_notes }}</small>
                            @endif
                        </div>
                    @endif

                    <div class="action-buttons">
                        @if($booking->status === 'Pending')
                            <div class="cancellation-pending" style="margin:0; width:100%;">
                                ⏳ Your booking is waiting for admin approval.
                            </div>

                            <!-- APPLY REWARDS BUTTON -->
                            @if(($booking->reward_points_used ?? 0) == 0 && auth()->user()->reward_points >= 100)
                                <button type="button" class="rewards-btn" onclick="openRewardsModal({{ $booking->id }})">
                                    🎁 Apply Rewards ({{ number_format(auth()->user()->reward_points) }} points available)
                                </button>

                                <!-- REWARDS MODAL -->
                                <div class="modal-overlay" id="rewardsModal-{{ $booking->id }}">
                                    <div class="modal-content" style="border-top: 4px solid #8b5cf6;">
                                        <button class="modal-close" onclick="closeRewardsModal({{ $booking->id }})">&times;</button>
                                        <h3 style="color: #6b21a8;">🎁 Apply Rewards for Booking #{{ $booking->id }}</h3>
                                        
                                        <p style="font-size: 14px; color: #4b5563; margin-bottom: 15px;">
                                            You have <strong style="color: #8b5cf6;">{{ number_format(auth()->user()->reward_points) }} points</strong> available.<br>
                                            <small style="color: #6b7280;">Conversion: 100 points = ₱5 discount</small>
                                        </p>

                                        <form method="POST" action="{{ route('customer.rewards.apply', $booking->id) }}">
                                            @csrf
                                            <label style="color: #6b21a8; font-weight: 700; margin-bottom: 8px; display: block;">Points to Use (min: 100)</label>
                                            <input type="number" name="points_to_use" min="100" max="{{ auth()->user()->reward_points }}" value="{{ auth()->user()->reward_points }}" step="100" required style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; margin-bottom: 15px;">
                                            
                                            <div style="background: #f3e8ff; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                                                <p style="font-size: 13px; color: #6b21a8; margin: 0;">
                                                    <strong>Discount preview:</strong> <span id="reward-preview-{{ $booking->id }}">₱{{ number_format((auth()->user()->reward_points / 100) * 5, 2) }}</span>
                                                </p>
                                            </div>

                                            <div class="modal-actions">
                                                <button type="button" class="modal-btn-cancel" onclick="closeRewardsModal({{ $booking->id }})">Cancel</button>
                                                <button type="submit" class="modal-btn-rewards">Apply Rewards</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif($booking->reward_points_used > 0)
                                <div class="rewards-applied-box" style="width: 100%; margin: 0;">
                                    ✅ Rewards already applied to this booking.
                                </div>
                            @endif
                        @endif

                        @if($booking->status === 'Confirmed')
                            <a href="/my-bookings/{{ $booking->id }}/receipt" class="receipt-btn">View E-Receipt</a>
                            <a href="/my-bookings/{{ $booking->id }}/invoice" class="invoice-btn">Download Invoice</a>

                            @if($booking->cancellation_status === 'Pending')
                                <div class="cancellation-pending" style="margin:0; width:100%;">
                                    Cancellation Request Pending. Waiting for admin approval.
                                </div>
                            @elseif($booking->cancellation_status === 'Rejected')
                                <div class="cancellation-rejected" style="margin:0; width:100%;">
                                    Cancellation request was rejected. Your booking remains confirmed.
                                </div>
                                
                                <details style="margin-top: 15px; width:100%;">
                                    <summary class="request-btn" style="display:inline-block; list-style:none;">Request Cancellation Again</summary>
                                    <form method="POST" action="/my-bookings/{{ $booking->id }}/request-cancellation" class="cancel-form">
                                        @csrf
                                        <label>Reason for Cancellation</label>
                                        <textarea name="cancellation_reason" placeholder="Please enter your reason..." required></textarea>
                                        <button type="submit" class="submit-request">Submit Cancellation Request</button>
                                    </form>
                                </details>
                            @else
                                <details style="margin-top: 0; width:100%;">
                                    <summary class="request-btn" style="display:inline-block; list-style:none;">Request Cancellation</summary>
                                    <form method="POST" action="/my-bookings/{{ $booking->id }}/request-cancellation" class="cancel-form">
                                        @csrf
                                        <label>Reason for Cancellation</label>
                                        <textarea name="cancellation_reason" placeholder="Please enter your reason..." required></textarea>
                                        <button type="submit" class="submit-request">Submit Cancellation Request</button>
                                    </form>
                                </details>
                            @endif
                        @endif

                        <!-- REFUND BUTTON LOGIC (Para sa GCash Payments lang) -->
                        @if($booking->payment_method === 'GCash' && $booking->payment_status === 'Verified' && in_array($booking->status, ['Confirmed', 'Checked Out', 'Cancelled']) && $booking->refund_status !== 'Pending' && $booking->refund_status !== 'Refunded')
                            <button type="button" class="refund-btn" onclick="openRefundModal({{ $booking->id }})">
                                💸 Request Refund
                            </button>

                            <!-- Refund Modal -->
                            <div class="modal-overlay" id="refundModal-{{ $booking->id }}">
                                <div class="modal-content">
                                    <button class="modal-close" onclick="closeRefundModal({{ $booking->id }})">&times;</button>
                                    <h3>Request Refund for Booking #{{ $booking->id }}</h3>
                                    <form method="POST" action="{{ route('customer.bookings.request-refund', $booking->id) }}">
                                        @csrf
                                        <label style="color: #991b1b; font-weight: 700; margin-bottom: 8px; display: block;">Reason for Refund</label>
                                        <textarea name="refund_request_reason" rows="4" placeholder="Explain why you are requesting a refund..." required></textarea>
                                        <div class="modal-actions">
                                            <button type="button" class="modal-btn-cancel" onclick="closeRefundModal({{ $booking->id }})">Cancel</button>
                                            <button type="submit" class="modal-btn-submit">Submit Request</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                        @if($booking->status === 'Confirmed')
                            @if(!$booking->review)
                                <details style="margin-top: 15px; width: 100%;">
                                    <summary class="review-btn" style="display: inline-block; list-style: none;">⭐ Leave a Review</summary>
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
                                <div class="review-display">
                                    <p style="margin: 0; font-size: 14px; color: #166534; font-weight: 600;">
                                        ✅ You rated this stay: {{ str_repeat('⭐', $booking->review->rating) }}
                                    </p>
                                    @if($booking->review->comment)
                                        <p style="margin: 5px 0 0; font-size: 13px; color: #4b5563; font-style: italic;">
                                            "{{ $booking->review->comment }}"
                                        </p>
                                    @endif
                                </div>
                            @endif
                        @endif

                        @if($booking->status === 'Cancelled')
                            <div class="cancellation-rejected" style="background:#e5e7eb; color:#4b5563; border-color:#d1d5db; margin:0; width:100%;">
                                This booking has been cancelled.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="empty">
            <h3>No bookings found.</h3>
            <p>You do not have any bookings yet.</p>
            <a href="/accommodations" class="back-btn">Make a Booking</a>
        </div>
    @endif

    @if($bookings->hasPages())
        <div class="pagination-area">
            @if ($bookings->onFirstPage())
                <span class="pagination-link disabled">← Previous</span>
            @else
                <a href="{{ $bookings->previousPageUrl() }}" class="pagination-link">← Previous</a>
            @endif

            @foreach ($bookings->getUrlRange(max(1, $bookings->currentPage() - 2), min($bookings->lastPage(), $bookings->currentPage() + 2)) as $page => $url)
                @if ($page == $bookings->currentPage())
                    <span class="pagination-link active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                @endif
            @endforeach

            @if ($bookings->hasMorePages())
                <a href="{{ $bookings->nextPageUrl() }}" class="pagination-link">Next →</a>
            @else
                <span class="pagination-link disabled">Next →</span>
            @endif
        </div>
    @endif
</div>

<script>
    function toggleBooking(id) {
        const card = document.getElementById('booking-card-' + id);
        if (card) {
            card.classList.toggle('open');
        }
    }

    // Refund Modal Functions
    function openRefundModal(id) {
        const modal = document.getElementById('refundModal-' + id);
        if (modal) {
            modal.classList.add('active');
        }
    }

    function closeRefundModal(id) {
        const modal = document.getElementById('refundModal-' + id);
        if (modal) {
            modal.classList.remove('active');
        }
    }

    // Rewards Modal Functions
    function openRewardsModal(id) {
        const modal = document.getElementById('rewardsModal-' + id);
        if (modal) {
            modal.classList.add('active');
            attachRewardPreview(id);
        }
    }

    function closeRewardsModal(id) {
        const modal = document.getElementById('rewardsModal-' + id);
        if (modal) {
            modal.classList.remove('active');
        }
    }

    function attachRewardPreview(bookingId) {
        const modal = document.getElementById('rewardsModal-' + bookingId);
        if (!modal) return;
        
        const input = modal.querySelector('input[name="points_to_use"]');
        const preview = document.getElementById('reward-preview-' + bookingId);
        
        if (input && preview) {
            input.addEventListener('input', function() {
                const points = parseInt(this.value) || 0;
                const discount = (points / 100) * 5;
                preview.textContent = '₱' + discount.toFixed(2);
            });
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
                        if (e.status === 'Confirmed') statusBadge.classList.add('confirmed');
                        else if (e.status === 'Rejected') statusBadge.classList.add('rejected');
                        else if (e.status === 'Cancelled') statusBadge.classList.add('cancelled');
                        else statusBadge.classList.add('pending');
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                }
            });
    });
</script>

</body>
</html>