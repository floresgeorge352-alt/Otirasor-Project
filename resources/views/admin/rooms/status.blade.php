<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Otirasor Beach</title>

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
            box-shadow: 0 4px 15px rgba(4, 48, 91, .15);
        }

        .navbar h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
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

        /* CONTAINER */
        .container {
            max-width: 1250px;
            margin: 40px auto;
            padding: 0 28px 50px;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 25px;
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
            margin-bottom: 25px;
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

        /* SEARCH */
        .search-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 28px;
            background: white;
            padding: 17px;
            border-radius: 13px;
            border: 1px solid #e6edf5;
            box-shadow: 0 4px 15px rgba(30,58,90,.04);
        }

        .search-bar input {
            flex: 1;
            min-width: 0;
            padding: 13px 16px;
            border: 1px solid #dce5ef;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
            color: #263445;
            transition: .2s;
        }

        .search-bar input:focus {
            border-color: #0756a5;
            box-shadow: 0 0 0 3px rgba(7,86,165,.09);
        }

        .search-bar button {
            padding: 12px 25px;
            background: #0756a5;
            color: white;
            border: none;
            border-radius: 9px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: .2s;
        }

        .search-bar button:hover {
            background: #063b75;
        }

        /* ROOM GRID */
        .room-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .room {
            position: relative;
            background: white;
            border: 1px solid #e3ebf5;
            border-top: 4px solid #0756a5;
            border-radius: 14px;
            padding: 23px;
            box-shadow: 0 4px 15px rgba(30,58,90,.045);
            transition: transform .22s ease, box-shadow .22s ease;
        }

        .room:hover {
            transform: translateY(-4px);
            box-shadow: 0 11px 25px rgba(7,86,165,.10);
        }

        .room-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 17px;
            flex-wrap: wrap;
        }

        .room-name {
            font-weight: 750;
            font-size: 19px;
            color: #123d69;
            margin: 0;
        }

        .room-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #e8f1fc;
            color: #0756a5;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
            flex-shrink: 0;
        }

        /* STATUS BADGES */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            margin-bottom: 17px;
            background: #e8f1fc;
            color: #0756a5;
            border: 1px solid #d8e8fa;
        }

        /* ROOM INFORMATION */
        .room-info {
            border-top: 1px solid #edf1f6;
            padding-top: 14px;
            margin-top: 5px;
        }

        .room p {
            margin: 11px 0;
            font-size: 13px;
            color: #718096;
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .room p strong {
            color: #425a73;
            font-weight: 600;
        }

        .room p span {
            color: #263f5a;
            text-align: right;
        }

        /* CLEAN BUTTON */
        .btn-clean {
            margin-top: 18px;
            display: block;
            width: 100%;
            padding: 12px;
            background: #0756a5;
            color: white;
            text-align: center;
            border: none;
            border-radius: 9px;
            font-weight: 600;
            cursor: pointer;
            transition: .2s;
            font-size: 13px;
        }

        .btn-clean:hover {
            background: #063b75;
            box-shadow: 0 4px 12px rgba(7,86,165,.18);
        }

        /* EMPTY STATE */
        .empty {
            background: white;
            padding: 55px 25px;
            border-radius: 14px;
            text-align: center;
            color: #718096;
            font-size: 14px;
            border: 1px solid #e3ebf5;
            box-shadow: 0 4px 15px rgba(30,58,90,.04);
        }

        .empty-icon {
            width: 60px;
            height: 60px;
            background: #e8f1fc;
            color: #0756a5;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            border-radius: 18px;
            font-size: 27px;
        }

        .empty strong {
            display: block;
            color: #294969;
            font-size: 17px;
            margin-bottom: 7px;
        }

        /* PAGINATION */
        .pagination-area {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .pagination-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 15px;
            border-radius: 9px;
            background: white;
            color: #0756a5;
            text-decoration: none;
            font-weight: 700;
            border: 1px solid #dce8f5;
            transition: .2s;
            font-size: 13px;
        }

        .pagination-link:hover {
            background: #e8f1fc;
            border-color: #0756a5;
        }

        .pagination-link.active {
            background: #0756a5;
            color: white;
            border-color: #0756a5;
        }

        .pagination-link.disabled {
            color: #adb5bd;
            background: #f8f9fa;
            cursor: not-allowed;
            border-color: #e9ecef;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
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

            .search-bar {
                flex-direction: column;
            }

            .search-bar button {
                width: 100%;
            }

            .room-list {
                grid-template-columns: 1fr;
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

        <a href="/admin/room-status" class="back-button">
            ← Back to Room Overview
        </a>

        <div class="page-heading">
            <h1>{{ $title }}</h1>
            <p>Manage and monitor room information and current status.</p>
        </div>

        <!-- SEARCH BAR -->
        <form method="GET" action="" class="search-bar">
            <input
                type="text"
                name="search"
                placeholder="Search by guest name..."
                value="{{ $search ?? '' }}"
            >

            <button type="submit">Search</button>
        </form>

        @if(count($rooms) > 0)

            <div class="room-list">

                @foreach($rooms as $room)

                    <div class="room">

                        <!-- AVAILABLE PAGE -->
                        @if($type === 'available')

                            <div class="room-header">
                                <h3 class="room-name">{{ $room->name }}</h3>
                                <div class="room-icon">🛏️</div>
                            </div>

                            <span class="status-badge">✓ Available</span>

                        <!-- NEEDS CLEANING PAGE -->
                        @elseif($type === 'needs_cleaning')

                            <div class="room-header">
                                <h3 class="room-name">{{ $room->name }}</h3>
                                <div class="room-icon">🧹</div>
                            </div>

                            <span class="status-badge">Needs Cleaning</span>

                            <form action="{{ route('admin.rooms.mark-cleaned', $room->id) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn-clean">
                                    ✓ Mark as Cleaned
                                </button>
                            </form>

                        <!-- RESERVED PAGE -->
                        @elseif($type === 'reserved')

                            <div class="room-header">
                                <h3 class="room-name">{{ $room['room'] }}</h3>
                                <div class="room-icon">📅</div>
                            </div>

                            <span class="status-badge">Reserved</span>

                            <div class="room-info">
                                <p>
                                    <strong>Guest:</strong>
                                    <span>{{ $room['guest_name'] }}</span>
                                </p>

                                <p>
                                    <strong>Check-in:</strong>
                                    <span>{{ \Carbon\Carbon::parse($room['check_in'])->format('F d, Y') }}</span>
                                </p>

                                <p>
                                    <strong>Check-out:</strong>
                                    <span>{{ \Carbon\Carbon::parse($room['check_out'])->format('F d, Y') }}</span>
                                </p>

                                <p>
                                    <strong>Status:</strong>
                                    <span>{{ $room['status'] }}</span>
                                </p>
                            </div>

                        <!-- OCCUPIED PAGE -->
                        @elseif($type === 'occupied')

                            <div class="room-header">
                                <h3 class="room-name">{{ $room['room'] }}</h3>
                                <div class="room-icon">🚪</div>
                            </div>

                            <span class="status-badge">Occupied</span>

                            <div class="room-info">
                                <p>
                                    <strong>Guest:</strong>
                                    <span>{{ $room['guest_name'] }}</span>
                                </p>

                                <p>
                                    <strong>Check-in:</strong>
                                    <span>{{ \Carbon\Carbon::parse($room['check_in'])->format('F d, Y') }}</span>
                                </p>

                                <p>
                                    <strong>Check-out:</strong>
                                    <span>{{ \Carbon\Carbon::parse($room['check_out'])->format('F d, Y') }}</span>
                                </p>

                                <p>
                                    <strong>Status:</strong>
                                    <span>{{ $room['status'] }}</span>
                                </p>
                            </div>

                        @endif

                    </div>

                @endforeach

            </div>

            <!-- PAGINATION -->
            @if($rooms->hasPages())

                <div class="pagination-area">

                    @if ($rooms->onFirstPage())
                        <span class="pagination-link disabled">← Previous</span>
                    @else
                        <a href="{{ $rooms->previousPageUrl() }}" class="pagination-link">
                            ← Previous
                        </a>
                    @endif

                    @foreach ($rooms->getUrlRange(
                        max(1, $rooms->currentPage() - 2),
                        min($rooms->lastPage(), $rooms->currentPage() + 2)
                    ) as $page => $url)

                        @if ($page == $rooms->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-link">
                                {{ $page }}
                            </a>
                        @endif

                    @endforeach

                    @if ($rooms->hasMorePages())
                        <a href="{{ $rooms->nextPageUrl() }}" class="pagination-link">
                            Next →
                        </a>
                    @else
                        <span class="pagination-link disabled">Next →</span>
                    @endif

                </div>

            @endif

        @else

            <div class="empty">
                <div class="empty-icon">🛏️</div>

                <strong>
                    @if($type === 'available')
                        No Available Rooms
                    @elseif($type === 'needs_cleaning')
                        No Rooms Need Cleaning
                    @elseif($type === 'reserved')
                        No Reserved Rooms
                    @elseif($type === 'occupied')
                        No Occupied Rooms
                    @endif
                </strong>

                <span>
                    @if($type === 'available')
                        No rooms are currently available.
                    @elseif($type === 'needs_cleaning')
                        No rooms need cleaning right now.
                    @elseif($type === 'reserved')
                        No reserved rooms.
                    @elseif($type === 'occupied')
                        No occupied rooms.
                    @endif
                </span>
            </div>

        @endif

    </div>

    <!-- REAL-TIME ROOM STATUS LISTENER -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            if (!window.Echo) {
                console.warn('Echo is not loaded.');
                return;
            }

            window.Echo.private('admin.rooms')
                .listen('RoomStatusUpdated', (e) => {

                    console.log('Room Status Updated:', e);

                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);

                });

        });
    </script>

</body>
</html>