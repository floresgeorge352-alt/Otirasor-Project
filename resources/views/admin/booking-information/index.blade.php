<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Booking Information - Otirasor Beach</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #2c3e50;
        }

        .navbar {
            background: #2c3e50;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            font-size: 22px;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-size: 14px;
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .back {
            display: inline-block;
            margin-bottom: 25px;
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        .page-title {
            font-size: 30px;
            margin-bottom: 8px;
        }

        .page-description {
            color: #666;
            margin-bottom: 30px;
        }

        .booking-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 190px;
        }

        .card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .card p {
            color: #666;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            background: #3498db;
            color: white;
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
            text-align: center;
            font-weight: bold;
        }

        .btn:hover {
            background: #2980b9;
        }

        @media (max-width: 800px) {
            .booking-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 550px) {
            .booking-grid {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 15px 20px;
            }

            .page-title {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Otirasor Beach and Resort</h2>

        <a href="/admin/dashboard">
            Admin Dashboard
        </a>
    </div>

    <div class="container">

        <a href="/admin/dashboard" class="back">
            ← Back to Dashboard
        </a>

        <h1 class="page-title">
            Booking Information
        </h1>

        <p class="page-description">
            View and monitor important booking information for the resort.
        </p>

        <div class="booking-grid">

            <div class="card">
                <div>
                    <h3>Booking Overview</h3>

                    <p>
                        View the overall summary of resort bookings,
                        including booking statuses and guest information.
                    </p>
                </div>

                <a href="/admin/booking-overview" class="btn">
                    View Booking Overview
                </a>
            </div>


            <div class="card">
                <div>
                    <h3>Recent Bookings</h3>

                    <p>
                        View the latest customer reservations and
                        their current booking information.
                    </p>
                </div>

                <a href="/admin/recent-bookings" class="btn">
                    View Recent Bookings
                </a>
            </div>


            <div class="card">
                <div>
                    <h3>Room Booking Details</h3>

                    <p>
                        View detailed room booking information,
                        including reserved and occupied rooms.
                    </p>
                </div>

                <a href="/admin/room-booking-details" class="btn">
                    View Room Details
                </a>
            </div>

        </div>

    </div>

</body>
</html>