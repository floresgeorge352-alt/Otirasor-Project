<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Otirasor Beach and Resort</title>


    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        html {
            scroll-behavior: smooth;
        }


        body {
            font-family: Arial, sans-serif;
            background: #f4fbfd;
            color: #333;
        }


        /* =====================================================
           NAVIGATION
           ===================================================== */

        nav {
            background: linear-gradient(
                135deg,
                #0077b6,
                #0096c7
            );

            padding: 12px 50px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            position: relative;

            z-index: 20;

            box-shadow:
                0 3px 15px rgba(0, 0, 0, 0.12);
        }


        .brand {
            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

            font-size: 23px;

            font-weight: bold;
        }


        .brand img {
            width: 50px;

            height: 50px;

            object-fit: contain;

            border-radius: 50%;

            background: white;

            border: 2px solid white;

            box-shadow:
                0 3px 8px rgba(0, 0, 0, 0.18);
        }


        .brand span {
            white-space: nowrap;
        }


        .nav-links {
            display: flex;

            align-items: center;

            gap: 25px;
        }


        nav a {
            color: white;

            text-decoration: none;

            font-size: 15px;

            font-weight: 500;

            transition: 0.2s;
        }


        nav a:hover {
            color: #dff8ff;

            transform: translateY(-1px);
        }


        .logout-btn {
            background: none;

            border: none;

            color: white;

            font-size: 15px;

            cursor: pointer;

            font-family: Arial, sans-serif;

            transition: 0.2s;
        }


        .logout-btn:hover {
            color: #dff8ff;
        }


        /* =====================================================
           HERO
           ===================================================== */

        .hero {

            min-height: 650px;

            display: flex;

            align-items: center;

            justify-content: center;

            text-align: center;

            padding: 60px 20px;

            background-image:
                linear-gradient(
                    rgba(0, 50, 80, 0.20),
                    rgba(0, 100, 150, 0.25)
                ),
                url('{{ asset('images/Home-hero.jpeg.jpg') }}?v={{ filemtime(public_path('images/Home-hero.jpeg.jpg')) }}');

            background-size: 125%;

            background-position: center center;

            background-repeat: no-repeat;

            color: white;

            position: relative;

            overflow: hidden;
        }


        .hero::before,
        .hero::after {
            content: none !important;

            display: none !important;
        }


        .hero-content {

            max-width: 900px;

            width: 100%;

            position: relative;

            z-index: 2;

            padding: 20px;
        }


        .hero-logo {

            width: 115px;

            height: 115px;

            object-fit: contain;

            border-radius: 50%;

            background: white;

            padding: 5px;

            margin-bottom: 22px;

            box-shadow:
                0 7px 22px rgba(0, 0, 0, 0.25);

            border:
                3px solid rgba(255, 255, 255, 0.95);
        }


        .hero h1 {

            font-size: 52px;

            line-height: 1.12;

            margin-bottom: 15px;

            font-weight: 800;

            text-shadow:
                0 3px 10px rgba(0, 0, 0, 0.55);
        }


        .hero h2 {

            font-size: 24px;

            font-weight: normal;

            margin-bottom: 15px;

            text-shadow:
                0 2px 7px rgba(0, 0, 0, 0.50);
        }


        .hero p {

            font-size: 18px;

            line-height: 1.6;

            margin: 0 auto 28px;

            max-width: 650px;

            text-shadow:
                0 2px 6px rgba(0, 0, 0, 0.50);
        }


        .btn {

            display: inline-flex;

            align-items: center;

            justify-content: center;

            gap: 10px;

            background: white;

            color: #0077b6;

            padding: 15px 34px;

            border-radius: 35px;

            text-decoration: none;

            font-weight: bold;

            font-size: 17px;

            transition: 0.25s;

            box-shadow:
                0 5px 18px rgba(0, 0, 0, 0.25);
        }


        .btn:hover {

            background: #e8f9ff;

            transform: translateY(-3px);

            box-shadow:
                0 8px 22px rgba(0, 0, 0, 0.28);
        }


        /* =====================================================
           WELCOME SECTION
           ===================================================== */

        .welcome-section {

            text-align: center;

            padding: 75px 20px;

            background: white;
        }


        .welcome-section h2 {

            color: #0077b6;

            font-size: 32px;

            margin-bottom: 16px;
        }


        .welcome-section p {

            max-width: 760px;

            margin: auto;

            line-height: 1.8;

            color: #555;

            font-size: 17px;
        }


        /* =====================================================
           FEATURES
           ===================================================== */

        .features {

            padding: 65px 20px;

            background:
                linear-gradient(
                    180deg,
                    #eef9fd,
                    #e7f6fb
                );

            text-align: center;
        }


        .features h2 {

            color: #023e8a;

            margin-bottom: 38px;

            font-size: 31px;
        }


        .feature-container {

            max-width: 1100px;

            margin: auto;

            display: grid;

            grid-template-columns:
                repeat(5, 1fr);

            gap: 20px;
        }


        .feature-card {

            background: white;

            padding: 30px 18px;

            border-radius: 18px;

            box-shadow:
                0 5px 18px rgba(0, 80, 120, 0.08);

            transition: 0.25s;

            border:
                1px solid #e2f2f7;
        }


        .feature-card:hover {

            transform: translateY(-6px);

            box-shadow:
                0 10px 25px rgba(0, 80, 120, 0.13);
        }


        .feature-icon {

            font-size: 40px;

            margin-bottom: 15px;
        }


        .feature-card h3 {

            color: #0077b6;

            margin-bottom: 10px;

            font-size: 18px;
        }


        .feature-card p {

            color: #666;

            line-height: 1.5;

            font-size: 14px;
        }


        /* =====================================================
           FOOTER
           ===================================================== */

        footer {

            background:
                linear-gradient(
                    135deg,
                    #023e8a,
                    #0077b6
                );

            color: white;

            text-align: center;

            padding: 24px;
        }


        footer p {

            font-size: 14px;

            opacity: 0.95;
        }


        /* =====================================================
           MOBILE
           ===================================================== */

        @media (max-width: 950px) {

            .feature-container {

                grid-template-columns:
                    repeat(2, 1fr);
            }

        }


        @media (max-width: 700px) {

            nav {

                padding: 12px 18px;

                flex-direction: column;

                gap: 12px;
            }


            .brand {

                font-size: 19px;
            }


            .brand img {

                width: 45px;

                height: 45px;
            }


            .brand span {

                white-space: normal;

                text-align: center;
            }


            .nav-links {

                gap: 16px;

                flex-wrap: wrap;

                justify-content: center;
            }


            nav a,
            .logout-btn {

                font-size: 14px;
            }


            .hero {

                min-height: 600px;

                padding: 50px 15px;

                background-position: center center;
            }


            .hero-logo {

                width: 95px;

                height: 95px;

                margin-bottom: 18px;
            }


            .hero h1 {

                font-size: 36px;

                line-height: 1.15;
            }


            .hero h2 {

                font-size: 20px;
            }


            .hero p {

                font-size: 16px;

                max-width: 500px;
            }


            .btn {

                padding: 14px 28px;

                font-size: 16px;
            }


            .feature-container {

                grid-template-columns:
                    1fr;
            }


            .feature-card {

                width: 100%;

                max-width: 360px;

                margin: auto;
            }


            .welcome-section,
            .features {

                padding-left: 18px;

                padding-right: 18px;
            }


            .welcome-section h2,
            .features h2 {

                font-size: 27px;
            }

        }

    </style>

</head>


<body>


<!-- =====================================================
     NAVIGATION
     ===================================================== -->

<nav>


    <div class="brand">

        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
            alt="Otirasor Beach and Resort Logo"
        >

        <span>
            Otirasor Beach and Resort
        </span>

    </div>


    <div class="nav-links">

        <a href="/">
            Home
        </a>


        <a href="/about">
            About
        </a>


        <a href="/contact">
            Contact
        </a>


        @auth

            <a href="/dashboard">
                Dashboard
            </a>


            <form
                method="POST"
                action="/logout"
                style="display:inline;"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >
                    Logout
                </button>

            </form>

        @else

            <a href="/login">
                Login
            </a>


            <a href="/register">
                Register
            </a>

        @endauth

    </div>

</nav>



<!-- =====================================================
     HERO
     ===================================================== -->

<section class="hero">


    <div class="hero-content">


        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
            alt="Otirasor Beach and Resort Logo"
            class="hero-logo"
        >


        <h1>
            Welcome to Otirasor Beach and Resort
        </h1>


        <h2>
            Relax • Enjoy • Create Memories
        </h2>


        <p>
            Your place to relax, enjoy, and create lasting memories.
        </p>


        <a
            href="/accommodations"
            class="btn"
        >
            🗓️ &nbsp; Book Your Stay &nbsp; →
        </a>


    </div>


</section>



<!-- =====================================================
     WELCOME
     ===================================================== -->

<section class="welcome-section">


    <h2>
        Your Beach Resort Destination
    </h2>


    <p>

        Otirasor Beach and Resort provides a place
        where guests can relax, spend time with family
        and friends, and enjoy comfortable accommodations
        and resort facilities.

    </p>


</section>



<!-- =====================================================
     FEATURES
     ===================================================== -->

<section class="features">


    <h2>
        Explore What We Offer
    </h2>


    <div class="feature-container">


        <div class="feature-card">

            <div class="feature-icon">
                🏖️
            </div>

            <h3>
                Beach
            </h3>

            <p>
                Enjoy a relaxing beach experience
                with family and friends.
            </p>

        </div>



        <div class="feature-card">

            <div class="feature-icon">
                🏊
            </div>

            <h3>
                Swimming Pool
            </h3>

            <p>
                Spend time swimming and relaxing
                at the resort.
            </p>

        </div>



        <div class="feature-card">

            <div class="feature-icon">
                🏠
            </div>

            <h3>
                Cottages
            </h3>

            <p>
                Comfortable cottages for guests
                and families.
            </p>

        </div>



        <div class="feature-card">

            <div class="feature-icon">
                🛏️
            </div>

            <h3>
                Rooms
            </h3>

            <p>
                Accommodation options for guests
                who want to stay at the resort.
            </p>

        </div>



        <div class="feature-card">

            <div class="feature-icon">
                🎉
            </div>

            <h3>
                Function Halls
            </h3>

            <p>
                Spaces for gatherings, celebrations,
                and special occasions.
            </p>

        </div>


    </div>


</section>



<!-- =====================================================
     FOOTER
     ===================================================== -->

<footer>

    <p>
        &copy; 2026 Otirasor Beach and Resort.
        All Rights Reserved.
    </p>

</footer>


</body>

</html>