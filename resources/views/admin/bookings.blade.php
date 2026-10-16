<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - Bookings</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #1f2937;
        }

        /* =========================================
           NAVBAR
        ========================================= */

        nav {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 15px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }

        .nav-title {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .nav-title strong {
            color: #023e8a;
            font-size: 18px;
        }

        .nav-title span {
            color: #6b7280;
            font-size: 12px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a {
            color: #374151;
            text-decoration: none;
            padding: 9px 13px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        nav a:hover {
            background: #eff6ff;
            color: #0077b6;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #374151;
            padding: 9px 13px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .logout-btn:hover {
            background: #fff1f2;
            color: #c62828;
        }

        /* =========================================
           PAGE
        ========================================= */

        .container {
            max-width: 1150px;
            margin: 35px auto;
            padding: 0 20px 40px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 18px;
        }

        .page-header-left h1 {
            color: #023e8a;
            font-size: 30px;
            margin-bottom: 7px;
        }

        .page-header-left p {
            color: #6b7280;
            font-size: 14px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: #ffffff;
            color: #0077b6;
            border: 1px solid #dbeafe;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 9px;
            font-weight: 600;
            font-size: 14px;
        }

        .back-btn:hover {
            background: #eff6ff;
        }

        /* =========================================
           BOOKING FILTERS
        ========================================= */

        .booking-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
            padding: 5px 0;
        }

        .filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 10px 15px;
            border-radius: 9px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            color: #374151;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .filter-btn:hover {
            background: #f8fafc;
            border-color: #bfdbfe;
            color: #023e8a;
        }

        .filter-btn.active {
            background: #023e8a;
            color: #ffffff;
            border-color: #023e8a;
        }

        .pending-filter.active {
            background: #856404;
            border-color: #856404;
        }

        .confirmed-filter.active {
            background: #2e7d32;
            border-color: #2e7d32;
        }

        .rejected-filter.active {
            background: #c62828;
            border-color: #c62828;
        }

        .cancelled-filter.active {
            background: #555b61;
            border-color: #555b61;
        }

        /* =========================================
           ALERTS
        ========================================= */

        .success {
            background: #ecfdf3;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        .error {
            background: #fff1f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 13px 16px;
            border-radius: 9px;
            margin-bottom: 18px;
        }

        /* =========================================
           BOOKING SEARCH
        ========================================= */

        .booking-search {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0 0 8px;
            padding: 12px 16px;
            background: #ffffff;
            border: 1px solid #dbe5ef;
            border-radius: 12px;
        }

        .booking-search:focus-within {
            border-color: #0077b6;
            box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.10);
        }

        .booking-search .search-icon {
            color: #0077b6;
            font-size: 20px;
            flex-shrink: 0;
        }

        .booking-search input {
            width: 100%;
            min-width: 0;
            padding: 4px 0;
            border: none;
            outline: none;
            background: transparent;
            color: #183b60;
            font-family: Arial, sans-serif;
            font-size: 15px;
        }

        .booking-search input::placeholder {
            color: #8295aa;
        }

        .search-count {
            margin: 0 0 14px;
            color: #718096;
            font-size: 13px;
        }

        .search-empty {
            display: none;
            margin-bottom: 18px;
            padding: 28px 16px;
            text-align: center;
            color: #718096;
            background: #ffffff;
            border: 1px solid #dbe5ef;
            border-radius: 12px;
        }

        .search-empty strong {
            display: block;
            color: #374151;
            margin-bottom: 7px;
        }

        .search-empty p {
            font-size: 14px;
        }

        /* =========================================
           BOOKING CARD
        ========================================= */

        .booking {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            margin-bottom: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05);
            overflow: hidden;
            transition: 0.2s ease;
        }

        .booking:hover {
            border-color: #bfdbfe;
            box-shadow: 0 5px 16px rgba(15, 23, 42, 0.08);
        }

        /* =========================================
           COMPACT BOOKING HEADER
        ========================================= */

        .booking-summary {
            padding: 18px 20px;
            cursor: pointer;
            user-select: none;
        }

        .booking-summary:hover {
            background: #fafcff;
        }

        .booking-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
        }

        .guest-info h2 {
            color: #023e8a;
            font-size: 19px;
            margin-bottom: 5px;
        }

        .booking-id {
            color: #9ca3af;
            font-size: 12px;
        }

        .summary-status {
            flex-shrink: 0;
        }

        .status {
            display: inline-block;
            font-weight: bold;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .confirmed {
            background: #d4edda;
            color: #155724;
        }

        .rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .cancelled {
            background: #e2e3e5;
            color: #383d41;
        }

        .booking-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-top: 15px;
        }

        .summary-item {
            background: #f8fafc;
            border-radius: 9px;
            padding: 10px 12px;
            min-width: 0;
        }

        .summary-label {
            display: block;
            color: #9ca3af;
            font-size: 11px;
            margin-bottom: 4px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .summary-value {
            color: #374151;
            font-size: 13px;
            font-weight: 600;
            word-break: break-word;
        }

        .summary-total {
            color: #0077b6;
            font-size: 15px;
            font-weight: bold;
        }

        .booking-click-hint {
            margin-top: 13px;
            color: #9ca3af;
            font-size: 12px;
            text-align: right;
        }

        .booking-click-hint span {
            color: #0077b6;
            font-weight: bold;
        }

        /* =========================================
           BOOKING DETAILS
        ========================================= */

        .booking-details {
            display: none;
            padding: 0 20px 22px;
            border-top: 1px solid #e5e7eb;
            background: #fcfdff;
        }

        .booking.open .booking-details {
            display: block;
        }

        .booking.open .booking-click-hint {
            display: none;
        }

        .detail-section {
            margin-top: 20px;
            padding: 17px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        .detail-section h3 {
            color: #023e8a;
            font-size: 16px;
            margin-bottom: 13px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-row strong {
            color: #374151;
        }

        .detail-row span {
            color: #4b5563;
            text-align: right;
        }

        /* =========================================
           GUEST SUMMARY
        ========================================= */

        .guest-summary {
            background: #f1f9ff;
            border: 1px solid #dbeafe;
            padding: 14px;
            border-radius: 9px;
            margin-top: 20px;
        }

        .guest-summary h3 {
            color: #023e8a;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .guest-summary p {
            margin-bottom: 6px;
        }

        .guest-summary p:last-child {
            margin-bottom: 0;
        }

        .total-guests {
            font-weight: bold;
            color: #0077b6;
        }

        /* =========================================
           PAYMENT STATUS
        ========================================= */

        .payment-status {
            display: inline-block;
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .payment-for-verification {
            background: #fff3cd;
            color: #856404;
        }

        .payment-verified {
            background: #d4edda;
            color: #155724;
        }

        .payment-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .payment-not-applicable {
            background: #e2e3e5;
            color: #383d41;
        }

        /* =========================================
           GCASH PROOF
        ========================================= */

        .gcash-proof {
            margin-top: 15px;
            padding: 15px;
            background: #f8fbff;
            border: 1px solid #d7eaf5;
            border-radius: 8px;
        }

        .gcash-proof h3 {
            color: #0077b6;
            margin-bottom: 10px;
        }

        .gcash-proof img {
            display: block;
            max-width: 300px;
            width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin-top: 10px;
            cursor: pointer;
            transition: 0.2s;
        }

        .gcash-proof img:hover {
            opacity: 0.9;
            transform: scale(1.01);
        }

        .view-proof-btn {
            display: inline-block;
            margin-top: 10px;
            background: #0077b6;
            color: white;
            border: none;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .view-proof-btn:hover {
            background: #005f8f;
        }

        /* =========================================
           ACCOMMODATION TOTAL
        ========================================= */

        .accommodation-total {
            margin-top: 15px;
            padding: 15px;
            background: #f8fbff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
        }

        .accommodation-total-label {
            font-weight: bold;
            color: #023e8a;
            margin-bottom: 5px;
        }

        .accommodation-total-value {
            font-size: 22px;
            font-weight: bold;
            color: #0077b6;
        }

        /* =========================================
           FACILITY DETAILS
        ========================================= */

        .facility-details {
            margin-top: 15px;
            padding: 18px;
            background: #f0fbff;
            border: 1px solid #a5d8e8;
            border-radius: 8px;
        }

        .facility-details h3 {
            color: #005f73;
            margin-bottom: 12px;
        }

        .facility-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 7px 0;
            border-bottom: 1px solid #d7edf2;
        }

        .facility-row:last-child {
            border-bottom: none;
        }

        .facility-row-label {
            font-weight: bold;
            color: #333;
        }

        .facility-row-value {
            font-weight: bold;
            color: #0077b6;
            text-align: right;
        }

        /* =========================================
           FACILITY TOTAL
        ========================================= */

        .facility-total {
            margin-top: 15px;
            padding: 15px;
            background: #f0fbff;
            border: 1px solid #a5d8e8;
            border-radius: 8px;
        }

        .facility-total-label {
            font-weight: bold;
            color: #005f73;
            margin-bottom: 5px;
        }

        .facility-total-value {
            font-size: 22px;
            font-weight: bold;
            color: #0077b6;
        }

        .facility-not-selected {
            margin-top: 15px;
            padding: 12px 15px;
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 8px;
            color: #666;
        }

        /* =========================================
           GRAND TOTAL
        ========================================= */

        .grand-total {
            margin-top: 15px;
            padding: 18px;
            background: #ecfdf3;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .grand-total-label {
            font-size: 18px;
            font-weight: bold;
            color: #166534;
        }

        .grand-total-value {
            font-size: 24px;
            font-weight: bold;
            color: #2e7d32;
        }

        /* =========================================
           ELECTRONIC RECEIPT
        ========================================= */

        .receipt-info {
            margin-top: 15px;
            padding: 15px;
            background: #f0fff4;
            border: 1px solid #b7dfc3;
            border-radius: 8px;
        }

        .receipt-info h3 {
            color: #2e7d32;
            margin-bottom: 12px;
        }

        .receipt-number {
            display: inline-block;
            background: #d4edda;
            color: #155724;
            font-weight: bold;
            padding: 6px 12px;
            border-radius: 20px;
        }

        /* =========================================
           REJECTION
        ========================================= */

        .rejection-reason {
            background: #fff5f5;
            border-left: 4px solid #c62828;
            padding: 12px 15px;
            margin-top: 15px;
            border-radius: 5px;
        }

        .rejection-reason strong {
            color: #c62828;
        }

        .rejection-form {
            margin-top: 15px;
        }

        .rejection-form textarea {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            resize: vertical;
            margin-bottom: 10px;
        }

        .rejection-form textarea:focus {
            outline: none;
            border-color: #c62828;
        }

        .confirm-reject-btn {
            background: #c62828;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .confirm-reject-btn:hover {
            background: #a82020;
        }

        .cancel-reject-btn {
            background: #777;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            margin-left: 8px;
        }

        .cancel-reject-btn:hover {
            background: #555;
        }

        /* =========================================
           PAYMENT REJECTION
        ========================================= */

        .payment-rejection-form {
            display: block;
            margin-top: 15px;
            padding: 15px;
            background: #fff8f2;
            border: 1px solid #f3d2b3;
            border-radius: 8px;
        }

        .payment-rejection-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #e65100;
        }

        .payment-rejection-form textarea {
            width: 100%;
            max-width: 600px;
            min-height: 90px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            resize: vertical;
            margin-bottom: 10px;
        }

        .payment-rejection-form textarea:focus {
            outline: none;
            border-color: #ef6c00;
        }

        .payment-rejection-form small {
            display: block;
            color: #666;
            margin-bottom: 10px;
        }

        .payment-rejection-reason {
            background: #fff5f5;
            border-left: 4px solid #ef6c00;
            padding: 12px 15px;
            margin-top: 15px;
            border-radius: 5px;
        }

        .payment-rejection-reason strong {
            color: #e65100;
        }

        /* =========================================
           CANCELLATION REQUEST
        ========================================= */

        .cancellation-request {
            margin-top: 20px;
            padding: 18px;
            background: #fff8e8;
            border: 1px solid #f0ad4e;
            border-radius: 8px;
        }

        .cancellation-request h3 {
            color: #d58512;
            margin-bottom: 10px;
        }

        .cancellation-request p {
            margin-bottom: 8px;
        }

        .cancellation-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
            background: #fff3cd;
            color: #856404;
        }

        .cancellation-rejected {
            margin-top: 15px;
            padding: 12px 15px;
            background: #f8d7da;
            color: #721c24;
            border-left: 4px solid #c62828;
            border-radius: 5px;
        }

        /* =========================================
           ACTIONS
        ========================================= */

        .actions {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .actions form {
            display: inline;
        }

        .approve-btn,
        .approve-cancellation-btn {
            background: #2e7d32;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .reject-btn,
        .reject-cancellation-btn {
            background: #c62828;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .verify-payment-btn {
            background: #1565c0;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .reject-payment-btn {
            background: #ef6c00;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .approve-btn:hover,
        .approve-cancellation-btn:hover {
            background: #256628;
        }

        .reject-btn:hover,
        .reject-cancellation-btn:hover {
            background: #a82020;
        }

        .verify-payment-btn:hover {
            background: #0d47a1;
        }

        .reject-payment-btn:hover {
            background: #e65100;
        }

        /* =========================================
           EMPTY
        ========================================= */

        .empty {
            background: white;
            padding: 45px 30px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .empty h2 {
            color: #374151;
            margin-bottom: 8px;
        }

        .empty p {
            color: #9ca3af;
        }

        /* =========================================
           GCASH MODAL
        ========================================= */

        .proof-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .proof-modal img {
            max-width: 90%;
            max-height: 90%;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.4);
        }

        .proof-modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: white;
            font-size: 42px;
            font-weight: bold;
            cursor: pointer;
            line-height: 1;
            z-index: 10000;
        }

        .proof-modal-close:hover {
            color: #ddd;
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 800px) {

            nav {
                padding: 14px 20px;
                flex-direction: column;
                align-items: flex-start;
            }

            .nav-links {
                width: 100%;
                flex-wrap: wrap;
            }

            .container {
                margin: 25px auto;
                padding: 0 15px 30px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .booking-summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }

        @media (max-width: 500px) {

            .booking-top {
                flex-direction: column;
            }

            .summary-status {
                align-self: flex-start;
            }

            .booking-summary-grid {
                grid-template-columns: 1fr;
            }

            .detail-row {
                flex-direction: column;
                gap: 4px;
            }

            .detail-row span {
                text-align: left;
            }

            .facility-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 3px;
            }

            .facility-row-value {
                text-align: left;
            }

            .grand-total {
                flex-direction: column;
                align-items: flex-start;
            }

            .booking-filters {
                gap: 7px;
            }

            .filter-btn {
                padding: 9px 11px;
                font-size: 12px;
            }

        }

    </style>
</head>

<body>

<nav>

    <div class="nav-brand">

        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
            alt="Otirasor Beach and Resort Logo"
        >

        <div class="nav-title">

            <strong>
                Otirasor Beach and Resort
            </strong>

            <span>
                Administration Portal
            </span>

        </div>

    </div>


    <div class="nav-links">

        <a href="/admin/dashboard">
            🏠 Dashboard
        </a>

        <a href="/admin/bookings">
            📋 Bookings
        </a>

        <a href="/admin/notifications">
            🔔 Notifications
        </a>

        <form method="POST" action="/logout">

            @csrf

            <button
                type="submit"
                class="logout-btn"
            >
                🚪 Logout
            </button>

        </form>

    </div>

</nav>


<div class="container">

    <div class="page-header">

        <div class="page-header-left">

            <h1>

                @if($filter == 'pending')

                    ⏳ Pending Bookings

                @elseif($filter == 'confirmed')

                    ✅ Confirmed Bookings

                @elseif($filter == 'rejected')

                    ❌ Rejected Bookings

                @elseif($filter == 'cancelled')

                    🚫 Cancelled Bookings

                @else

                    📋 All Bookings

                @endif

            </h1>

            <p>
                Click a booking card to view complete details.
            </p>

        </div>


        <a
            href="/admin/management"
            class="back-btn"
        >
            ← Back to Management
        </a>

    </div>


    {{-- =========================================
         BOOKING FILTERS
    ========================================== --}}

    <div class="booking-filters">

        <a
            href="/admin/bookings"
            class="filter-btn {{ $filter == 'all' ? 'active' : '' }}"
        >
            📋 All
        </a>

        <a
            href="/admin/bookings?filter=pending"
            class="filter-btn pending-filter {{ $filter == 'pending' ? 'active' : '' }}"
        >
            ⏳ Pending
        </a>

        <a
            href="/admin/bookings?filter=confirmed"
            class="filter-btn confirmed-filter {{ $filter == 'confirmed' ? 'active' : '' }}"
        >
            ✅ Confirmed
        </a>

        <a
            href="/admin/bookings?filter=rejected"
            class="filter-btn rejected-filter {{ $filter == 'rejected' ? 'active' : '' }}"
        >
            ❌ Rejected
        </a>

        <a
            href="/admin/bookings?filter=cancelled"
            class="filter-btn cancelled-filter {{ $filter == 'cancelled' ? 'active' : '' }}"
        >
            🚫 Cancelled
        </a>

    </div>


    <div class="booking-search">
        <span class="search-icon" aria-hidden="true">🔎</span>
        <input
            type="search"
            id="bookingSearch"
            placeholder="Search guest name, booking ID, contact number, or room..."
            autocomplete="off"
            aria-label="Search bookings"
        >
    </div>

    <p class="search-count" id="searchCount" aria-live="polite">
        Showing {{ $bookings->count() }} booking(s)
    </p>

    <div class="search-empty" id="searchEmpty" role="status">
        <strong>No matching bookings found.</strong>
        <p>Try another guest name, booking ID, contact number, or room.</p>
    </div>


    @if(session('success'))

        <div class="success">
            {{ session('success') }}
        </div>

    @endif


    @if(session('error'))

        <div class="error">
            {{ session('error') }}
        </div>

    @endif


    @if($bookings->count() == 0)

        <div class="empty">

            <h2>
                No bookings found.
            </h2>

            <p>
                There are currently no bookings in this category.
            </p>

        </div>

    @else

        @foreach($bookings as $booking)

            @php

                $poolAdults = (int) ($booking->pool_adults ?? 0);

                $poolKids = (int) ($booking->pool_kids ?? 0);

                $entranceTotal =
                    ((int) ($booking->number_of_adults ?? 0) * 20) +
                    ((int) ($booking->number_of_kids ?? 0) * 10);

                $poolTotal =
                    ($poolAdults * 70) +
                    ($poolKids * 50);

                $grandTotal =
                    ($booking->accommodation_total ?? 0) +
                    ($booking->facility_total ?? 0);

            @endphp


            <div
                class="booking"
                id="booking-{{ $booking->id }}"
                data-booking-id="{{ $booking->id }}"
            >

                {{-- =========================================
                     COMPACT BOOKING CARD
                ========================================== --}}

                <div
                    class="booking-summary"
                    onclick="toggleBooking({{ $booking->id }})"
                >

                    <div class="booking-top">

                        <div class="guest-info">

                            <h2>
                                {{ $booking->guest_name }}
                            </h2>

                            <span class="booking-id">
                                Booking #{{ $booking->id }}
                            </span>

                        </div>


                        <div class="summary-status">

                            @if($booking->status == 'Pending')

                                <span class="status pending">
                                    Pending
                                </span>

                            @elseif($booking->status == 'Confirmed')

                                <span class="status confirmed">
                                    Confirmed
                                </span>

                            @elseif($booking->status == 'Rejected')

                                <span class="status rejected">
                                    Rejected
                                </span>

                            @elseif($booking->status == 'Cancelled')

                                <span class="status cancelled">
                                    Cancelled
                                </span>

                            @else

                                <span class="status">
                                    {{ $booking->status }}
                                </span>

                            @endif

                        </div>

                    </div>


                    <div class="booking-summary-grid">

                        <div class="summary-item">

                            <span class="summary-label">
                                📅 Check-in
                            </span>

                            <span class="summary-value">
                                {{ $booking->check_in }}
                            </span>

                        </div>


                        <div class="summary-item">

                            <span class="summary-label">
                                📅 Check-out
                            </span>

                            <span class="summary-value">
                                {{ $booking->check_out }}
                            </span>

                        </div>


                        <div class="summary-item">

                            <span class="summary-label">
                                👥 Guests
                            </span>

                            <span class="summary-value">
                                {{ $booking->number_of_guests }}
                            </span>

                        </div>


                        <div class="summary-item">

                            <span class="summary-label">
                                💰 Total
                            </span>

                            <span class="summary-total">
                                ₱{{ number_format($grandTotal, 2) }}
                            </span>

                        </div>

                    </div>


                    <div class="booking-click-hint">

                        Click this booking to view details
                        <span>→</span>

                    </div>

                </div>


                {{-- =========================================
                     FULL BOOKING DETAILS
                ========================================== --}}

                <div class="booking-details">

                    <div class="detail-section">

                        <h3>
                            👤 Guest Information
                        </h3>


                        <div class="detail-row">

                            <strong>
                                Guest Name
                            </strong>

                            <span>
                                {{ $booking->guest_name }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Contact
                            </strong>

                            <span>
                                {{ $booking->contact_number }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Adults
                            </strong>

                            <span>
                                {{ $booking->number_of_adults }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Kids
                            </strong>

                            <span>
                                {{ $booking->number_of_kids }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Total Guests
                            </strong>

                            <span>
                                {{ $booking->number_of_guests }}
                            </span>

                        </div>

                    </div>


                    <div class="detail-section">

                        <h3>
                            📅 Booking Information
                        </h3>


                        <div class="detail-row">

                            <strong>
                                Check-in
                            </strong>

                            <span>
                                {{ $booking->check_in }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Check-out
                            </strong>

                            <span>
                                {{ $booking->check_out }}
                            </span>

                        </div>


                        <div class="detail-row">

                            <strong>
                                Accommodation
                            </strong>

                            <span>
                                {{ $booking->accommodations }}
                            </span>

                        </div>

                    </div>


                    {{-- =========================================
                         ACCOMMODATION TOTAL
                    ========================================== --}}

                    <div class="accommodation-total">

                        <div class="accommodation-total-label">
                            Accommodation Total
                        </div>

                        <div class="accommodation-total-value">
                            ₱{{ number_format($booking->accommodation_total ?? 0, 2) }}
                        </div>

                    </div>


                    {{-- =========================================
                         BEACH / SWIMMING POOL
                    ========================================== --}}

                    @if(($booking->facility_total ?? 0) > 0)

                        <div class="facility-details">

                            <h3>
                                🏖️ Beach / Swimming Pool Details
                            </h3>


                            <div class="facility-row">

                                <span class="facility-row-label">
                                    Beach Entrance - Adults
                                </span>

                                <span class="facility-row-value">

                                    {{ $booking->number_of_adults }}
                                    × ₱20 =

                                    ₱{{
                                        number_format(
                                            ($booking->number_of_adults ?? 0) * 20,
                                            2
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="facility-row">

                                <span class="facility-row-label">
                                    Beach Entrance - Kids
                                </span>

                                <span class="facility-row-value">

                                    {{ $booking->number_of_kids }}
                                    × ₱10 =

                                    ₱{{
                                        number_format(
                                            ($booking->number_of_kids ?? 0) * 10,
                                            2
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="facility-row">

                                <span class="facility-row-label">
                                    Entrance Total
                                </span>

                                <span class="facility-row-value">

                                    ₱{{
                                        number_format(
                                            $entranceTotal,
                                            2
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="facility-row">

                                <span class="facility-row-label">
                                    Swimming Pool - Adults
                                </span>

                                <span class="facility-row-value">

                                    {{ $poolAdults }}
                                    × ₱70 =

                                    ₱{{
                                        number_format(
                                            $poolAdults * 70,
                                            2
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="facility-row">

                                <span class="facility-row-label">
                                    Swimming Pool - Kids
                                </span>

                                <span class="facility-row-value">

                                    {{ $poolKids }}
                                    × ₱50 =

                                    ₱{{
                                        number_format(
                                            $poolKids * 50,
                                            2
                                        )
                                    }}

                                </span>

                            </div>


                            <div class="facility-row">

                                <span class="facility-row-label">
                                    Swimming Pool Total
                                </span>

                                <span class="facility-row-value">

                                    ₱{{
                                        number_format(
                                            $poolTotal,
                                            2
                                        )
                                    }}

                                </span>

                            </div>

                        </div>


                        <div class="facility-total">

                            <div class="facility-total-label">
                                🏖️ Beach / Swimming Pool Total
                            </div>

                            <div class="facility-total-value">

                                ₱{{
                                    number_format(
                                        $booking->facility_total ?? 0,
                                        2
                                    )
                                }}

                            </div>

                        </div>

                    @else

                        <div class="facility-not-selected">

                            🏖️
                            <strong>
                                Beach / Swimming Pool:
                            </strong>

                            Not Selected

                        </div>

                    @endif


                    {{-- =========================================
                         GRAND TOTAL
                    ========================================== --}}

                    <div class="grand-total">

                        <div class="grand-total-label">
                            Grand Total
                        </div>

                        <div class="grand-total-value">

                            ₱{{
                                number_format(
                                    $grandTotal,
                                    2
                                )
                            }}

                        </div>

                    </div>


                    {{-- =========================================
                         PAYMENT
                    ========================================== --}}

                    <div class="detail-section">

                        <h3>
                            💳 Payment Information
                        </h3>


                        <div class="detail-row">

                            <strong>
                                Payment Method
                            </strong>

                            <span>
                                {{ $booking->payment_method }}
                            </span>

                        </div>


                        @if($booking->payment_method == 'GCash')

                            <div class="detail-row">

                                <strong>
                                    GCash Reference
                                </strong>

                                <span>
                                    {{ $booking->gcash_reference }}
                                </span>

                            </div>


                            <div class="detail-row">

                                <strong>
                                    Payment Status
                                </strong>

                                <span>

                                    @if($booking->payment_status == 'For Verification')

                                        <span class="payment-status payment-for-verification">
                                            For Verification
                                        </span>

                                    @elseif($booking->payment_status == 'Verified')

                                        <span class="payment-status payment-verified">
                                            Verified
                                        </span>

                                    @elseif($booking->payment_status == 'Rejected')

                                        <span class="payment-status payment-rejected">
                                            Rejected
                                        </span>

                                    @else

                                        <span class="payment-status payment-not-applicable">
                                            {{ $booking->payment_status }}
                                        </span>

                                    @endif

                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- =========================================
                         GCASH PROOF
                    ========================================== --}}

                    @if($booking->payment_method == 'GCash')

                        @if($booking->gcash_proof)

                            <div class="gcash-proof">

                                <h3>
                                    📷 GCash Payment Proof
                                </h3>

                                <p>
                                    Click the image below to view the full payment proof.
                                </p>


                                <img
                                    src="{{ asset('storage/' . $booking->gcash_proof) }}"
                                    alt="GCash payment proof"
                                    class="proof-preview"
                                    onclick="event.stopPropagation(); openProofModal('{{ asset('storage/' . $booking->gcash_proof) }}')"
                                >


                                <button
                                    type="button"
                                    class="view-proof-btn"
                                    onclick="event.stopPropagation(); openProofModal('{{ asset('storage/' . $booking->gcash_proof) }}')"
                                >
                                    Open Full Proof
                                </button>

                            </div>

                        @else

                            <div class="gcash-proof">

                                <h3>
                                    📷 GCash Payment Proof
                                </h3>

                                <p>
                                    No GCash payment proof was uploaded.
                                </p>

                            </div>

                        @endif


                        @if(
                            $booking->payment_status == 'Rejected' &&
                            $booking->payment_rejection_reason
                        )

                            <div class="payment-rejection-reason">

                                <strong>
                                    Payment Rejection Reason:
                                </strong>

                                <p>
                                    {{ $booking->payment_rejection_reason }}
                                </p>

                            </div>

                        @endif


                        @if($booking->payment_status == 'For Verification')

                            <div
                                class="actions"
                                onclick="event.stopPropagation()"
                            >

                                <form
                                    method="POST"
                                    action="/admin/bookings/{{ $booking->id }}/verify-payment"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="verify-payment-btn"
                                    >
                                        Verify Payment
                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="/admin/bookings/{{ $booking->id }}/reject-payment"
                                    class="payment-rejection-form"
                                >

                                    @csrf

                                    <label
                                        for="payment-rejection-{{ $booking->id }}"
                                    >
                                        Reason for Payment Rejection
                                    </label>

                                    <small>
                                        Please explain why the submitted GCash payment proof was rejected.
                                        This reason can be sent to the customer by email.
                                    </small>

                                    <textarea
                                        id="payment-rejection-{{ $booking->id }}"
                                        name="payment_rejection_reason"
                                        rows="3"
                                        placeholder="Example: The GCash reference number does not match the uploaded payment proof."
                                        required
                                    ></textarea>

                                    <button
                                        type="submit"
                                        class="reject-payment-btn"
                                    >
                                        Reject Payment
                                    </button>

                                </form>

                            </div>

                        @endif

                    @endif


                    {{-- =========================================
                         BOOKING STATUS
                    ========================================== --}}

                    <div class="detail-section">

                        <h3>
                            📌 Booking Status
                        </h3>


                        <div class="detail-row">

                            <strong>
                                Status
                            </strong>

                            <span>

                                @if($booking->status == 'Pending')

                                    <span class="status pending">
                                        Pending
                                    </span>

                                @elseif($booking->status == 'Confirmed')

                                    <span class="status confirmed">
                                        Confirmed
                                    </span>

                                @elseif($booking->status == 'Rejected')

                                    <span class="status rejected">
                                        Rejected
                                    </span>

                                @elseif($booking->status == 'Cancelled')

                                    <span class="status cancelled">
                                        Cancelled
                                    </span>

                                @else

                                    <span class="status">
                                        {{ $booking->status }}
                                    </span>

                                @endif

                            </span>

                        </div>

                    </div>


                    {{-- =========================================
                         ELECTRONIC RECEIPT
                    ========================================== --}}

                    @if(
                        $booking->status == 'Confirmed' &&
                        $booking->receipt_number
                    )

                        <div class="receipt-info">

                            <h3>
                                🧾 Electronic Receipt
                            </h3>

                            <p>

                                <strong>
                                    Receipt Number:
                                </strong>

                                <span class="receipt-number">
                                    {{ $booking->receipt_number }}
                                </span>

                            </p>


                            <p>

                                <strong>
                                    Receipt Generated:
                                </strong>

                                @if($booking->receipt_generated_at)

                                    {{ $booking->receipt_generated_at->format('F j, Y g:i A') }}

                                @else

                                    Not available

                                @endif

                            </p>

                        </div>

                    @endif


                    {{-- =========================================
                         BOOKING REJECTION REASON
                    ========================================== --}}

                    @if(
                        $booking->status == 'Rejected' &&
                        $booking->rejection_reason
                    )

                        <div class="rejection-reason">

                            <strong>
                                Booking Rejection Reason:
                            </strong>

                            <p>
                                {{ $booking->rejection_reason }}
                            </p>

                        </div>

                    @endif


                    {{-- =========================================
                         CANCELLATION REQUEST
                    ========================================== --}}

                    @if(
                        $booking->status == 'Confirmed' &&
                        $booking->cancellation_status == 'Pending'
                    )

                        <div class="cancellation-request">

                            <h3>
                                Cancellation Request
                            </h3>


                            <p>

                                <strong>
                                    Status:
                                </strong>

                                <span class="cancellation-status">
                                    Pending Admin Review
                                </span>

                            </p>


                            @if($booking->cancellation_requested_at)

                                <p>

                                    <strong>
                                        Requested At:
                                    </strong>

                                    {{ $booking->cancellation_requested_at->format('M d, Y h:i A') }}

                                </p>

                            @endif


                            @if($booking->cancellation_reason)

                                <p>

                                    <strong>
                                        Customer Reason:
                                    </strong>

                                    {{ $booking->cancellation_reason }}

                                </p>

                            @endif


                            <div
                                class="actions"
                                onclick="event.stopPropagation()"
                            >

                                <form
                                    method="POST"
                                    action="/admin/bookings/{{ $booking->id }}/approve-cancellation"
                                    onsubmit="return confirm('Approve this cancellation request? The booking will be cancelled.');"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="approve-cancellation-btn"
                                    >
                                        Approve Cancellation
                                    </button>

                                </form>


                                <form
                                    method="POST"
                                    action="/admin/bookings/{{ $booking->id }}/reject-cancellation"
                                    onsubmit="return confirm('Reject this cancellation request? The booking will remain confirmed.');"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="reject-cancellation-btn"
                                    >
                                        Reject Cancellation
                                    </button>

                                </form>

                            </div>

                        </div>

                    @elseif(
                        $booking->status == 'Confirmed' &&
                        $booking->cancellation_status == 'Rejected'
                    )

                        <div class="cancellation-rejected">

                            <strong>
                                Cancellation Request Rejected
                            </strong>

                            <p>
                                The customer requested cancellation previously,
                                but the request was rejected.
                            </p>

                        </div>

                    @endif


                    {{-- =========================================
                         PENDING BOOKING ACTIONS
                    ========================================== --}}

                    @if($booking->status == 'Pending')

                        <div
                            class="actions"
                            onclick="event.stopPropagation()"
                        >

                            <form
                                method="POST"
                                action="/admin/bookings/{{ $booking->id }}/approve"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="approve-btn"
                                >
                                    Approve
                                </button>

                            </form>


                            <button
                                type="button"
                                class="reject-btn"
                                onclick="showRejectForm({{ $booking->id }})"
                            >
                                Reject
                            </button>


                            <div
                                id="reject-form-{{ $booking->id }}"
                                class="rejection-form"
                                style="display: none; width: 100%;"
                            >

                                <form
                                    method="POST"
                                    action="/admin/bookings/{{ $booking->id }}/reject"
                                    style="display: block;"
                                >

                                    @csrf

                                    <textarea
                                        name="rejection_reason"
                                        placeholder="Enter the reason for rejecting this booking..."
                                        required
                                    ></textarea>

                                    <br>

                                    <button
                                        type="submit"
                                        class="confirm-reject-btn"
                                    >
                                        Confirm Rejection
                                    </button>

                                    <button
                                        type="button"
                                        class="cancel-reject-btn"
                                        onclick="hideRejectForm({{ $booking->id }})"
                                    >
                                        Cancel
                                    </button>

                                </form>

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        @endforeach

    @endif

</div>


<!-- =========================================
     GCASH PROOF MODAL
========================================= -->

<div
    id="proofModal"
    class="proof-modal"
    onclick="closeProofModal()"
>

    <span
        class="proof-modal-close"
        onclick="closeProofModal()"
    >
        &times;
    </span>

    <img
        id="proofModalImage"
        src=""
        alt="GCash Payment Proof"
        onclick="event.stopPropagation()"
    >

</div>


<script>

    /* =========================================
       TOGGLE BOOKING DETAILS
    ========================================= */

    function toggleBooking(bookingId) {

        const booking =
            document.getElementById(
                'booking-' + bookingId
            );

        if (!booking) {
            return;
        }

        booking.classList.toggle('open');

    }


    /* =========================================
       REJECTION FORM
    ========================================= */

    function showRejectForm(bookingId) {

        const form =
            document.getElementById(
                'reject-form-' + bookingId
            );

        if (form) {

            form.style.display = 'block';

        }

    }


    function hideRejectForm(bookingId) {

        const form =
            document.getElementById(
                'reject-form-' + bookingId
            );

        if (form) {

            form.style.display = 'none';

        }

    }


    /* =========================================
       OPEN GCASH PROOF
    ========================================= */

    function openProofModal(imageUrl) {

        document.getElementById(
            'proofModalImage'
        ).src = imageUrl;

        document.getElementById(
            'proofModal'
        ).style.display = 'flex';

        document.body.style.overflow = 'hidden';

    }


    /* =========================================
       CLOSE GCASH PROOF
    ========================================= */

    function closeProofModal() {

        document.getElementById(
            'proofModal'
        ).style.display = 'none';

        document.getElementById(
            'proofModalImage'
        ).src = '';

        document.body.style.overflow = '';

    }


    /* =========================================
       SEARCH BOOKINGS
    ========================================= */

    function initializeBookingSearch() {

        const searchInput = document.getElementById('bookingSearch');
        const searchCount = document.getElementById('searchCount');
        const searchEmpty = document.getElementById('searchEmpty');

        if (!searchInput || !searchCount || !searchEmpty) {
            return;
        }

        // Kunin ang booking cards pagkatapos ma-render ang page.
        const bookingCards = Array.from(
            document.querySelectorAll('.booking')
        );

        function searchBookings() {
            const query = searchInput.value.trim().toLocaleLowerCase();
            const isBookingIdSearch = /^\d+$/.test(query);
            let visibleCount = 0;

            bookingCards.forEach(function (card) {
                const searchableText = (card.innerText || card.textContent || '')
                    .toLocaleLowerCase();
                const bookingId = card.dataset.bookingId || '';

                // Kapag numero lang ang hinanap, eksaktong Booking ID ang itugma.
                // Halimbawa: "1" ay Booking #1 lamang, hindi #10 hanggang #19.
                const matches = query === '' || (
                    isBookingIdSearch
                        ? bookingId === query
                        : searchableText.includes(query)
                );

                card.style.display = matches ? '' : 'none';

                if (matches) {
                    visibleCount++;
                }
            });

            searchCount.textContent =
                'Showing ' + visibleCount + ' booking(s)';

            searchEmpty.style.display =
                visibleCount === 0 ? 'block' : 'none';
        }

        searchInput.addEventListener('input', searchBookings);

        // I-update agad ang count sa initial load.
        searchBookings();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeBookingSearch);
    } else {
        initializeBookingSearch();
    }


    /* =========================================
       ESC KEY
    ========================================= */

    document.addEventListener(
        'keydown',
        function(event) {

            if (
                event.key === 'Escape'
            ) {

                closeProofModal();

            }

        }
    );

</script>


</body>
</html>