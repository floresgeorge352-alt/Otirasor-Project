<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Days Present</th>
            <th>Completed</th>
            <th>Worked Hours</th>
            <th>Late (min)</th>
            <th>Undertime (min)</th>
            <th>Overtime (min)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($summaries as $s)
            <tr>
                <td><strong>{{ $s['employee']->name }}</strong></td>
                <td>{{ $s['days_present'] }}</td>
                <td>{{ $s['days_completed'] }}</td>
                <td class="worked-hours">{{ $s['worked_hours'] }}h</td>
                <td class="{{ $s['late_minutes'] > 0 ? 'red' : 'gray' }}">{{ $s['late_minutes'] }}</td>
                <td class="{{ $s['undertime_minutes'] > 0 ? 'red' : 'gray' }}">{{ $s['undertime_minutes'] }}</td>
                <td class="{{ $s['overtime_minutes'] > 0 ? 'orange' : 'gray' }}">{{ $s['overtime_minutes'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="empty">No employees found.</td>
            </tr>
        @endforelse
    </tbody>
</table>