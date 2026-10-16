<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Employee Dashboard - Otirasor Beach and Resort</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f7f9;
            color: #333;
        }

        .navbar {
            background: #0f4c5c;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-section img {
            width: 45px;
            height: 45px;
            object-fit: contain;
            background: white;
            border-radius: 50%;
        }

        .logo-section h2 {
            font-size: 18px;
        }

        .logout-form button {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 9px 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .logout-form button:hover {
            background: #c0392b;
        }

        .container {
            max-width: 1100px;
            margin: 35px auto;
            padding: 0 20px;
        }

        .welcome {
            background: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        .welcome h1 {
            color: #0f4c5c;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #666;
        }

        .portal-badge {
            display: inline-block;
            margin-top: 12px;
            background: #e8f6f8;
            color: #0f4c5c;
            padding: 7px 13px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .message {
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            min-width: 0;
        }

        .card h3 {
            color: #0f4c5c;
            margin-bottom: 15px;
        }

        .attendance-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            margin-top: 10px;
            background: #fff3cd;
            color: #856404;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
        }

        .attendance-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .attendance-button {
            width: 100%;
            border: none;
            color: white;
            padding: 13px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
            font-weight: bold;
        }

        .time-in-button {
            background: #27ae60;
        }

        .time-in-button:hover {
            background: #219150;
        }

        .time-out-button {
            background: #e67e22;
        }

        .time-out-button:hover {
            background: #cf6d17;
        }

        .info-card {
            margin-top: 20px;
        }

        .info-card p {
            color: #666;
            line-height: 1.6;
        }

        .qr-placeholder {
            margin-top: 25px;
            padding: 25px;
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            text-align: center;
        }

        .qr-title {
            font-size: 18px;
            font-weight: bold;
            color: #0f4c5c;
            margin-bottom: 8px;
        }

        .qr-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 18px;
        }

        #employee-qr {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px auto;
        }

        .employee-qr-name {
            margin-top: 12px;
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        .qr-note {
            margin-top: 8px;
            font-size: 12px;
            color: #888;
        }

        .section-heading {
            color: #0f4c5c;
            margin-bottom: 8px;
        }

        .section-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            color: #444;
            font-size: 14px;
            font-weight: bold;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccd4d8;
            border-radius: 7px;
            font-family: inherit;
            font-size: 15px;
            background: white;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .form-group input:focus,
        .form-group textarea:focus {
            outline: 2px solid #0f4c5c;
            outline-offset: 1px;
        }

        .submit-button {
            background: #0f4c5c;
            color: white;
            border: none;
            border-radius: 7px;
            padding: 13px 20px;
            font-weight: bold;
            font-size: 15px;
            cursor: pointer;
        }

        .submit-button:hover {
            background: #0b3945;
        }

        .form-errors {
            color: #b42318;
            font-size: 13px;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .requests-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        .requests-table th,
        .requests-table td {
            padding: 13px 12px;
            text-align: left;
            border-bottom: 1px solid #e5e9eb;
            font-size: 14px;
            white-space: nowrap;
        }

        .requests-table th {
            background: #f3f7f8;
            color: #0f4c5c;
        }

        .reason-cell {
            white-space: normal !important;
            min-width: 180px;
        }

        .request-status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }

        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-cancelled {
            background: #e2e3e5;
            color: #383d41;
        }

        .status-approved {
            background: #d4edda;
            color: #155724;
        }

        .status-available {
            background: #d4edda;
            color: #155724;
        }

        .status-unavailable {
            background: #f8d7da;
            color: #721c24;
        }

        .offer-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .offer-actions form {
            margin: 0;
        }

        .offer-btn {
            border: none;
            border-radius: 7px;
            padding: 9px 14px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            color: white;
        }

        .offer-btn.accept {
            background: #16a34a;
        }

        .offer-btn.accept:hover {
            background: #15803d;
        }

        .offer-btn.decline {
            background: #dc2626;
        }

        .offer-btn.decline:hover {
            background: #b91c1c;
        }

        .offer-count {
            display: inline-block;
            margin-left: 8px;
            padding: 3px 9px;
            border-radius: 20px;
            background: #dc2626;
            color: white;
            font-size: 12px;
            vertical-align: middle;
        }

        .offer-note {
            color: #666;
            font-size: 13px;
        }

        .empty-state {
            padding: 20px;
            background: #f8f9fa;
            color: #666;
            border-radius: 8px;
            text-align: center;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 15px;
            }

            .cards,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .attendance-actions {
                grid-template-columns: 1fr;
            }

            .logo-section h2 {
                font-size: 15px;
            }

            .container {
                margin-top: 20px;
            }

            .form-group.full-width {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    @php
        $employee = auth()->user();

        $todayAttendance = \App\Models\Attendance::where(
            'user_id',
            $employee->id
        )
        ->whereDate('date', today())
        ->first();

        // Requests submitted by this employee.
        $myExtraShiftRequests = \App\Models\ExtraShiftRequest::where(
            'employee_id',
            $employee->id
        )
        ->where('request_type', 'employee')
        ->latest()
        ->get();

        // Extra-shift offers sent by the admin to this employee.
        $shiftOffers = \App\Models\ExtraShiftRequest::where(
            'employee_id',
            $employee->id
        )
        ->where('request_type', 'admin')
        ->latest()
        ->get();

        $awaitingOfferCount = $shiftOffers
            ->where('status', 'Pending')
            ->where('employee_response', 'Pending')
            ->count();
    @endphp

    <div class="navbar">
        <div class="logo-section">
            <img
                src="{{ asset('images/otirasor-logo.png') }}"
                alt="Otirasor Logo"
            >

            <h2>Otirasor Beach and Resort</h2>
        </div>

        <form
            method="POST"
            action="{{ route('logout') }}"
            class="logout-form"
        >
            @csrf

            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Welcome, {{ $employee->name }}!</h1>

            <p>
                Welcome to the Otirasor Beach and Resort Employee Portal.
            </p>

            <span class="portal-badge">Employee Portal</span>
        </div>

        @if(session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="message error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="message error">
                <strong>Please check the following:</strong>

                <ul style="margin: 10px 0 0 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Dashboard Summary --}}

        <div class="cards">

            <div class="card">
                <h3>Today's Attendance</h3>

                <div class="attendance-value">
                    @if($todayAttendance && $todayAttendance->time_in)
                        Present
                    @else
                        Not yet recorded
                    @endif
                </div>

                @if($todayAttendance && $todayAttendance->time_in)
                    <span class="status"
                          style="background:#d4edda;color:#155724;">
                        Present
                    </span>
                @else
                    <span class="status">Pending</span>
                @endif
            </div>

            <div class="card">
                <h3>Time In</h3>

                <div class="attendance-value">
                    @if($todayAttendance && $todayAttendance->time_in)
                        {{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') }}
                    @else
                        —
                    @endif
                </div>

                <p style="margin-top:8px;color:#777;">
                    @if($todayAttendance && $todayAttendance->time_in)
                        Time In recorded.
                    @else
                        No Time In recorded yet.
                    @endif
                </p>
            </div>

            <div class="card">
                <h3>Time Out</h3>

                <div class="attendance-value">
                    @if($todayAttendance && $todayAttendance->time_out)
                        {{ \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') }}
                    @else
                        —
                    @endif
                </div>

                <p style="margin-top:8px;color:#777;">
                    @if($todayAttendance && $todayAttendance->time_out)
                        Time Out recorded.
                    @else
                        No Time Out recorded yet.
                    @endif
                </p>
            </div>

        </div>

        {{-- Attendance and QR Code --}}

        <div class="card info-card">
            <h3>Attendance</h3>

            <p>
                Record your attendance for today using the buttons below.
            </p>

            <div class="attendance-actions">

                <form
                    method="POST"
                    action="{{ route('employee.attendance.time-in') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="attendance-button time-in-button"
                    >
                        Time In
                    </button>
                </form>

                <form
                    method="POST"
                    action="{{ route('employee.attendance.time-out') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="attendance-button time-out-button"
                    >
                        Time Out
                    </button>
                </form>

            </div>

            <div class="qr-placeholder">
                <div class="qr-title">My QR Code</div>

                <p class="qr-description">
                    This is your personal QR code for attendance.
                </p>

                <div id="employee-qr"></div>

                <div class="employee-qr-name">
                    {{ $employee->name }}
                </div>

                <div class="qr-note">
                    Scan this QR code to open your attendance page.
                </div>
            </div>
        </div>

        {{-- Shift Offers from Admin --}}

        <div class="card info-card" id="shift-offers">
            <h3 class="section-heading">
                Shift Offers from Admin
                @if($awaitingOfferCount > 0)
                    <span class="offer-count">{{ $awaitingOfferCount }} new</span>
                @endif
            </h3>

            <p class="section-description">
                The admin may offer you an extra shift. Choose Accept if you
                are available or Decline if you are not. The shift becomes
                final once the admin confirms it.
            </p>

            @if($shiftOffers->isEmpty())

                <div class="empty-state">
                    You have no shift offers from the admin right now.
                </div>

            @else

                <div class="table-wrapper">
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Shift Date</th>
                                <th>Schedule</th>
                                <th>Reason</th>
                                <th>Your Response</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($shiftOffers as $offer)

                                @php
                                    $responseClass = match ($offer->employee_response) {
                                        'Available' => 'status-available',
                                        'Unavailable' => 'status-unavailable',
                                        default => 'status-pending',
                                    };

                                    $offerStatusClass = match ($offer->status) {
                                        'Confirmed', 'Approved' => 'status-confirmed',
                                        'Rejected' => 'status-rejected',
                                        'Cancelled' => 'status-cancelled',
                                        default => 'status-pending',
                                    };

                                    $canRespond = $offer->status === 'Pending'
                                        && $offer->employee_response === 'Pending';
                                @endphp

                                <tr>
                                    <td>
                                        {{ $offer->shift_date
                                            ? $offer->shift_date->format('M d, Y')
                                            : '—' }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($offer->start_time)->format('h:i A') }}
                                        –
                                        {{ \Carbon\Carbon::parse($offer->end_time)->format('h:i A') }}
                                    </td>

                                    <td class="reason-cell">
                                        {{ $offer->reason ?: '—' }}
                                    </td>

                                    <td>
                                        <span class="request-status {{ $responseClass }}">
                                            {{ $offer->employee_response === 'Pending' ? 'Awaiting your response' : $offer->employee_response }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="request-status {{ $offerStatusClass }}">
                                            {{ $offer->status }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($canRespond)
                                            <div class="offer-actions">
                                                <form
                                                    method="POST"
                                                    action="{{ route('employee.extra-shift-requests.respond', $offer) }}"
                                                    onsubmit="return confirm('Accept this extra shift? You are telling the admin you are available.');"
                                                >
                                                    @csrf
                                                    <input type="hidden" name="response" value="Available">
                                                    <button type="submit" class="offer-btn accept">
                                                        ✓ Accept
                                                    </button>
                                                </form>

                                                <form
                                                    method="POST"
                                                    action="{{ route('employee.extra-shift-requests.respond', $offer) }}"
                                                    onsubmit="return confirm('Decline this extra shift?');"
                                                >
                                                    @csrf
                                                    <input type="hidden" name="response" value="Unavailable">
                                                    <button type="submit" class="offer-btn decline">
                                                        ✕ Decline
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($offer->status === 'Confirmed')
                                            <span class="offer-note">Shift confirmed by admin</span>
                                        @elseif($offer->status === 'Rejected')
                                            <span class="offer-note">Offer was rejected by admin</span>
                                        @elseif($offer->status === 'Cancelled')
                                            <span class="offer-note">Offer cancelled</span>
                                        @elseif($offer->employee_response === 'Available')
                                            <span class="offer-note">Waiting for admin confirmation</span>
                                        @elseif($offer->employee_response === 'Unavailable')
                                            <span class="offer-note">You declined this offer</span>
                                        @else
                                            <span class="offer-note">No action available</span>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>

        {{-- Employee Extra Shift Request Form --}}

        <div class="card info-card" id="extra-shift">
            <h3 class="section-heading">Request an Extra Shift</h3>

            <p class="section-description">
                Need to work an additional shift? Submit your preferred
                date and time. Your request will remain Pending until
                the admin approves or rejects it.
            </p>

            <form
                method="POST"
                action="{{ route('employee.extra-shift-requests.store') }}"
            >
                @csrf

                <div class="form-grid">

                    <div class="form-group">
                        <label for="shift_date">Requested Date</label>

                        <input
                            type="date"
                            id="shift_date"
                            name="shift_date"
                            min="{{ today()->format('Y-m-d') }}"
                            value="{{ old('shift_date') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="start_time">Start Time</label>

                        <input
                            type="time"
                            id="start_time"
                            name="start_time"
                            value="{{ old('start_time') }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="end_time">End Time</label>

                        <input
                            type="time"
                            id="end_time"
                            name="end_time"
                            value="{{ old('end_time') }}"
                            required
                        >
                    </div>

                    <div class="form-group full-width">
                        <label for="reason">Reason for Extra Shift</label>

                        <textarea
                            id="reason"
                            name="reason"
                            maxlength="1000"
                            placeholder="Explain why you are requesting an extra shift."
                            required
                        >{{ old('reason') }}</textarea>
                    </div>

                    <div class="form-group full-width">
                        <button
                            type="submit"
                            class="submit-button"
                        >
                            Submit Extra Shift Request
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- Employee's Own Requests --}}

        <div class="card info-card" id="my-requests">
            <h3 class="section-heading">My Extra Shift Requests</h3>

            <p class="section-description">
                View the requests you have submitted and check their
                current status.
            </p>

            @if($myExtraShiftRequests->isEmpty())

                <div class="empty-state">
                    You have not submitted any extra-shift requests yet.
                </div>

            @else

                <div class="table-wrapper">
                    <table class="requests-table">
                        <thead>
                            <tr>
                                <th>Requested Date</th>
                                <th>Schedule</th>
                                <th>Reason</th>
                                <th>Status</th>
                                <th>Submitted</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($myExtraShiftRequests as $shiftRequest)

                                <tr>
                                    <td>
                                        {{ $shiftRequest->shift_date
                                            ? \Carbon\Carbon::parse($shiftRequest->shift_date)->format('M d, Y')
                                            : '—' }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($shiftRequest->start_time)->format('h:i A') }}
                                        –
                                        {{ \Carbon\Carbon::parse($shiftRequest->end_time)->format('h:i A') }}
                                    </td>

                                    <td class="reason-cell">
                                        {{ $shiftRequest->reason ?: '—' }}
                                    </td>

                                    <td>
                                        @php
                                            $statusClass = match ($shiftRequest->status) {
                                                'Approved' => 'status-approved',
                                                'Confirmed' => 'status-confirmed',
                                                'Rejected' => 'status-rejected',
                                                'Cancelled' => 'status-cancelled',
                                                default => 'status-pending',
                                            };
                                        @endphp

                                        <span class="request-status {{ $statusClass }}">
                                            {{ $shiftRequest->status }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $shiftRequest->created_at
                                            ? $shiftRequest->created_at->format('M d, Y')
                                            : '—' }}
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
        </div>

    </div>

    {{-- QR Code Library --}}

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>

    {{-- Generate Employee QR Code --}}

    <script>
        const employeeId = {{ (int) $employee->id }};

        const attendanceUrl =
            "{{ url('/employee/attendance/scan') }}/" + employeeId;

        if (typeof QRCode !== 'undefined') {
            new QRCode(
                document.getElementById("employee-qr"),
                {
                    text: attendanceUrl,
                    width: 180,
                    height: 180
                }
            );
        } else {
            document.getElementById("employee-qr").textContent =
                "QR code could not load. Please check your internet connection.";
        }
    </script>

</body>
</html>