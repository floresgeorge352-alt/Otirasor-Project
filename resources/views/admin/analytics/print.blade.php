<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Attendance Report - {{ $selectedYear }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            margin: 20px; 
            color: #000;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        td {
            text-align: center;
        }
        td:first-child {
            text-align: left;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        @media print {
            body { margin: 0; }
            @page { size: A4 landscape; margin: 15mm; }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Otirasor Beach and Resort</h1>
        <p>Employee Attendance Summary Report</p>
        <p><strong>Year: {{ $selectedYear }}</strong></p>
        @if($search)
            <p>Filtered by: "{{ $search }}"</p>
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>Employee Name</th>
                <th>Days Present</th>
                <th>Days Late</th>
                <th>Days Absent</th>
                <th>Late (Mins)</th>
                <th>OT (Mins)</th>
                <th>UT (Mins)</th>
                <th>Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employeeStats as $stat)
                <tr>
                    <td>{{ $stat['name'] }}</td>
                    <td>{{ $stat['present'] }}</td>
                    <td>{{ $stat['late_count'] }}</td>
                    <td>{{ $stat['absent_count'] }}</td>
                    <td>{{ $stat['late_minutes'] }}</td>
                    <td>{{ $stat['overtime_minutes'] }}</td>
                    <td>{{ $stat['undertime_minutes'] }}</td>
                    <td>{{ $stat['worked_hours'] }} hrs</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">No attendance records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generated on: {{ now()->format('M d, Y h:i A') }}
    </div>

    <!-- Auto-open print dialog -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>