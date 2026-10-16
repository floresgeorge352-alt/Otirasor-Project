<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shift Requests</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            margin: 0 0 8px;
        }

        .subtitle {
            color: #64748b;
            margin: 0;
        }

        .back {
            display: inline-block;
            padding: 10px 15px;
            border-radius: 7px;
            background: #e2e8f0;
            color: #1e293b;
            text-decoration: none;
            font-weight: bold;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            min-width: 650px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        th {
            background: #f8fafc;
            font-size: 13px;
        }

        td {
            font-size: 14px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 12px;
            font-weight: bold;
        }

        .approved {
            background: #dcfce7;
            color: #166534;
        }

        .rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .cancelled {
            background: #e2e8f0;
            color: #334155;
        }

        .empty {
            padding: 35px 15px;
            text-align: center;
            color: #64748b;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>My Shift Requests</h1>
            <p class="subtitle">
                Track the status of your extra-shift requests.
            </p>
        </div>

        <a href="{{ route('employee.dashboard') }}" class="back">
            Back to Dashboard
        </a>
    </div>

    <div class="card">
        @if ($requests->isEmpty())
            <div class="empty">
                <h3>No shift requests yet</h3>
                <p>Your submitted requests will appear here.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Shift Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Submitted</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($requests as $request)
                    @php
                        $statusClass = match ($request->status) {
                            'Approved' => 'approved',
                            'Rejected' => 'rejected',
                            'Cancelled' => 'cancelled',
                            default => '',
                        };
                    @endphp

                    <tr>
                        <td>
                            {{ $request->shift_date?->format('M d, Y') ?? '—' }}
                        </td>

                        <td>{{ $request->start_time ?? '—' }}</td>

                        <td>{{ $request->end_time ?? '—' }}</td>

                        <td>
                            {{ $request->reason ?? 'No reason provided' }}
                        </td>

                        <td>
                            <span class="status {{ $statusClass }}">
                                {{ $request->status }}
                            </span>
                        </td>

                        <td>
                            {{ $request->created_at?->format('M d, Y h:i A') ?? '—' }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
</body>
</html>