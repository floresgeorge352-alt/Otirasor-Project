<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Otirasor Beach</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Poppins', sans-serif; background: #f4f7f9; color: #333; min-height: 100vh; }
        h1, h2 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        .navbar { background: #0f4c5c; color: white; padding: 15px 6%; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 15px rgba(0,0,0,0.15); position: sticky; top: 0; z-index: 100; }
        .logo-section { display: flex; align-items: center; gap: 12px; }
        .logo-section img { width: 45px; height: 45px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        .logo-section h2 { font-size: 18px; margin: 0; color: white; }
        
        .nav-actions { display: flex; align-items: center; gap: 20px; }
        .notification-link { color: white; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; }
        
        .logout-form button { background: #e74c3c; color: white; border: none; padding: 9px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.3s; font-family: 'Poppins', sans-serif; }
        .logout-form button:hover { background: #c0392b; }

        .container { width: 800px; max-width: 92%; margin: 40px auto 60px; }
        h1 { color: #0f4c5c; text-align: center; margin-bottom: 30px; font-size: 32px; }

        .notif-card {
            background: white; padding: 20px 25px; border-radius: 12px; margin-bottom: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); border-left: 5px solid #0f4c5c;
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

<nav class="navbar">
    <div class="logo-section">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo">
        <h2>Otirasor Beach and Resort</h2>
    </div>
    <div class="nav-actions">
        <a href="{{ route('employee.notifications') }}" class="notification-link">🔔 Notifications</a>
        <form method="POST" action="{{ route('logout') }}" class="logout-form" style="margin: 0;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>
</nav>

<div class="container">
    <h1>Notifications</h1>

    @forelse($notifications as $notification)
        <a href="/employee/notifications/{{ $notification->id }}/open" class="notif-card {{ $notification->read_at ? '' : 'unread' }}">
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