<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs - Otirasor Beach and Resort</title>

    @vite(['resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f8fc; color: #263746; min-height: 100vh; }
        a { text-decoration: none; }

        nav { background: #023e8a; min-height: 76px; padding: 0 5%; display: flex; justify-content: space-between; align-items: center; color: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.12); position: sticky; top: 0; z-index: 100; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand-logo { width: 58px; height: 58px; display: flex; align-items: center; justify-content: center; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; }
        .brand-title { font-size: 18px; font-weight: 700; }
        .brand-subtitle { font-size: 11px; opacity: 0.8; margin-top: 4px; }
        .nav-links { display: flex; align-items: center; gap: 15px; }
        .nav-links a { color: white; padding: 10px 12px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: 0.2s; }
        .nav-links a:hover { background: rgba(255, 255, 255, 0.13); }

        .container { max-width: 1180px; margin: 34px auto; padding: 0 22px 45px; }

        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
        
        .btn-back { background: white; color: #023e8a; padding: 10px 18px; border-radius: 8px; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: 1px solid #dce8ed; }
        .btn-back:hover { background: #e3eaf1; }

        .section-title { color: #023e8a; font-size: 24px; font-weight: 700; margin-bottom: 5px; }
        .section-description { color: #7a8793; font-size: 14px; margin-bottom: 25px; }

        .card { background: white; border: 1px solid #e1e9f0; border-radius: 14px; padding: 22px; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.045); }

        .search-wrapper { position: relative; width: 300px; }
        .search-wrapper input { width: 100%; padding: 10px 10px 10px 35px; border: 1px solid #ccc; border-radius: 8px; font-family: inherit; font-size: 14px; outline: none; }
        .search-wrapper input:focus { border-color: #0077b6; box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.1); }
        .search-wrapper span { position: absolute; left: 10px; top: 10px; color: #999; }

        .btn-print { padding: 10px 20px; background: #023e8a; color: white; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 14px; font-family: Arial; display: inline-flex; align-items: center; gap: 5px; }
        .btn-print:hover { background: #005f8f; }

        @media print {
            nav, .btn-back, .search-wrapper, .btn-print { display: none !important; }
            .container { margin: 0 !important; padding: 0 !important; max-width: 100% !important; }
            .card { border: none; box-shadow: none; padding: 0; }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <div class="brand-logo">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Logo">
        </div>
        <div class="brand-text">
            <div class="brand-title">Otirasor Beach and Resort</div>
            <div class="brand-subtitle">Administration Portal</div>
        </div>
    </div>

    <div class="nav-links">
        <a href="/admin/notifications" style="position: relative;">
            🔔 Notifications
            @if (($unreadNotificationsCount ?? 0) > 0)
                <span style="position: absolute; top: 0; right: 0; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px;">
                    {{ $unreadNotificationsCount }}
                </span>
            @endif
        </a>
        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" style="background: none; border: none; color: white; font-weight: bold; cursor: pointer; font-size: 14px; font-family: Arial;">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="header-flex">
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            ← Back to Dashboard
        </a>
    </div>

    <h1 class="section-title">Audit Logs</h1>
    <p class="section-description">Track all admin actions, approvals, and rejections.</p>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div class="search-wrapper">
            <input type="text" id="search-input" value="{{ $search }}" placeholder="Search admin, action, ID...">
            <span>🔍</span>
        </div>

        <button onclick="window.print()" class="btn-print">
            🖨️ Print
        </button>
    </div>

    <div class="card" id="table-container">
        @include('admin.audit-logs._table', ['logs' => $logs])
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-input');
        const tableContainer = document.getElementById('table-container');
        let debounceTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                
                debounceTimer = setTimeout(() => {
                    const query = this.value;

                    fetch(`{{ route('admin.audit-logs') }}?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        tableContainer.innerHTML = data.html;
                    })
                    .catch(error => console.error('Error fetching data:', error));
                }, 300);
            });
        }
    });
</script>

</body>
</html>