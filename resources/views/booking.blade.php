<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Otirasor Beach and Resort - Booking</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #0077b6;
            --primary-dark: #005f8f;
            --secondary: #00b4d8;
            --dark: #023e8a;
            --light-blue: #eaf8fc;
            --background: #f4fbfd;
            --white: #ffffff;
            --text: #243746;
            --muted: #6c7a86;
            --border: #dce8ed;
            --success-bg: #e9f8f0;
            --success: #168a52;
            --danger-bg: #fff0f0;
            --danger: #c0392b;
            --warning-bg: #fff8e6;
            --warning: #9a6a00;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background:
                linear-gradient(
                    180deg,
                    #eaf9fd 0%,
                    #f4fbfd 30%,
                    #f7fbfc 100%
                );
            color: var(--text);
            min-height: 100vh;
        }

        nav {
            background: linear-gradient(
                135deg,
                #0077b6,
                #0096c7,
                #00b4d8
            );

            min-height: 78px;
            padding: 10px 6%;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow:
                0 5px 20px rgba(0, 119, 182, 0.18);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            width: 62px;
            height: 62px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;
            overflow: hidden;
            border-radius: 50%;
        }

        .brand-logo img {
            width: 62px;
            height: 62px;

            display: block;
            object-fit: contain;

            border: 0;
            outline: 0;

            filter:
                drop-shadow(
                    0 3px 5px rgba(0, 0, 0, 0.25)
                );
        }

        .brand-text {
            color: white;
        }

        .brand-title {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.2px;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 11px;
            opacity: 0.88;
            margin-top: 4px;
        }

        nav .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        nav a {
            color: white;
            text-decoration: none;

            padding: 10px 15px;
            border-radius: 9px;

            font-size: 14px;
            font-weight: 600;

            transition: 0.2s ease;
        }

        nav a:hover {
            background: rgba(255,255,255,0.16);
        }

        .page-header {
            max-width: 1000px;
            width: 92%;

            margin: 38px auto 24px;
            text-align: center;
        }

        .page-badge {
            display: inline-block;

            background: #dff6fb;
            color: var(--primary-dark);

            padding: 7px 14px;
            border-radius: 30px;

            font-size: 12px;
            font-weight: 700;

            margin-bottom: 12px;
            letter-spacing: 0.3px;
        }

        .page-header h1 {
            color: var(--dark);
            font-size: 34px;
            margin-bottom: 9px;
        }

        .page-header p {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.6;
        }

        .container {
            width: 92%;
            max-width: 1000px;

            margin: 0 auto 55px;
        }

        .card {
            background: var(--white);

            border: 1px solid var(--border);
            border-radius: 18px;

            padding: 27px;
            margin-bottom: 20px;

            box-shadow:
                0 8px 30px rgba(25, 72, 88, 0.07);
        }

        .section-heading {
            display: flex;
            align-items: center;

            gap: 13px;
            margin-bottom: 20px;
        }

        .section-icon {
            width: 43px;
            height: 43px;

            border-radius: 12px;

            background: var(--light-blue);
            color: var(--primary);

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;
            flex-shrink: 0;
        }

        .section-heading h2 {
            color: var(--dark);
            font-size: 20px;
            margin: 0;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 3px;
        }

        .error {
            background: var(--danger-bg);

            border: 1px solid #f2b8b5;
            color: var(--danger);

            padding: 16px 18px;
            border-radius: 12px;

            margin-bottom: 20px;
        }

        .error strong {
            display: block;
            margin-bottom: 6px;
        }

        .error p {
            margin: 4px 0;
            font-size: 14px;
        }

        .selected-box {
            background: linear-gradient(
                135deg,
                #effaff,
                #f7fdff
            );

            border: 1px solid #c9ebf4;
            border-radius: 14px;

            padding: 18px;
        }

        .selected-list {
            list-style: none;
            padding: 0;
        }

        .selected-item {
            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            background: white;

            border: 1px solid #bfe4ed;

            padding: 13px 15px;
            border-radius: 10px;

            margin-bottom: 9px;
        }

        .selected-item:last-child {
            margin-bottom: 0;
        }

        .selected-item-name {
            color: var(--primary-dark);

            font-size: 13px;
            font-weight: 700;
        }

        .selected-item-price {
            color: var(--dark);

            font-size: 14px;
            font-weight: 800;

            white-space: nowrap;
        }

        .accommodation-total-preview {
            margin-top: 14px;

            padding: 15px 17px;

            background: #eaf8fc;

            border: 1px solid #b9e1eb;
            border-radius: 11px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;
        }

        .accommodation-total-preview span {
            color: var(--dark);

            font-size: 14px;
            font-weight: 700;
        }

        .accommodation-total-preview strong {
            color: var(--primary);

            font-size: 20px;
            font-weight: 800;

            white-space: nowrap;
        }

        .empty {
            text-align: center;
            padding: 15px;

            color: var(--muted);
            background: white;

            border-radius: 10px;
        }

        .date-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .date-item {
            background: #f8fcfd;

            border: 1px solid var(--border);

            padding: 17px;
            border-radius: 13px;
        }

        .date-label {
            display: block;

            color: var(--muted);

            font-size: 12px;
            font-weight: 700;

            text-transform: uppercase;
            letter-spacing: 0.6px;

            margin-bottom: 6px;
        }

        .date-value {
            color: var(--dark);

            font-size: 16px;
            font-weight: 700;
        }

        .form-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .form-group {
            margin-bottom: 3px;
        }

        label {
            display: block;

            color: #334e5c;

            font-size: 13px;
            font-weight: 700;

            margin-bottom: 8px;
        }

        .required {
            color: #e05252;
        }

        input,
        select {
            width: 100%;
            height: 48px;

            padding: 0 14px;

            border: 1px solid var(--border);
            border-radius: 11px;

            background: #fbfdfe;
            color: var(--text);

            font-size: 14px;

            outline: none;
            transition: 0.2s ease;
        }

        input:hover,
        select:hover {
            border-color: #a9d6e2;
        }

        input:focus,
        select:focus {
            border-color: var(--secondary);

            background: white;

            box-shadow:
                0 0 0 4px rgba(0,180,216,0.10);
        }

        input::placeholder {
            color: #9aa8b0;
        }

        input[type="file"] {
            height: auto;

            padding: 12px 14px;

            cursor: pointer;
            background: white;
        }

        .upload-help {
            color: var(--muted);

            font-size: 12px;
            line-height: 1.5;

            margin-top: 7px;
        }

        .guest-section {
            grid-column: 1 / -1;

            background: linear-gradient(
                135deg,
                #f2fbfd,
                #ffffff
            );

            border: 1px solid #cfeaf0;
            border-radius: 15px;

            padding: 20px;
        }

        .guest-title {
            color: var(--dark);

            font-size: 15px;
            font-weight: 700;

            margin-bottom: 14px;
        }

        .guest-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .total-guests {
            margin-top: 15px;

            padding: 14px;
            border-radius: 11px;

            background: white;
            border: 1px solid #d9eaee;

            text-align: center;

            color: var(--muted);
            font-size: 13px;
        }

        .total-guests span {
            color: var(--primary);

            font-size: 19px;
            font-weight: 800;

            margin-left: 4px;
        }

        /* ==========================================
           BEACH / SWIMMING POOL
        =========================================== */

        .facility-section {
            grid-column: 1 / -1;
            margin-top: 5px;
        }

        .facility-title {
            color: var(--dark);

            font-size: 15px;
            font-weight: 700;

            margin-bottom: 9px;
        }

        .facility-box {
            background: linear-gradient(
                135deg,
                #effaff,
                #f9fdff
            );

            border: 1px solid #bfe5ee;
            border-radius: 15px;

            padding: 20px;
        }

        .facility-description {
            color: var(--muted);
            font-size: 13px;

            line-height: 1.5;
            margin-bottom: 15px;
        }

        .entrance-box {
            background: white;

            border: 1px solid #dce8ed;
            border-radius: 12px;

            padding: 16px;
            margin-bottom: 15px;
        }

        .entrance-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .entrance-header strong {
            color: var(--dark);
            font-size: 14px;
        }

        .entrance-header small {
            color: var(--muted);
            font-size: 12px;
        }

        .entrance-total {
            color: var(--primary);
            font-size: 18px;
            font-weight: 800;
            white-space: nowrap;
        }

        .pool-option {
            display: flex;
            align-items: flex-start;

            gap: 12px;

            padding: 16px;

            background: white;

            border: 1px solid #dce8ed;
            border-radius: 12px;

            cursor: pointer;

            transition: 0.2s ease;
        }

        .pool-option:hover {
            border-color: #9dd9e7;
            background: #fafdff;
        }

        .pool-option input[type="checkbox"] {
            width: 20px;
            height: 20px;

            flex-shrink: 0;

            margin-top: 2px;

            cursor: pointer;
        }

        .pool-option strong {
            color: var(--dark);
            font-size: 14px;
        }

        .pool-option small {
            color: var(--muted);
            font-size: 12px;
        }

        .pool-controls {
            display: none;

            margin-top: 15px;
            padding: 17px;

            background: #f8fcfd;

            border: 1px solid #d8e9ed;
            border-radius: 12px;
        }

        .pool-controls.active {
            display: block;
        }

        .pool-controls-title {
            color: var(--dark);
            font-size: 14px;
            font-weight: 700;

            margin-bottom: 13px;
        }

        .pool-count-grid {
            display: grid;

            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .pool-count-item {
            background: white;

            border: 1px solid var(--border);
            border-radius: 11px;

            padding: 14px;
        }

        .pool-count-item label {
            margin-bottom: 7px;
        }

        .pool-count-item select {
            background: white;
        }

        .pool-limit {
            margin-top: 10px;

            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .pool-summary {
            margin-top: 15px;

            padding: 14px;

            background: white;

            border: 1px solid #bfe5ee;
            border-radius: 11px;
        }

        .pool-summary-row {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 15px;

            padding: 6px 0;
        }

        .pool-summary-row:not(:last-child) {
            border-bottom: 1px solid #edf2f4;
        }

        .pool-summary-row span:first-child {
            color: var(--muted);
            font-size: 13px;
        }

        .pool-summary-row strong {
            color: var(--dark);
            font-size: 14px;
        }

        .pool-total-row strong {
            color: var(--primary);
            font-size: 18px;
        }

        .facility-total-preview {
            margin-top: 15px;

            padding: 15px;

            background: var(--success-bg);

            border: 1px solid #b7dfc3;
            border-radius: 11px;

            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .facility-total-preview span {
            color: #1b5e20;
            font-weight: 700;
            font-size: 14px;
        }

        .facility-total-preview strong {
            color: var(--success);
            font-size: 20px;
        }

        /* ==========================================
           GRAND TOTAL
        =========================================== */

        .grand-total-preview {
            grid-column: 1 / -1;

            margin-top: 5px;

            padding: 20px;

            background: linear-gradient(
                135deg,
                #e9f8f0,
                #f4fff8
            );

            border: 2px solid #2e7d32;
            border-radius: 14px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;

            box-shadow:
                0 5px 18px rgba(46, 125, 50, 0.10);
        }

        .grand-total-preview span {
            color: #155c37;

            font-size: 17px;
            font-weight: 800;
        }

        .grand-total-preview strong {
            color: #2e7d32;

            font-size: 28px;
            font-weight: 900;

            white-space: nowrap;
        }

        /* ==========================================
           PAYMENT
        =========================================== */

        .payment-section {
            grid-column: 1 / -1;
            margin-top: 5px;
        }

        .payment-title {
            color: var(--dark);

            font-size: 15px;
            font-weight: 700;

            margin-bottom: 9px;
        }

        .gcash-box {
            display: none;

            margin-top: 16px;
            padding: 20px;

            border-radius: 15px;

            background: linear-gradient(
                135deg,
                #effaff,
                #f9fdff
            );

            border: 1px solid #bfe5ee;
        }

        .gcash-header {
            display: flex;
            align-items: center;

            gap: 12px;
            margin-bottom: 15px;
        }

        .gcash-icon {
            width: 43px;
            height: 43px;

            border-radius: 12px;

            background: #0077b6;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        .gcash-header h3 {
            color: var(--dark);

            font-size: 17px;
            margin: 0;
        }

        .gcash-header p {
            color: var(--muted);

            font-size: 12px;
            margin-top: 3px;
        }

        .gcash-info {
            background: white;

            border: 1px solid #d8e9ed;
            border-radius: 12px;

            padding: 15px;
            margin-bottom: 16px;
        }

        .gcash-row {
            display: flex;

            justify-content: space-between;
            align-items: center;

            gap: 15px;
            padding: 7px 0;
        }

        .gcash-row:not(:last-child) {
            border-bottom: 1px solid #edf2f4;
        }

        .gcash-row span:first-child {
            color: var(--muted);
            font-size: 13px;
        }

        .gcash-row strong {
            color: var(--dark);
            font-size: 14px;
        }

        .proof-box {
            margin-top: 16px;

            background: white;

            border: 1px solid #d8e9ed;
            border-radius: 12px;

            padding: 16px;
        }

        .proof-box label {
            margin-bottom: 8px;
        }

        .note {
            grid-column: 1 / -1;

            background: var(--warning-bg);

            border: 1px solid #f0d58a;

            padding: 15px 17px;
            border-radius: 12px;

            color: #725600;

            font-size: 13px;
            line-height: 1.6;
        }

        .note strong {
            color: #5f4800;
        }

        .button-area {
            grid-column: 1 / -1;
            margin-top: 5px;
        }

        .submit-btn {
            width: 100%;
            height: 52px;

            border: none;
            border-radius: 12px;

            background: linear-gradient(
                135deg,
                #0077b6,
                #00a4cc
            );

            color: white;

            cursor: pointer;

            font-size: 15px;
            font-weight: 700;

            box-shadow:
                0 8px 20px rgba(0,119,182,0.20);

            transition: 0.2s ease;
        }

        .submit-btn:hover {
            transform: translateY(-1px);

            box-shadow:
                0 11px 25px rgba(0,119,182,0.27);
        }

        .back-btn {
            display: block;

            width: 100%;
            height: 48px;

            margin-top: 11px;
            padding: 14px;

            text-align: center;

            background: #f1f5f7;
            color: #52636d;

            text-decoration: none;
            border-radius: 11px;

            font-size: 14px;
            font-weight: 700;

            transition: 0.2s ease;
        }

        .back-btn:hover {
            background: #e5ecef;
            color: #263b45;
        }

        footer {
            text-align: center;

            color: #84939b;

            font-size: 12px;

            padding: 5px 20px 35px;
        }

        @media (max-width: 700px) {

            nav {
                min-height: auto;

                padding: 12px 5%;

                flex-direction: column;
                gap: 10px;
            }

            .brand {
                width: 100%;
                justify-content: flex-start;
            }

            .brand-logo {
                width: 54px;
                height: 54px;
            }

            .brand-logo img {
                width: 54px;
                height: 54px;
            }

            .brand-title {
                font-size: 16px;
            }

            .brand-subtitle {
                font-size: 10px;
            }

            nav .nav-links {
                width: 100%;

                justify-content: flex-start;
                flex-wrap: wrap;
            }

            nav a {
                padding: 8px 12px;
                font-size: 13px;
            }

            .page-header {
                margin-top: 28px;
            }

            .page-header h1 {
                font-size: 28px;
            }

            .container {
                width: 94%;
            }

            .card {
                padding: 20px;
                border-radius: 15px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .full-width,
            .guest-section,
            .facility-section,
            .payment-section,
            .note,
            .button-area,
            .grand-total-preview {
                grid-column: auto;
            }

            .guest-grid {
                grid-template-columns: 1fr;
            }

            .pool-count-grid {
                grid-template-columns: 1fr;
            }

            .date-grid {
                grid-template-columns: 1fr;
            }

            .section-heading h2 {
                font-size: 18px;
            }

            .gcash-row {
                align-items: flex-start;
                flex-direction: column;
                gap: 2px;
            }

            .entrance-header,
            .facility-total-preview,
            .accommodation-total-preview,
            .grand-total-preview {
                align-items: flex-start;
                flex-direction: column;
            }

            .selected-item {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (max-width: 420px) {

            .brand-logo {
                width: 50px;
                height: 50px;
            }

            .brand-logo img {
                width: 50px;
                height: 50px;
            }

            .brand-title {
                font-size: 15px;
            }

            .brand-subtitle {
                font-size: 9px;
            }

            .page-header h1 {
                font-size: 25px;
            }

            .card {
                padding: 17px;
            }

            .section-icon {
                width: 39px;
                height: 39px;
                font-size: 17px;
            }
        }
    </style>
</head>

<body>

    <nav>

        <div class="brand">

            <div class="brand-logo">

                <img
                    src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
                    alt="Otirasor Beach and Resort Logo"
                >

            </div>

            <div class="brand-text">

                <div class="brand-title">
                    Otirasor Beach and Resort
                </div>

                <div class="brand-subtitle">
                    Relax • Enjoy • Create Memories
                </div>

            </div>

        </div>

        <div class="nav-links">

            <a href="/">
                Home
            </a>

            <a href="/accommodations">
                Book Now
            </a>

        </div>

    </nav>


    <div class="page-header">

        <div class="page-badge">
            🌴 RESERVATION
        </div>

        <h1>
            Complete Your Booking
        </h1>

        <p>
            Provide your details below to submit your reservation at
            Otirasor Beach and Resort.
        </p>

    </div>


    <div class="container">

        @if ($errors->any())

            <div class="error">

                <strong>
                    ⚠ Please check the following:
                </strong>

                @foreach ($errors->all() as $error)

                    <p>
                        {{ $error }}
                    </p>

                @endforeach

            </div>

        @endif


        @if (session('error'))

            <div class="error">
                {{ session('error') }}
            </div>

        @endif


        <div class="card">

            <div class="section-heading">

                <div class="section-icon">
                    🏡
                </div>

                <div>

                    <h2>
                        Selected Accommodations
                    </h2>

                    <p>
                        Your chosen accommodation and current price
                    </p>

                </div>

            </div>


            <div class="selected-box">

                @if(count($accommodations) > 0)

                    <ul class="selected-list">

                        @foreach($accommodations as $accommodation)

                            @php
                                $selectedAccommodation =
                                    $selectedAccommodations->firstWhere(
                                        'name',
                                        $accommodation
                                    );
                            @endphp

                            <li class="selected-item">

                                <span class="selected-item-name">
                                    ✓ {{ $accommodation }}
                                </span>

                                <span class="selected-item-price">

                                    @if($selectedAccommodation)

                                        ₱{{ number_format(
                                            $selectedAccommodation->price,
                                            2
                                        ) }}

                                    @else

                                        Price unavailable

                                    @endif

                                </span>

                            </li>

                        @endforeach

                    </ul>


                    <div class="accommodation-total-preview">

                        <span>
                            🏠 Accommodation Total
                        </span>

                        <strong>
                            ₱<span id="accommodation_total_preview">
                                {{ number_format(
                                    $accommodationTotal,
                                    2
                                ) }}
                            </span>
                        </strong>

                    </div>

                @else

                    <div class="empty">
                        No accommodation selected.
                    </div>

                @endif

            </div>

        </div>


        <div class="card">

            <div class="section-heading">

                <div class="section-icon">
                    📅
                </div>

                <div>

                    <h2>
                        Booking Dates
                    </h2>

                    <p>
                        Your selected check-in and check-out dates
                    </p>

                </div>

            </div>


            <div class="date-grid">

                <div class="date-item">

                    <span class="date-label">
                        Check-in
                    </span>

                    <div class="date-value">
                        {{ $checkIn ?: 'Not selected' }}
                    </div>

                </div>


                <div class="date-item">

                    <span class="date-label">
                        Check-out
                    </span>

                    <div class="date-value">
                        {{ $checkOut ?: 'Not selected' }}
                    </div>

                </div>

            </div>

        </div>


        <div class="card">

            <div class="section-heading">

                <div class="section-icon">
                    👤
                </div>

                <div>

                    <h2>
                        Guest Information
                    </h2>

                    <p>
                        Please provide the information needed for your reservation
                    </p>

                </div>

            </div>


            <form
                method="POST"
                action="/booking"
                enctype="multipart/form-data"
            >

                @csrf


                @foreach($accommodations as $accommodation)

                    <input
                        type="hidden"
                        name="accommodations[]"
                        value="{{ $accommodation }}"
                    >

                @endforeach


                <div class="form-grid">


                    <div class="form-group">

                        <label for="guest_name">
                            Guest Name <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="guest_name"
                            name="guest_name"
                            value="{{ old('guest_name') }}"
                            placeholder="Enter guest name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="contact_number">
                            Contact Number <span class="required">*</span>
                        </label>

                        <input
                            type="text"
                            id="contact_number"
                            name="contact_number"
                            value="{{ old('contact_number') }}"
                            placeholder="Enter contact number"
                            required
                        >

                    </div>


                    <div class="guest-section">

                        <div class="guest-title">
                            👥 Number of Guests
                        </div>


                        <div class="guest-grid">


                            <div class="form-group">

                                <label for="number_of_adults">
                                    Adults <span class="required">*</span>
                                </label>

                                <select
                                    id="number_of_adults"
                                    name="number_of_adults"
                                    required
                                >

                                    @for($i = 1; $i <= 50; $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('number_of_adults', 1) == $i ? 'selected' : '' }}
                                        >
                                            {{ $i }}
                                        </option>

                                    @endfor

                                </select>

                            </div>


                            <div class="form-group">

                                <label for="number_of_kids">
                                    Kids
                                </label>

                                <select
                                    id="number_of_kids"
                                    name="number_of_kids"
                                    required
                                >

                                    @for($i = 0; $i <= 50; $i++)

                                        <option
                                            value="{{ $i }}"
                                            {{ old('number_of_kids', 0) == $i ? 'selected' : '' }}
                                        >
                                            {{ $i }}
                                        </option>

                                    @endfor

                                </select>

                            </div>

                        </div>


                        <div class="total-guests">

                            Total Guests:

                            <span id="total_guests">
                                {{ old('number_of_adults', 1) + old('number_of_kids', 0) }}
                            </span>

                        </div>


                        <input
                            type="hidden"
                            id="number_of_guests"
                            name="number_of_guests"
                            value="{{ old('number_of_adults', 1) + old('number_of_kids', 0) }}"
                        >

                    </div>


                    <div class="form-group">

                        <label for="check_in">
                            Check-in Date <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            id="check_in"
                            name="check_in"
                            value="{{ old('check_in', $checkIn) }}"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="check_out">
                            Check-out Date <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            id="check_out"
                            name="check_out"
                            value="{{ old('check_out', $checkOut) }}"
                            required
                        >

                    </div>


                    <!-- ==========================================
                         BEACH / SWIMMING POOL
                    =========================================== -->

                    <div class="facility-section">

                        <div class="facility-title">
                            🏖️ Beach / Swimming Pool
                        </div>

                        <div class="facility-box">

                            <p class="facility-description">
                                Beach entrance is automatically included based on
                                the number of guests. Swimming pool use is optional.
                            </p>


                            <div class="entrance-box">

                                <div class="entrance-header">

                                    <div>

                                        <strong>
                                            🏖️ Beach Entrance
                                        </strong>

                                        <br>

                                        <small>
                                            Adults ₱20 • Kids ₱10
                                            • Automatically charged for all guests
                                        </small>

                                    </div>

                                    <div class="entrance-total">
                                        ₱<span id="entrance_total">30.00</span>
                                    </div>

                                </div>

                            </div>


                            <label class="pool-option">

                                <input
                                    type="checkbox"
                                    name="swimming_pool"
                                    value="1"
                                    id="swimming_pool"
                                    {{ old('swimming_pool') ? 'checked' : '' }}
                                >

                                <span>

                                    <strong>
                                        🏊 Add Swimming Pool
                                    </strong>

                                    <br>

                                    <small>
                                        Adult ₱70 • Kids ₱50
                                    </small>

                                </span>

                            </label>


                            <div
                                id="pool-controls"
                                class="pool-controls {{ old('swimming_pool') ? 'active' : '' }}"
                            >

                                <div class="pool-controls-title">
                                    👥 Who will use the swimming pool?
                                </div>


                                <div class="pool-count-grid">


                                    <div class="pool-count-item">

                                        <label for="pool_adults">
                                            Adults Swimming
                                        </label>

                                        <select
                                            id="pool_adults"
                                            name="pool_adults"
                                        >

                                            @for($i = 0; $i <= 50; $i++)

                                                <option
                                                    value="{{ $i }}"
                                                    {{ old('pool_adults', 0) == $i ? 'selected' : '' }}
                                                >
                                                    {{ $i }}
                                                </option>

                                            @endfor

                                        </select>

                                    </div>


                                    <div class="pool-count-item">

                                        <label for="pool_kids">
                                            Kids Swimming
                                        </label>

                                        <select
                                            id="pool_kids"
                                            name="pool_kids"
                                        >

                                            @for($i = 0; $i <= 50; $i++)

                                                <option
                                                    value="{{ $i }}"
                                                    {{ old('pool_kids', 0) == $i ? 'selected' : '' }}
                                                >
                                                    {{ $i }}
                                                </option>

                                            @endfor

                                        </select>

                                    </div>

                                </div>


                                <div class="pool-limit">
                                    The number of swimmers cannot exceed the number
                                    of adult and kid guests.
                                </div>


                                <div class="pool-summary">

                                    <div class="pool-summary-row">

                                        <span>
                                            Adult Pool Fee
                                        </span>

                                        <strong>
                                            ₱<span id="pool_adult_total">0.00</span>
                                        </strong>

                                    </div>


                                    <div class="pool-summary-row">

                                        <span>
                                            Kids Pool Fee
                                        </span>

                                        <strong>
                                            ₱<span id="pool_kid_total">0.00</span>
                                        </strong>

                                    </div>


                                    <div class="pool-summary-row pool-total-row">

                                        <span>
                                            Swimming Pool Total
                                        </span>

                                        <strong>
                                            ₱<span id="pool_total">0.00</span>
                                        </strong>

                                    </div>

                                </div>

                            </div>


                            <div class="facility-total-preview">

                                <span>
                                    🧾 Facility Total
                                </span>

                                <strong>
                                    ₱<span id="facility_total_preview">30.00</span>
                                </strong>

                            </div>

                        </div>

                    </div>


                    <!-- ==========================================
                         PAYMENT
                    =========================================== -->

                    <div class="payment-section">

                        <div class="payment-title">
                            💳 Payment Method
                        </div>

                        <select
                            name="payment_method"
                            id="payment_method"
                            required
                        >

                            <option value="">
                                Select payment method
                            </option>

                            <option
                                value="Cash"
                                {{ old('payment_method') == 'Cash' ? 'selected' : '' }}
                            >
                                Cash
                            </option>

                            <option
                                value="GCash"
                                {{ old('payment_method') == 'GCash' ? 'selected' : '' }}
                            >
                                GCash
                            </option>

                        </select>


                        <div
                            id="gcash-payment"
                            class="gcash-box"
                        >

                            <div class="gcash-header">

                                <div class="gcash-icon">
                                    ₱
                                </div>

                                <div>

                                    <h3>
                                        GCash Payment
                                    </h3>

                                    <p>
                                        Send your payment using the account below.
                                    </p>

                                </div>

                            </div>


                            <div class="gcash-info">

                                <div class="gcash-row">

                                    <span>
                                        GCash Number
                                    </span>

                                    <strong>
                                        09945598510
                                    </strong>

                                </div>


                                <div class="gcash-row">

                                    <span>
                                        Account Name
                                    </span>

                                    <strong>
                                        Otirasor Beach
                                    </strong>

                                </div>

                            </div>


                            <div class="form-group">

                                <label for="gcash_reference">
                                    GCash Reference Number
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="gcash_reference"
                                    name="gcash_reference"
                                    value="{{ old('gcash_reference') }}"
                                    placeholder="Enter 13-digit reference number"
                                    maxlength="13"
                                    minlength="13"
                                    pattern="[0-9]{13}"
                                    inputmode="numeric"
                                >

                            </div>


                            <div class="proof-box">

                                <label for="gcash_proof">
                                    GCash Payment Proof
                                    <span class="required">*</span>
                                </label>

                                <input
                                    type="file"
                                    id="gcash_proof"
                                    name="gcash_proof"
                                    accept=".jpg,.jpeg,.png,image/jpeg,image/png"
                                >

                                <div class="upload-help">
                                    Upload a screenshot or photo of your GCash payment.
                                    JPG, JPEG, or PNG only. Maximum file size: 5 MB.
                                </div>

                            </div>

                        </div>

                    </div>


                    <!-- ==========================================
                         FINAL GRAND TOTAL
                    =========================================== -->

                    <div class="grand-total-preview">

                        <span>
                            💰 Grand Total
                        </span>

                        <strong>
                            ₱<span id="grand_total_preview">
                                {{ number_format(
                                    $accommodationTotal + 30,
                                    2
                                ) }}
                            </span>
                        </strong>

                    </div>


                    <div class="note">

                        <strong>
                            Important:
                        </strong>

                        Your booking will be submitted as
                        <strong>Pending</strong>
                        and will still require manager approval before it becomes confirmed.

                        <br><br>

                        For GCash payments, the uploaded payment proof and reference number
                        will be checked by the administrator before the payment is verified.

                    </div>


                    <div class="button-area">

                        <button
                            type="submit"
                            class="submit-btn"
                        >
                            Continue Booking
                        </button>


                        <a
                            href="/accommodations"
                            class="back-btn"
                        >
                            ← Back to Accommodations
                        </a>

                    </div>


                </div>

            </form>

        </div>

    </div>


    <footer>

        © {{ date('Y') }} Otirasor Beach and Resort
        • Reservation System

    </footer>


    <script>

        // =====================================================
        // ACCOMMODATION TOTAL
        // =====================================================

        const accommodationTotal =
            {{ (float) $accommodationTotal }};


        // =====================================================
        // GUEST TOTAL
        // =====================================================

        const adults =
            document.getElementById('number_of_adults');

        const kids =
            document.getElementById('number_of_kids');

        const totalGuests =
            document.getElementById('total_guests');

        const totalGuestsInput =
            document.getElementById('number_of_guests');


        function updateGuestTotal() {

            const adultCount =
                parseInt(adults.value) || 0;

            const kidCount =
                parseInt(kids.value) || 0;

            const total =
                adultCount + kidCount;


            totalGuests.textContent =
                total;

            totalGuestsInput.value =
                total;


            updatePoolOptions();

            updateFacilityTotal();

        }


        adults.addEventListener(
            'change',
            updateGuestTotal
        );

        kids.addEventListener(
            'change',
            updateGuestTotal
        );


        // =====================================================
        // BEACH ENTRANCE
        // AUTOMATIC FOR ALL GUESTS
        // =====================================================

        function updateEntranceTotal() {

            const adultCount =
                parseInt(adults.value) || 0;

            const kidCount =
                parseInt(kids.value) || 0;


            const entranceTotal =
                (adultCount * 20) +
                (kidCount * 10);


            document.getElementById(
                'entrance_total'
            ).textContent =
                entranceTotal.toFixed(2);

        }


        // =====================================================
        // SWIMMING POOL
        // =====================================================

        const swimmingPool =
            document.getElementById('swimming_pool');

        const poolControls =
            document.getElementById('pool-controls');

        const poolAdults =
            document.getElementById('pool_adults');

        const poolKids =
            document.getElementById('pool_kids');


        function updatePoolOptions() {

            const adultCount =
                parseInt(adults.value) || 0;

            const kidCount =
                parseInt(kids.value) || 0;


            const currentPoolAdults =
                parseInt(poolAdults.value) || 0;

            const currentPoolKids =
                parseInt(poolKids.value) || 0;


            if (
                currentPoolAdults > adultCount
            ) {

                poolAdults.value =
                    adultCount;

            }


            if (
                currentPoolKids > kidCount
            ) {

                poolKids.value =
                    kidCount;

            }


            Array.from(
                poolAdults.options
            ).forEach(
                function(option) {

                    option.disabled =
                        parseInt(option.value) >
                        adultCount;

                }
            );


            Array.from(
                poolKids.options
            ).forEach(
                function(option) {

                    option.disabled =
                        parseInt(option.value) >
                        kidCount;

                }
            );


            updatePoolTotal();

        }


        function updatePoolTotal() {

            const swimmersAdults =
                parseInt(poolAdults.value) || 0;

            const swimmersKids =
                parseInt(poolKids.value) || 0;


            const adultPoolTotal =
                swimmersAdults * 70;

            const kidPoolTotal =
                swimmersKids * 50;


            const poolTotal =
                adultPoolTotal +
                kidPoolTotal;


            document.getElementById(
                'pool_adult_total'
            ).textContent =
                adultPoolTotal.toFixed(2);


            document.getElementById(
                'pool_kid_total'
            ).textContent =
                kidPoolTotal.toFixed(2);


            document.getElementById(
                'pool_total'
            ).textContent =
                poolTotal.toFixed(2);


            updateFacilityTotal();

        }


        swimmingPool.addEventListener(
            'change',
            function() {

                if (
                    swimmingPool.checked
                ) {

                    poolControls.classList.add(
                        'active'
                    );

                } else {

                    poolControls.classList.remove(
                        'active'
                    );

                    poolAdults.value =
                        0;

                    poolKids.value =
                        0;

                }


                updatePoolTotal();

            }
        );


        poolAdults.addEventListener(
            'change',
            updatePoolTotal
        );

        poolKids.addEventListener(
            'change',
            updatePoolTotal
        );


        // =====================================================
        // FACILITY TOTAL
        // ENTRANCE + OPTIONAL POOL
        // =====================================================

        function updateFacilityTotal() {

            const adultCount =
                parseInt(adults.value) || 0;

            const kidCount =
                parseInt(kids.value) || 0;


            const entranceTotal =
                (adultCount * 20) +
                (kidCount * 10);


            let poolTotal = 0;


            if (
                swimmingPool.checked
            ) {

                const swimmersAdults =
                    parseInt(poolAdults.value) || 0;

                const swimmersKids =
                    parseInt(poolKids.value) || 0;


                poolTotal =
                    (swimmersAdults * 70) +
                    (swimmersKids * 50);

            }


            const facilityTotal =
                entranceTotal +
                poolTotal;


            document.getElementById(
                'facility_total_preview'
            ).textContent =
                facilityTotal.toFixed(2);


            document.getElementById(
                'entrance_total'
            ).textContent =
                entranceTotal.toFixed(2);


            // =================================================
            // GRAND TOTAL
            // ACCOMMODATION + FACILITY
            // =================================================

            const grandTotal =
                accommodationTotal +
                facilityTotal;


            document.getElementById(
                'grand_total_preview'
            ).textContent =
                grandTotal.toFixed(2);

        }


        // =====================================================
        // INITIALIZE FACILITY CALCULATIONS
        // =====================================================

        updateGuestTotal();

        updateEntranceTotal();

        updatePoolOptions();

        updatePoolTotal();

        updateFacilityTotal();


        // =====================================================
        // PAYMENT / GCASH
        // =====================================================

        const paymentMethod =
            document.getElementById('payment_method');

        const gcashPayment =
            document.getElementById('gcash-payment');

        const gcashReference =
            document.getElementById('gcash_reference');

        const gcashProof =
            document.getElementById('gcash_proof');


        function updateGCash() {

            if (
                paymentMethod.value === 'GCash'
            ) {

                gcashPayment.style.display =
                    'block';

                gcashReference.required =
                    true;

                gcashReference.setAttribute(
                    'name',
                    'gcash_reference'
                );

                gcashProof.required =
                    true;

                gcashProof.setAttribute(
                    'name',
                    'gcash_proof'
                );

            } else {

                gcashPayment.style.display =
                    'none';

                gcashReference.required =
                    false;

                gcashReference.removeAttribute(
                    'name'
                );

                gcashReference.value =
                    '';

                gcashProof.required =
                    false;

                gcashProof.removeAttribute(
                    'name'
                );

                gcashProof.value =
                    '';

            }

        }


        paymentMethod.addEventListener(
            'change',
            updateGCash
        );


        updateGCash();


        // =====================================================
        // CHECK-IN / CHECK-OUT
        // =====================================================

        const checkIn =
            document.getElementById('check_in');

        const checkOut =
            document.getElementById('check_out');


        checkIn.addEventListener(
            'change',
            function() {

                if (checkIn.value) {

                    checkOut.min =
                        checkIn.value;

                }

            }
        );


        if (checkIn.value) {

            checkOut.min =
                checkIn.value;

        }

    </script>

</body>
</html>