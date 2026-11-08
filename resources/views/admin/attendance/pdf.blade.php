<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance - Otirasor Beach</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #f4f7fb; color: #333; }
        nav { background: #023e8a; color: white; padding: 18px 30px; display: flex; justify-content: space-between; align-items: center; }
        nav .logo { font-size: 21px; font-weight: bold; }
        nav a { color: white; text-decoration: none; margin-left: 20px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1000px; margin: 35px auto; padding: 0 20px; }
        .back-button { display: inline-block; margin-bottom: 20px; color: #023e8a; text-decoration: none; font-weight: bold; }
        .back-button:hover { text-decoration: underline; }
        .header-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px; }
        .header-flex h1 { color: #023e8a; margin: 0; }
        .filter-form { display: flex; gap: 10px; align-items: center; background: white; padding: 10px 15px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .filter-form select { padding: 8px; border: 1px solid #ccc; border-radius: 6px; }
        .filter-form button { padding: 8px 15px; background: #0077b6; color: white; border: none; border-radius: 6px; cursor: pointer; }
        .summary-boxes { display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px; margin-bottom: 30px; }
        .box { background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .box h3 { margin: 0 0 10px; font-size: 12px; text-transform: uppercase; color: #666; }
        .box .val { font-size: 24px; font-weight: bold; color: #023e8a; }
        .box .val.red { color: #dc3545; }
        .box .val.orange { color: #856404; }
        .table-container { background: white; border-radius: 10px; overflow-x: auto; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { background: #023e8a; color: white; padding: 14px; text-align: left; }
        td { padding: 13px; border-bottom: 1px solid #eee; }
        tr:hover { background: #f8fbff; }
        @media (max-width: 700px) {
            .summary-boxes { grid-template-columns: 1fr 1fr; }
            .header-flex { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<nav>
    <div class="logo">Otirasor Beach and Resort</div>
    <div>
        <a href="/employee/dashboard">Dashboard</a>
        <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        <form id="logout-form" action="/logout" method="POST" style="display: none;">@csrf</form>
    </div>
</nav>

<div class="container">
    <a href="/employee/dashboard" class="back-button">← Back to Dashboard</a>

    <div class="header-flex">
        <h1>My Attendance — {{ $startOfMonth->format('F Y') }}</h1>

        <form method="GET" action="/employee/my-attendance" class="filter-form">
            <select name="month">
                @for ($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                @endfor
            </select>
            <select name="year">
                @for ($y = now()->year - 2; $y <= now()->year + 1; $y++)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
            <button type="submit">Filter</button>
        </form>
    </div>

    <div class="summary-boxes">
        <div class="box">
            <h3>Days Present</h3>
            <div class="val">{{ $summary['days_present'] }}</div>
        </div>
        <div class="box">
            <h3>Worked Hours</h3>
            <div class="val">{{ $summary['worked_hours'] }}h</div>
        </div>
        <div class="box">
            <h3>Late (Minutes)</h3>
            <div class="val {{ $summary['late_minutes'] > 0 ? 'red' : '' }}">{{ $summary['late_minutes'] }}</div>
        </div>
        <div class="box">
            <h3>Overtime (Minutes)</h3>
            <div class="val {{ $summary['overtime_minutes'] > 0 ? 'orange' : '' }}">{{ $summary['overtime_minutes'] }}</div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Late (min)</th>
                    <th>Undertime (min)</th>
                    <th>Overtime (min)</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $r)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($r->date)->format('M d, Y (l)') }}</td>
                        <td>{{ $r->time_in ? \Carbon\Carbon::parse($r->time_in)->format('h:i A') : '—' }}</td>
                        <td>{{ $r->time_out ? \Carbon\Carbon::parse($r->time_out)->format('h:i A') : '—' }}</td>
                        <td style="color: {{ $r->late_minutes > 0 ? '#dc3545' : '#666' }}">{{ $r->late_minutes ?? 0 }}</td>
                        <td style="color: {{ $r->undertime_minutes > 0 ? '#dc3545' : '#666' }}">{{ $r->undertime_minutes ?? 0 }}</td>
                        <td style="color: {{ $r->overtime_minutes > 0 ? '#856404' : '#666' }}">{{ $r->overtime_minutes ?? 0 }}</td>
                        <td style="font-weight: bold; color: {{ strtolower($r->status) === 'present' ? '#198754' : '#dc3545' }}">{{ $r->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 30px; color: #777;">No attendance records found for this month.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

</body>
</html>