<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About | Otirasor Beach and Resort</title>

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
            margin-bottom: 25px;
        }

        .card p {
            color: #555;
            font-size: 17px;
            line-height: 1.8;
            margin-bottom: 18px;
        }

        .facilities {
            margin-top: 35px;
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .facility {
            background: #eef9fd;
            color: #0077b6;
            padding: 12px 20px;
            border-radius: 25px;
            font-weight: bold;
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
        }
    </style>
</head>

<body>

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

            <form method="POST" action="/logout" style="display:inline;">
                @csrf

                <button
                    type="submit"
                    style="background:none;border:none;color:white;cursor:pointer;font-size:15px;"
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


<div class="page">

    <div class="card">

        <h1>
            About Otirasor Beach and Resort
        </h1>

        <p>
            Otirasor Beach and Resort is a beach resort that provides
            accommodations and facilities for guests, families, friends,
            and visitors.
        </p>

        <p>
            The resort has been operating for nine years and offers
            rooms, cottages, function halls, a swimming pool, and
            beach facilities.
        </p>

        <p>
            Reservations are currently accepted through phone calls,
            text messages, and Messenger. Customers may also pay
            through Cash or GCash.
        </p>

        <div class="facilities">

            <div class="facility">🏖️ Beach</div>

            <div class="facility">🏊 Swimming Pool</div>

            <div class="facility">🏠 Cottages</div>

            <div class="facility">🛏️ Rooms</div>

            <div class="facility">🎉 Function Halls</div>

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