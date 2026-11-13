<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Summary - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #023e8a; color: white; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #023e8a; }
        .header p { margin: 5px 0; color: #666; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #888; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Otirasor Beach and Resort</h1>
        <p>Employee Attendance Summary</p>
        <p><strong>{{ $startOfMonth->format('F Y') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Days Present</th>
                <th>Days Completed</th>
                <th>Worked Hours</th>
                <th>Late (Mins)</th>
                <th>Undertime (Mins)</th>
                <th>Overtime (Mins)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($summaries as $summary)
                <tr>
                    <td>{{ $summary['employee']->name }}</td>
                    <td>{{ $summary['days_present'] }}</td>
                    <td>{{ $summary['days_completed'] }}</td>
                    <td>{{ $summary['worked_hours'] }} hrs</td>
                    <td>{{ $summary['late_minutes'] }}</td>
                    <td>{{ $summary['undertime_minutes'] }}</td>
                    <td>{{ $summary['overtime_minutes'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on: {{ now()->format('M d, Y h:i A') }}
    </div>

</body>
</html>