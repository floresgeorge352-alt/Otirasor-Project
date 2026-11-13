<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Otirasor Beach and Resort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { font-family: 'Poppins', sans-serif; background: #f4fbfd; color: #333; overflow-x: hidden; }

        /* HERO SECTION (Full Screen) */
        .hero {
            position: relative;
            width: 100%;
            height: 100vh;
            min-height: 700px;
            background: linear-gradient(rgba(0, 20, 40, 0.5), rgba(0, 50, 100, 0.7)), 
                        url('{{ asset('images/Home-hero.jpeg.jpg') }}?v={{ filemtime(public_path('images/Home-hero.jpeg.jpg')) }}') center/cover no-repeat;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: flex-start;
            padding: 0 8%;
            color: white;
        }

        /* NAVIGATION BAR (Floating Glass) */
        .navbar {
            position: absolute;
            top: 25px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 1200px;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .navbar .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar .brand img {
            height: 45px;
            width: 45px;
            object-fit: contain;
            background: white;
            border-radius: 50%;
            padding: 2px;
        }

        .navbar .brand-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.5px;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-links a:hover {
            color: #fbbf24;
        }

        .nav-links a.active-link {
            color: white;
            font-weight: 700;
        }

        .btn-nav {
            background: #fbbf24;
            color: #111827;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }

        .btn-nav:hover {
            background: #f59e0b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(251, 191, 36, 0.4);
        }

        /* HERO CONTENT */
        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin-top: 80px;
        }

        .location-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 25px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-decoration: none;
            color: white;
            transition: 0.3s;
            cursor: pointer;
        }

        .location-badge:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .hero-content h1 {
            font-family: 'Montserrat', sans-serif;
            font-size: 75px;
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 25px;
            text-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        .hero-content h1 .highlight {
            color: #fbbf24;
        }

        .hero-content p {
            font-size: 18px;
            line-height: 1.6;
            color: #e5e7eb;
            margin-bottom: 40px;
            font-weight: 300;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: #fbbf24;
            color: #111827;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            font-size: 16px;
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
            border: 2px solid #fbbf24;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            background: #f59e0b;
            border-color: #f59e0b;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(251, 191, 36, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: white;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            font-size: 16px;
            border: 2px solid rgba(255, 255, 255, 0.6);
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
        }

        .btn-secondary:hover {
            border-color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        /* WELCOME SECTION */
        .welcome-section {
            text-align: center;
            padding: 80px 20px;
            background: white;
        }

        .welcome-section h2 {
            color: #023e8a;
            font-size: 34px;
            margin-bottom: 16px;
            font-family: 'Montserrat', sans-serif;
        }

        .welcome-section p {
            max-width: 760px;
            margin: auto;
            line-height: 1.8;
            color: #555;
            font-size: 17px;
        }

        /* FEATURES */
        .features {
            padding: 70px 20px;
            background: linear-gradient(180deg, #eef9fd, #e7f6fb);
            text-align: center;
        }

        .features h2 {
            color: #023e8a;
            margin-bottom: 40px;
            font-size: 32px;
            font-family: 'Montserrat', sans-serif;
        }

        .feature-container {
            max-width: 1100px;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
        }

        .feature-card {
            background: white;
            padding: 35px 20px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0, 80, 120, 0.06);
            transition: 0.3s;
            border: 1px solid #e2f2f7;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 80, 120, 0.12);
        }

        .feature-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .feature-card h3 {
            color: #0077b6;
            margin-bottom: 10px;
            font-size: 18px;
            font-family: 'Montserrat', sans-serif;
        }

        .feature-card p {
            color: #666;
            line-height: 1.5;
            font-size: 14px;
        }

        /* FOOTER */
        footer {
            background: linear-gradient(135deg, #023e8a, #0077b6);
            color: white;
            text-align: center;
            padding: 25px;
        }

        footer p {
            font-size: 14px;
            opacity: 0.95;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 950px) {
            .feature-container { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 12px 20px;
                flex-direction: column;
                gap: 15px;
                border-radius: 20px;
            }
            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
            .hero-content h1 { font-size: 48px; }
            .hero-content p { font-size: 16px; }
            .hero-buttons { flex-direction: column; width: 100%; }
            .btn-primary, .btn-secondary { text-align: center; justify-content: center; width: 100%; }
        }

        @media (max-width: 600px) {
            .feature-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- HERO SECTION -->
    <section class="hero">
        
        <!-- NAVIGATION BAR (Floating) -->
        <nav class="navbar">
            <div class="brand">
                <img src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}" alt="Otirasor Logo">
                <div class="brand-text">OTIRASOR</div>
            </div>
            
            <div class="nav-links">
                <a href="/" class="{{ request()->is('/') ? 'active-link' : '' }}">Home</a>
                <a href="/about" class="{{ request()->is('about') ? 'active-link' : '' }}">About</a>
                <a href="/gallery" class="{{ request()->is('gallery') ? 'active-link' : '' }}">Gallery</a>
                <a href="/reviews" class="{{ request()->is('reviews') ? 'active-link' : '' }}">Reviews</a>
                <a href="/contact" class="{{ request()->is('contact') ? 'active-link' : '' }}">Contact</a>

                @auth
                    <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active-link' : '' }}">Dashboard</a>
                    <form method="POST" action="/logout" style="display:inline; margin: 0;">
                        @csrf
                        <button type="submit" class="btn-nav" style="background: transparent; color: white; border: 1px solid rgba(255,255,255,0.3);">Logout</button>
                    </form>
                @else
                    <a href="/login" class="{{ request()->is('login') ? 'active-link' : '' }}">Login</a>
                    <a href="/register" class="btn-nav">Book Now</a>
                @endauth
            </div>
        </nav>

        <!-- HERO CONTENT -->
        <div class="hero-content">
            <!-- LOCATION BADGE (Clickable to Google Maps) -->
            <a href="https://www.google.com/maps/search/?api=1&query=Brgy+Talaban+Negros+Occidental+Philippines" target="_blank" class="location-badge">
                📍 Brgy. Talaban, Negros Occidental, Philippines
            </a>
            
            <h1>Where Waves<br>Meet <span class="highlight">Paradise</span></h1>
            
            <p>Experience the ultimate beachfront getaway. Unwind, relax, and create unforgettable memories at Otirasor Beach and Resort.</p>

            <div class="hero-buttons">
                <a href="/accommodations" class="btn-primary">
                    🗓️ Book Your Stay →
                </a>
                <a href="/gallery" class="btn-secondary">
                    Explore Gallery
                </a>
            </div>
        </div>
    </section>

    <!-- WELCOME SECTION -->
    <section class="welcome-section">
        <h2>Your Beach Resort Destination</h2>
        <p>
            Otirasor Beach and Resort provides a place
            where guests can relax, spend time with family
            and friends, and enjoy comfortable accommodations
            and resort facilities.
        </p>
    </section>

    <!-- FEATURES -->
    <section class="features">
        <h2>Explore What We Offer</h2>
        <div class="feature-container">
            <div class="feature-card">
                <div class="feature-icon">🏖️</div>
                <h3>Beach</h3>
                <p>Enjoy a relaxing beach experience with family and friends.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏊</div>
                <h3>Swimming Pool</h3>
                <p>Spend time swimming and relaxing at the resort.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏠</div>
                <h3>Cottages</h3>
                <p>Comfortable cottages for guests and families.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛏️</div>
                <h3>Rooms</h3>
                <p>Accommodation options for guests who want to stay at the resort.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎉</div>
                <h3>Function Halls</h3>
                <p>Spaces for gatherings, celebrations, and special occasions.</p>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2026 Otirasor Beach and Resort. All Rights Reserved.</p>
    </footer>

</body>
</html>