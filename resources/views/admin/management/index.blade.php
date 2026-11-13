<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Management - Otirasor Beach
    </title>


    <style>

        /* =========================================
           RESET
        ========================================== */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }


        /* =========================================
           BODY
        ========================================== */

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            color: #1f2937;
        }


        /* =========================================
           NAVBAR
        ========================================== */

        .navbar {
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;

            padding: 15px 40px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }


        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }


        .brand img {
            width: 48px;
            height: 48px;
            object-fit: contain;
        }


        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }


        .brand-title {
            color: #023e8a;
            font-size: 18px;
            font-weight: bold;
        }


        .brand-subtitle {
            color: #6b7280;
            font-size: 12px;
        }


        .navbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }


        .navbar-right a {
            color: #374151;
            text-decoration: none;

            padding: 9px 13px;

            border-radius: 8px;

            font-size: 14px;
            font-weight: 600;

            transition: 0.2s ease;
        }


        .navbar-right a:hover {
            background: #eff6ff;
            color: #0077b6;
        }


        /* =========================================
           MAIN CONTAINER
        ========================================== */

        .container {
            max-width: 1150px;

            margin: 35px auto;

            padding: 0 20px 45px;
        }


        /* =========================================
           BACK BUTTON
        ========================================== */

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;

            background: #ffffff;

            color: #0077b6;

            border: 1px solid #dbeafe;

            text-decoration: none;

            padding: 10px 16px;

            border-radius: 9px;

            font-size: 14px;
            font-weight: 600;

            margin-bottom: 22px;

            transition: 0.2s ease;
        }


        .back-btn:hover {
            background: #eff6ff;
            border-color: #bfdbfe;
        }


        /* =========================================
           PAGE HEADER
        ========================================== */

        .page-header {
            margin-bottom: 25px;
        }


        .page-title {
            color: #023e8a;

            font-size: 30px;

            margin-bottom: 7px;
        }


        .page-description {
            color: #6b7280;

            font-size: 14px;

            line-height: 1.6;
        }


        /* =========================================
           MANAGEMENT GRID
        ========================================== */

        .management-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 16px;

            max-width: 780px;
        }


        /* =========================================
           MANAGEMENT CARD
        ========================================== */

        .card {
            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-radius: 14px;

            padding: 20px;

            min-height: 205px;

            display: flex;
            flex-direction: column;
            justify-content: space-between;

            box-shadow:
                0 2px 8px
                rgba(15, 23, 42, 0.05);

            transition: 0.2s ease;
        }


        .card:hover {
            border-color: #bfdbfe;

            box-shadow:
                0 6px 18px
                rgba(15, 23, 42, 0.09);

            transform: translateY(-2px);
        }


        /* =========================================
           CARD ICON
        ========================================== */

        .card-icon {
            width: 45px;
            height: 45px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #eff6ff;

            border-radius: 11px;

            font-size: 22px;

            margin-bottom: 15px;
        }


        /* =========================================
           CARD TITLE
        ========================================== */

        .card h3 {
            color: #023e8a;

            font-size: 18px;

            margin-bottom: 8px;
        }


        /* =========================================
           CARD DESCRIPTION
        ========================================== */

        .card p {
            color: #6b7280;

            line-height: 1.5;

            font-size: 13px;

            margin-bottom: 18px;
        }


        /* =========================================
           CARD BUTTON
        ========================================== */

        .btn {
            display: inline-flex;

            align-items: center;
            justify-content: center;

            gap: 6px;

            width: 100%;

            background: #023e8a;

            color: #ffffff;

            text-decoration: none;

            padding: 10px 15px;

            border-radius: 8px;

            text-align: center;

            font-size: 13px;

            font-weight: bold;

            transition: 0.2s ease;
        }


        .btn:hover {
            background: #0077b6;
        }


        /* =========================================
           CARD ACCENTS
        ========================================== */

        .bookings-card .card-icon {
            background: #eff6ff;
        }


        .accommodations-card .card-icon {
            background: #ecfeff;
        }


        .reports-card .card-icon {
            background: #f5f3ff;
        }


        .notifications-card .card-icon {
            background: #fff7ed;
        }


        .gallery-card .card-icon {
            background: #faf5ff;
        }

        /* =========================================
           BACKUPS ACCENT (NEW)
        ========================================== */
        .backups-card .card-icon {
            background: #fef3c7;
        }


        /* =========================================
           MOBILE
        ========================================== */

        @media (max-width: 700px) {

            .management-grid {
                grid-template-columns: 1fr;

                max-width: 100%;
            }

        }


        @media (max-width: 600px) {

            .navbar {
                padding: 14px 20px;

                align-items: flex-start;
            }


            .navbar-right {
                display: none;
            }


            .container {
                margin: 25px auto;

                padding:
                    0 15px 30px;
            }


            .page-title {
                font-size: 26px;
            }


            .management-grid {
                gap: 14px;
            }


            .card {
                min-height: 190px;
            }

        }

    </style>

</head>


<body>


    <!-- =========================================
         NAVBAR
    ========================================== -->

    <nav class="navbar">


        <div class="brand">

            <img
                src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
                alt="Otirasor Beach and Resort Logo"
            >


            <div class="brand-text">

                <div class="brand-title">
                    Otirasor Beach and Resort
                </div>


                <div class="brand-subtitle">
                    Administration Portal
                </div>

            </div>

        </div>


        <div class="navbar-right">

            <a href="/admin/dashboard">
                🏠 Dashboard
            </a>


            <a href="/admin/bookings">
                📋 Bookings
            </a>


            <a href="/admin/notifications">
                🔔 Notifications
            </a>

        </div>

    </nav>


    <!-- =========================================
         MAIN
    ========================================== -->

    <div class="container">


        <a
            href="/admin/dashboard"
            class="back-btn"
        >
            ← Back to Dashboard
        </a>


        <!-- =========================================
             PAGE HEADER
        ========================================== -->

        <div class="page-header">

            <h1 class="page-title">
                Management
            </h1>


            <p class="page-description">
                Manage the different areas of the
                Otirasor Beach and Resort system.
            </p>

        </div>


        <!-- =========================================
             MANAGEMENT CARDS
        ========================================== -->

        <div class="management-grid">


            <!-- =====================================
                 BOOKINGS
            ====================================== -->

            <div class="card bookings-card">

                <div>

                    <div class="card-icon">
                        📋
                    </div>


                    <h3>
                        Bookings
                    </h3>


                    <p>
                        Manage customer bookings,
                        reservations, and booking status.
                    </p>

                </div>


                <a
                    href="/admin/bookings"
                    class="btn"
                >
                    Manage Bookings →
                </a>

            </div>


            <!-- =====================================
                 ACCOMMODATIONS
            ====================================== -->

            <div class="card accommodations-card">

                <div>

                    <div class="card-icon">
                        🏨
                    </div>


                    <h3>
                        Accommodations
                    </h3>


                    <p>
                        Manage rooms, cottages,
                        function halls, prices,
                        and availability.
                    </p>

                </div>


                <a
                    href="/admin/accommodations"
                    class="btn"
                >
                    Manage Accommodations →
                </a>

            </div>


            <!-- =====================================
                 REPORTS
            ====================================== -->

            <div class="card reports-card">

                <div>

                    <div class="card-icon">
                        📊
                    </div>


                    <h3>
                        Reports
                    </h3>


                    <p>
                        View booking, payment,
                        and resort management reports.
                    </p>

                </div>


                <a
                    href="/admin/reports"
                    class="btn"
                >
                    View Reports →
                </a>

            </div>


            <!-- =====================================
                 NOTIFICATIONS
            ====================================== -->

            <div class="card notifications-card">

                <div>

                    <div class="card-icon">
                        🔔
                    </div>


                    <h3>
                        Notifications
                    </h3>


                    <p>
                        View and manage system
                        notifications and booking alerts.
                    </p>

                </div>


                <a
                    href="/admin/notifications"
                    class="btn"
                >
                    View Notifications →
                </a>

            </div>


            <!-- =====================================
                 GALLERY
            ====================================== -->

            <div class="card gallery-card">

                <div>

                    <div class="card-icon">
                        🖼️
                    </div>


                    <h3>
                        Manage Gallery
                    </h3>


                    <p>
                        Upload, view, and delete
                        photos for the customer gallery.
                    </p>

                </div>


                <a
                    href="{{ route('admin.gallery.index') }}"
                    class="btn"
                >
                    Manage Gallery →
                </a>

            </div>


            <!-- =====================================
                 DATABASE BACKUPS (NEW CARD)
            ====================================== -->

            <div class="card backups-card">

                <div>

                    <div class="card-icon">
                        🗄️
                    </div>


                    <h3>
                        Database Backups
                    </h3>


                    <p>
                        Create, download, and restore
                        database backups. View history
                        and manage retention.
                    </p>

                </div>


                <a
                    href="{{ route('admin.backups.index') }}"
                    class="btn"
                >
                    Manage Backups →
                </a>

            </div>


        </div>

    </div>


</body>

</html>