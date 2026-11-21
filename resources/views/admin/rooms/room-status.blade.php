<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Status Overview - Otirasor Beach</title>

    @vite(['resources/js/app.js'])

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f7fc;
            color: #263445;
        }

        /* NAVBAR */
        .navbar {
            background: linear-gradient(110deg, #063b75, #0756a5);
            color: white;
            padding: 19px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 4px 15px rgba(4, 48, 91, 0.15);
        }

        .navbar h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            letter-spacing: .2px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 27px;
            flex-wrap: wrap;
        }

        .navbar a {
            color: rgba(255,255,255,.9);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: .2s;
        }

        .navbar a:hover {
            color: white;
            opacity: .75;
        }

        /* MAIN CONTAINER */
        .container {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 28px 50px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 27px;
            background: white;
            color: #31516f;
            text-decoration: none;
            padding: 11px 17px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: 600;
            border: 1px solid #e3eaf2;
            box-shadow: 0 2px 7px rgba(0,0,0,.03);
            transition: .2s;
        }

        .back-button:hover {
            background: #edf4fc;
            transform: translateX(-3px);
        }

        .page-heading {
            margin-bottom: 30px;
        }

        .page-heading h1 {
            color: #123d69;
            font-size: 29px;
            margin: 0 0 8px;
            font-weight: 750;
        }

        .page-heading p {
            color: #8290a2;
            margin: 0;
            font-size: 14px;
        }

        .section-label {
            color: #53677d;
            font-size: 14px;
            font-weight: 700;
            margin: 0 0 17px;
        }

        /* SUMMARY CARDS */
        .summary {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }

        .summary-card {
            position: relative;
            overflow: hidden;
            background: #ffffff;
            padding: 25px 23px 22px;
            border-radius: 15px;
            text-decoration: none;
            color: inherit;
            display: block;
            border: 1px solid #e3ebf5;
            border-top: 4px solid #0756a5;
            box-shadow: 0 4px 15px rgba(30, 58, 90, .045);
            transition: transform .25s ease, box-shadow .25s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            border-top-color: #0756a5;
            box-shadow: 0 12px 28px rgba(7, 86, 165, .13);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 21px;
        }

        .card-icon {
            width: 49px;
            height: 49px;
            border-radius: 13px;
            background: #e8f1fc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .card-tag {
            font-size: 10px;
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 20px;
            letter-spacing: .4px;
            text-transform: uppercase;
            background: #e8f1fc;
            color: #0756a5;
        }

        .summary-card h3 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #718096;
        }

        .number {
            font-size: 43px;
            font-weight: 750;
            margin: 8px 0 5px;
            line-height: 1.2;
            color: #0756a5;
        }

        .card-description {
            font-size: 12px;
            margin: 0;
            font-weight: 500;
            color: #356b9f;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #e9eef5;
            padding-top: 15px;
            margin-top: 19px;
            font-size: 11px;
            font-weight: 600;
            color: #0756a5;
        }

        .arrow {
            font-size: 17px;
            transition: transform .2s;
        }

        .summary-card:hover .arrow {
            transform: translateX(4px);
        }

        /* INFORMATION PANEL */
        .info-panel {
            margin-top: 30px;
            padding: 20px 23px;
            background: white;
            border: 1px solid #e3ebf5;
            border-radius: 13px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 3px 12px rgba(30,58,90,.035);
        }

        .info-icon {
            width: 39px;
            height: 39px;
            background: #e8f1fc;
            color: #0756a5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            font-size: 19px;
            flex-shrink: 0;
        }

        .info-panel strong {
            display: block;
            color: #294969;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .info-panel p {
            color: #8492a3;
            font-size: 12px;
            margin: 0;
            line-height: 1.5;
        }

        /* RESPONSIVE */
        @media (max-width: 950px) {
            .summary {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 17px 20px;
            }

            .navbar h2 {
                font-size: 17px;
            }

            .navbar-links {
                gap: 15px;
            }

            .navbar a {
                font-size: 12px;
            }

            .container {
                margin: 27px auto;
                padding: 0 17px 35px;
            }

            .page-heading h1 {
                font-size: 24px;
            }

            .summary {
                grid-template-columns: 1fr;
                gap: 15px;
            }

            .summary-card {
                padding: 22px;
            }

            .number {
                font-size: 39px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <div class="navbar">
        <h2>Otirasor Beach and Resort - Admin</h2>

        <div class="navbar-links">
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/bookings">Bookings</a>
            <a href="/admin/notifications">Notifications</a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="container">

        <a href="/admin/dashboard" class="back-button">
            ← Back to Dashboard
        </a>

        <div class="page-heading">
            <h1>Room Status Overview</h1>
            <p>Monitor room availability and housekeeping status across the resort.</p>
        </div>

        <h3 class="section-label">Room Status Summary</h3>

        <div class="summary">

            <!-- AVAILABLE ROOMS -->
            <a href="/admin/rooms/available" class="summary-card">

                <div class="card-top">
                    <div class="card-icon">🛏️</div>
                    <span class="card-tag">Available</span>
                </div>

                <h3>Available Rooms</h3>

                <div class="number">
                    {{ count($availableRooms) }}
                </div>

                <p class="card-description">
                    Currently Available
                </p>

                <div class="card-footer">
                    <span>View room details</span>
                    <span class="arrow">→</span>
                </div>

            </a>

            <!-- NEEDS CLEANING -->
            <a href="/admin/rooms/needs-cleaning" class="summary-card">

                <div class="card-top">
                    <div class="card-icon">🧹</div>
                    <span class="card-tag">Cleaning</span>
                </div>

                <h3>Needs Cleaning</h3>

                <div class="number">
                    {{ count($needsCleaningRooms) }}
                </div>

                <p class="card-description">
                    For Housekeeping
                </p>

                <div class="card-footer">
                    <span>View room details</span>
                    <span class="arrow">→</span>
                </div>

            </a>

            <!-- RESERVED ROOMS -->
            <a href="/admin/rooms/reserved" class="summary-card">

                <div class="card-top">
                    <div class="card-icon">📅</div>
                    <span class="card-tag">Reserved</span>
                </div>

                <h3>Reserved Rooms</h3>

                <div class="number">
                    {{ count($reservedRooms) }}
                </div>

                <p class="card-description">
                    Upcoming Reservations
                </p>

                <div class="card-footer">
                    <span>View room details</span>
                    <span class="arrow">→</span>
                </div>

            </a>

            <!-- OCCUPIED ROOMS -->
            <a href="/admin/rooms/occupied" class="summary-card">

                <div class="card-top">
                    <div class="card-icon">🚪</div>
                    <span class="card-tag">Occupied</span>
                </div>

                <h3>Occupied Rooms</h3>

                <div class="number">
                    {{ count($occupiedRooms) }}
                </div>

                <p class="card-description">
                    Currently Occupied
                </p>

                <div class="card-footer">
                    <span>View room details</span>
                    <span class="arrow">→</span>
                </div>

            </a>

        </div>

        <!-- INFORMATION PANEL -->
        <div class="info-panel">

            <div class="info-icon">ℹ️</div>

            <div>
                <strong>Room Status Information</strong>

                <p>
                    Select any status card to view its room details.
                    Room status changes are reflected automatically when an update is received.
                </p>
            </div>

        </div>

    </div>

    <!-- REAL-TIME ROOM STATUS UPDATES -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        if (!window.Echo) {
            console.warn('Echo is not loaded.');
            return;
        }

        window.Echo.channel('admin.rooms')
            .listen('RoomStatusUpdated', (e) => {

                console.log('Room Status Updated:', e);

                if (window.showToast) {
                    window.showToast(
                        'Room Status Updated',
                        `Booking #${e.booking_id} status has changed to ${e.status}.`,
                        'info'
                    );
                }

                setTimeout(() => {
                    window.location.reload();
                }, 1500);

            });

    });
    </script>

</body>
</html>