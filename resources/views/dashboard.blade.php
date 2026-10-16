<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Dashboard - Otirasor Beach</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            color: #333;
        }

        nav {
            background: #0077b6;
            padding: 18px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            color: white;
            font-size: 25px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            margin-left: 25px;
            font-size: 16px;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }

        .welcome {
            background: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .welcome h1 {
            color: #0077b6;
            margin-bottom: 10px;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            flex: 1;
            min-width: 250px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .card h2 {
            color: #0077b6;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 20px;
            background: #0077b6;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .btn:hover {
            background: #005f8f;
        }

        footer {
            background: #023e8a;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

    </style>

</head>

<body>

    <nav>

        <div class="logo">
            Otirasor Beach
        </div>

        <div>

            <a href="/">
                Home
            </a>

            <a href="/accommodations">
                Book Now
            </a>

            <a href="/my-bookings">
                My Bookings
            </a>

            <form
                method="POST"
                action="/logout"
                style="display: inline;"
            >

                @csrf

                <button
                    type="submit"
                    class="logout-btn"
                >
                    Logout
                </button>

            </form>

        </div>

    </nav>


    <div class="container">

        <div class="welcome">

            <h1>
                Welcome, {{ Auth::user()->name }}!
            </h1>

            <p>
                Welcome to your Otirasor Beach customer dashboard.
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <h2>
                    My Bookings
                </h2>

                <p>
                    View your bookings and check their current status.
                </p>

                <a
                    href="/my-bookings"
                    class="btn"
                >
                    View My Bookings
                </a>

            </div>


            <div class="card">

                <h2>
                    Book Now
                </h2>

                <p>
                    Choose a room, cottage, or function hall.
                </p>

                <a
                    href="/accommodations"
                    class="btn"
                >
                    Make a Booking
                </a>

            </div>

        </div>

    </div>


    <footer>

        <p>
            &copy; 2026 Otirasor Beach. All Rights Reserved.
        </p>

    </footer>

</body>

</html>