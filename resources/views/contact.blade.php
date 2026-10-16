<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact | Otirasor Beach and Resort</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4fbfd;
            color: #333;
        }

        nav {
            background: linear-gradient(135deg, #0077b6, #0096c7);
            padding: 12px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.12);
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
        }

        nav a:hover {
            color: #dff8ff;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            font-size: 15px;
        }

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
                padding: 12px 18px;
                flex-direction: column;
                gap: 12px;
            }

            .brand {
                font-size: 19px;
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

        <img
            src="{{ asset('images/otirasor-logo.png') }}"
            alt="Otirasor Beach and Resort Logo"
        >

        <span>
            Otirasor Beach and Resort
        </span>

    </div>

    <div class="nav-links">

        <a href="/">Home</a>

        <a href="/about">About</a>

        <a href="/contact">Contact</a>

        @auth

            <a href="/dashboard">Dashboard</a>

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

            <a href="/login">Login</a>

            <a href="/register">Register</a>

        @endauth

    </div>

</nav>


<div class="page">

    <div class="card">

        <h1>
            Contact Otirasor Beach and Resort
        </h1>

        <p>
            If you have questions about reservations,
            accommodations, or the resort, you may
            contact Otirasor Beach and Resort through
            the following contact details.
        </p>


        <div class="contact-container">


            <!-- LOCATION -->

            <div class="contact-box">

                <a
                    href="https://maps.app.goo.gl/hS6jGNXAiYBQpSdCA"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="location-link"
                >

                    <div class="icon">
                        📍
                    </div>

                    <h3>
                        Location
                    </h3>

                    <p>
                        Talaban, Negros Occidental,
                        Philippines
                    </p>

                    <small class="map-text">
                        Click to open Google Maps
                    </small>

                </a>

            </div>


            <!-- GLOBE -->

            <div class="contact-box">

                <div class="icon">
                    📞
                </div>

                <h3>
                    Globe
                </h3>

                <p>
                    09971154140
                </p>

            </div>


            <!-- SMART -->

            <div class="contact-box">

                <div class="icon">
                    📞
                </div>

                <h3>
                    Smart
                </h3>

                <p>
                    09089765318
                </p>

            </div>


        </div>

    </div>

</div>


<footer>

    <p>
        &copy; 2026 Otirasor Beach and Resort.
        All Rights Reserved.
    </p>

</footer>

</body>

</html>