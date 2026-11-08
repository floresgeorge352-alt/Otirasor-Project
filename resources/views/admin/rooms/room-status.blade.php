<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Status Overview - Otirasor Beach</title>
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

        .summary { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 35px; }
        
        .summary-card {
            background: white; padding: 30px 25px; border-radius: 12px; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            text-align: center; text-decoration: none; color: inherit; display: block;
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
            border: 2px solid transparent;
        }
        .summary-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12); }
        
        .summary-card.available-card:hover { border-color: #168a4a; }
        .summary-card.cleaning-card:hover { border-color: #d97706; }
        .summary-card.reserved-card:hover { border-color: #d68910; }
        .summary-card.occupied-card:hover { border-color: #c0392b; }
        
        .summary-card h3 { margin-top: 0; color: #555; font-size: 18px; }
        .number { font-size: 48px; font-weight: bold; margin: 15px 0; }
        
        .available-num { color: #168a4a; }
        .cleaning-num { color: #d97706; }
        .reserved-num { color: #d68910; }
        .occupied-num { color: #c0392b; }
        
        .available-text { color: #168a4a; font-weight: bold; }
        .cleaning-text { color: #d97706; font-weight: bold; }
        .reserved-text { color: #d68910; font-weight: bold; }
        .occupied-text { color: #c0392b; font-weight: bold; }
        
        .click-hint { font-size: 12px; color: #999; margin-top: 10px; font-style: italic; }

        @media (max-width: 950px) { .summary { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 600px) { .summary { grid-template-columns: 1fr; } }
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
        <a href="/admin/dashboard" class="back-button">← Back to Dashboard</a>
        <h1 class="title">Room Status Overview</h1>

        <div class="summary">
            <a href="/admin/rooms/available" class="summary-card available-card">
                <h3>Available Rooms</h3>
                <div class="number available-num">{{ count($availableRooms) }}</div>
                <p class="available-text">Currently Available</p>
                <div class="click-hint">Click to view details →</div>
            </a>

            <a href="/admin/rooms/needs-cleaning" class="summary-card cleaning-card">
                <h3>Needs Cleaning</h3>
                <div class="number cleaning-num">{{ count($needsCleaningRooms) }}</div>
                <p class="cleaning-text">For Housekeeping</p>
                <div class="click-hint">Click to view details →</div>
            </a>

            <a href="/admin/rooms/reserved" class="summary-card reserved-card">
                <h3>Reserved Rooms</h3>
                <div class="number reserved-num">{{ count($reservedRooms) }}</div>
                <p class="reserved-text">Upcoming Reservations</p>
                <div class="click-hint">Click to view details →</div>
            </a>

            <a href="/admin/rooms/occupied" class="summary-card occupied-card">
                <h3>Occupied Rooms</h3>
                <div class="number occupied-num">{{ count($occupiedRooms) }}</div>
                <p class="occupied-text">Currently Occupied</p>
                <div class="click-hint">Click to view details →</div>
            </a>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        if (!window.Echo) {
            console.warn('Echo is not loaded.');
            return;
        }

        // Makinig sa room status updates (Check-in, Check-out, Mark Cleaned)
        window.Echo.channel('admin.rooms')
            .listen('RoomStatusUpdated', (e) => {
                console.log('Room Status Updated:', e);

                // Optional: Mag-show ng toast notification
                if (window.showToast) {
                    window.showToast(
                        'Room Status Updated',
                        `Booking #${e.booking_id} status has changed to ${e.status}.`,
                        'info'
                    );
                }

                // Auto-reload ang page after 1.5 seconds para lumabas ang bagong bilang
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            });
    });
    </script>

</body>
</html>