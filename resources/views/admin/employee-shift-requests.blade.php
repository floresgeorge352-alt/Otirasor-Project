<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Shift Requests</title>

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
            max-width: 1200px;
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

        .back, .btn {
            display: inline-block;
            border: none;
            border-radius: 7px;
            padding: 10px 15px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .back {
            background: #e2e8f0;
            color: #1e293b;
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
            border-collapse: collapse;
            min-width: 850px;
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
            padding: 5px 9px;
            border-radius: 20px;
            background: #fef3c7;
            color: #92400e;
            font-size: 12px;
            font-weight: bold;
        }

        .actions {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
        }

        .approve {
            background: #16a34a;
            color: white;
        }

        .reject {
            background: #dc2626;
            color: white;
        }

        .empty {
            padding: 30px;
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
            <h1>Employee Shift Requests</h1>
            <p class="subtitle">
                Review requests submitted by employees.
            </p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="back">
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
                <h3>No employee requests yet</h3>
                <p>Employee-submitted shift requests will appear here.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Shift Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>
                            {{ $request->employee->name ?? 'Unknown employee' }}
                        </td>

                        <td>
                            {{ $request->shift_date?->format('M d, Y') ?? '—' }}
                        </td>

                        <td>
                            {{ $request->start_time ?? '—' }}
                        </td>

                        <td>
                            {{ $request->end_time ?? '—' }}
                        </td>

                        <td>
                            {{ $request->reason ?? 'No reason provided' }}
                        </td>

                        <td>
                            <span class="status">
                                {{ $request->status }}
                            </span>
                        </td>

                        <td>
                            @if ($request->status === 'Pending')
                                <div class="actions">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.extra-shift-requests.confirm', $request) }}"
                                        onsubmit="return confirm('Approve this employee request?')"
                                    >
                                        @csrf

                                        <button type="submit" class="btn approve">
                                            Approve
                                        </button>
                                    </form>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.extra-shift-requests.reject', $request) }}"
                                        onsubmit="return confirm('Reject this employee request?')"
                                    >
                                        @csrf

                                        <button type="submit" class="btn reject">
                                            Reject
                                        </button>
                                    </form>
                                </div>
                            @else
                                No actions available
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