<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Notifications - Otirasor Beach
    </title>


    <style>

        /* =========================================
           RESET
        ========================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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

        nav {
            background: #ffffff;

            border-bottom: 1px solid #e5e7eb;

            padding: 15px 40px;

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;
        }


        .nav-brand {
            display: flex;

            align-items: center;

            gap: 12px;
        }


        .nav-brand img {
            width: 48px;

            height: 48px;

            object-fit: contain;
        }


        .nav-title {
            display: flex;

            flex-direction: column;

            gap: 3px;
        }


        .nav-title strong {
            color: #023e8a;

            font-size: 18px;
        }


        .nav-title span {
            color: #6b7280;

            font-size: 12px;
        }


        .nav-links {
            display: flex;

            align-items: center;

            gap: 8px;
        }


        nav a {
            color: #374151;

            text-decoration: none;

            padding: 9px 13px;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 600;

            transition: 0.2s ease;
        }


        nav a:hover {
            background: #eff6ff;

            color: #0077b6;
        }


        .logout-btn {
            background: none;

            border: none;

            color: #374151;

            padding: 9px 13px;

            border-radius: 8px;

            font-size: 14px;

            font-weight: 600;

            cursor: pointer;

            font-family: Arial, sans-serif;

            transition: 0.2s ease;
        }


        .logout-btn:hover {
            background: #fff1f2;

            color: #c62828;
        }


        /* =========================================
           MAIN CONTAINER
        ========================================== */

        .container {
            max-width: 1000px;

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
            display: flex;

            justify-content: space-between;

            align-items: flex-end;

            gap: 20px;

            margin-bottom: 22px;
        }


        .page-header-left h1 {
            color: #023e8a;

            font-size: 30px;

            margin-bottom: 7px;
        }


        .page-header-left p {
            color: #6b7280;

            font-size: 14px;
        }


        .notification-count {
            background: #eff6ff;

            color: #023e8a;

            border: 1px solid #dbeafe;

            padding: 8px 13px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: bold;

            white-space: nowrap;
        }


        /* =========================================
           NOTIFICATION LINK
        ========================================== */

        .notification-link {
            display: block;

            text-decoration: none;

            color: inherit;
        }


        /* =========================================
           NOTIFICATION CARD
        ========================================== */

        .notification {
            background: #ffffff;

            border: 1px solid #e5e7eb;

            border-left: 5px solid #cbd5e1;

            padding: 18px 20px;

            margin-bottom: 13px;

            border-radius: 12px;

            box-shadow:
                0 2px 8px
                rgba(15, 23, 42, 0.05);

            transition: 0.2s ease;
        }


        .notification:hover {
            border-color: #bfdbfe;

            border-left-color: #0077b6;

            background: #fafcff;

            box-shadow:
                0 6px 16px
                rgba(15, 23, 42, 0.08);

            transform: translateY(-2px);

            cursor: pointer;
        }


        /* =========================================
           UNREAD
        ========================================== */

        .notification.unread {
            background: #f8fcff;

            border-left-color: #0077b6;
        }


        .notification.unread:hover {
            background: #f1f9ff;
        }


        /* =========================================
           READ
        ========================================== */

        .notification.read {
            background: #ffffff;

            border-left-color: #d1d5db;
        }


        /* =========================================
           NOTIFICATION TOP
        ========================================== */

        .notification-top {
            display: flex;

            justify-content: space-between;

            align-items: flex-start;

            gap: 15px;

            margin-bottom: 10px;
        }


        /* =========================================
           NOTIFICATION TITLE
        ========================================== */

        .notification-title {
            color: #023e8a;

            font-size: 16px;

            font-weight: bold;

            line-height: 1.4;
        }


        .notification.unread .notification-title {
            color: #0077b6;
        }


        /* =========================================
           UNREAD BADGE
        ========================================== */

        .unread-badge {
            background: #0077b6;

            color: white;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: bold;

            flex-shrink: 0;
        }


        .read-badge {
            background: #f1f5f9;

            color: #9ca3af;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: bold;

            flex-shrink: 0;
        }


        /* =========================================
           NOTIFICATION DETAILS
        ========================================== */

        .notification-details {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 8px 20px;

            margin-top: 10px;
        }


        .notification-detail {
            color: #4b5563;

            font-size: 13px;

            line-height: 1.5;
        }


        .notification-detail strong {
            color: #374151;
        }


        /* =========================================
           TIME
        ========================================== */

        .notification-time {
            color: #9ca3af;

            font-size: 12px;

            margin-top: 14px;

            padding-top: 12px;

            border-top: 1px solid #f1f5f9;
        }


        /* =========================================
           CLICK HINT
        ========================================== */

        .click-hint {
            color: #0077b6;

            font-size: 12px;

            margin-top: 10px;

            font-weight: bold;
        }


        /* =========================================
           EMPTY STATE
        ========================================== */

        .empty {
            background: #ffffff;

            padding: 50px 30px;

            border-radius: 14px;

            text-align: center;

            border: 1px solid #e5e7eb;

            box-shadow:
                0 2px 8px
                rgba(15, 23, 42, 0.05);
        }


        .empty-icon {
            font-size: 42px;

            margin-bottom: 12px;
        }


        .empty h2 {
            color: #374151;

            font-size: 20px;

            margin-bottom: 8px;
        }


        .empty p {
            color: #9ca3af;

            font-size: 14px;

            line-height: 1.5;
        }


        /* =========================================
           MOBILE
        ========================================== */

        @media (max-width: 700px) {

            nav {
                padding: 14px 20px;
            }


            .nav-links a {
                display: none;
            }


            .container {
                margin: 25px auto;

                padding:
                    0 15px 30px;
            }


            .page-header {
                align-items: flex-start;

                flex-direction: column;

                gap: 10px;
            }


            .page-header-left h1 {
                font-size: 26px;
            }


            .notification-details {
                grid-template-columns: 1fr;
            }

        }


        @media (max-width: 500px) {

            .nav-title strong {
                font-size: 16px;
            }


            .nav-title span {
                font-size: 11px;
            }


            .nav-brand img {
                width: 42px;

                height: 42px;
            }


            .notification {
                padding: 16px;
            }


            .notification-top {
                flex-direction: column;

                gap: 8px;
            }


            .unread-badge,
            .read-badge {
                align-self: flex-start;
            }

        }

    </style>

</head>


<body>


    <!-- =========================================
         NAVBAR
    ========================================== -->

    <nav>


        <div class="nav-brand">

            <img
                src="{{ asset('images/otirasor-logo.png') }}?v={{ filemtime(public_path('images/otirasor-logo.png')) }}"
                alt="Otirasor Beach and Resort Logo"
            >


            <div class="nav-title">

                <strong>
                    Otirasor Beach and Resort
                </strong>


                <span>
                    Administration Portal
                </span>

            </div>

        </div>


        <div class="nav-links">

            <a href="/admin/dashboard">
                🏠 Dashboard
            </a>


            <a href="/admin/bookings">
                📋 Bookings
            </a>


            <a href="/admin/notifications">
                🔔 Notifications
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
                    🚪 Logout
                </button>

            </form>

        </div>

    </nav>


    <!-- =========================================
         MAIN CONTAINER
    ========================================== -->

    <div class="container">


        <a
            href="/admin/management"
            class="back-btn"
        >
            ← Back to Management
        </a>


        <!-- =====================================
             PAGE HEADER
        ====================================== -->

        <div class="page-header">


            <div class="page-header-left">

                <h1>
                    🔔 Notifications
                </h1>


                <p>
                    View booking updates and system notifications.
                </p>

            </div>


            <div class="notification-count">

                {{ $notifications->count() }}

                {{ $notifications->count() == 1 ? 'Notification' : 'Notifications' }}

            </div>

        </div>


        <!-- =========================================
             NOTIFICATIONS
        ========================================== -->

        @if($notifications->count() > 0)


            @foreach($notifications as $notification)


                {{--

                    Clicking a notification goes through
                    AdminDashboardController@openNotification.

                    openNotification() will:

                    1. Find this specific notification.
                    2. Mark ONLY this notification as read.
                    3. Get the booking_id.
                    4. Redirect to the exact booking.

                --}}


                @if(isset($notification->data['booking_id']))

                    <a
                        href="/admin/notifications/{{ $notification->id }}/open"
                        class="notification-link"
                    >

                @endif


                <div
                    class="
                        notification
                        {{ is_null($notification->read_at)
                            ? 'unread'
                            : 'read'
                        }}
                    "
                >


                    <!-- =================================
                         NOTIFICATION HEADER
                    ================================== -->

                    <div class="notification-top">


                        <div class="notification-title">

                            {{ $notification->data['message'] ?? 'New notification' }}

                        </div>


                        @if(is_null($notification->read_at))

                            <span class="unread-badge">
                                NEW
                            </span>

                        @else

                            <span class="read-badge">
                                READ
                            </span>

                        @endif

                    </div>


                    <!-- =================================
                         NOTIFICATION DETAILS
                    ================================== -->

                    <div class="notification-details">


                        @if(isset($notification->data['booking_id']))

                            <div class="notification-detail">

                                <strong>
                                    📋 Booking ID:
                                </strong>

                                #{{ $notification->data['booking_id'] }}

                            </div>

                        @endif


                        @if(isset($notification->data['guest_name']))

                            <div class="notification-detail">

                                <strong>
                                    👤 Guest:
                                </strong>

                                {{ $notification->data['guest_name'] }}

                            </div>

                        @endif


                        @if(isset($notification->data['number_of_guests']))

                            <div class="notification-detail">

                                <strong>
                                    👥 Total Guests:
                                </strong>

                                {{ $notification->data['number_of_guests'] }}

                            </div>

                        @endif


                        @if(isset($notification->data['check_in']))

                            <div class="notification-detail">

                                <strong>
                                    📅 Check-in:
                                </strong>

                                {{ $notification->data['check_in'] }}

                            </div>

                        @endif


                        @if(isset($notification->data['check_out']))

                            <div class="notification-detail">

                                <strong>
                                    📅 Check-out:
                                </strong>

                                {{ $notification->data['check_out'] }}

                            </div>

                        @endif


                    </div>


                    <!-- =================================
                         CREATED TIME
                    ================================== -->

                    <div class="notification-time">

                        🕒

                        {{ $notification->created_at->format('M d, Y h:i A') }}

                    </div>


                    <!-- =================================
                         CLICK HINT
                    ================================== -->

                    @if(isset($notification->data['booking_id']))

                        <div class="click-hint">

                            Click to view this booking →

                        </div>

                    @endif


                </div>


                @if(isset($notification->data['booking_id']))

                    </a>

                @endif


            @endforeach


        @else


            <!-- =====================================
                 EMPTY STATE
            ====================================== -->

            <div class="empty">


                <div class="empty-icon">
                    🔔
                </div>


                <h2>
                    No notifications yet.
                </h2>


                <p>
                    New booking notifications will appear here.
                </p>

            </div>


        @endif


    </div>


</body>

</html>