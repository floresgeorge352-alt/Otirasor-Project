<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Otirasor Beach and Resort - Book Now
    </title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f2fbfc;
            color: #243b4a;
            min-height: 100vh;
        }

        /* =====================================================
           NAVIGATION
           ===================================================== */

        nav {
            background: linear-gradient(
                135deg,
                #006994,
                #008cba
            );

            padding: 9px 55px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            box-shadow:
                0 3px 15px rgba(0, 70, 100, 0.18);

            position: sticky;

            top: 0;

            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
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
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand-title {
            color: white;
            font-size: 20px;
            font-weight: bold;
            line-height: 1.2;
        }

        .brand-subtitle {
            color: rgba(255,255,255,0.88);
            font-size: 11px;
            margin-top: 4px;
            letter-spacing: 0.2px;
        }

        nav .nav-links {
            display: flex;
            align-items: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 15px;
            font-weight: 600;
            transition: 0.2s;
        }

        nav a:hover {
            opacity: 0.75;
        }

        /* =====================================================
           HERO
           ===================================================== */

        .page-hero {
            background:
                linear-gradient(
                    135deg,
                    #0077a8,
                    #00a6c7
                );

            color: white;
            text-align: center;
            padding: 55px 20px 70px;
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: "🌴";
            position: absolute;
            left: 7%;
            top: 25px;
            font-size: 55px;
            opacity: 0.18;
            transform: rotate(-10deg);
        }

        .page-hero::after {
            content: "🌊";
            position: absolute;
            right: 8%;
            bottom: 15px;
            font-size: 65px;
            opacity: 0.18;
        }

        .hero-icon {
            font-size: 42px;
            margin-bottom: 12px;
        }

        .page-hero h1 {
            font-size: 38px;
            margin-bottom: 12px;
            color: white;
        }

        .page-hero p {
            font-size: 17px;
            opacity: 0.92;
            max-width: 650px;
            margin: auto;
            line-height: 1.6;
        }

        /* =====================================================
           MAIN
           ===================================================== */

        .container {
            max-width: 1150px;
            margin: -30px auto 0;
            padding: 0 25px 60px;
            position: relative;
            z-index: 2;
        }

        .category-intro {
            background: white;
            padding: 35px;
            border-radius: 18px;

            box-shadow:
                0 8px 30px rgba(0, 80, 100, 0.10);

            text-align: center;
            margin-bottom: 25px;
        }

        .category-intro h2 {
            color: #006994;
            font-size: 28px;
            margin-bottom: 8px;
        }

        .category-intro p {
            color: #6a7d87;
            line-height: 1.6;
        }

        /* =====================================================
           SELECTION SUMMARY
           ===================================================== */

        .selection-summary {
            background: linear-gradient(
                135deg,
                #e5f8f3,
                #effcf9
            );

            border: 1px solid #8edbc7;

            color: #126b59;

            padding: 15px 20px;

            border-radius: 12px;

            margin-bottom: 25px;

            text-align: center;

            font-weight: bold;

            box-shadow:
                0 3px 10px rgba(0, 120, 100, 0.06);
        }

        #selectedCount {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 28px;

            height: 28px;

            padding: 0 8px;

            margin-left: 5px;

            border-radius: 20px;

            background: #008f73;

            color: white;
        }

        /* =====================================================
           CATEGORY BUTTONS
           ===================================================== */

        .category-buttons {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;

            margin-top: 25px;
        }

        .category-btn {
            border: none;

            border-radius: 18px;

            padding: 35px 20px;

            min-height: 180px;

            background: white;

            color: #006994;

            cursor: pointer;

            box-shadow:
                0 7px 22px rgba(0, 70, 100, 0.09);

            transition:
                transform 0.25s,
                box-shadow 0.25s,
                background 0.25s;

            position: relative;

            overflow: hidden;
        }

        .category-btn::after {
            content: "";

            position: absolute;

            width: 90px;

            height: 90px;

            border-radius: 50%;

            background: #e7f8fb;

            right: -25px;

            bottom: -25px;

            transition: 0.25s;
        }

        .category-btn:hover {
            transform: translateY(-7px);

            background: linear-gradient(
                135deg,
                #0077a8,
                #00a6c7
            );

            color: white;

            box-shadow:
                0 12px 30px rgba(0, 100, 140, 0.20);
        }

        .category-btn:hover::after {
            background: rgba(255,255,255,0.13);
            transform: scale(1.5);
        }

        .category-icon {
            display: block;
            font-size: 43px;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }

        .category-name {
            display: block;
            font-size: 21px;
            font-weight: bold;
            position: relative;
            z-index: 2;
        }

        .category-description {
            display: block;
            font-size: 13px;
            margin-top: 8px;
            opacity: 0.75;
            position: relative;
            z-index: 2;
        }

        /* =====================================================
           CONTINUE
           ===================================================== */

        .continue-area {
            text-align: center;
            margin-top: 35px;
        }

        .continue-btn {
            padding: 15px 32px;

            background: linear-gradient(
                135deg,
                #008f73,
                #00ad8a
            );

            color: white;

            border: none;

            border-radius: 30px;

            cursor: pointer;

            font-size: 16px;

            font-weight: bold;

            box-shadow:
                0 6px 18px rgba(0, 130, 100, 0.20);

            transition: 0.25s;
        }

        .continue-btn:hover {
            transform: translateY(-3px);

            box-shadow:
                0 9px 24px rgba(0, 130, 100, 0.28);
        }

        /* =====================================================
           CATEGORY PAGE
           ===================================================== */

        .category-page {
            max-width: 1150px;
            margin: 0 auto;
        }

        .back-btn {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            margin-bottom: 20px;

            padding: 10px 17px;

            background: white;

            color: #006994;

            text-decoration: none;

            border-radius: 9px;

            font-weight: bold;

            box-shadow:
                0 3px 12px rgba(0, 70, 100, 0.08);

            transition: 0.2s;
        }

        .back-btn:hover {
            background: #006994;
            color: white;
            transform: translateX(-3px);
        }

        .category-title {
            text-align: center;

            color: #006994;

            margin: 5px 0 25px;

            font-size: 32px;
        }

        /* =====================================================
           ROOM TYPE SELECTOR
           ===================================================== */

        .room-type-box {
            max-width: 700px;

            margin: 0 auto 30px;

            background: white;

            padding: 25px;

            border-radius: 18px;

            box-shadow:
                0 8px 25px rgba(0, 70, 100, 0.10);

            text-align: center;
        }

        .room-type-box h2 {
            color: #006994;

            font-size: 22px;

            margin-bottom: 8px;
        }

        .room-type-box p {
            color: #71818a;

            font-size: 14px;

            margin-bottom: 20px;
        }

        .room-type-buttons {
            display: grid;

            grid-template-columns: repeat(2, 1fr);

            gap: 15px;
        }

        .room-type-btn {
            border: 2px solid #d7e8ed;

            background: #f8fcfd;

            color: #006994;

            padding: 18px 15px;

            border-radius: 13px;

            cursor: pointer;

            font-size: 16px;

            font-weight: bold;

            transition: 0.2s;
        }

        .room-type-btn:hover {
            border-color: #00a6c7;

            transform: translateY(-2px);
        }

        .room-type-btn.active {
            background: linear-gradient(
                135deg,
                #0077a8,
                #00a6c7
            );

            border-color: #0077a8;

            color: white;

            box-shadow:
                0 6px 18px rgba(0, 120, 160, 0.18);
        }

        .room-type-icon {
            display: block;

            font-size: 28px;

            margin-bottom: 6px;
        }

        /* =====================================================
           DATE BOX
           ===================================================== */

        .date-box {
            max-width: 600px;

            margin: 0 auto 30px;

            background: white;

            padding: 30px;

            border-radius: 18px;

            box-shadow:
                0 8px 25px rgba(0, 70, 100, 0.10);
        }

        .date-box-header {
            text-align: center;
            margin-bottom: 22px;
        }

        .date-box-header h2 {
            color: #006994;
            font-size: 23px;
            margin-bottom: 7px;
        }

        .date-box-header p {
            color: #71818a;
            font-size: 14px;
        }

        .date-box label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #405864;
        }

        .date-box input {
            width: 100%;

            padding: 13px 14px;

            margin-bottom: 18px;

            border: 1px solid #d4e1e6;

            border-radius: 9px;

            font-size: 15px;

            background: #f9fcfd;

            color: #334e5a;

            outline: none;

            transition: 0.2s;
        }

        .date-box input:focus {
            border-color: #00a6c7;

            box-shadow:
                0 0 0 3px rgba(0,166,199,0.10);

            background: white;
        }

        .date-btn {
            width: 100%;

            padding: 13px;

            background: linear-gradient(
                135deg,
                #0077a8,
                #00a6c7
            );

            color: white;

            border: none;

            border-radius: 9px;

            cursor: pointer;

            font-weight: bold;

            font-size: 15px;

            transition: 0.2s;
        }

        .date-btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 6px 15px rgba(0, 120, 160, 0.18);
        }

        .date-error {
            color: #d93025;

            text-align: center;

            margin-top: 12px;

            font-weight: bold;

            font-size: 14px;
        }

        /* =====================================================
           DATE SUMMARY
           ===================================================== */

        .date-summary {
            background: white;

            border-radius: 14px;

            padding: 18px 22px;

            margin-bottom: 20px;

            display: flex;

            justify-content: center;

            gap: 45px;

            flex-wrap: wrap;

            box-shadow:
                0 5px 18px rgba(0,70,100,0.07);
        }

        .date-summary p {
            margin: 0;
            color: #516873;
        }

        .date-summary strong {
            color: #006994;
        }

        /* =====================================================
           CAPACITY FILTER
           ===================================================== */

        .capacity-box {
            background: white;

            padding: 18px;

            border-radius: 14px;

            margin-bottom: 20px;

            box-shadow:
                0 5px 18px rgba(0,70,100,0.07);

            text-align: center;
        }

        .capacity-title {
            color: #006994;

            font-weight: bold;

            font-size: 16px;

            margin-bottom: 12px;
        }

        .capacity-buttons {
            display: flex;

            justify-content: center;

            gap: 10px;

            flex-wrap: wrap;
        }

        .capacity-btn {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            padding: 11px 18px;

            border: 1px solid #d4e5e9;

            background: #f7fbfc;

            color: #006994;

            border-radius: 9px;

            text-decoration: none;

            font-weight: bold;

            font-size: 14px;

            transition: 0.2s;
        }

        .capacity-btn:hover {
            background: #e7f7fa;

            border-color: #00a6c7;

            transform: translateY(-2px);
        }

        .capacity-btn.active {
            background: linear-gradient(
                135deg,
                #0077a8,
                #00a6c7
            );

            border-color: #0077a8;

            color: white;

            box-shadow:
                0 5px 15px rgba(0,120,160,0.15);
        }

        /* =====================================================
           SEARCH
           ===================================================== */

        .search-box {
            background: white;

            padding: 18px;

            border-radius: 14px;

            margin-bottom: 25px;

            box-shadow:
                0 5px 18px rgba(0,70,100,0.07);
        }

        .search-form {
            display: flex;

            gap: 10px;

            align-items: center;
        }

        .search-input {
            flex: 1;

            min-width: 0;

            padding: 13px 15px;

            border: 1px solid #d4e1e6;

            border-radius: 9px;

            font-size: 15px;

            background: #f9fcfd;

            color: #334e5a;

            outline: none;
        }

        .search-input:focus {
            border-color: #00a6c7;

            box-shadow:
                0 0 0 3px rgba(0,166,199,0.10);

            background: white;
        }

        .search-btn {
            padding: 13px 20px;

            background: linear-gradient(
                135deg,
                #0077a8,
                #00a6c7
            );

            color: white;

            border: none;

            border-radius: 9px;

            cursor: pointer;

            font-weight: bold;

            font-size: 14px;

            white-space: nowrap;
        }

        .clear-search {
            padding: 13px 18px;

            background: #edf5f7;

            color: #006994;

            border-radius: 9px;

            text-decoration: none;

            font-weight: bold;

            font-size: 14px;

            white-space: nowrap;
        }

        .results-info {
            color: #71818a;

            font-size: 14px;

            margin-bottom: 18px;

            text-align: center;
        }

        /* =====================================================
           ACCOMMODATION GRID
           ===================================================== */

        .rooms {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 22px;
        }

        .room {
            background: white;

            border-radius: 16px;

            padding: 0;

            box-shadow:
                0 6px 20px rgba(0, 70, 100, 0.08);

            overflow: hidden;

            border: 1px solid #e6f0f3;

            transition:
                transform 0.25s,
                box-shadow 0.25s;

            position: relative;
        }

        .room:hover {
            transform: translateY(-6px);

            box-shadow:
                0 12px 28px rgba(0, 70, 100, 0.14);
        }

        .room::before {
            content: "";

            display: block;

            height: 6px;

            background: linear-gradient(
                90deg,
                #0077a8,
                #00b4d8
            );
        }

        /* =====================================================
           ACCOMMODATION PHOTO
           ===================================================== */

        .room-image {
            width: 100%;

            height: 220px;

            background: #edf5f7;

            overflow: hidden;

            display: flex;

            align-items: center;

            justify-content: center;
        }

        .room-image img {
            width: 100%;

            height: 100%;

            object-fit: cover;

            display: block;
        }

        .no-room-image {
            color: #7a8d96;

            font-size: 14px;

            text-align: center;

            padding: 20px;
        }

        .room-content {
            padding: 24px;
        }

        .room h3 {
            color: #006994;
            margin-bottom: 10px;
            font-size: 21px;
        }

        .room-content p {
            line-height: 1.5;
            color: #667983;
            font-size: 14px;
            margin-bottom: 9px;
        }

        .price {
            font-size: 20px !important;

            font-weight: bold;

            color: #008f73 !important;

            margin-top: 15px;
        }

        .available {
            display: inline-block;

            background: #e5f8ef;

            color: #16805d !important;

            padding: 6px 10px;

            border-radius: 20px;

            font-weight: bold;

            font-size: 13px !important;
        }

        .booked {
            display: inline-block;

            background: #fff0f0;

            color: #d33b3b !important;

            padding: 6px 10px;

            border-radius: 20px;

            font-weight: bold;

            font-size: 13px !important;
        }

        /* =====================================================
           SELECT
           ===================================================== */

        .select-box {
            margin-top: 18px;

            padding-top: 15px;

            border-top: 1px solid #edf2f4;
        }

        .select-box label {
            display: flex;

            align-items: center;

            gap: 9px;

            cursor: pointer;

            font-weight: bold;

            color: #006994;

            font-size: 14px;
        }

        .select-box input {
            appearance: none;

            width: 20px;

            height: 20px;

            border: 2px solid #9bb8c2;

            border-radius: 5px;

            cursor: pointer;

            position: relative;

            transition: 0.2s;
        }

        .select-box input:checked {
            background: #008f73;

            border-color: #008f73;
        }

        .select-box input:checked::after {
            content: "✓";

            color: white;

            position: absolute;

            font-size: 13px;

            font-weight: bold;

            left: 3px;

            top: -1px;
        }

        /* =====================================================
           PAGINATION
           ===================================================== */

        .pagination-area {
            margin-top: 35px;

            display: flex;

            justify-content: center;

            align-items: center;

            gap: 8px;

            flex-wrap: wrap;
        }

        .pagination-link {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 42px;

            height: 42px;

            padding: 0 14px;

            border-radius: 9px;

            background: white;

            color: #006994;

            text-decoration: none;

            font-weight: bold;

            border: 1px solid #d9e9ed;

            transition: 0.2s;
        }

        .pagination-link:hover {
            background: #006994;

            color: white;

            border-color: #006994;
        }

        .pagination-link.active {
            background: linear-gradient(
                135deg,
                #0077a8,
                #00a6c7
            );

            color: white;

            border-color: #0077a8;
        }

        .pagination-link.disabled {
            color: #a4b4ba;

            background: #f1f5f6;

            cursor: not-allowed;
        }

        /* =====================================================
           EMPTY
           ===================================================== */

        .empty {
            text-align: center;

            background: white;

            padding: 40px;

            border-radius: 15px;

            color: #667983;

            grid-column: 1 / -1;
        }

        /* =====================================================
           FOOTER
           ===================================================== */

        footer {
            text-align: center;

            padding: 25px;

            background: #034b63;

            color: white;

            margin-top: 30px;

            font-size: 13px;
        }

        /* =====================================================
           MOBILE
           ===================================================== */

        @media (max-width: 850px) {

            nav {
                padding: 10px 25px;
            }

            .rooms {
                grid-template-columns:
                    repeat(2, 1fr);
            }

            .category-buttons {
                grid-template-columns:
                    1fr;
            }

        }

        @media (max-width: 600px) {

            nav {
                flex-direction: column;

                gap: 10px;

                text-align: center;

                padding: 12px 20px;
            }

            .brand {
                width: 100%;
                justify-content: center;
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
                justify-content: center;
            }

            nav a {
                margin-left: 10px;
                margin-right: 10px;
            }

            .page-hero {
                padding: 45px 20px 60px;
            }

            .page-hero h1 {
                font-size: 30px;
            }

            .page-hero p {
                font-size: 15px;
            }

            .container {
                padding:
                    0 15px 45px;
            }

            .rooms {
                grid-template-columns: 1fr;
            }

            .date-summary {
                gap: 12px;
                flex-direction: column;
            }

            .category-intro {
                padding: 25px 20px;
            }

            .category-intro h2 {
                font-size: 24px;
            }

            .room-type-buttons {
                grid-template-columns: 1fr;
            }

            .room-image {
                height: 210px;
            }

            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input,
            .search-btn,
            .clear-search {
                width: 100%;
            }

            .capacity-buttons {
                flex-direction: column;
            }

            .capacity-btn {
                width: 100%;
            }

            .pagination-area {
                gap: 6px;
            }

            .pagination-link {
                min-width: 38px;
                height: 38px;
                padding: 0 10px;
                font-size: 13px;
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

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVIGATION
====================================================== -->

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



<!-- =====================================================
     HERO
====================================================== -->

<section class="page-hero">

    <div class="hero-icon">
        🏖️
    </div>

    <h1>
        Plan Your Stay
    </h1>

    <p>
        Choose your preferred accommodation and
        select your dates for a relaxing stay
        at Otirasor Beach and Resort.
    </p>

</section>



<div class="container">


    @php

        $currentCategory =
            request('category', '');

        $roomType =
            request('room_type', 'day_use');

        $capacity =
            request('capacity', '');

        $selectedAccommodations =
            array_filter(
                explode(
                    ',',
                    request('selected', '')
                )
            );

        $search =
            request('search', '');

    @endphp



    {{-- =====================================================
         MAIN CATEGORY PAGE
    ====================================================== --}}

    @if($currentCategory === '')


        <div class="category-intro">

            <h2>
                What Would You Like to Book?
            </h2>

            <p>
                Select an accommodation category
                to explore your available options.
            </p>

        </div>


        <div class="selection-summary">

            Selected accommodations:

            <span id="selectedCount">

                {{ count($selectedAccommodations) }}

            </span>

        </div>


        <div class="category-buttons">


            <button
                type="button"
                class="category-btn"
                onclick="openCategory('rooms')"
            >

                <span class="category-icon">
                    🛏️
                </span>

                <span class="category-name">
                    Rooms
                </span>

                <span class="category-description">
                    Day Use & Overnight
                </span>

            </button>



            <button
                type="button"
                class="category-btn"
                onclick="openCategory('cottages')"
            >

                <span class="category-icon">
                    🏡
                </span>

                <span class="category-name">
                    Cottages
                </span>

                <span class="category-description">
                    Relax with family and friends
                </span>

            </button>



            <button
                type="button"
                class="category-btn"
                onclick="openCategory('halls')"
            >

                <span class="category-icon">
                    🎉
                </span>

                <span class="category-name">
                    Function Halls
                </span>

                <span class="category-description">
                    Perfect for gatherings and events
                </span>

            </button>


        </div>


        <div class="continue-area">

            <button
                type="button"
                class="continue-btn"
                onclick="goToBooking()"
            >

                Continue to Booking →

            </button>

        </div>


    {{-- =====================================================
         CATEGORY PAGE
    ====================================================== --}}

    @else


        <div class="category-page">


            <a
                href="#"
                class="back-btn"
                onclick="goBackToCategories(event)"
            >

                ← Back to Categories

            </a>



            @if($currentCategory === 'rooms')


                <h1 class="category-title">

                    🛏️ Rooms

                </h1>


                <div class="room-type-box">

                    <h2>
                        Choose Your Room Type
                    </h2>

                    <p>
                        Select whether you want a Day Use or Overnight room.
                    </p>


                    <div class="room-type-buttons">


                        <button
                            type="button"
                            class="room-type-btn {{ $roomType === 'day_use' ? 'active' : '' }}"
                            onclick="changeRoomType('day_use')"
                        >

                            <span class="room-type-icon">
                                ☀️
                            </span>


                            <small>
                                Day stay
                            </small>

                        </button>



                        <button
                            type="button"
                            class="room-type-btn {{ $roomType === 'overnight' ? 'active' : '' }}"
                            onclick="changeRoomType('overnight')"
                        >

                            <span class="room-type-icon">
                                🌙
                            </span>


                            <small>
                                Overnight stay
                            </small>

                        </button>


                    </div>

                </div>


            @elseif($currentCategory === 'cottages')


                <h1 class="category-title">

                    🏡 Cottages

                </h1>


            @elseif($currentCategory === 'halls')


                <h1 class="category-title">

                    🎉 Function Halls

                </h1>


            @endif



            {{-- =================================================
                 DATE SELECTION
            ================================================== --}}


            @if(!$checkIn || !$checkOut)


                <div class="date-box">


                    <div class="date-box-header">

                        <h2>
                            📅 Select Your Dates
                        </h2>

                        <p>
                            Choose your check-in and check-out dates.
                        </p>

                    </div>


                    <form
                        method="GET"
                        action="/accommodations"
                        onsubmit="return validateDateForm()"
                    >


                        <input
                            type="hidden"
                            name="category"
                            value="{{ $currentCategory }}"
                        >


                        @if($currentCategory === 'rooms')

                            <input
                                type="hidden"
                                name="room_type"
                                value="{{ $roomType }}"
                            >

                        @endif


                        @if($currentCategory === 'cottages')

                            @if($capacity !== '')

                                <input
                                    type="hidden"
                                    name="capacity"
                                    value="{{ $capacity }}"
                                >

                            @endif

                        @endif


                        @if(count($selectedAccommodations) > 0)

                            <input
                                type="hidden"
                                name="selected"
                                value="{{ implode(',', $selectedAccommodations) }}"
                            >

                        @endif


                        <label for="check_in">
                            Check-in Date
                        </label>


                        <input
                            type="date"
                            id="check_in"
                            name="check_in"
                            value="{{ $checkIn }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >


                        <label for="check_out">
                            Check-out Date
                        </label>


                        <input
                            type="date"
                            id="check_out"
                            name="check_out"
                            value="{{ $checkOut }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >


                        <button
                            type="submit"
                            class="date-btn"
                        >

                            Check Availability

                        </button>


                        <div
                            id="date-error"
                            class="date-error"
                        ></div>


                    </form>

                </div>


            @else


                {{-- =================================================
                     DATE SUMMARY
                ================================================== --}}


                <div class="date-summary">


                    <p>

                        📅

                        <strong>
                            Check-in:
                        </strong>

                        {{ $checkIn }}

                    </p>


                    <p>

                        📅

                        <strong>
                            Check-out:
                        </strong>

                        {{ $checkOut }}

                    </p>


                </div>



                <div class="selection-summary">

                    Selected accommodations:

                    <span id="selectedCount">

                        {{ count($selectedAccommodations) }}

                    </span>

                </div>



                {{-- =================================================
                     COTTAGE CAPACITY FILTER
                ================================================== --}}


                @if($currentCategory === 'cottages')


                    <div class="capacity-box">

                        <div class="capacity-title">

                            👥 Choose Cottage Capacity

                        </div>


                        <div class="capacity-buttons">


                            {{-- ALL COTTAGES --}}

                            <a
                                href="{{ url('/accommodations') }}?category=cottages&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}"
                                class="capacity-btn {{ $capacity === '' ? 'active' : '' }}"
                            >

                                All Cottages

                            </a>



                            {{-- 15 PERSONS --}}

                            <a
                                href="{{ url('/accommodations') }}?category=cottages&capacity=15&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}"
                                class="capacity-btn {{ $capacity === '15' ? 'active' : '' }}"
                            >

                                15 Persons

                            </a>



                            {{-- 20 PERSONS --}}

                            <a
                                href="{{ url('/accommodations') }}?category=cottages&capacity=20&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}"
                                class="capacity-btn {{ $capacity === '20' ? 'active' : '' }}"
                            >

                                20 Persons

                            </a>


                        </div>

                    </div>


                @endif



                {{-- =================================================
                     SEARCH
                ================================================== --}}


                <div class="search-box">


                    <form
                        method="GET"
                        action="/accommodations"
                        class="search-form"
                    >


                        <input
                            type="hidden"
                            name="category"
                            value="{{ $currentCategory }}"
                        >


                        @if($currentCategory === 'rooms')

                            <input
                                type="hidden"
                                name="room_type"
                                value="{{ $roomType }}"
                            >

                        @endif


                        @if($currentCategory === 'cottages')

                            @if($capacity !== '')

                                <input
                                    type="hidden"
                                    name="capacity"
                                    value="{{ $capacity }}"
                                >

                            @endif

                        @endif


                        <input
                            type="hidden"
                            name="check_in"
                            value="{{ $checkIn }}"
                        >


                        <input
                            type="hidden"
                            name="check_out"
                            value="{{ $checkOut }}"
                        >


                        @if(count($selectedAccommodations) > 0)

                            <input
                                type="hidden"
                                name="selected"
                                value="{{ implode(',', $selectedAccommodations) }}"
                            >

                        @endif


                        <input
                            type="search"
                            name="search"
                            class="search-input"
                            value="{{ $search }}"
                            placeholder="🔎 Search accommodation..."
                            autocomplete="off"
                        >


                        <button
                            type="submit"
                            class="search-btn"
                        >

                            Search

                        </button>


                        @if($search !== '')

                            <a
                                href="{{ url('/accommodations') }}?category={{ urlencode($currentCategory) }}{{ $currentCategory === 'rooms' ? '&room_type=' . urlencode($roomType) : '' }}{{ $currentCategory === 'cottages' && $capacity !== '' ? '&capacity=' . urlencode($capacity) : '' }}&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}{{ count($selectedAccommodations) > 0 ? '&selected=' . urlencode(implode(',', $selectedAccommodations)) : '' }}"
                                class="clear-search"
                            >

                                Clear

                            </a>

                        @endif


                    </form>

                </div>



                {{-- =================================================
                     RESULTS INFORMATION
                ================================================== --}}


                @if($accommodations->total() > 0)

                    <div class="results-info">

                        Showing

                        <strong>
                            {{ $accommodations->firstItem() }}
                        </strong>

                        to

                        <strong>
                            {{ $accommodations->lastItem() }}
                        </strong>

                        of

                        <strong>
                            {{ $accommodations->total() }}
                        </strong>

                        accommodations

                        @if($search !== '')

                            matching

                            <strong>
                                "{{ $search }}"
                            </strong>

                        @endif

                        @if(
                            $currentCategory === 'cottages' &&
                            $capacity !== ''
                        )

                            ·

                            <strong>
                                {{ $capacity }} persons
                            </strong>

                        @endif

                    </div>

                @endif



                {{-- =================================================
                     ACCOMMODATIONS
                ================================================== --}}


                <div class="rooms">


                    @forelse($accommodations as $accommodation)


                        <div class="room">


                            {{-- =================================================
                                 ACCOMMODATION PHOTO
                            ================================================== --}}


                            <div class="room-image">


                                @if(!empty($accommodation['image']))


                                    <img
                                        src="{{ asset('storage/' . $accommodation['image']) }}"
                                        alt="{{ $accommodation['name'] }}"
                                    >


                                @else


                                    <div class="no-room-image">

                                        No photo available

                                    </div>


                                @endif


                            </div>



                            <div class="room-content">


                                <h3>

                                    {{ $accommodation['name'] }}

                                </h3>



                                @if(!empty($accommodation['description']))


                                    <p>

                                        {{ $accommodation['description'] }}

                                    </p>


                                @endif



                                @if($accommodation['capacity'] > 0)


                                    <p>

                                        👥 Capacity:

                                        {{ $accommodation['capacity'] }}

                                        persons

                                    </p>


                                @endif



                                <p class="price">

                                    ₱{{ number_format(
                                        $accommodation['price'],
                                        2
                                    ) }}


                                    @if(
                                        $currentCategory === 'rooms'
                                        &&
                                        $roomType === 'overnight'
                                    )

                                        / night

                                    @elseif(
                                        $currentCategory === 'rooms'
                                        &&
                                        $roomType === 'day_use'
                                    )

                                        / day

                                    @endif

                                </p>



                                @if($accommodation['available'])


                                    <p class="available">

                                        ✓ Available

                                    </p>



                                    <div class="select-box">


                                        <label>


                                            <input
                                                type="checkbox"
                                                name="accommodations[]"
                                                value="{{ $accommodation['name'] }}"
                                                @checked(
                                                    in_array(
                                                        $accommodation['name'],
                                                        $selectedAccommodations
                                                    )
                                                )
                                            >


                                            Select this accommodation


                                        </label>


                                    </div>


                                @else


                                    <p class="booked">

                                        ✕ Already Booked

                                    </p>


                                @endif


                            </div>


                        </div>


                    @empty


                        <div class="empty">


                            @if($search !== '')


                                <h3>

                                    No accommodations found

                                </h3>


                                <p style="margin-top: 10px;">

                                    No accommodations matched
                                    your search for

                                    <strong>
                                        "{{ $search }}"
                                    </strong>.

                                </p>


                                <div style="margin-top: 20px;">


                                    <a
                                        href="{{ url('/accommodations') }}?category={{ urlencode($currentCategory) }}{{ $currentCategory === 'rooms' ? '&room_type=' . urlencode($roomType) : '' }}{{ $currentCategory === 'cottages' && $capacity !== '' ? '&capacity=' . urlencode($capacity) : '' }}&check_in={{ urlencode($checkIn) }}&check_out={{ urlencode($checkOut) }}"
                                        class="clear-search"
                                    >

                                        Clear Search

                                    </a>


                                </div>


                            @elseif($currentCategory === 'rooms')


                                <h3>

                                    No rooms found

                                </h3>


                                <p style="margin-top: 10px;">

                                    There are no
                                    {{ $roomType === 'day_use' ? 'Day Use' : 'Overnight' }}
                                    rooms available in the system yet.

                                </p>


                            @elseif($currentCategory === 'cottages')


                                <h3>

                                    No cottages found

                                </h3>


                                <p style="margin-top: 10px;">

                                    @if($capacity === '15')

                                        No 15-person cottages have been added yet.

                                    @elseif($capacity === '20')

                                        No 20-person cottages have been added yet.

                                    @else

                                        No cottages have been added yet.

                                    @endif

                                </p>


                            @else


                                <h3>

                                    No function halls found

                                </h3>


                                <p style="margin-top: 10px;">

                                    No function halls have been added yet.

                                </p>


                            @endif


                        </div>


                    @endforelse


                </div>



                {{-- =================================================
                     PAGINATION
                ================================================== --}}


                @if($accommodations->hasPages())


                    <div class="pagination-area">


                        @if($accommodations->onFirstPage())


                            <span class="pagination-link disabled">

                                ← Previous

                            </span>


                        @else


                            <a
                                href="{{ $accommodations->previousPageUrl() }}"
                                class="pagination-link"
                            >

                                ← Previous

                            </a>


                        @endif



                        @foreach(
                            $accommodations->getUrlRange(
                                max(
                                    1,
                                    $accommodations->currentPage() - 2
                                ),
                                min(
                                    $accommodations->lastPage(),
                                    $accommodations->currentPage() + 2
                                )
                            )
                            as $page => $url
                        )


                            @if($page == $accommodations->currentPage())


                                <span class="pagination-link active">

                                    {{ $page }}

                                </span>


                            @else


                                <a
                                    href="{{ $url }}"
                                    class="pagination-link"
                                >

                                    {{ $page }}

                                </a>


                            @endif


                        @endforeach



                        @if($accommodations->hasMorePages())


                            <a
                                href="{{ $accommodations->nextPageUrl() }}"
                                class="pagination-link"
                            >

                                Next →

                            </a>


                        @else


                            <span class="pagination-link disabled">

                                Next →

                            </span>


                        @endif


                    </div>


                @endif



                <div class="continue-area">


                    <button
                        type="button"
                        class="continue-btn"
                        onclick="goToBooking()"
                    >

                        Continue to Booking →

                    </button>


                </div>


            @endif


        </div>


    @endif


</div>



<!-- =====================================================
     FOOTER
====================================================== -->

<footer>

    © 2026 Otirasor Beach and Resort

    · Enjoy your stay 🌊

</footer>



<script>


    function getSelected() {

        const params =
            new URLSearchParams(
                window.location.search
            );

        const selected =
            params.get('selected');

        if (!selected) {

            return [];

        }

        return selected
            .split(',')
            .filter(Boolean);

    }



    function openCategory(category) {

        const params =
            new URLSearchParams(
                window.location.search
            );

        const checkIn =
            params.get('check_in');

        const checkOut =
            params.get('check_out');

        const selected =
            params.get('selected');


        let url =
            '/accommodations?category=' +
            encodeURIComponent(category);


        if (category === 'rooms') {

            url +=
                '&room_type=day_use';

        }


        if (checkIn && checkOut) {

            url +=
                '&check_in=' +
                encodeURIComponent(checkIn) +
                '&check_out=' +
                encodeURIComponent(checkOut);

        }


        if (selected) {

            url +=
                '&selected=' +
                encodeURIComponent(selected);

        }


        window.location.href =
            url;

    }



    function changeRoomType(roomType) {

        const params =
            new URLSearchParams(
                window.location.search
            );

        const checkIn =
            params.get('check_in');

        const checkOut =
            params.get('check_out');

        const selected =
            params.get('selected');


        let url =
            '/accommodations?' +
            'category=rooms' +
            '&room_type=' +
            encodeURIComponent(roomType);


        if (checkIn && checkOut) {

            url +=
                '&check_in=' +
                encodeURIComponent(checkIn) +
                '&check_out=' +
                encodeURIComponent(checkOut);

        }


        if (selected) {

            url +=
                '&selected=' +
                encodeURIComponent(selected);

        }


        window.location.href =
            url;

    }



    function goBackToCategories(event) {

        event.preventDefault();


        const params =
            new URLSearchParams(
                window.location.search
            );


        const checkIn =
            params.get('check_in');

        const checkOut =
            params.get('check_out');

        const selected =
            params.get('selected');


        let query = [];


        if (checkIn) {

            query.push(
                'check_in=' +
                encodeURIComponent(checkIn)
            );

        }


        if (checkOut) {

            query.push(
                'check_out=' +
                encodeURIComponent(checkOut)
            );

        }


        if (selected) {

            query.push(
                'selected=' +
                encodeURIComponent(selected)
            );

        }


        let url =
            '/accommodations';


        if (query.length > 0) {

            url +=
                '?' +
                query.join('&');

        }


        window.location.href =
            url;

    }



    document.addEventListener(
        'change',
        function(event) {

            if (
                !event.target.matches(
                    'input[name="accommodations[]"]'
                )
            ) {

                return;

            }


            let selected =
                getSelected();


            const value =
                event.target.value;


            if (event.target.checked) {

                if (
                    !selected.includes(value)
                ) {

                    selected.push(value);

                }

            }

            else {

                selected =
                    selected.filter(
                        function(item) {

                            return item !== value;

                        }
                    );

            }


            updateSelectedInUrl(
                selected
            );

        }
    );



    function updateSelectedInUrl(selected) {

        const params =
            new URLSearchParams(
                window.location.search
            );


        if (
            selected.length > 0
        ) {

            params.set(
                'selected',
                selected.join(',')
            );

        }

        else {

            params.delete(
                'selected'
            );

        }


        const newUrl =
            window.location.pathname +
            '?' +
            params.toString();


        window.history.replaceState(
            {},
            '',
            newUrl
        );


        updateSelectedCount(
            selected
        );

    }



    function updateSelectedCount(selected) {

        const elements =
            document.querySelectorAll(
                '#selectedCount'
            );


        elements.forEach(
            function(element) {

                element.textContent =
                    selected.length;

            }
        );

    }



    function validateDateForm() {

        const checkIn =
            document.getElementById(
                'check_in'
            ).value;


        const checkOut =
            document.getElementById(
                'check_out'
            ).value;


        const error =
            document.getElementById(
                'date-error'
            );


        error.textContent =
            '';


        if (!checkIn || !checkOut) {

            error.textContent =
                'Please select check-in and check-out dates.';

            return false;

        }


        if (checkOut <= checkIn) {

            error.textContent =
                'Check-out date must be after check-in date.';

            return false;

        }


        return true;

    }



    function goToBooking() {

        const selected =
            getSelected();


        if (
            selected.length === 0
        ) {

            alert(
                'Please select at least one available accommodation.'
            );

            return;

        }


        const params =
            new URLSearchParams(
                window.location.search
            );


        const checkIn =
            params.get('check_in');


        const checkOut =
            params.get('check_out');


        if (
            !checkIn ||
            !checkOut
        ) {

            alert(
                'Please choose a category and select your dates first.'
            );

            return;

        }


        window.location.href =
            '/booking?accommodations=' +
            encodeURIComponent(
                selected.join(',')
            ) +
            '&check_in=' +
            encodeURIComponent(
                checkIn
            ) +
            '&check_out=' +
            encodeURIComponent(
                checkOut
            );

    }



    document.addEventListener(
        'DOMContentLoaded',
        function() {

            const selected =
                getSelected();


            updateSelectedCount(
                selected
            );

        }
    );

</script>


</body>

</html>