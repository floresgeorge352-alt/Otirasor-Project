<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Attendance - Otirasor Beach and Resort</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #333;
        }

        nav {
            background: #023e8a;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            font-size: 21px;
            font-weight: bold;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1200px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #023e8a;
            text-decoration: none;
            font-weight: bold;
        }

        .back-button:hover {
            text-decoration: underline;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            color: #023e8a;
            margin-bottom: 5px;
        }

        .header p {
            color: #666;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        .filter-box label {
            font-weight: bold;
            margin-right: 10px;
        }

        .filter-box input {
            padding: 9px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .filter-box button {
            padding: 9px 16px;
            margin-left: 8px;
            border: none;
            border-radius: 6px;
            background: #0077b6;
            color: white;
            cursor: pointer;
        }

        .filter-box button:hover {
            background: #005f8f;
        }

        .filter-box a {
            margin-left: 8px;
            text-decoration: none;
            color: #023e8a;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.07);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
        }

        th {
            background: #023e8a;
            color: white;
            padding: 14px;
            text-align: left;
            white-space: nowrap;
        }

        td {
            padding: 13px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }

        tr:hover {
            background: #f8fbff;
        }

        .status {
            font-weight: bold;
        }

        .present {
            color: #198754;
        }

        .absent {
            color: #dc3545;
        }

        .duration {
            white-space: nowrap;
        }

        .overtime-status {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #856404;
        }

        .overtime-status.approved {
            color: #198754;
        }

        .overtime-status.rejected {
            color: #dc3545;
        }

        .overtime-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .overtime-actions form {
            margin: 0;
        }

        .overtime-actions button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            color: white;
            font-size: 12px;
            cursor: pointer;
        }

        .approve-button {
            background: #198754;
        }

        .approve-button:hover {
            background: #146c43;
        }

        .reject-button {
            background: #dc3545;
        }

        .reject-button:hover {
            background: #b02a37;
        }

        .message {
            padding: 12px 16px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .success-message {
            background: #d1e7dd;
            color: #0f5132;
        }

        .error-message {
            background: #f8d7da;
            color: #842029;
        }

        .empty {
            text-align: center;
            padding: 35px;
            color: #777;
        }

        @media (max-width: 700px) {
            nav {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            nav a {
                margin: 0 8px;
            }

            .container {
                margin: 20px auto;
            }
        }
    </style>
</head>

<body>

<nav>
    <div class="logo">
        Otirasor Beach and Resort
    </div>

    <div>
        <a href="/admin/management">Management</a>
        <a href="/admin/employees">Employees</a>
    </div>
</nav>

<div class="container">

    <a href="/admin/management" class="back-button">
        ← Back to Management
    </a>

    <div class="header">
        <h1>Employee Attendance</h1>
        <p>
            View employee Time In, Time Out, late, undertime,
            and overtime records.
        </p>
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

    <div class="filter-box">
        <form method="GET" action="{{ url('/admin/attendance') }}">

            <label for="date">Select Date:</label>

            <input
                type="date"
                id="date"
                name="date"
                value="{{ request('date') }}"
            >

            <button type="submit">Filter</button>

            <a href="{{ url('/admin/attendance') }}">Clear</a>

        </form>
    </div>

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Late</th>
                    <th>Undertime</th>
                    <th>Overtime</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                @php
                    $formatDuration = function ($minutes) {
                        $minutes = (int) $minutes;

                        if ($minutes <= 0) {
                            return '—';
                        }

                        $hours = intdiv($minutes, 60);
                        $remainingMinutes = $minutes % 60;
                        $parts = [];

                        if ($hours > 0) {
                            $parts[] = $hours . ' ' .
                                ($hours === 1 ? 'hour' : 'hours');
                        }

                        if ($remainingMinutes > 0) {
                            $parts[] = $remainingMinutes . ' ' .
                                ($remainingMinutes === 1
                                    ? 'minute'
                                    : 'minutes');
                        }

                        return implode(' ', $parts);
                    };
                @endphp

                @forelse ($attendances as $attendance)

                    <tr>
                        <td>
                            {{ $attendance->user->name ?? 'Unknown Employee' }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                        </td>

                        <td>
                            @if ($attendance->time_in)
                                {{ \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') }}
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @if ($attendance->time_out)
                                {{ \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="duration">
                            @if (($attendance->late_minutes ?? 0) > 0)
                                {{ $formatDuration($attendance->late_minutes) }} late
                            @else
                                —
                            @endif
                        </td>

                        <td class="duration">
                            @if (($attendance->undertime_minutes ?? 0) > 0)
                                {{ $formatDuration($attendance->undertime_minutes) }} undertime
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            @if (($attendance->overtime_minutes ?? 0) > 0)

                                <div class="duration">
                                    {{ $formatDuration($attendance->overtime_minutes) }}
                                </div>

                                @php
                                    $overtimeStatus = $attendance->overtime_status ?? 'Not Requested';

                                    $overtimeStatusClass = match ($overtimeStatus) {
                                        'Approved' => 'approved',
                                        'Rejected' => 'rejected',
                                        default => '',
                                    };
                                @endphp

                                <small class="overtime-status {{ $overtimeStatusClass }}">
                                    {{ $overtimeStatus }}
                                </small>

                                @if ($overtimeStatus === 'Pending Approval')
                                    <div class="overtime-actions">

                                        <form
                                            method="POST"
                                            action="{{ route('admin.attendance.approve-overtime', $attendance->id) }}"
                                            onsubmit="return confirm('Approve this overtime record?')"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="approve-button"
                                            >
                                                Approve
                                            </button>
                                        </form>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.attendance.reject-overtime', $attendance->id) }}"
                                            onsubmit="return confirm('Reject this overtime record?')"
                                        >
                                            @csrf

                                            <button
                                                type="submit"
                                                class="reject-button"
                                            >
                                                Reject
                                            </button>
                                        </form>

                                    </div>
                                @endif

                            @else
                                —
                            @endif
                        </td>

                        <td class="status {{ strtolower($attendance->status ?? '') === 'present' ? 'present' : 'absent' }}">
                            {{ $attendance->status ?? 'Unknown' }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="empty">
                            No attendance records found.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

</div>

</body>
</html>