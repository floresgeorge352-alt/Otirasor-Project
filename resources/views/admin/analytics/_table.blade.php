<div style="overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="background-color: #f5f8fc; border-bottom: 2px solid #e1e9f0;">
                <th style="padding: 12px; font-weight: bold; color: #023e8a;">Employee Name</th>
                <th style="padding: 12px; font-weight: bold; color: #10b981;">Days Present</th>
                <th style="padding: 12px; font-weight: bold; color: #ef4444;">Days Late</th>
                <th style="padding: 12px; font-weight: bold; color: #6b7280;">Days Absent</th>
                <th style="padding: 12px; font-weight: bold; color: #dc2626;">Late (Mins)</th>
                <th style="padding: 12px; font-weight: bold; color: #2563eb;">OT (Mins)</th>
                <th style="padding: 12px; font-weight: bold; color: #d97706;">UT (Mins)</th>
                <th style="padding: 12px; font-weight: bold; color: #059669;">Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employeeStats as $stat)
                <tr style="border-bottom: 1px solid #edf1f5;">
                    <td style="padding: 12px; font-weight: 600; color: #263746;">{{ $stat['name'] }}</td>
                    <td style="padding: 12px; color: #10b981; font-weight: 600;">{{ $stat['present'] }}</td>
                    <td style="padding: 12px; color: #ef4444; font-weight: 600;">{{ $stat['late_count'] }}</td>
                    <td style="padding: 12px; color: #6b7280; font-weight: 600;">{{ $stat['absent_count'] }}</td>
                    <td style="padding: 12px; color: #dc2626;">{{ $stat['late_minutes'] }}</td>
                    <td style="padding: 12px; color: #2563eb;">{{ $stat['overtime_minutes'] }}</td>
                    <td style="padding: 12px; color: #d97706;">{{ $stat['undertime_minutes'] }}</td>
                    <td style="padding: 12px; color: #059669; font-weight: 600;">{{ $stat['worked_hours'] }} hrs</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding: 20px; text-align: center; color: #7a8793;">No employee records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>