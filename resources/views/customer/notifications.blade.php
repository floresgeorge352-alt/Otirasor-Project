<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Otirasor Beach</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f5f8fc; color: #243b4a; min-height: 100vh; }
        h1, h2 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        nav { background: rgba(0, 119, 182, 0.95); backdrop-filter: blur(10px); padding: 15px 6%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); position: sticky; top: 0; z-index: 100; }
        .nav-brand { display: flex; align-items: center; gap: 12px; color: white; font-size: 18px; font-weight: 800; font-family: 'Montserrat', sans-serif; }
        .nav-brand img { width: 45px; height: 45px; object-fit: contain; border-radius: 50%; background: white; padding: 2px; }
        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a { color: white; text-decoration: none; font-size: 14px; font-weight: 500; transition: 0.3s; }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }
        .logout-btn { background: none; border: none; color: white; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif; }

        .container { width: 800px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #023e8a; text-align: center; margin-bottom: 30px; font-size: 32px; }

        .notif-card {
            background: white; padding: 20px 25px; border-radius: 12px; margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border-left: 5px solid #0077b6;
            display: flex; justify-content: space-between; align-items: center; gap: 15px;
            text-decoration: none; color: inherit; transition: 0.2s;
        }
        .notif-card:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08); }
        .notif-card.unread { background: #f0fbfd; border-left-color: #00b4d8; }
        
        .notif-content p { margin: 0; font-size: 15px; color: #1f2937; font-weight: 500; }
        .notif-content small { font-size: 12px; color: #6b7280; display: block; margin-top: 5px; }
        
        .empty { background: white; padding: 50px; text-align: center; border-radius: 16px; color: #6b7280; }
    </style>
</head>
<body>

<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo"> Otirasor Beach and Resort
    </div>
    <div class="nav-links">
        <a href="/dashboard">Dashboard</a>
        <a href="/accommodations">Book Now</a>
        <a href="/my-bookings">My Bookings</a>
        <a href="{{ route('customer.notifications') }}" style="position: relative;">🔔 Notifications</a>
        <form method="POST" action="/logout" style="display:inline;"><button type="submit" class="logout-btn">Logout</button></form>
    </div>
</nav>

<div class="container">
    <h1>Notifications</h1>

    @forelse($notifications as $notification)
        <a href="/notifications/{{ $notification->id }}/open" class="notif-card {{ $notification->read_at ? '' : 'unread' }}">
            <div class="notif-content">
                <p>{{ $notification->data['message'] ?? 'New notification' }}</p>
                <small>{{ $notification->created_at->diffForHumans() }}</small>
            </div>
            @if(!$notification->read_at)
                <span style="background: #00b4d8; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: bold;">NEW</span>
            @endif
        </a>
    @empty
        <div class="empty">
            <h2>No notifications yet.</h2>
            <p>You're all caught up!</p>
        </div>
    @endforelse
</div>

</body>
</html>