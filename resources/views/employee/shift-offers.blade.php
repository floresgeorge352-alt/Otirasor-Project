<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Offers from Admin</title>

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
            margin: 0;
            color: #64748b;
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

        .message {
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 15px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        table {
            width: 100%;
            min-width: 800px;
            border-collapse: collapse;
        }

        th, td {
            padding: 13px 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
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

        .available {
            background: #dcfce7;
            color: #166534;
        }

        .unavailable {
            background: #fee2e2;
            color: #991b1b;
        }

        .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 6px;
            padding: 9px 12px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        .yes {
            background: #16a34a;
            color: white;
        }

        .no {
            background: #dc2626;
            color: white;
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
            <h1>Shift Offers from Admin</h1>
            <p class="subtitle">
                Review extra shifts offered to you and submit your response.
            </p>
        </div>

        <a href="{{ route('employee.dashboard') }}" class="back">
            Back to Dashboard
        </a>
    </div>

    @if (session('success'))
        <div class="message success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="message error">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="message error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="card">
        @if ($requests->isEmpty())
            <div class="empty">
                <h3>No shift offers yet</h3>
                <p>New offers from your admin will appear here.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Shift Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Reason</th>
                        <th>Your Response</th>
                        <th>Offer Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($requests as $request)
                    @php
                        $responseClass = match ($request->employee_response) {
                            'Available' => 'available',
                            'Unavailable' => 'unavailable',
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
                            <span class="status {{ $responseClass }}">
                                {{ $request->employee_response ?? 'Pending' }}
                            </span>
                        </td>

                        <td>
                            <span class="status">
                                {{ $request->status }}
                            </span>
                        </td>

                        <td>
                            @if (
                                $request->status === 'Pending'
                                && $request->employee_response === 'Pending'
                            )
                                <div class="actions">
                                    <form
                                        method="POST"
                                        action="{{ route('employee.extra-shift-requests.respond', $request) }}"
                                        onsubmit="return confirm('Are you available for this shift?')"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="response"
                                            value="Available"
                                        >

                                        <button type="submit" class="btn yes">
                                            Available
                                        </button>
                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route('employee.extra-shift-requests.respond', $request) }}"
                                        onsubmit="return confirm('Are you unavailable for this shift?')"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="response"
                                            value="Unavailable"
                                        >

                                        <button type="submit" class="btn no">
                                            Unavailable
                                        </button>
                                    </form>
                                </div>
                            @elseif ($request->status === 'Confirmed')
                                <span>Shift confirmed</span>
                            @elseif ($request->status === 'Rejected')
                                <span>Offer rejected</span>
                            @elseif ($request->employee_response === 'Available')
                                <span>Waiting for admin confirmation</span>
                            @elseif ($request->employee_response === 'Unavailable')
                                <span>You declined this offer</span>
                            @else
                                <span>No action available</span>
                            @endif
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