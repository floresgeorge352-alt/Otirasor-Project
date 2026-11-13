<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Otirasor Beach and Resort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f4fbfd; color: #333; }

        /* NAVIGATION */
        nav {
            background: #023e8a;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 20px; font-weight: bold; font-family: 'Montserrat', sans-serif; }
        .brand img { width: 45px; height: 45px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        
        .nav-links { display: flex; gap: 20px; }
        .nav-links a { color: rgba(255,255,255,0.8); text-decoration: none; font-size: 15px; font-weight: 500; transition: 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: #fbbf24; }

        /* MAIN CONTENT */
        .container {
            max-width: 1000px;
            margin: 40px auto 50px;
            padding: 0 20px;
        }

        .content-card {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 10px 30px rgba(0, 80, 120, 0.08);
            border: 1px solid #e2f2f7;
        }

        .content-card h2 {
            color: #023e8a;
            font-family: 'Montserrat', sans-serif;
            font-size: 32px;
            margin-bottom: 25px;
        }

        .content-card p {
            color: #555;
            line-height: 1.8;
            font-size: 16px;
            margin-bottom: 20px;
        }

        /* FEATURES GRID */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 40px;
        }

        .feature-badge {
            background: #f0f9ff;
            border: 1px solid #bae6fd;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            font-weight: 600;
            color: #0369a1;
            transition: 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .feature-badge:hover {
            background: #e0f2fe;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(3, 105, 161, 0.15);
        }

        .feature-icon { font-size: 30px; }

        /* FOOTER */
        footer {
            background: #023e8a;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 14px;
        }

        /* MOBILE */
        @media (max-width: 768px) {
            .content-card { padding: 30px; }
            .content-card h2 { font-size: 26px; }
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <!-- NAVIGATION -->
    <nav>
        <div class="brand">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo">
            <span>Otirasor</span>
        </div>
        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/about" class="active">About</a>
            <a href="/gallery">Gallery</a>
            <a href="/reviews">Reviews</a>
            <a href="/contact">Contact</a>
        </div>
    </nav>

    <!-- CONTENT CARD (Deretso na agad) -->
    <div class="container">
        <div class="content-card">
            <h2>About Otirasor Beach and Resort</h2>
            
            <p>
                Otirasor Beach and Resort is a beach resort that provides accommodations and facilities for guests, families, friends, and visitors.
            </p>
            
            <p>
                The resort has been operating for nine years and offers rooms, cottages, function halls, a swimming pool, and beach facilities. We are committed to providing our guests with a relaxing and memorable experience.
            </p>
            
            <p>
                Reservations are currently accepted through phone calls, text messages, and Messenger. Customers may also pay through Cash or GCash for their convenience.
            </p>

            <h2 style="margin-top: 40px; font-size: 24px;">What We Offer</h2>
            <div class="features-grid">
                <div class="feature-badge">
                    <span class="feature-icon">🏖️</span>
                    Beach
                </div>
                <div class="feature-badge">
                    <span class="feature-icon">🏊</span>
                    Swimming Pool
                </div>
                <div class="feature-badge">
                    <span class="feature-icon">🏠</span>
                    Cottages
                </div>
                <div class="feature-badge">
                    <span class="feature-icon">🛏️</span>
                    Rooms
                </div>
                <div class="feature-badge">
                    <span class="feature-icon">🎉</span>
                    Function Halls
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        &copy; 2026 Otirasor Beach and Resort. All Rights Reserved.
    </footer>

</body>
</html>