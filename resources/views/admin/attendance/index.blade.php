<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Attendance - Otirasor Beach and Resort</title>

    @vite(['resources/js/app.js'])

    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #333; }

        nav { background: #023e8a; color: white; padding: 18px 30px; display: flex; justify-content: space-between; align-items: center; }
        nav .logo { font-size: 21px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        nav a:hover { text-decoration: underline; }

        .container { max-width: 1200px; margin: 35px auto; padding: 0 20px; }

        .back-button { display: inline-block; margin-bottom: 20px; color: #023e8a; text-decoration: none; font-weight: bold; }
        .back-button:hover { text-decoration: underline; }

        .header { margin-bottom: 25px; }
        .header h1 { color: #023e8a; margin-bottom: 5px; }
        .header p { color: #666; }

        .filter-box { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07); }
        .filter-box label { font-weight: bold; margin-right: 10px; }
        .filter-box input, .filter-box select { padding: 9px 12px; border: 1px solid #ccc; border-radius: 6px; font-family: inherit; }
        .filter-box button { padding: 9px 16px; margin-left: 8px; border: none; border-radius: 6px; background: #0077b6; color: white; cursor: pointer; }
        .filter-box button:hover { background: #005f8f; }
        .filter-box a { margin-left: 8px; text-decoration: none; color: #023e8a; }

        .section-title { color: #023e8a; font-size: 20px; margin: 30px 0 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; }
        .section-title h2 { margin: 0; font-size: 20px; }

        .table-container { background: white; border-radius: 10px; overflow-x: auto; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07); }
        .table-container.mb { margin-bottom: 40px; }

        table { width: 100%; border-collapse: collapse; min-width: 1100px; }
        th { background: #023e8a; color: white; padding: 14px; text-align: left; white-space: nowrap; }
        td { padding: 13px; border-bottom: 1px solid #eee; vertical-align: top; }
        tr:hover { background: #f8fbff; }

        .status { font-weight: bold; }
        .present { color: #198754; }
        .absent { color: #dc3545; }

        .duration { white-space: nowrap; }

        .overtime-status { display: block; margin-top: 5px; font-size: 12px; color: #856404; }
        .overtime-status.approved { color: #198754; }
        .overtime-status.rejected { color: #dc3545; }

        .overtime-actions { display: flex; gap: 6px; flex-wrap: wrap; margin-top: 8px; }
        .overtime-actions form { margin: 0; }
        .overtime-actions button { padding: 6px 10px; border: none; border-radius: 4px; color: white; font-size: 12px; cursor: pointer; }
        .approve-button { background: #198754; }
        .approve-button:hover { background: #146c43; }
        .reject-button { background: #dc3545; }
        .reject-button:hover { background: #b02a37; }

        .message { padding: 12px 16px; margin-bottom: 15px; border-radius: 6px; }
        .success-message { background: #d1e7dd; color: #0f5132; }
        .error-message { background: #f8d7da; color: #842029; }

        .empty { text-align: center; padding: 35px; color: #777; }

        .worked-hours { font-weight: 700; color: #0077b6; }
        .red { color: #c62828; }
        .gray { color: #6b7280; }
        .orange { color: #856404; }

        @media (max-width: 700px) {
            nav { flex-direction: column; gap: 10px; text-align: center; }
            nav a { margin: 0 8px; }
            .container { margin: 20px auto; }
            .section-title { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>

<body>

<nav>
    <div class="logo">
        Otirasor Beach and Resort
    </div>

    <div>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a href="/admin/management">Management</a>
    </div>
</nav>

<div class="container">

    <a href="{{ route('admin.dashboard') }}" class="back-button">
        ← Back to Dashboard
    </a>

    <div class="header">
        <h1>Employee Attendance</h1>
        <p>View monthly summary and daily Time In, Time Out, late, undertime, and overtime records.</p>
    </div>

    {{-- BAGONG BUTTON PARA SA CORRECTIONS --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('admin.attendance.corrections') }}" style="display: inline-block; padding: 10px 20px; background: #f59e0b; color: white; border-radius: 6px; text-decoration: none; font-weight: bold;">
            ⚠️ Review Attendance Corrections
        </a>
    </div>

    @if (session('success'))
        <div class="message success-message">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="message error-message">
            {{ session('error') }}
        </div>
    @endif

    {{-- ============================================ --}}
    {{-- MONTHLY SUMMARY --}}
    {{-- ============================================ --}}

    <div class="section-title">
        <h2>📊 Monthly Summary — {{ $startOfMonth->format('F Y') }}</h2>

        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <form method="GET" action="/admin/attendance" class="filter-box" style="padding: 12px 18px; margin: 0; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                <select name="month">
                    @for ($m = 1; $m <= 12; $m++)
                        <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                        </option>
                    @endfor
                </select>

                <select name="year">
                    @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                        <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <button type="submit">Filter</button>
            </form>

            {{-- DOWNLOAD CSV BUTTON --}}
            <a href="{{ route('admin.attendance.download-csv', ['month' => $month, 'year' => $year]) }}"
               style="padding: 9px 16px; background: #10b981; color: white; border-radius: 6px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                ⬇️ Download CSV
            </a>

            {{-- DOWNLOAD PDF BUTTON --}}
            <a href="{{ route('admin.attendance.download-pdf', ['month' => $month, 'year' => $year]) }}"
               style="padding: 9px 16px; background: #ef4444; color: white; border-radius: 6px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                📄 Download PDF
            </a>
        </div>
    </div>

    <!-- SEARCH BAR PARA SA MONTHLY SUMMARY -->
    <div style="margin-bottom: 15px; position: relative; max-width: 400px;">
        <input type="text" id="summary-search" value="{{ $search ?? '' }}" placeholder="Search employee name..." 
            style="width: 100%; padding: 10px 10px 10px 35px; border: 1px solid #ccc; border-radius: 8px; font-family: inherit; font-size: 14px;">
        <span style="position: absolute; left: 10px; top: 10px; color: #999;">🔍</span>
    </div>

    <div class="table-container mb" id="summary-table-container">
        @include('admin.attendance._summary_table', ['summaries' => $summaries])
    </div>

    {{-- ============================================ --}}
    {{-- DAILY ATTENDANCE LIST --}}
    {{-- ============================================ --}}

    <div class="section-title">
        <h2>📋 Daily Attendance Records</h2>
    </div>

    <div class="filter-box">
        <form method="GET" action="{{ url('/admin/attendance') }}" style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
            <label>Select Date:</label>
            
            <!-- MONTH DROPDOWN (AUTO SUBMIT) -->
            <select name="month" onchange="this.form.submit()">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                    </option>
                @endfor
            </select>

            <!-- DAY DROPDOWN (AUTO SUBMIT) -->
            <select name="day" onchange="this.form.submit()" style="min-width: 80px;">
                <option value="">Day</option>
                @for ($d = 1; $d <= 31; $d++)
                    @php
                        $isValidDay = checkdate($month, $d, $year);
                    @endphp
                    @if($isValidDay)
                        <option value="{{ $d }}" {{ request('day') == $d ? 'selected' : '' }}>
                            {{ $d }}
                        </option>
                    @endif
                @endfor
            </select>

            <!-- YEAR DROPDOWN (AUTO SUBMIT) -->
            <select name="year" onchange="this.form.submit()">
                @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>

            <a href="{{ url('/admin/attendance') }}" style="text-decoration: none; color: #023e8a; font-weight: bold; margin-left: 10px;">Clear</a>
        </form>
    </div>

    <!-- SEARCH BAR PARA SA DAILY RECORDS -->
    <div style="margin-bottom: 15px; position: relative; max-width: 400px;">
        <input type="text" id="daily-search" value="{{ $search ?? '' }}" placeholder="Search employee name..." 
            style="width: 100%; padding: 10px 10px 10px 35px; border: 1px solid #ccc; border-radius: 8px; font-family: inherit; font-size: 14px;">
        <span style="position: absolute; left: 10px; top: 10px; color: #999;">🔍</span>
    </div>

    <div class="table-container" id="daily-table-container">
        @include('admin.attendance._daily_table', ['attendances' => $attendances])
    </div>

</div>

<!-- REAL-TIME SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.Echo) {
        console.warn('Echo is not loaded.');
        return;
    }

    // Makinig sa notifications ng admin (para sa attendance corrections at time-in/out)
    window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
        .notification((notification) => {
            console.log('Attendance Notification:', notification);

            // Kapag may attendance correction o update
            if (notification.type === 'attendance_correction' || notification.type === 'attendance_updated') {
                
                if (window.showToast) {
                    window.showToast(
                        'Attendance Update',
                        notification.message || 'May bagong update sa attendance.',
                        'info'
                    );
                }

                // Mag-reload after 1.5 seconds para lumabas ang bagong record sa table
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            }
        });
});
</script>

<!-- LIVE SEARCH SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const month = '{{ $month }}';
    const year = '{{ $year }}';
    const day = '{{ $day }}';

    // === SEARCH PARA SA MONTHLY SUMMARY ===
    const summarySearchInput = document.getElementById('summary-search');
    const summaryTableContainer = document.getElementById('summary-table-container');
    let summaryTimer;

    if (summarySearchInput) {
        summarySearchInput.addEventListener('input', function () {
            clearTimeout(summaryTimer);
            summaryTimer = setTimeout(() => {
                const query = this.value;
                fetch(`{{ route('admin.attendance.search-summary') }}?search=${encodeURIComponent(query)}&month=${month}&year=${year}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => { summaryTableContainer.innerHTML = data.html; })
                .catch(error => console.error('Error:', error));
            }, 300);
        });
    }

    // === SEARCH PARA SA DAILY RECORDS ===
    const dailySearchInput = document.getElementById('daily-search');
    const dailyTableContainer = document.getElementById('daily-table-container');
    let dailyTimer;

    if (dailySearchInput) {
        dailySearchInput.addEventListener('input', function () {
            clearTimeout(dailyTimer);
            dailyTimer = setTimeout(() => {
                const query = this.value;
                fetch(`{{ route('admin.attendance.search-daily') }}?search=${encodeURIComponent(query)}&month=${month}&year=${year}&day=${day}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                })
                .then(response => response.json())
                .then(data => { dailyTableContainer.innerHTML = data.html; })
                .catch(error => console.error('Error:', error));
            }, 300);
        });
    }
});
</script>

</body>
</html>