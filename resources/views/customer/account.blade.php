<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>My Account - Otirasor Beach and Resort</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

@vite(['resources/js/app.js'])

<style>
:root {
    --primary:#087eae;
    --primary-dark:#075985;
    --navy:#123b55;
    --muted:#718096;
    --border:#e5edf3;
    --background:#f3f7fa;
    --white:#fff;
    --shadow:0 10px 35px rgba(20,55,80,.07);
}

*{margin:0;padding:0;box-sizing:border-box}

body{
    font-family:'Poppins',sans-serif;
    background:var(--background);
    color:#243b4a;
}

h1,h2,h3,h4{font-family:'Montserrat',sans-serif}

nav{
    background:var(--primary-dark);
    padding:13px 5%;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:20px;
    position:sticky;
    top:0;
    z-index:100;
    box-shadow:0 4px 20px rgba(0,0,0,.10);
}

.nav-brand{
    display:flex;
    align-items:center;
    gap:11px;
    color:white;
    font-weight:800;
    font-family:'Montserrat',sans-serif;
    font-size:16px;
}

.nav-brand img{
    width:43px;
    height:43px;
    object-fit:contain;
    background:white;
    border-radius:50%;
    padding:3px;
}

.nav-links{
    display:flex;
    align-items:center;
    gap:7px;
    flex-wrap:wrap;
}

.nav-links a,.logout-btn{
    color:white;
    text-decoration:none;
    font-size:12px;
    font-weight:500;
    padding:9px 11px;
    border-radius:8px;
    transition:.2s;
}

.nav-links a:hover,.logout-btn:hover{
    background:rgba(255,255,255,.15);
}

.logout-btn{
    background:transparent;
    border:0;
    cursor:pointer;
    font-family:inherit;
}

.container{
    width:min(1080px,94%);
    margin:35px auto 70px;
}

.page-heading{margin-bottom:23px}

.page-heading h1{
    color:var(--navy);
    font-size:clamp(26px,4vw,34px);
    font-weight:800;
}

.page-heading p{
    color:var(--muted);
    font-size:13px;
    margin-top:6px;
}

.hero{
    background:linear-gradient(120deg,#075985,#0784bd 65%,#38a3c7);
    color:white;
    border-radius:19px;
    padding:28px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    box-shadow:0 12px 30px rgba(7,89,133,.18);
}

.hero h2{font-size:21px;margin-bottom:6px}
.hero p{color:#e1f3fb;font-size:12px}

.hero-label{
    background:rgba(255,255,255,.16);
    border:1px solid rgba(255,255,255,.25);
    padding:9px 15px;
    border-radius:30px;
    font-size:11px;
    font-weight:600;
}

.message{
    padding:14px 18px;
    border-radius:11px;
    margin-top:18px;
    font-size:13px;
    font-weight:500;
}

.success{
    background:#ecfdf3;
    color:#166534;
    border:1px solid #bbf7d0;
}

.error{
    background:#fff1f2;
    color:#991b1b;
    border:1px solid #fecaca;
}

.error ul{margin:7px 0 0 19px}

.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
    margin:20px 0;
}

.stat{
    background:white;
    padding:19px;
    border:1px solid var(--border);
    border-radius:14px;
    box-shadow:var(--shadow);
}

.stat small{
    display:block;
    color:var(--muted);
    font-size:11px;
    margin-bottom:8px;
}

.stat strong{
    font-family:'Montserrat',sans-serif;
    font-size:25px;
    color:var(--primary-dark);
}

.stat-icon{
    width:34px;
    height:34px;
    display:grid;
    place-items:center;
    background:#e8f5fb;
    color:var(--primary);
    border-radius:10px;
    margin-bottom:10px;
    font-size:16px;
}

.tabs{
    display:flex;
    gap:8px;
    padding:6px;
    background:#e8eff4;
    border-radius:12px;
    margin:24px 0 16px;
    overflow-x:auto;
}

.tab-btn{
    flex:1;
    min-width:110px;
    padding:12px 15px;
    border:0;
    border-radius:9px;
    background:transparent;
    color:#526b7c;
    font:600 12px 'Poppins',sans-serif;
    cursor:pointer;
    transition:.2s;
}

.tab-btn:hover{background:rgba(255,255,255,.6)}

.tab-btn.active{
    background:white;
    color:var(--primary-dark);
    box-shadow:0 3px 10px rgba(0,0,0,.06);
}

.panel{
    display:none;
    background:white;
    border:1px solid var(--border);
    border-radius:16px;
    padding:27px;
    box-shadow:var(--shadow);
}

.panel.active{
    display:block;
    animation:fadeIn .25s ease;
}

@keyframes fadeIn{
    from{opacity:0;transform:translateY(5px)}
    to{opacity:1;transform:translateY(0)}
}

.panel h2{
    font-size:19px;
    color:var(--navy);
    margin-bottom:5px;
}

.panel .hint{
    color:var(--muted);
    font-size:12px;
    margin-bottom:22px;
}

.avatar-row{
    display:flex;
    align-items:center;
    gap:19px;
    padding:18px;
    background:#f8fbfd;
    border:1px solid var(--border);
    border-radius:13px;
    margin-bottom:23px;
    flex-wrap:wrap;
}

.avatar{
    width:86px;
    height:86px;
    border-radius:50%;
    background:#dceff8;
    border:3px solid #c4e4f2;
    display:grid;
    place-items:center;
    overflow:hidden;
    color:var(--primary-dark);
    font:800 30px 'Montserrat',sans-serif;
    flex-shrink:0;
}

.avatar img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.avatar-info strong{
    display:block;
    color:var(--navy);
    font-size:14px;
    margin-bottom:4px;
}

.avatar-info small{color:var(--muted);font-size:11px}

.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}

.field{margin-bottom:17px}
.field.full{grid-column:1/-1}

label.lbl{
    display:block;
    font-size:12px;
    font-weight:600;
    color:#405568;
    margin-bottom:7px;
}

input[type=text],
input[type=email],
input[type=password],
input[type=file]{
    width:100%;
    padding:12px 13px;
    border:1px solid #dce5ed;
    border-radius:9px;
    background:#fff;
    font:13px 'Poppins',sans-serif;
    color:#243b4a;
    transition:.2s;
}

input:focus{
    outline:none;
    border-color:var(--primary);
    box-shadow:0 0 0 3px rgba(8,126,174,.10);
}

.badge{
    display:inline-block;
    padding:4px 9px;
    border-radius:20px;
    font-size:10px;
    font-weight:700;
    margin-left:5px;
}

.badge.ok{background:#e5f8ee;color:#147a4b}
.badge.warn{background:#fff4d8;color:#986300}

.btn{
    padding:11px 18px;
    border:0;
    border-radius:9px;
    font:600 12px 'Poppins',sans-serif;
    cursor:pointer;
    color:white;
    background:var(--primary);
    transition:.2s;
}

.btn:hover{
    background:var(--primary-dark);
    transform:translateY(-1px);
}

.btn.red{background:#dc4242}
.btn.red:hover{background:#b91c1c}
.btn.gray{background:#edf1f5;color:#405568}
.btn.gray:hover{background:#dce5ed}
.btn.small{padding:8px 13px;font-size:11px}

.divider{
    border:0;
    border-top:1px solid var(--border);
    margin:27px 0;
}

.toggle-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:15px;
    padding:17px;
    border:1px solid var(--border);
    border-radius:12px;
    background:#f9fbfd;
    margin-bottom:18px;
}

.toggle-row strong{font-size:13px;color:var(--navy)}

.toggle-row small{
    display:block;
    color:var(--muted);
    font-size:11px;
    margin-top:4px;
}

.switch{
    position:relative;
    width:46px;
    height:26px;
    flex-shrink:0;
}

.switch input{
    opacity:0;
    width:0;
    height:0;
}

.slider{
    position:absolute;
    inset:0;
    background:#cbd5e1;
    border-radius:26px;
    cursor:pointer;
    transition:.2s;
}

.slider:before{
    content:'';
    position:absolute;
    width:20px;
    height:20px;
    left:3px;
    top:3px;
    background:white;
    border-radius:50%;
    transition:.2s;
}

.switch input:checked + .slider{background:var(--primary)}
.switch input:checked + .slider:before{transform:translateX(20px)}

.danger{
    border:1px solid #fecaca;
    background:#fff8f8;
    border-radius:13px;
    padding:20px;
}

.danger h3{
    color:#991b1b;
    font-size:16px;
    margin-bottom:7px;
}

.danger p{
    color:#7f1d1d;
    font-size:12px;
    line-height:1.7;
    margin-bottom:15px;
}

.qr{
    margin:12px 0;
    padding:14px;
    background:white;
    border:1px solid var(--border);
    border-radius:11px;
    display:inline-block;
    max-width:100%;
    overflow:auto;
}

.codes{
    background:#f1f5f9;
    border-radius:9px;
    padding:14px;
    font:12px monospace;
    margin-top:10px;
    line-height:1.8;
    overflow-wrap:anywhere;
}

.footer{
    text-align:center;
    color:#8a9aa8;
    font-size:11px;
    padding:25px 10px;
}

@media(max-width:800px){
    nav{padding:12px 4%;flex-direction:column}
    .nav-links{justify-content:center}
    .nav-links a,.logout-btn{font-size:11px;padding:7px}
}

@media(max-width:600px){
    .container{margin-top:23px}
    .hero{padding:22px}
    .stats{grid-template-columns:1fr;gap:10px}
    .stat{padding:14px}
    .stat-icon{
        display:inline-grid;
        vertical-align:middle;
        margin:0 9px 0 0;
    }
    .grid{grid-template-columns:1fr;gap:0}
    .field.full{grid-column:auto}
    .panel{padding:19px}
    .tabs{gap:4px}
    .tab-btn{min-width:95px;padding:10px 7px;font-size:11px}
    .avatar-row{align-items:flex-start}
}
</style>
</head>

<body>

<nav>
    <div class="nav-brand">
        <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo">
        Otirasor Beach and Resort
    </div>

    <div class="nav-links">
        <a href="/">Dashboard</a>
        <a href="/accommodations">Book Now</a>
        <a href="/my-bookings">My Bookings</a>
        <a href="/my-requests">My Requests</a>
        <a href="/notifications">🔔 Notifications</a>
        <a href="{{ route('customer.account') }}">👤 My Account</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>

<main class="container">

    <div class="page-heading">
        <h1>My Account</h1>
        <p>Manage your personal information, security and preferences.</p>
    </div>

    <section class="hero">
        <div>
            <h2>Welcome, {{ $user->name }}!</h2>
            <p>Your personal account and resort booking information.</p>
        </div>
        <span class="hero-label">✦ Customer Account</span>
    </section>

    @if(session('success'))
        <div class="message success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message error">{{ session('error') }}</div>
    @endif

    @if(session('status'))
        <div class="message success">
            {{ str_replace('-', ' ', ucfirst(session('status'))) }}.
        </div>
    @endif

    @if($errors->any())
        <div class="message error">
            Please fix the following:
            <ul>
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="stats">
        <div class="stat">
            <div class="stat-icon">★</div>
            <small>Reward Points</small>
            <strong>{{ number_format($user->reward_points ?? 0) }}</strong>
        </div>

        <div class="stat">
            <div class="stat-icon">▣</div>
            <small>Total Bookings</small>
            <strong>{{ $stats['total'] }}</strong>
        </div>

        <div class="stat">
            <div class="stat-icon">✓</div>
            <small>Confirmed Bookings</small>
            <strong>{{ $stats['confirmed'] }}</strong>
        </div>
    </section>

    @php
        $activeTab = old('tab', session('tab', 'profile'));
        $allowedTabs = ['profile', 'security', 'preferences'];

        if (!in_array($activeTab, $allowedTabs, true)) {
            $activeTab = 'profile';
        }
    @endphp

    <div class="tabs" role="tablist" aria-label="Account settings">
        <button type="button" class="tab-btn" data-tab="profile" role="tab">👤 Profile</button>
        <button type="button" class="tab-btn" data-tab="security" role="tab">🔒 Security</button>
        <button type="button" class="tab-btn" data-tab="preferences" role="tab">⚙ Preferences</button>
    </div>

    <!-- PROFILE PANEL -->
    <section class="panel" id="panel-profile">

        <h2>Personal Information</h2>
        <p class="hint">Keep your contact information updated for your bookings.</p>

        <form method="POST"
              action="{{ route('customer.account.profile') }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')
            <input type="hidden" name="tab" value="profile">

            <div class="avatar-row">
                <div class="avatar">
                    @if($user->avatar)
                        <img id="avatarPreview"
                             src="{{ asset('storage/' . $user->avatar) }}"
                             alt="Profile picture">
                    @else
                        <span id="avatarInitial">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                        <img id="avatarPreview" src="" alt="Profile picture preview" hidden>
                    @endif
                </div>

                <div class="avatar-info">
                    <strong>Your Profile Photo</strong>
                    <small>JPG, PNG or WEBP · Maximum 2MB</small>

                    <div style="margin-top:12px">
                        <input type="file"
                               id="avatarInput"
                               name="avatar"
                               accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    </div>
                </div>
            </div>

            <div class="grid">
                <div class="field">
                    <label class="lbl" for="name">Full Name</label>
                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           required>
                </div>

                <div class="field">
                    <label class="lbl" for="phone">Phone Number</label>
                    <input type="text"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           placeholder="09123456789">
                </div>

                <div class="field full">
                    <label class="lbl" for="email">
                        Email Address

                        @if($user->email_verified_at)
                            <span class="badge ok">Verified</span>
                        @else
                            <span class="badge warn">Not verified</span>
                        @endif
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           required>
                </div>
            </div>

            <button type="submit" class="btn">Save Changes</button>
        </form>

        @if($user->avatar)
            <form method="POST"
                  action="{{ route('customer.account.avatar.remove') }}"
                  style="margin-top:12px">

                @csrf
                @method('DELETE')

                <button type="submit" class="btn gray small"
                        onclick="return confirm('Remove your profile picture?')">
                    Remove Profile Picture
                </button>
            </form>
        @endif
    </section>

    <!-- SECURITY PANEL -->
    <section class="panel" id="panel-security">

        <h2>Password & Security</h2>
        <p class="hint">Protect your account with a strong password and two-factor authentication.</p>

        <form method="POST" action="{{ route('customer.account.password') }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="tab" value="security">

            <div class="field">
                <label class="lbl" for="current_password">Current Password</label>
                <input type="password"
                       id="current_password"
                       name="current_password"
                       autocomplete="current-password"
                       required>
            </div>

            <div class="grid">
                <div class="field">
                    <label class="lbl" for="password">New Password</label>
                    <input type="password"
                           id="password"
                           name="password"
                           autocomplete="new-password"
                           required>
                </div>

                <div class="field">
                    <label class="lbl" for="password_confirmation">Confirm New Password</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           autocomplete="new-password"
                           required>
                </div>
            </div>

            <button type="submit" class="btn">Update Password</button>
        </form>

        <hr class="divider">

        <h2>Two-Factor Authentication</h2>
        <p class="hint">Add another layer of protection using an authenticator app.</p>

        @if($user->two_factor_secret)

            @if($user->two_factor_confirmed_at)

                <span class="badge ok" style="margin:0 0 12px">Enabled</span>

                <p class="hint">Your two-factor authentication is active.</p>

                @if($user->two_factor_recovery_codes)
                    <div class="codes">
                        <strong>Recovery codes — keep them safe:</strong><br>

                        @foreach(json_decode(decrypt($user->two_factor_recovery_codes), true) as $code)
                            {{ $code }}<br>
                        @endforeach
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('two-factor.regenerate-codes') }}"
                      style="margin-top:14px">

                    @csrf

                    <button type="submit" class="btn gray small"
                            onclick="return confirm('Generate new recovery codes? Your old codes will no longer work.')">
                        Regenerate Recovery Codes
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('two-factor.disable') }}"
                      style="margin-top:14px">

                    @csrf

                    <button type="submit" class="btn red small"
                            onclick="return confirm('Are you sure you want to disable two-factor authentication?')">
                        Disable Two-Factor Authentication
                    </button>
                </form>

            @else

                <span class="badge warn" style="margin:0 0 12px">Setup Pending</span>

                <p class="hint">
                    Scan this QR code using your authenticator app, then enter the verification code below.
                </p>

                <div class="qr">
                    {!! $user->twoFactorQrCodeSvg() !!}
                </div>

                <form method="POST"
                      action="{{ route('two-factor.confirm') }}"
                      style="margin-top:14px">

                    @csrf

                    <input type="hidden" name="tab" value="security">

                    <div class="field">
                        <label class="lbl" for="two_factor_code">
                            Authentication Code
                        </label>

                        <input type="text"
                               id="two_factor_code"
                               name="code"
                               inputmode="numeric"
                               autocomplete="one-time-code"
                               placeholder="Enter 6-digit code"
                               required>
                    </div>

                    <button type="submit" class="btn small">
                        Confirm Two-Factor Authentication
                    </button>
                </form>

            @endif

        @else

            <span class="badge warn" style="margin:0 0 12px">Not Enabled</span>

            <form method="POST" action="{{ route('two-factor.enable') }}">
                @csrf

                <button type="submit" class="btn small">
                    Enable Two-Factor Authentication
                </button>
            </form>

        @endif

        <hr class="divider">

        <div class="danger">
            <h3>Delete Account</h3>

            <p>
                Permanently delete your account and associated profile information.
                You cannot delete your account while you have Pending, Confirmed,
                or Pending Cancellation bookings.
            </p>

            <form method="POST"
                  action="{{ route('customer.account.destroy') }}"
                  onsubmit="return confirm('Are you sure you want to permanently delete your account? This cannot be undone.');">

                @csrf
                @method('DELETE')

                <input type="hidden" name="tab" value="security">

                <div class="field">
                    <label class="lbl" for="delete_password">
                        Enter your password to confirm
                    </label>

                    <input type="password"
                           id="delete_password"
                           name="delete_password"
                           autocomplete="current-password"
                           required>
                </div>

                <button type="submit" class="btn red">
                    Delete My Account
                </button>
            </form>
        </div>
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
                    <input type="checkbox"
                           name="email_notifications"
                           value="1"
                           {{ old('email_notifications', $user->email_notifications ?? true) ? 'checked' : '' }}>

                    <span class="slider"></span>
                </label>
            </div>

            <button type="submit" class="btn">Save Preferences</button>
        </form>
    </section>

    <footer class="footer">
        © {{ date('Y') }} Otirasor Beach and Resort. All rights reserved.
    </footer>

</main>

<script>
(function () {
    const tabs = document.querySelectorAll('.tab-btn');
    const panels = document.querySelectorAll('.panel');

    function show(name) {
        tabs.forEach(function (tab) {
            const active = tab.dataset.tab === name;
            tab.classList.toggle('active', active);
            tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        panels.forEach(function (panel) {
            panel.classList.toggle(
                'active',
                panel.id === 'panel-' + name
            );
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            show(tab.dataset.tab);
        });
    });

    show(@json($activeTab));

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

                if (avatarInitial) {
                    avatarInitial.hidden = true;
                }
            };

            reader.readAsDataURL(file);
        });
    }
})();
</script>

</body>
</html>