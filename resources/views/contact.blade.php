<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact | Otirasor Beach and Resort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f4fbfd;
            color: #333;
        }

        /* NAVIGATION (Updated) */
        nav {
            background: #023e8a;
            padding: 15px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
        }

        .brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            background: white;
            border-radius: 50%;
            padding: 2px;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        nav a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }

        nav a:hover, nav a.active {
            color: #fbbf24;
        }

        /* AUTH BUTTONS */
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
        .btn-nav:hover { background: #f59e0b; transform: translateY(-2px); box-shadow: 0 5px 15px rgba(251, 191, 36, 0.4); }
        
        .btn-logout {
            background: transparent;
            color: white;
            padding: 10px 24px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-family: 'Montserrat', sans-serif;
            font-size: 14px;
            border: 1px solid rgba(255,255,255,0.3);
            cursor: pointer;
        }
        .btn-logout:hover { background: rgba(255,255,255,0.1); }

        /* PAGE CONTENT */
        .page {
            max-width: 1000px;
            margin: 60px auto;
            padding: 20px;
        }

        .card {
            background: white;
            padding: 50px;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(0, 100, 140, 0.10);
            text-align: center;
        }

        .card h1 {
            color: #0077b6;
            font-size: 38px;
            margin-bottom: 15px;
            font-family: 'Montserrat', sans-serif;
        }

        .card > p {
            color: #666;
            line-height: 1.7;
            margin-bottom: 35px;
        }

        .contact-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .contact-box {
            background: #eef9fd;
            padding: 25px;
            border-radius: 16px;
            width: 250px;
        }

        .contact-box .icon {
            font-size: 35px;
            margin-bottom: 12px;
        }

        .contact-box h3 {
            color: #0077b6;
            margin-bottom: 10px;
            font-family: 'Montserrat', sans-serif;
        }

        .contact-box p {
            color: #555;
            line-height: 1.6;
        }

        /* CLICKABLE LOCATION */
        .location-link {
            display: block;
            text-decoration: none;
            color: inherit;
            transition: 0.25s;
        }

        .location-link:hover {
            transform: translateY(-4px);
        }

        .location-link:hover h3 {
            color: #005f91;
        }

        .location-link:hover p {
            color: #0077b6;
        }

        .map-text {
            display: block;
            margin-top: 8px;
            color: #777;
            font-size: 12px;
        }

        footer {
            margin-top: 80px;
            background: linear-gradient(135deg, #023e8a, #0077b6);
            color: white;
            text-align: center;
            padding: 24px;
        }

        @media (max-width: 700px) {
            nav {
                padding: 12px 20px;
                flex-direction: column;
                gap: 15px;
            }

            .brand {
                font-size: 18px;
            }

            .nav-links {
                gap: 16px;
                flex-wrap: wrap;
                justify-content: center;
            }

            .card {
                padding: 30px 20px;
            }

            .card h1 {
                font-size: 30px;
            }

            .contact-box {
                width: 100%;
                max-width: 320px;
            }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Beach and Resort Logo">
        <span>Otirasor Beach and Resort</span>
    </div>

    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/about">About</a>
        <a href="/gallery">Gallery</a>
        <a href="/reviews">Reviews</a>
        <a href="/contact" class="active">Contact</a>

        {{-- AUTH LOGIC --}}
        @auth
            <a href="/dashboard">Dashboard</a>
            <form method="POST" action="/logout" style="display:inline; margin: 0;">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        @else
            <a href="/login">Login</a>
            <a href="/register" class="btn-nav">Book Now</a>
        @endauth
    </div>
</nav>


<div class="page">
    <div class="card">
        <h1>Contact Otirasor Beach and Resort</h1>

        <p>
            If you have questions about reservations, accommodations, or the resort, 
            you may contact Otirasor Beach and Resort through the following contact details.
        </p>

        <div class="contact-container">

            <!-- LOCATION -->
            <div class="contact-box">
                <a href="https://maps.app.goo.gl/hS6jGNXAiYBQpSdCA" target="_blank" rel="noopener noreferrer" class="location-link">
                    <div class="icon">📍</div>
                    <h3>Location</h3>
                    <p>Talaban, Negros Occidental, Philippines</p>
                    <small class="map-text">Click to open Google Maps</small>
                </a>
            </div>

            <!-- GLOBE -->
            <div class="contact-box">
                <div class="icon">📞</div>
                <h3>Globe</h3>
                <p>09971154140</p>
            </div>

            <!-- SMART -->
            <div class="contact-box">
                <div class="icon">📞</div>
                <h3>Smart</h3>
                <p>09089765318</p>
            </div>

        </div>
    </div>
</div>


<footer>
    <p>&copy; 2026 Otirasor Beach and Resort. All Rights Reserved.</p>
</footer>

</body>

</html>