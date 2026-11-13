<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Schedule - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f6f8; color: #1f2937; padding: 30px; }
        .container { max-width: 1400px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .header h1 { color: #023e8a; font-size: 24px; }
        .back-btn { background: #6c757d; color: white; text-decoration: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; font-size: 14px; }
        .back-btn:hover { background: #5a6268; }

        .controls { display: flex; gap: 10px; margin-bottom: 20px; align-items: center; }
        .btn-nav { background: #0077b6; color: white; text-decoration: none; padding: 10px 15px; border-radius: 8px; font-weight: 600; }
        .btn-nav:hover { background: #005f8f; }
        .btn-today { background: #10b981; color: white; text-decoration: none; padding: 10px 15px; border-radius: 8px; font-weight: 600; }
        .btn-today:hover { background: #059669; }

        .table-container { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border: 1px solid #e5e7eb; overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th, td { padding: 15px; border: 1px solid #e5e7eb; font-size: 13px; vertical-align: top; }
        th { background: #f8fafc; color: #023e8a; font-weight: 700; text-align: center; }
        td { background: white; }
        .employee-name { font-weight: 600; color: #333; background: #fafbfc; }

        .shift-card { background: #e0f2fe; color: #0369a1; padding: 8px; border-radius: 6px; font-size: 12px; margin-bottom: 5px; text-align: center; }
        .rest-day { color: #9ca3af; font-style: italic; text-align: center; font-size: 12px; }
        .today-col { background: #f0fdf4; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📅 Weekly Schedule</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">← Back to Dashboard</a>
        </div>

        <div class="controls">
            <a href="{{ route('admin.weekly-schedule', ['week' => $startOfWeek->copy()->subWeek()->toDateString()]) }}" class="btn-nav">← Previous Week</a>
            <a href="{{ route('admin.weekly-schedule') }}" class="btn-today">This Week</a>
            <a href="{{ route('admin.weekly-schedule', ['week' => $startOfWeek->copy()->addWeek()->toDateString()]) }}" class="btn-nav">Next Week →</a>
            <span style="margin-left: auto; font-weight: bold; color: #555;">
                {{ $startOfWeek->format('M d, Y') }} - {{ $endOfWeek->format('M d, Y') }}
            </span>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 180px;">Employee</th>
                        @foreach(range(0, 6) as $day)
                            @php $currentDate = $startOfWeek->copy()->addDays($day); @endphp
                            <th class="{{ $currentDate->isToday() ? 'today-col' : '' }}">
                                <div>{{ $currentDate->format('l') }}</div>
                                <div style="font-size: 11px; color: #888;">{{ $currentDate->format('M d') }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td class="employee-name">{{ $employee->name }}</td>
                            @foreach(range(0, 6) as $day)
                                @php $currentDate = $startOfWeek->copy()->addDays($day); @endphp
                                <td class="{{ $currentDate->isToday() ? 'today-col' : '' }}">
                                    @if(in_array($currentDate->format('l'), $employee->work_days ?? []))
                                        <div class="shift-card">
                                            {{ \Carbon\Carbon::parse($employee->regular_time_in)->format('g:i A') }}<br>-<br>
                                            {{ \Carbon\Carbon::parse($employee->regular_time_out)->format('g:i A') }}
                                        </div>
                                    @else
                                        <div class="rest-day">Rest Day</div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px;">No active employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>