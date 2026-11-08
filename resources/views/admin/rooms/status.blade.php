<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - Otirasor Beach</title>
    @vite(['resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #333; }
        .navbar { background: #064b93; color: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; }
        .navbar h2 { margin: 0; font-size: 22px; }
        .navbar a { color: white; text-decoration: none; margin-left: 25px; font-size: 15px; }
        .container { max-width: 1200px; margin: 40px auto; padding: 0 25px; }
        .back-button { display: inline-block; margin-bottom: 25px; background: #6c757d; color: white; text-decoration: none; padding: 10px 18px; border-radius: 6px; }
        .back-button:hover { background: #555; }
        .title { color: #064b93; margin-bottom: 25px; }

        /* SEARCH BAR */
        .search-bar { display: flex; gap: 10px; margin-bottom: 25px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); }
        .search-bar input { flex: 1; padding: 12px 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 15px; outline: none; }
        .search-bar input:focus { border-color: #064b93; }
        .search-bar button { padding: 12px 25px; background: #064b93; color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }

        .room-list { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .room { border: 1px solid #ddd; border-radius: 10px; padding: 20px; background: white; box-shadow: 0 3px 10px rgba(0,0,0,0.05); }
        .room-name { font-weight: bold; font-size: 20px; color: #064b93; margin-bottom: 10px; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: bold; margin-bottom: 15px; }
        .available-badge { background: #e6f7ef; color: #168a4a; }
        .reserved-badge { background: #fff4d8; color: #d68910; }
        .occupied-badge { background: #ffe8ec; color: #c0392b; }
        .cleaning-badge { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        
        .room p { margin: 6px 0; font-size: 14px; color: #555; }
        .room p strong { color: #333; }
        .empty { background: white; padding: 40px; border-radius: 10px; text-align: center; color: #777; font-size: 16px; }

        /* MARK CLEANED BUTTON */
        .btn-clean { margin-top: 15px; display: block; width: 100%; padding: 10px; background: #10b981; color: white; text-align: center; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; transition: 0.2s; font-size: 14px; }
        .btn-clean:hover { background: #059669; }

        /* PAGINATION */
        .pagination-area { margin-top: 30px; display: flex; justify-content: center; gap: 8px; flex-wrap: wrap; }
        .pagination-link { display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; padding: 0 15px; border-radius: 8px; background: white; color: #064b93; text-decoration: none; font-weight: 700; border: 1px solid #dce8ed; transition: 0.2s; font-size: 14px; }
        .pagination-link:hover { background: #eaf8fc; border-color: #064b93; }
        .pagination-link.active { background: #064b93; color: white; border-color: #064b93; }
        .pagination-link.disabled { color: #adb5bd; background: #f8f9fa; cursor: not-allowed; border-color: #e9ecef; }

        @media (max-width: 768px) { .navbar { padding: 18px 20px; } .navbar a { margin-left: 10px; } }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Otirasor Beach and Resort - Admin</h2>
        <div>
            <a href="/admin/dashboard">Dashboard</a>
            <a href="/admin/bookings">Bookings</a>
            <a href="/admin/notifications">Notifications</a>
        </div>
    </div>

    <div class="container">
        <a href="/admin/room-status" class="back-button">← Back to Room Overview</a>
        <h1 class="title">{{ $title }}</h1>

        <!-- SEARCH BAR -->
        <form method="GET" action="" class="search-bar">
            <input type="text" name="search" placeholder="Search by guest name..." value="{{ $search ?? '' }}">
            <button type="submit">Search</button>
        </form>

        @if(count($rooms) > 0)
            <div class="room-list">
                @foreach($rooms as $room)
                    <div class="room">
                        
                        {{-- AVAILABLE PAGE --}}
                        @if($type === 'available')
                            <div class="room-name">{{ $room->name }}</div>
                            <span class="status-badge available-badge">✓ Available</span>

                        {{-- NEEDS CLEANING PAGE --}}
                        @elseif($type === 'needs_cleaning')
                            <div class="room-name">{{ $room->name }}</div>
                            <span class="status-badge cleaning-badge">🧹 Needs Cleaning</span>
                            <form action="{{ route('admin.rooms.mark-cleaned', $room->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-clean">✓ Mark as Cleaned</button>
                            </form>

                        {{-- RESERVED PAGE --}}
                        @elseif($type === 'reserved')
                            <div class="room-name">{{ $room['room'] }}</div>
                            <span class="status-badge reserved-badge">Reserved</span>
                            <p><strong>Guest:</strong> {{ $room['guest_name'] }}</p>
                            <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($room['check_in'])->format('F d, Y') }}</p>
                            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($room['check_out'])->format('F d, Y') }}</p>
                            <p><strong>Status:</strong> {{ $room['status'] }}</p>

                        {{-- OCCUPIED PAGE --}}
                        @elseif($type === 'occupied')
                            <div class="room-name">{{ $room['room'] }}</div>
                            <span class="status-badge occupied-badge">Occupied</span>
                            <p><strong>Guest:</strong> {{ $room['guest_name'] }}</p>
                            <p><strong>Check-in:</strong> {{ \Carbon\Carbon::parse($room['check_in'])->format('F d, Y') }}</p>
                            <p><strong>Check-out:</strong> {{ \Carbon\Carbon::parse($room['check_out'])->format('F d, Y') }}</p>
                            <p><strong>Status:</strong> {{ $room['status'] }}</p>
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
                        <a href="{{ $rooms->previousPageUrl() }}" class="pagination-link">← Previous</a>
                    @endif

                    @foreach ($rooms->getUrlRange(max(1, $rooms->currentPage() - 2), min($rooms->lastPage(), $rooms->currentPage() + 2)) as $page => $url)
                        @if ($page == $rooms->currentPage())
                            <span class="pagination-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if ($rooms->hasMorePages())
                        <a href="{{ $rooms->nextPageUrl() }}" class="pagination-link">Next →</a>
                    @else
                        <span class="pagination-link disabled">Next →</span>
                    @endif
                </div>
            @endif

        @else
            <div class="empty">
                @if($type === 'available') No rooms are currently available.
                @elseif($type === 'needs_cleaning') No rooms need cleaning right now.
                @elseif($type === 'reserved') No reserved rooms.
                @elseif($type === 'occupied') No occupied rooms.
                @endif
            </div>
        @endif
    </div>

    {{-- REAL-TIME ROOM STATUS LISTENER --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (!window.Echo) return;

            window.Echo.private('admin.rooms')
                .listen('RoomStatusUpdated', (e) => {
                    console.log('Room Status Updated:', e);
                    setTimeout(() => { window.location.reload(); }, 1000); 
                });
        });
    </script>

</body>
</html>