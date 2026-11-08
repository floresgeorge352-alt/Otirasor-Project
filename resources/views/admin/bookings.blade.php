<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Bookings</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', Arial, sans-serif; background: #f4f6f8; color: #1f2937; }
        nav { background: #ffffff; border-bottom: 1px solid #e5e7eb; padding: 15px 40px; display: flex; justify-content: space-between; align-items: center; gap: 20px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03); position: sticky; top: 0; z-index: 100; }
        .nav-brand { display: flex; align-items: center; gap: 12px; }
        .nav-brand img { width: 48px; height: 48px; object-fit: contain; }
        .nav-title { display: flex; flex-direction: column; gap: 3px; }
        .nav-title strong { color: #023e8a; font-size: 18px; font-family: 'Montserrat', sans-serif; }
        .nav-title span { color: #6b7280; font-size: 12px; }
        .nav-links { display: flex; align-items: center; gap: 8px; }
        nav a { color: #374151; text-decoration: none; padding: 9px 13px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: 0.2s; }
        nav a:hover { background: #eff6ff; color: #0077b6; }
        .logout-btn { background: none; border: none; color: #374151; padding: 9px 13px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Poppins', sans-serif; transition: 0.2s; }
        .logout-btn:hover { background: #fff1f2; color: #c62828; }

        .container { max-width: 1150px; margin: 35px auto; padding: 0 20px 40px; }

        .page-header { display: flex; justify-content: space-between; align-items: flex-end; gap: 20px; margin-bottom: 18px; }
        .page-header-left h1 { color: #023e8a; font-size: 30px; margin-bottom: 7px; font-family: 'Montserrat', sans-serif; }
        .page-header-left p { color: #6b7280; font-size: 14px; }

        .back-btn { display: inline-flex; align-items: center; gap: 7px; background: #ffffff; color: #0077b6; border: 1px solid #dbeafe; text-decoration: none; padding: 10px 16px; border-radius: 9px; font-weight: 600; font-size: 14px; transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.02); }
        .back-btn:hover { background: #eff6ff; }

        .booking-filters { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 22px; padding: 5px 0; }
        .filter-btn { display: inline-flex; align-items: center; justify-content: center; gap: 6px; padding: 10px 15px; border-radius: 9px; border: 1px solid #e5e7eb; background: #ffffff; color: #374151; text-decoration: none; font-size: 13px; font-weight: 700; transition: 0.2s ease; }
        .filter-btn:hover { background: #f8fafc; border-color: #bfdbfe; color: #023e8a; }
        .filter-btn.active { background: #023e8a; color: #ffffff; border-color: #023e8a; box-shadow: 0 4px 10px rgba(2, 62, 138, 0.2); }
        
        .pending-filter.active { background: #856404; border-color: #856404; box-shadow: 0 4px 10px rgba(133, 100, 4, 0.2); }
        .confirmed-filter.active { background: #2e7d32; border-color: #2e7d32; box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2); }
        .checkedin-filter.active { background: #084298; border-color: #084298; box-shadow: 0 4px 10px rgba(8, 66, 152, 0.2); }
        .rejected-filter.active { background: #c62828; border-color: #c62828; box-shadow: 0 4px 10px rgba(198, 40, 40, 0.2); }
        .cancelled-filter.active { background: #555b61; border-color: #555b61; box-shadow: 0 4px 10px rgba(85, 91, 97, 0.2); }
        .checkedout-filter.active { background: #8b5cf6; border-color: #8b5cf6; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.2); }
        .completed-filter.active { background: #059669; border-color: #059669; box-shadow: 0 4px 10px rgba(5, 150, 105, 0.2); }
        .refundpending-filter.active { background: #ea580c; border-color: #ea580c; box-shadow: 0 4px 10px rgba(234, 88, 12, 0.2); }

        .booking-search { display: flex; align-items: center; gap: 12px; margin: 0 0 8px; padding: 12px 16px; background: #ffffff; border: 1px solid #dbe5ef; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .booking-search input { width: 100%; min-width: 0; padding: 4px 0; border: none; outline: none; background: transparent; color: #183b60; font-family: 'Poppins', sans-serif; font-size: 15px; }
        .search-count { margin: 0 0 14px; color: #718096; font-size: 13px; }

        .booking { background: #ffffff; border: 1px solid #e5e7eb; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03); overflow: hidden; transition: all 0.3s ease; }
        .booking:hover { border-color: #bfdbfe; box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06); transform: translateY(-2px); }

        .booking-summary { padding: 22px; cursor: pointer; user-select: none; }
        .booking-summary:hover { background: #fafcff; }
        .booking-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 15px; }
        .guest-info h2 { color: #023e8a; font-size: 20px; margin-bottom: 5px; font-family: 'Montserrat', sans-serif; }
        .booking-id { color: #9ca3af; font-size: 12px; font-weight: 600; }
        .summary-status { flex-shrink: 0; display: flex; gap: 5px; flex-wrap: wrap; justify-content: flex-end; }

        .status { display: inline-block; font-weight: bold; padding: 6px 12px; border-radius: 20px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .confirmed { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .rejected { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .cancelled { background: #e2e3e5; color: #383d41; border: 1px solid #d6d8db; }
        
        .checked-in { background: #cfe2ff; color: #084298; border: 1px solid #b6d4fe; }
        .checked-out { background: #e0cffc; color: #432874; border: 1px solid #d0bfff; }
        .completed { background: #d1e7dd; color: #0f5132; border: 1px solid #badbcc; }
        .no-show { background: #f8d7da; color: #842029; border: 1px solid #f5c2c7; }
        
        .refund-pending { background: #ffedd5; color: #9a3412; border: 1px solid #fed7aa; }

        .booking-summary-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 12px; margin-top: 20px; }
        .summary-item { background: #f8fafc; border-radius: 10px; padding: 12px; min-width: 0; border: 1px solid #f1f5f9; }
        .summary-label { display: block; color: #64748b; font-size: 11px; margin-bottom: 4px; text-transform: uppercase; font-weight: 700; }
        .summary-value { color: #1e293b; font-size: 14px; font-weight: 700; word-break: break-word; }
        .summary-total { color: #0077b6; font-size: 16px; font-weight: 800; }

        .booking-click-hint { margin-top: 15px; color: #94a3b8; font-size: 12px; text-align: right; font-weight: 500; }
        .booking-click-hint span { color: #0077b6; font-weight: bold; }

        .booking-details { display: none; padding: 0 22px 22px; border-top: 1px solid #e5e7eb; background: #fafbfc; }
        .booking.open .booking-details { display: block; }
        .booking.open .booking-click-hint { display: none; }

        .detail-section { margin-top: 20px; padding: 20px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 0 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.02); }
        .detail-section h3 { grid-column: 1 / -1; color: #023e8a; font-size: 16px; margin-bottom: 15px; padding-bottom: 10px; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; gap: 8px; font-family: 'Montserrat', sans-serif; }
        .detail-row { display: flex; align-items: flex-start; gap: 15px; padding: 10px 0; border-bottom: 1px dashed #e2e8f0; }
        .detail-row:last-child { border-bottom: none; }
        .detail-row strong { color: #64748b; font-size: 13px; min-width: 110px; font-weight: 600; }
        .detail-row span { color: #1e293b; font-size: 14px; font-weight: 600; text-align: left; flex: 1; }
        .single-column { grid-template-columns: 1fr; }

        .accommodation-total { margin-top: 15px; padding: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; }
        .accommodation-total-label { font-weight: 700; color: #475569; font-size: 13px; text-transform: uppercase; margin-bottom: 5px; }
        .accommodation-total-value { font-size: 24px; font-weight: 800; color: #334155; }

        .facility-details { margin-top: 15px; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; }
        .facility-details h3 { color: #475569; margin-bottom: 12px; font-size: 15px; font-family: 'Montserrat', sans-serif; }
        .facility-row { display: flex; justify-content: space-between; align-items: center; gap: 15px; padding: 8px 0; border-bottom: 1px dashed #cbd5e1; }
        .facility-row:last-child { border-bottom: none; }
        .facility-row-label { font-weight: 600; color: #64748b; font-size: 13px; }
        .facility-row-value { font-weight: 700; color: #334155; text-align: right; font-size: 14px; }

        .facility-total { margin-top: 15px; padding: 18px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; }
        .facility-total-label { font-weight: 700; color: #475569; font-size: 13px; text-transform: uppercase; margin-bottom: 5px; }
        .facility-total-value { font-size: 24px; font-weight: 800; color: #334155; }

        .facility-not-selected { margin-top: 15px; padding: 15px; background: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; color: #64748b; font-size: 14px; text-align: center; font-style: italic; }

        .grand-total { margin-top: 15px; padding: 22px; background: linear-gradient(135deg, #ecfdf5, #d1fae5); border: 1px solid #a7f3d0; border-radius: 12px; display: flex; justify-content: space-between; align-items: center; gap: 15px; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.05); }
        .grand-total-label { font-size: 18px; font-weight: 800; color: #065f46; text-transform: uppercase; letter-spacing: 1px; }
        .grand-total-value { font-size: 32px; font-weight: 900; color: #059669; }

        .payment-status { display: inline-block; font-weight: bold; padding: 6px 12px; border-radius: 20px; font-size: 12px; }
        .payment-for-verification { background: #fff3cd; color: #856404; }
        .payment-verified { background: #d4edda; color: #155724; }
        .payment-rejected { background: #f8d7da; color: #721c24; }
        .payment-not-applicable { background: #e2e3e5; color: #383d41; }

        .receipt-info { margin-top: 15px; padding: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; }
        .receipt-info h3 { color: #166534; margin-bottom: 12px; }
        .receipt-number { display: inline-block; background: #dcfce7; color: #14532d; font-weight: 800; padding: 6px 12px; border-radius: 20px; letter-spacing: 1px; }

        .rejection-reason { background: #fff1f2; border-left: 4px solid #e11d48; padding: 15px; margin-top: 15px; border-radius: 8px; }
        .rejection-reason strong { color: #be123c; }
        .rejection-form { margin-top: 15px; }
        .rejection-form textarea { width: 100%; min-height: 100px; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical; margin-bottom: 10px; }
        .rejection-form textarea:focus { outline: none; border-color: #e11d48; box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1); }

        .payment-rejection-form { display: block; margin-top: 15px; padding: 15px; background: #fff7ed; border: 1px solid #fed7aa; border-radius: 10px; }
        .payment-rejection-form label { display: block; font-weight: bold; margin-bottom: 8px; color: #c2410c; }
        .payment-rejection-form textarea { width: 100%; max-width: 600px; min-height: 90px; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-family: 'Poppins', sans-serif; font-size: 14px; resize: vertical; margin-bottom: 10px; }
        .payment-rejection-form textarea:focus { outline: none; border-color: #ea580c; box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.1); }
        .payment-rejection-form small { display: block; color: #64748b; margin-bottom: 10px; }
        .payment-rejection-reason { background: #fff7ed; border-left: 4px solid #ea580c; padding: 12px 15px; margin-top: 15px; border-radius: 5px; }
        .payment-rejection-reason strong { color: #ea580c; }

        .cancellation-request { margin-top: 20px; padding: 20px; background: #fffbeb; border: 1px solid #fcd34d; border-radius: 10px; }
        .cancellation-request h3 { color: #b45309; margin-bottom: 10px; }
        .cancellation-status { display: inline-block; padding: 6px 12px; border-radius: 20px; font-weight: bold; background: #fef3c7; color: #92400e; }
        .cancellation-rejected { margin-top: 15px; padding: 12px 15px; background: #f8d7da; color: #721c24; border-left: 4px solid #c62828; border-radius: 5px; }

        .refund-section { margin-top: 20px; padding: 20px; border-radius: 10px; }
        .refund-section.pending-refund { background: #fef2f2; border: 1px solid #fecaca; }
        .refund-section.approved-refund { background: #ecfdf3; border: 1px solid #bbf7d0; }
        .refund-section.rejected-refund { background: #f8d7da; border: 1px solid #f5c6cb; }
        .refund-section h3 { margin-bottom: 15px; font-size: 16px; font-family: 'Montserrat', sans-serif; }
        .refund-section.pending-refund h3 { color: #991b1b; }
        .refund-section.approved-refund h3 { color: #166534; }
        .refund-section.rejected-refund h3 { color: #721c24; }
        
        .refund-forms-wrapper { display: flex; gap: 15px; flex-wrap: wrap; margin-top: 15px; }
        .refund-form-box { flex: 1; min-width: 250px; padding: 15px; background: white; border-radius: 8px; border: 1px solid #e5e7eb; }
        .refund-form-box input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px; font-family: 'Poppins', sans-serif; font-size: 13px; }

        .actions { margin-top: 25px; display: flex; flex-wrap: wrap; gap: 10px; }
        .actions form { display: inline; }

        .approve-btn, .approve-cancellation-btn, .approve-refund-btn,
        .reject-btn, .reject-cancellation-btn, .reject-refund-btn,
        .verify-payment-btn, .reject-payment-btn,
        .confirm-reject-btn, .cancel-reject-btn,
        .checkin-btn, .checkout-btn, .complete-btn, .noshow-btn, .mark-cleaned-btn {
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 700;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: white;
            border: none;
            font-family: 'Poppins', sans-serif;
        }

        .approve-btn, .approve-cancellation-btn, .checkin-btn, .complete-btn, .approve-refund-btn { background: #10b981; }
        .approve-btn:hover, .approve-cancellation-btn:hover, .checkin-btn:hover, .complete-btn:hover, .approve-refund-btn:hover { background: #059669; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transform: translateY(-1px); }

        .reject-btn, .reject-cancellation-btn, .reject-refund-btn { background: #ef4444; }
        .reject-btn:hover, .reject-cancellation-btn:hover, .reject-refund-btn:hover { background: #dc2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); transform: translateY(-1px); }

        .verify-payment-btn, .checkout-btn { background: #3b82f6; }
        .verify-payment-btn:hover, .checkout-btn:hover { background: #2563eb; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transform: translateY(-1px); }
        
        .mark-cleaned-btn { background: #8b5cf6; }
        .mark-cleaned-btn:hover { background: #7c3aed; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3); transform: translateY(-1px); }

        .reject-payment-btn, .noshow-btn { background: #f97316; }
        .reject-payment-btn:hover, .noshow-btn:hover { background: #ea580c; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3); transform: translateY(-1px); }

        .confirm-reject-btn { background: #ef4444; }
        .confirm-reject-btn:hover { background: #dc2626; }

        .cancel-reject-btn { background: #64748b; margin-left: 8px; }
        .cancel-reject-btn:hover { background: #475569; }

        .empty { background: white; padding: 50px 30px; border-radius: 16px; text-align: center; border: 1px dashed #cbd5e1; }
        .empty h2 { color: #334155; margin-bottom: 8px; }
        .empty p { color: #64748b; }

        .proof-modal { display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.85); justify-content: center; align-items: center; padding: 30px; backdrop-filter: blur(5px); }
        .proof-modal img { max-width: 90%; max-height: 90%; width: auto; height: auto; object-fit: contain; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.5); }
        .proof-modal-close { position: absolute; top: 20px; right: 30px; color: white; font-size: 42px; font-weight: bold; cursor: pointer; line-height: 1; z-index: 10000; opacity: 0.7; transition: 0.2s; }
        .proof-modal-close:hover { opacity: 1; transform: scale(1.1); }

        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 12px 18px; border-radius: 8px; margin-bottom: 16px; font-weight: 600; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 12px 18px; border-radius: 8px; margin-bottom: 16px; font-weight: 600; }
        .search-empty { display: none; }

        @media (max-width: 800px) {
            nav { padding: 14px 20px; flex-direction: column; align-items: flex-start; }
            .nav-links { width: 100%; flex-wrap: wrap; }
            .container { margin: 25px auto; padding: 0 15px 30px; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .booking-summary-grid { grid-template-columns: repeat(2, 1fr); }
            .detail-section { grid-template-columns: 1fr; }
        }

        @media (max-width: 500px) {
            .booking-top { flex-direction: column; }
            .summary-status { align-self: flex-start; }
            .booking-summary-grid { grid-template-columns: 1fr; }
            .detail-row { flex-direction: column; gap: 4px; }
            .detail-row span { text-align: left; }
            .facility-row { align-items: flex-start; flex-direction: column; gap: 3px; }
            .facility-row-value { text-align: left; }
            .grand-total { flex-direction: column; align-items: flex-start; }
            .booking-filters { gap: 7px; }
            .filter-btn { padding: 9px 11px; font-size: 12px; }
        }
    </style>
</head>

<body>

<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}" alt="Otirasor Beach and Resort Logo">
        <div class="nav-title">
            <strong>Otirasor Beach and Resort</strong>
            <span>Administration Portal</span>
        </div>
    </div>

    <div class="nav-links">
        <a href="/admin/dashboard">🏠 Dashboard</a>
        <a href="/admin/bookings">📋 Bookings</a>
        <a href="/admin/notifications">🔔 Notifications</a>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <div class="page-header-left">
            <h1>
                @if($month)
                    📅 {{ date('F', mktime(0, 0, 0, $month, 1)) }} Bookings
                @elseif($filter == 'pending')
                    ⏳ Pending Bookings
                @elseif($filter == 'confirmed')
                    ✅ Confirmed Bookings
                @elseif($filter == 'checked_in')
                    🔑 Checked In Bookings
                @elseif($filter == 'checked_out')
                    🚪 Checked Out Bookings
                @elseif($filter == 'completed')
                    🏁 Completed Bookings
                @elseif($filter == 'rejected')
                    ❌ Rejected Bookings
                @elseif($filter == 'cancelled')
                    🚫 Cancelled Bookings
                @elseif($filter == 'refund_pending')
                    💸 Pending Refunds
                @else
                    📋 All Bookings
                @endif
            </h1>
            <p>Click a booking card to view complete details.</p>
        </div>

        <a href="/admin/management" class="back-btn">← Back to Management</a>
    </div>

    <div class="booking-filters">
        <a href="/admin/bookings" class="filter-btn {{ ($filter == 'all' && !$month) ? 'active' : '' }}">📋 All</a>
        <a href="/admin/bookings?filter=pending" class="filter-btn pending-filter {{ $filter == 'pending' ? 'active' : '' }}">⏳ Pending</a>
        <a href="/admin/bookings?filter=confirmed" class="filter-btn confirmed-filter {{ $filter == 'confirmed' ? 'active' : '' }}">✅ Confirmed</a>
        <a href="/admin/bookings?filter=checked_in" class="filter-btn checkedin-filter {{ $filter == 'checked_in' ? 'active' : '' }}">🔑 Checked In</a>
        <a href="/admin/bookings?filter=checked_out" class="filter-btn checkedout-filter {{ $filter == 'checked_out' ? 'active' : '' }}">🚪 Checked Out</a>
        <a href="/admin/bookings?filter=completed" class="filter-btn completed-filter {{ $filter == 'completed' ? 'active' : '' }}">🏁 Completed</a>
        <a href="/admin/bookings?filter=rejected" class="filter-btn rejected-filter {{ $filter == 'rejected' ? 'active' : '' }}">❌ Rejected</a>
        <a href="/admin/bookings?filter=cancelled" class="filter-btn cancelled-filter {{ $filter == 'cancelled' ? 'active' : '' }}">🚫 Cancelled</a>
        <a href="/admin/bookings?filter=refund_pending" class="filter-btn refundpending-filter {{ $filter == 'refund_pending' ? 'active' : '' }}">💸 Refund Pending</a>
    </div>

    <div class="booking-search">
        <span class="search-icon" aria-hidden="true">🔎</span>
        <input type="search" id="bookingSearch" placeholder="Search guest name, booking ID, contact number, or room..." autocomplete="off" aria-label="Search bookings">
    </div>

    <p class="search-count" id="searchCount" aria-live="polite">Showing {{ $bookings->count() }} booking(s)</p>

    <div class="search-empty" id="searchEmpty" role="status">
        <strong>No matching bookings found.</strong>
        <p>Try another guest name, booking ID, contact number, or room.</p>
    </div>

    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif

    @if($bookings->count() == 0)
        <div class="empty">
            <h2>No bookings found.</h2>
            <p>There are currently no bookings in this category.</p>
        </div>
    @else
        @foreach($bookings as $booking)
            @php
                $poolAdults = (int) ($booking->pool_adults ?? 0);
                $poolKids = (int) ($booking->pool_kids ?? 0);
                $entranceTotal = ((int) ($booking->number_of_adults ?? 0) * 20) + ((int) ($booking->number_of_kids ?? 0) * 10);
                $poolTotal = ($poolAdults * 70) + ($poolKids * 50);
                
                $subtotal = ($booking->accommodation_total ?? 0) + ($booking->facility_total ?? 0);
                $discount = $booking->discount_amount ?? 0;
                $rewardDiscount = $booking->reward_discount ?? 0;
                $grandTotal = $subtotal - $discount - $rewardDiscount;
            @endphp

            <div class="booking" id="booking-{{ $booking->id }}" data-booking-id="{{ $booking->id }}">
                
                <div class="booking-summary" onclick="toggleBooking({{ $booking->id }})">
                    <div class="booking-top">
                        <div class="guest-info">
                            <h2>{{ $booking->guest_name }}</h2>
                            <span class="booking-id">Booking #{{ $booking->id }}</span>
                        </div>
                        <div class="summary-status">
                            @if($booking->status == 'Pending')
                                <span class="status pending">Pending</span>
                            @elseif($booking->status == 'Confirmed')
                                <span class="status confirmed">Confirmed</span>
                            @elseif($booking->status == 'Checked In')
                                <span class="status checked-in">Checked In</span>
                            @elseif($booking->status == 'Checked Out')
                                <span class="status checked-out">Checked Out</span>
                            @elseif($booking->status == 'Completed')
                                <span class="status completed">Completed</span>
                            @elseif($booking->status == 'No Show')
                                <span class="status no-show">No Show</span>
                            @elseif($booking->status == 'Rejected')
                                <span class="status rejected">Rejected</span>
                            @elseif($booking->status == 'Cancelled')
                                <span class="status cancelled">Cancelled</span>
                            @else
                                <span class="status">{{ $booking->status }}</span>
                            @endif

                            @if($booking->refund_status === 'Pending')
                                <span class="status refund-pending">Refund Pending</span>
                            @endif
                        </div>
                    </div>

                    <div class="booking-summary-grid">
                        <div class="summary-item">
                            <span class="summary-label">📅 Check-in</span>
                            <span class="summary-value">{{ $booking->check_in }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">📅 Check-out</span>
                            <span class="summary-value">{{ $booking->check_out }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">👥 Guests</span>
                            <span class="summary-value">{{ $booking->number_of_guests }}</span>
                        </div>
                        <div class="summary-item">
                            <span class="summary-label">💰 Total</span>
                            <span class="summary-total">₱{{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>

                    <div class="booking-click-hint">Click this booking to view details <span>→</span></div>
                </div>

                <div class="booking-details">
                    
                    <div class="detail-section">
                        <h3>👤 Guest Information</h3>
                        <div class="detail-row"><strong>Guest Name</strong><span>{{ $booking->guest_name }}</span></div>
                        <div class="detail-row"><strong>Contact</strong><span>{{ $booking->contact_number }}</span></div>
                        <div class="detail-row"><strong>Adults</strong><span>{{ $booking->number_of_adults }}</span></div>
                        <div class="detail-row"><strong>Kids</strong><span>{{ $booking->number_of_kids }}</span></div>
                    </div>

                    <div class="detail-section">
                        <h3>📅 Booking Information</h3>
                        <div class="detail-row"><strong>Accommodation</strong><span>{{ $booking->accommodations }}</span></div>
                        <div class="detail-row">
                            <strong>Status</strong>
                            <span>
                                @if($booking->status == 'Pending') <span class="status pending">Pending</span>
                                @elseif($booking->status == 'Confirmed') <span class="status confirmed">Confirmed</span>
                                @elseif($booking->status == 'Checked In') <span class="status checked-in">Checked In</span>
                                @elseif($booking->status == 'Checked Out') <span class="status checked-out">Checked Out</span>
                                @elseif($booking->status == 'Completed') <span class="status completed">Completed</span>
                                @elseif($booking->status == 'No Show') <span class="status no-show">No Show</span>
                                @elseif($booking->status == 'Rejected') <span class="status rejected">Rejected</span>
                                @elseif($booking->status == 'Cancelled') <span class="status cancelled">Cancelled</span>
                                @else <span class="status">{{ $booking->status }}</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="accommodation-total">
                        <div class="accommodation-total-label">Accommodation Total</div>
                        <div class="accommodation-total-value">₱{{ number_format($booking->accommodation_total ?? 0, 2) }}</div>
                    </div>

                    @if(($booking->facility_total ?? 0) > 0)
                        <div class="facility-details single-column">
                            <h3>🏖️ Beach / Swimming Pool Details</h3>
                            <div class="facility-row">
                                <span class="facility-row-label">Beach Entrance - Adults</span>
                                <span class="facility-row-value">{{ $booking->number_of_adults }} × ₱20 = ₱{{ number_format(($booking->number_of_adults ?? 0) * 20, 2) }}</span>
                            </div>
                            <div class="facility-row">
                                <span class="facility-row-label">Beach Entrance - Kids</span>
                                <span class="facility-row-value">{{ $booking->number_of_kids }} × ₱10 = ₱{{ number_format(($booking->number_of_kids ?? 0) * 10, 2) }}</span>
                            </div>
                            <div class="facility-row">
                                <span class="facility-row-label">Entrance Total</span>
                                <span class="facility-row-value">₱{{ number_format($entranceTotal, 2) }}</span>
                            </div>

                            @if($poolAdults > 0 || $poolKids > 0)
                                <div class="facility-row"><span class="facility-row-label">Swimming Pool - Adults</span><span class="facility-row-value">{{ $poolAdults }} × ₱70 = ₱{{ number_format($poolAdults * 70, 2) }}</span></div>
                                <div class="facility-row"><span class="facility-row-label">Swimming Pool - Kids</span><span class="facility-row-value">{{ $poolKids }} × ₱50 = ₱{{ number_format($poolKids * 50, 2) }}</span></div>
                                <div class="facility-row"><span class="facility-row-label">Swimming Pool Total</span><span class="facility-row-value">₱{{ number_format($poolTotal, 2) }}</span></div>
                            @else
                                <div class="facility-row">
                                    <span class="facility-row-label">Swimming Pool</span>
                                    <span class="facility-row-value" style="color:#64748b;">Not Selected</span>
                                </div>
                            @endif
                        </div>

                        <div class="facility-total single-column">
                            <div class="facility-total-label">🏖️ Beach / Swimming Pool Total</div>
                            <div class="facility-total-value">₱{{ number_format($booking->facility_total ?? 0, 2) }}</div>
                        </div>
                    @else
                        <div class="facility-not-selected single-column">🏖️ <strong>Beach / Swimming Pool:</strong> Not Selected</div>
                    @endif

                    @if($discount > 0)
                        <div class="facility-total single-column" style="background: #fef2f2; border-color: #fecaca;">
                            <div class="facility-total-label" style="color: #991b1b;">🎟️ Promo Discount ({{ $booking->promo_code }})</div>
                            <div class="facility-total-value" style="color: #dc2626;">- ₱{{ number_format($discount, 2) }}</div>
                        </div>
                    @endif

                    @if($rewardDiscount > 0)
                        <div class="facility-total single-column" style="background: #f3e8ff; border-color: #d8b4fe;">
                            <div class="facility-total-label" style="color: #6b21a8;">🎁 Rewards Discount ({{ number_format($booking->reward_points_used) }} points)</div>
                            <div class="facility-total-value" style="color: #8b5cf6;">- ₱{{ number_format($rewardDiscount, 2) }}</div>
                        </div>
                    @endif

                    <div class="grand-total single-column">
                        <div class="grand-total-label">Grand Total</div>
                        <div class="grand-total-value">₱{{ number_format($grandTotal, 2) }}</div>
                    </div>

                    <div class="detail-section">
                        <h3>💳 Payment Information</h3>
                        <div class="detail-row"><strong>Payment Method</strong><span>{{ $booking->payment_method }}</span></div>
                        @if($booking->payment_method == 'GCash')
                            <div class="detail-row"><strong>GCash Reference</strong><span>{{ $booking->gcash_reference }}</span></div>
                            <div class="detail-row">
                                <strong>Payment Status</strong>
                                <span>
                                    @if($booking->payment_status == 'For Verification') <span class="payment-status payment-for-verification">For Verification</span>
                                    @elseif($booking->payment_status == 'Verified') <span class="payment-status payment-verified">Verified</span>
                                    @elseif($booking->payment_status == 'Rejected') <span class="payment-status payment-rejected">Rejected</span>
                                    @else <span class="payment-status payment-not-applicable">{{ $booking->payment_status }}</span>
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    @if($booking->payment_method == 'GCash')
                        @if($booking->gcash_proof)
                            <div class="gcash-proof single-column">
                                <h3>📷 GCash Payment Proof</h3>
                                <p>Click the image below to view the full payment proof.</p>
                                <img src="{{ asset('storage/' . $booking->gcash_proof) }}" alt="GCash payment proof" class="proof-preview" onclick="event.stopPropagation(); openProofModal('{{ asset('storage/' . $booking->gcash_proof) }}')">
                                <button type="button" class="view-proof-btn" onclick="event.stopPropagation(); openProofModal('{{ asset('storage/' . $booking->gcash_proof) }}')">Open Full Proof</button>
                            </div>
                        @else
                            <div class="gcash-proof single-column">
                                <h3>📷 GCash Payment Proof</h3>
                                <p>No GCash payment proof was uploaded.</p>
                            </div>
                        @endif

                        @if($booking->payment_status == 'Rejected' && $booking->payment_rejection_reason)
                            <div class="payment-rejection-reason">
                                <strong>Payment Rejection Reason:</strong>
                                <p>{{ $booking->payment_rejection_reason }}</p>
                            </div>
                        @endif

                        @if($booking->payment_status == 'For Verification')
                            <div class="actions" onclick="event.stopPropagation()">
                                <form method="POST" action="/admin/bookings/{{ $booking->id }}/verify-payment">
                                    @csrf
                                    <button type="submit" class="verify-payment-btn">Verify Payment</button>
                                </form>
                                <form method="POST" action="/admin/bookings/{{ $booking->id }}/reject-payment" class="payment-rejection-form">
                                    @csrf
                                    <label for="payment-rejection-{{ $booking->id }}">Reason for Payment Rejection</label>
                                    <small>Please explain why the submitted GCash payment proof was rejected.</small>
                                    <textarea id="payment-rejection-{{ $booking->id }}" name="payment_rejection_reason" rows="3" placeholder="Example: The GCash reference number does not match the uploaded payment proof." required></textarea>
                                    <button type="submit" class="reject-payment-btn">Reject Payment</button>
                                </form>
                            </div>
                        @endif
                    @endif

                    @if($booking->status == 'Confirmed' && $booking->receipt_number)
                        <div class="receipt-info single-column">
                            <h3>🧾 Electronic Receipt</h3>
                            <p><strong>Receipt Number:</strong> <span class="receipt-number">{{ $booking->receipt_number }}</span></p>
                            <p><strong>Receipt Generated:</strong> @if($booking->receipt_generated_at) {{ $booking->receipt_generated_at->format('F j, Y g:i A') }} @else Not available @endif</p>
                        </div>
                    @endif

                    @if($booking->status == 'Rejected' && $booking->rejection_reason)
                        <div class="rejection-reason single-column">
                            <strong>Booking Rejection Reason:</strong>
                            <p>{{ $booking->rejection_reason }}</p>
                        </div>
                    @endif

                    @if($booking->status == 'Confirmed' && $booking->cancellation_status == 'Pending')
                        <div class="cancellation-request single-column">
                            <h3>Cancellation Request</h3>
                            <p><strong>Status:</strong> <span class="cancellation-status">Pending Admin Review</span></p>
                            @if($booking->cancellation_requested_at) <p><strong>Requested At:</strong> {{ $booking->cancellation_requested_at->format('M d, Y h:i A') }}</p> @endif
                            @if($booking->cancellation_reason) <p><strong>Customer Reason:</strong> {{ $booking->cancellation_reason }}</p> @endif
                            <div class="actions" onclick="event.stopPropagation()">
                                <form method="POST" action="/admin/bookings/{{ $booking->id }}/approve-cancellation" onsubmit="return confirm('Approve this cancellation request? The booking will be cancelled.');">
                                    @csrf
                                    <button type="submit" class="approve-cancellation-btn">Approve Cancellation</button>
                                </form>
                                <form method="POST" action="/admin/bookings/{{ $booking->id }}/reject-cancellation" onsubmit="return confirm('Reject this cancellation request? The booking will remain confirmed.');">
                                    @csrf
                                    <button type="submit" class="reject-cancellation-btn">Reject Cancellation</button>
                                </form>
                            </div>
                        </div>
                    @elseif($booking->status == 'Confirmed' && $booking->cancellation_status == 'Rejected')
                        <div class="cancellation-rejected single-column">
                            <strong>Cancellation Request Rejected</strong>
                            <p>The customer requested cancellation previously, but the request was rejected.</p>
                        </div>
                    @endif

                    @if($booking->refund_status === 'Pending')
                        <div class="refund-section single-column pending-refund">
                            <h3>⏳ Refund Request Pending</h3>
                            <p><strong>Customer Reason:</strong> {{ $booking->refund_request_reason }}</p>
                            
                            <div class="refund-forms-wrapper" onclick="event.stopPropagation()" style="display: block; margin-top: 15px;">
                                <form method="POST" action="{{ route('admin.bookings.approve-refund', $booking->id) }}" style="background: #f0fdf4; padding: 15px; border-radius: 8px; border: 1px solid #bbf7d0; margin-bottom: 15px;">
                                    @csrf
                                    <label style="font-weight: bold; color: #166534; display: block; margin-bottom: 5px;">GCash Reference No. (Required)</label>
                                    <input type="text" name="refund_reference" placeholder="e.g. 1234567890123" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;">
                                    
                                    <label style="font-weight: bold; color: #166534; display: block; margin-bottom: 5px;">Message to Customer (Optional)</label>
                                    <input type="text" name="refund_message" placeholder="e.g. Nai-send na po mga 9:30 PM." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;">
                                    
                                    <button type="submit" class="approve-refund-btn" style="width:100%;" onclick="return confirm('Approve and mark this refund as processed?')">Approve & Mark as Refunded</button>
                                </form>

                                <form method="POST" action="{{ route('admin.bookings.reject-refund', $booking->id) }}" style="background: #fef2f2; padding: 15px; border-radius: 8px; border: 1px solid #fecaca;">
                                    @csrf
                                    <label style="font-weight: bold; color: #991b1b; display: block; margin-bottom: 5px;">Reason for Rejection (Required)</label>
                                    <input type="text" name="refund_notes" placeholder="Explain why it's rejected..." required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px;">
                                    <button type="submit" class="reject-refund-btn" style="width:100%;" onclick="return confirm('Reject this refund?')">Reject Refund</button>
                                </form>
                            </div>
                        </div>
                    @elseif($booking->refund_status === 'Refunded')
                        <div class="refund-section single-column approved-refund">
                            <h3>✅ Refund Processed</h3>
                            <p><strong>Refunded At:</strong> {{ \Carbon\Carbon::parse($booking->refunded_at)->format('M d, Y h:i A') }}</p>
                            <p><strong>GCash Ref:</strong> {{ $booking->refund_reference }}</p>
                            @if($booking->refund_message)
                                <p><strong>Message to Customer:</strong> {{ $booking->refund_message }}</p>
                            @endif
                        </div>
                    @elseif($booking->refund_status === 'Rejected')
                        <div class="refund-section single-column rejected-refund">
                            <h3>❌ Refund Request Rejected</h3>
                            <p><strong>Reason:</strong> {{ $booking->refund_notes }}</p>
                        </div>
                    @endif

                    @if($booking->status == 'Cancelled' && $booking->payment_method == 'GCash' && $booking->refund_status !== 'Pending' && $booking->refund_status !== 'Refunded' && $booking->refund_status !== 'Rejected')
                        <div class="refund-section single-column pending-refund" style="margin-top: 20px; background: #f0fdf4; border: 1px solid #bbf7d0;">
                            <h3 style="color: #166534;">💰 GCash Refund Status</h3>
                            
                            <form method="POST" action="/admin/bookings/{{ $booking->id }}/refund" onclick="event.stopPropagation()">
                                @csrf
                                <textarea name="refund_notes" placeholder="Enter GCash reference or refund notes..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; margin-bottom: 10px; font-family: 'Poppins', sans-serif; font-size: 14px;"></textarea>
                                <button type="submit" class="verify-payment-btn" style="background: #10b981;" onclick="return confirm('Mark this GCash payment as refunded?')">Mark as Refunded</button>
                            </form>
                        </div>
                    @endif

                    @if($booking->status == 'Pending')
                        <div class="actions" onclick="event.stopPropagation()">
                            <form method="POST" action="/admin/bookings/{{ $booking->id }}/approve">
                                @csrf
                                <button type="submit" class="approve-btn">Approve</button>
                            </form>
                            <button type="button" class="reject-btn" onclick="showRejectForm({{ $booking->id }})">Reject</button>
                            <div id="reject-form-{{ $booking->id }}" class="rejection-form" style="display: none; width: 100%;">
                                <form method="POST" action="/admin/bookings/{{ $booking->id }}/reject" style="display: block;">
                                    @csrf
                                    <textarea name="rejection_reason" placeholder="Enter the reason for rejecting this booking..." required></textarea>
                                    <br>
                                    <button type="submit" class="confirm-reject-btn">Confirm Rejection</button>
                                    <button type="button" class="cancel-reject-btn" onclick="hideRejectForm({{ $booking->id }})">Cancel</button>
                                </form>
                            </div>
                        </div>
                    @endif

                    @if($booking->status == 'Confirmed')
                        <div class="actions" onclick="event.stopPropagation()">
                            <form method="POST" action="{{ route('admin.bookings.checkIn', $booking) }}">
                                @csrf
                                <button type="submit" class="checkin-btn">✅ Check In</button>
                            </form>
                            <form method="POST" action="{{ route('admin.bookings.noShow', $booking) }}" onsubmit="return confirm('Mark this booking as No Show?')">
                                @csrf
                                <button type="submit" class="noshow-btn">⚠️ No Show</button>
                            </form>
                        </div>
                    @endif

                    @if($booking->status == 'Checked In')
                        <div class="actions" onclick="event.stopPropagation()">
                            <form method="POST" action="{{ route('admin.bookings.checkOut', $booking) }}">
                                @csrf
                                <button type="submit" class="checkout-btn">🚪 Check Out</button>
                            </form>
                        </div>
                    @endif

                    @if($booking->status == 'Checked Out')
                        <div class="actions" onclick="event.stopPropagation()">
                            <form method="POST" action="{{ route('admin.bookings.markCleaned', $booking) }}">
                                @csrf
                                <button type="submit" class="mark-cleaned-btn">✓ Mark as Cleaned</button>
                            </form>
                        </div>
                    @endif

                </div>
            </div>
        @endforeach
    @endif
</div>

<div id="proofModal" class="proof-modal" onclick="closeProofModal()">
    <span class="proof-modal-close" onclick="closeProofModal()">&times;</span>
    <img id="proofModalImage" src="" alt="GCash Payment Proof" onclick="event.stopPropagation()">
</div>

<script>
    function toggleBooking(bookingId) {
        const booking = document.getElementById('booking-' + bookingId);
        if (booking) booking.classList.toggle('open');
    }

    function showRejectForm(bookingId) {
        const form = document.getElementById('reject-form-' + bookingId);
        if (form) form.style.display = 'block';
    }

    function hideRejectForm(bookingId) {
        const form = document.getElementById('reject-form-' + bookingId);
        if (form) form.style.display = 'none';
    }

    function openProofModal(imageUrl) {
        document.getElementById('proofModalImage').src = imageUrl;
        document.getElementById('proofModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeProofModal() {
        document.getElementById('proofModal').style.display = 'none';
        document.getElementById('proofModalImage').src = '';
        document.body.style.overflow = '';
    }

    function initializeBookingSearch() {
        const searchInput = document.getElementById('bookingSearch');
        const searchCount = document.getElementById('searchCount');
        const searchEmpty = document.getElementById('searchEmpty');
        if (!searchInput || !searchCount || !searchEmpty) return;

        const bookingCards = Array.from(document.querySelectorAll('.booking'));

        function searchBookings() {
            const query = searchInput.value.trim().toLocaleLowerCase();
            const isBookingIdSearch = /^\d+$/.test(query);
            let visibleCount = 0;

            bookingCards.forEach(function (card) {
                const searchableText = (card.innerText || card.textContent || '').toLocaleLowerCase();
                const bookingId = card.dataset.bookingId || '';
                const matches = query === '' || (isBookingIdSearch ? bookingId === query : searchableText.includes(query));
                card.style.display = matches ? '' : 'none';
                if (matches) visibleCount++;
            });

            searchCount.textContent = 'Showing ' + visibleCount + ' booking(s)';
            searchEmpty.style.display = visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', searchBookings);
        searchBookings();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeBookingSearch);
    } else {
        initializeBookingSearch();
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeProofModal();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
            console.warn('Echo is not loaded.');
            return;
        }

        // 1. Bagong Booking
        window.Echo.channel('admin.bookings')
            .listen('BookingCreated', (e) => {
                console.log('New Booking:', e);
                
                if (window.showToast) {
                    window.showToast(
                        'New Booking!', 
                        `${e.guest_name} (₱${Number(e.total_amount).toLocaleString()})`, 
                        'info',
                        `/admin/bookings?booking_id=${e.id}`
                    );
                }

                setTimeout(() => window.location.reload(), 3000); 
            });

        // 2. Cancellation Request
        window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
            .notification((notification) => {
                console.log('New Notification:', notification);
                if (notification.type === 'cancellation_requested') {
                    if (window.showToast) {
                        window.showToast(
                            'Cancellation Request!', 
                            `${notification.guest_name} requested cancellation.`, 
                            'warning',
                            `/admin/bookings?booking_id=${notification.booking_id}`
                        );
                    }
                }
            });
    });
</script>

</body>
</html>