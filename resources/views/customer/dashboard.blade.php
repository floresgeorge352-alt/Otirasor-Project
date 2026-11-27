<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard - Otirasor Beach</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    {{-- Load Vite and Echo for Real-Time --}}
    @vite(['resources/js/app.js'])

    <style>
        :root {
            --primary: #0077b6;
            --primary-dark: #023e8a;
            --primary-light: #00b4d8;
            --bg: #f5f8fc;
            --text: #243b4a;
            --muted: #6c7a86;
            --border: #dce8ed;
            --white: #fff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            --radius: 20px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        h1, h2, h3, h4 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        /* NAVIGATION */
        nav {
            background: rgba(0, 119, 182, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 18px;
            font-weight: 800;
        }

        .nav-brand img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            border-radius: 50%;
            background: white;
            padding: 2px;
        }

        nav .nav-links { display: flex; align-items: center; gap: 20px; }
        nav a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: 0.3s;
        }
        nav a:hover { color: #dff8ff; transform: translateY(-2px); }

        .logout-btn {
            background: none;
            border: none;
            color: white;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: 0.3s;
        }
        .logout-btn:hover { color: #dff8ff; }

        /* MAIN CONTAINER */
        .container {
            width: 1100px;
            max-width: 92%;
            margin: 50px auto;
            flex: 1;
        }

        /* WELCOME HEADER */
        .welcome-header {
            background: linear-gradient(135deg, #ffffff, #f0fbfd);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 30px 40px;
            margin-bottom: 30px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-left: 6px solid var(--primary);
            flex-wrap: wrap;
        }

        .welcome-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .welcome-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #dceff8;
            border: 3px solid #c4e4f2;
            display: grid;
            place-items: center;
            overflow: hidden;
            color: var(--primary-dark);
            font: 800 30px 'Montserrat', sans-serif;
            flex-shrink: 0;
        }

        .welcome-avatar img { width: 100%; height: 100%; object-fit: cover; }

        .welcome-text h1 {
            color: var(--primary-dark);
            font-size: 26px;
            margin-bottom: 5px;
        }

        .welcome-text p {
            color: var(--muted);
            font-size: 14px;
            font-weight: 300;
        }

        .welcome-email {
            font-size: 13px;
            color: var(--primary);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: var(--shadow);
        }

        .stat-card .icon { font-size: 30px; margin-bottom: 10px; }
        .stat-card h3 { color: var(--muted); font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; }
        .stat-card .value { color: var(--primary-dark); font-size: 28px; font-weight: 800; }

        /* QUICK ACTIONS & LATEST BOOKING GRID */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
        }

        .card h2 {
            color: var(--primary-dark);
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 1px solid #edf1f5;
            padding-bottom: 15px;
        }

        .booking-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
        }

        .booking-info h4 { color: #1f2937; font-size: 15px; margin-bottom: 5px; }
        .booking-info p { color: var(--muted); font-size: 13px; }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }
        .status-pending { background: #fff4d8; color: #a36a00; }
        .status-confirmed { background: #e6f7ef; color: #147a4b; }
        .status-rejected { background: #ffe8ec; color: #b52d43; }
        .status-cancelled { background: #e5e7eb; color: #4b5563; }

        .quick-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .action-btn {
            display: block;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(0, 119, 182, 0.25);
        }
        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(0, 119, 182, 0.35); }
        .action-btn.orange { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25); }

        /* SETTINGS TABS */
        .settings-section { margin-top: 40px; }
        
        .tabs {
            display: flex;
            gap: 8px;
            padding: 6px;
            background: #e8eff4;
            border-radius: 12px;
            margin-bottom: 20px;
            overflow-x: auto;
        }

        .tab-btn {
            flex: 1;
            min-width: 120px;
            padding: 12px 15px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: #526b7c;
            font: 600 13px 'Poppins', sans-serif;
            cursor: pointer;
            transition: .2s;
        }
        .tab-btn:hover { background: rgba(255,255,255,.6); }
        .tab-btn.active { background: white; color: var(--primary-dark); box-shadow: 0 3px 10px rgba(0,0,0,.06); }

        .panel {
            display: none;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 30px;
            box-shadow: var(--shadow);
        }
        .panel.active { display: block; animation: fadeIn .25s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        .panel h2 { font-size: 18px; color: var(--primary-dark); margin-bottom: 5px; }
        .panel .hint { color: var(--muted); font-size: 12px; margin-bottom: 20px; }

        .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field { margin-bottom: 17px; }
        .field.full { grid-column: 1/-1; }
        label.lbl { display: block; font-size: 12px; font-weight: 600; color: #405568; margin-bottom: 7px; }

        input[type=text], input[type=email], input[type=password], input[type=file] {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #dce5ed;
            border-radius: 9px;
            background: #fff;
            font: 13px 'Poppins', sans-serif;
            color: var(--text);
            transition: .2s;
        }
        input:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(8,126,174,.10); }

        .btn {
            padding: 11px 18px;
            border: 0;
            border-radius: 9px;
            font: 600 12px 'Poppins', sans-serif;
            cursor: pointer;
            color: white;
            background: var(--primary);
            transition: .2s;
        }
        .btn:hover { background: var(--primary-dark); transform: translateY(-1px); }
        .btn.gray { background: #edf1f5; color: #405568; }
        .btn.red { background: #dc4242; }

        .divider { border: 0; border-top: 1px solid var(--border); margin: 25px 0; }

        .toggle-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #f9fbfd;
            margin-bottom: 18px;
        }
        .toggle-row strong { font-size: 13px; color: var(--primary-dark); }
        .toggle-row small { display: block; color: var(--muted); font-size: 11px; margin-top: 4px; }

        .switch { position: relative; width: 46px; height: 26px; flex-shrink: 0; }
        .switch input { opacity: 0; width: 0; height: 0; }
        .slider { position: absolute; inset: 0; background: #cbd5e1; border-radius: 26px; cursor: pointer; transition: .2s; }
        .slider:before { content: ''; position: absolute; width: 20px; height: 20px; left: 3px; top: 3px; background: white; border-radius: 50%; transition: .2s; }
        .switch input:checked + .slider { background: var(--primary); }
        .switch input:checked + .slider:before { transform: translateX(20px); }

        /* FOOTER */
        footer {
            text-align: center;
            padding: 25px;
            background: var(--primary-dark);
            color: rgba(255, 255, 255, 0.8);
            font-size: 13px;
            letter-spacing: 1px;
            margin-top: auto;
        }

        /* MOBILE */
        @media (max-width: 992px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .main-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            nav { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .welcome-header { flex-direction: column; text-align: center; padding: 30px 20px; }
            .welcome-left { flex-direction: column; }
            .stats-grid { grid-template-columns: 1fr; }
            .grid-form { grid-template-columns: 1fr; }
            .field.full { grid-column: auto; }
        }
    </style>
</head>
<body>

<!-- NAVIGATION -->
<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        Otirasor Beach and Resort
    </div>

    <div class="nav-links">
        <a href="/">Home</a>
        <a href="/dashboard" style="font-weight: 800;">Dashboard</a>
        <a href="/accommodations">Book Now</a>
        <a href="/my-bookings">My Bookings</a>
        <a href="/my-requests">My Requests</a>
        
        <!-- NOTIFICATION BELL -->
        <a href="{{ route('customer.notifications') }}" style="position: relative; display: inline-flex; align-items: center;">
            🔔 Notifications
            <span id="customer-notification-badge" style="position: absolute; top: -8px; right: -10px; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold; {{ auth()->user()->unreadNotifications->count() > 0 ? '' : 'display: none;' }}">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
        </a>

        <a href="/reviews">Reviews</a>

        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<!-- MAIN CONTENT -->
<div class="container">

    <!-- WELCOME HEADER -->
    <div class="welcome-header">
        <div class="welcome-left">
            <div class="welcome-avatar">
                @if(Auth::user()->avatar)
                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Profile">
                @else
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                @endif
            </div>
            <div class="welcome-text">
                <h1>Welcome, {{ Auth::user()->name }}!</h1>
                <p>Manage your bookings, explore our resort, and keep your account secure.</p>
                <div class="welcome-email">
                    📧 {{ Auth::user()->email }}
                    @if(Auth::user()->email_verified_at)
                        <span style="color: #147a4b; font-weight: 700; font-size: 11px;">(Verified)</span>
                    @else
                        <span style="color: #b52d43; font-weight: 700; font-size: 11px;">(Not Verified)</span>
                    @endif
                </div>
            </div>
        </div>
        <div>
            <a href="#settings" class="btn gray" style="text-decoration: none; font-size: 13px;">⚙ Edit Profile</a>
        </div>
    </div>

    @php
        $user = Auth::user();
        
        // Kunin lahat ng bookings kasama ang accommodations relationship
        $userBookings = App\Models\Booking::with('accommodations')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalBookings = $userBookings->count();
        $confirmedBookings = $userBookings->where('status', 'Confirmed')->count();
        $latestBooking = $userBookings->first(); // Pinakabago na agad
        
        // Get average rating and total reviews for the Resort
        $averageRating = App\Models\Review::avg('rating') ?? 0;
        $totalReviews = App\Models\Review::count();
    @endphp

    <!-- STATS CARDS -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="icon">📊</div>
            <h3>Total Bookings</h3>
            <div class="value">{{ $totalBookings }}</div>
        </div>
        
        <div class="stat-card">
            <div class="icon">✅</div>
            <h3>Confirmed</h3>
            <div class="value">{{ $confirmedBookings }}</div>
        </div>

        <div class="stat-card">
            <div class="icon">⭐</div>
            <h3>Reward Points</h3>
            <div class="value">{{ number_format($user->reward_points ?? 0) }}</div>
        </div>

        <div class="stat-card" style="border: 2px solid #fbbf24; background: #fffbeb;">
            <div class="icon">🏖️</div>
            <h3>Resort Rating</h3>
            <div class="value" style="color: #d97706; font-size: 26px;">
                {{ number_format($averageRating, 1) }} / 5
            </div>
            <div style="font-size: 12px; color: #92400e; margin-top: 5px;">
                {{ $totalReviews }} reviews
            </div>
        </div>
    </div>

    <!-- LATEST BOOKING & QUICK ACTIONS -->
    <div class="main-grid">
        <!-- Latest Booking Status -->
        <div class="card">
            <h2>📌 Latest Booking Status</h2>
            @if($latestBooking)
                <div class="booking-item">
                    <div class="booking-info">
                        <h4>Booking #{{ $latestBooking->id }}</h4>
                        <p>
                            @php
                                // Direkta nang gamitin ang accessor (string na ang ibinabalik nito)
                                $accNames = $latestBooking->accommodations;
                            @endphp
                            @if($accNames)
                                {{ $accNames }}
                            @else
                                <em style="color: #9ca3af;">No accommodation details</em>
                            @endif
                        </p>
                    </div>
                    <div>
                        @if($latestBooking->status === 'Pending')
                            <span class="status status-pending">Pending</span>
                        @elseif($latestBooking->status === 'Confirmed')
                            <span class="status status-confirmed">Confirmed</span>
                        @elseif($latestBooking->status === 'Rejected')
                            <span class="status status-rejected">Rejected</span>
                        @else
                            <span class="status status-cancelled">{{ $latestBooking->status }}</span>
                        @endif
                    </div>
                </div>
            @else
                <p style="color: var(--muted); font-size: 14px;">You haven't made any bookings yet. <a href="/accommodations" style="color: var(--primary); font-weight: bold; text-decoration: none;">Book your first stay!</a></p>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <h2>⚡ Quick Actions</h2>
            <div class="quick-actions">
                <a href="/accommodations" class="action-btn">🏖️ Book Now</a>
                <a href="/my-bookings" class="action-btn orange">📋 View All My Bookings</a>
                <a href="/reviews" class="action-btn" style="background: linear-gradient(135deg, #64748b, #94a3b8); box-shadow: 0 4px 15px rgba(100, 116, 139, 0.25);">⭐ View Reviews</a>
            </div>
        </div>
    </div>

    <!-- SETTINGS SECTION (Tabs) -->
    <div class="settings-section" id="settings">
        <div class="tabs" role="tablist">
            <button type="button" class="tab-btn active" data-tab="profile" role="tab">👤 Profile</button>
            <button type="button" class="tab-btn" data-tab="security" role="tab">🔒 Security</button>
            <button type="button" class="tab-btn" data-tab="preferences" role="tab">⚙ Preferences</button>
        </div>

        <!-- PROFILE PANEL -->
        <section class="panel active" id="panel-profile">
            <h2>Personal Information</h2>
            <p class="hint">Keep your contact information updated for your bookings.</p>

            <form method="POST" action="{{ route('customer.account.profile') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="profile">

                <div class="grid-form">
                    <div class="field full">
                        <label class="lbl" for="avatarInput">Profile Photo (JPG, PNG, WEBP - Max 2MB)</label>
                        <div style="display: flex; align-items: center; gap: 15px; margin-top: 8px;">
                            <div class="welcome-avatar" style="width: 60px; height: 60px; font-size: 22px;">
                                @if($user->avatar)
                                    <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" alt="Profile">
                                @else
                                    <span id="avatarInitial">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    <img id="avatarPreview" src="" alt="Preview" hidden>
                                @endif
                            </div>
                            <input type="file" id="avatarInput" name="avatar" accept=".jpg,.jpeg,.png,.webp">
                        </div>
                    </div>

                    <div class="field">
                        <label class="lbl" for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <div class="field">
                        <label class="lbl" for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="09123456789">
                    </div>

                    <div class="field full">
                        <label class="lbl" for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <button type="submit" class="btn">Save Changes</button>
            </form>

            @if($user->avatar)
                <form method="POST" action="{{ route('customer.account.avatar.remove') }}" style="margin-top: 12px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn gray" onclick="return confirm('Remove your profile picture?')">Remove Profile Picture</button>
                </form>
            @endif
        </section>

        <!-- SECURITY PANEL -->
        <section class="panel" id="panel-security">
            <h2>Password & Security</h2>
            <p class="hint">Protect your account with a strong password.</p>

            <form method="POST" action="{{ route('customer.account.password') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="security">

                <div class="field">
                    <label class="lbl" for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="grid-form">
                    <div class="field">
                        <label class="lbl" for="password">New Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="field">
                        <label class="lbl" for="password_confirmation">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="btn">Update Password</button>
            </form>

            <hr class="divider">

            <h2>Delete Account</h2>
            <p class="hint">Permanently delete your account and associated profile information.</p>
            
            <form method="POST" action="{{ route('customer.account.destroy') }}" onsubmit="return confirm('Are you sure you want to permanently delete your account? This cannot be undone.');">
                @csrf
                @method('DELETE')
                <input type="hidden" name="tab" value="security">

                <div class="field">
                    <label class="lbl" for="delete_password">Enter your password to confirm</label>
                    <input type="password" id="delete_password" name="delete_password" required>
                </div>

                <button type="submit" class="btn red">Delete My Account</button>
            </form>
        </section>

        <!-- PREFERENCES PANEL -->
        <section class="panel" id="panel-preferences">
            <h2>Notification Preferences</h2>
            <p class="hint">Choose whether you want to receive important resort updates by email.</p>

            <form method="POST" action="{{ route('customer.account.preferences') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="preferences">

                <div class="toggle-row">
                    <div>
                        <strong>Email Notifications</strong>
                        <small>Booking approvals, payment updates and receipts.</small>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="email_notifications" value="1" {{ old('email_notifications', $user->email_notifications ?? true) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                </div>

                <button type="submit" class="btn">Save Preferences</button>
            </form>
        </section>
    </div>

</div>

<!-- FOOTER -->
<footer>
    &copy; {{ date('Y') }} Otirasor Beach and Resort. All Rights Reserved.
</footer>

{{-- SCRIPTS --}}
<script>
    // Tabs Logic
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.panel');

        function show(name) {
            tabs.forEach(tab => {
                const active = tab.dataset.tab === name;
                tab.classList.toggle('active', active);
                tab.setAttribute('aria-selected', active ? 'true' : 'false');
            });
            panels.forEach(panel => {
                panel.classList.toggle('active', panel.id === 'panel-' + name);
            });
        }

        tabs.forEach(tab => {
            tab.addEventListener('click', () => show(tab.dataset.tab));
        });

        // Auto-open tab if there's a session flash
        @if(session('tab'))
            show('{{ session('tab') }}');
        @endif

        // Avatar Preview Logic
        const avatarInput = document.getElementById('avatarInput');
        const avatarPreview = document.getElementById('avatarPreview');
        const avatarInitial = document.getElementById('avatarInitial');

        if (avatarInput) {
            avatarInput.addEventListener('change', function () {
                const file = this.files && this.files[0];
                if (!file) return;

                if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                    alert('Please select a JPG, PNG or WEBP image.');
                    this.value = '';
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    alert('Image must not exceed 2MB.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (event) {
                    avatarPreview.src = event.target.result;
                    avatarPreview.hidden = false;
                    if (avatarInitial) avatarInitial.hidden = true;
                };
                reader.readAsDataURL(file);
            });
        }

        // Real-time Notification Listener
        if (window.Echo) {
            const userId = {{ auth()->id() }};
            const badge = document.getElementById('customer-notification-badge');

            window.Echo.private(`App.Models.User.${userId}`)
                .notification((notification) => {
                    console.log('New notification:', notification);
                    if (badge) {
                        let count = parseInt(badge.textContent.trim()) || 0;
                        badge.textContent = count + 1;
                        badge.style.display = 'inline-block';
                    }
                    if (window.showToast) {
                        let toastTitle = 'Booking Update';
                        if (notification.message) {
                            if (notification.message.toLowerCase().includes('confirmed')) toastTitle = 'Booking Confirmed!';
                            else if (notification.message.toLowerCase().includes('rejected')) toastTitle = 'Booking Rejected!';
                            else if (notification.message.toLowerCase().includes('cancelled')) toastTitle = 'Booking Cancelled!';
                        }
                        window.showToast(toastTitle, notification.message || `Update for Booking #${notification.booking_id}`, '/my-bookings');
                    }
                });
        }
    });
</script>

</body>
</html>