<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard - Otirasor Beach and Resort</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;800&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #f4f7f9; color: #333; }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; font-weight: 800; }

        .navbar { background: #0f4c5c; color: white; padding: 15px 6%; display: flex; justify-content: space-between; align-items: center; gap: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.15); position: sticky; top: 0; z-index: 100; }
        .logo-section { display: flex; align-items: center; gap: 12px; }
        .logo-section img { width: 45px; height: 45px; object-fit: contain; background: white; border-radius: 50%; padding: 2px; }
        .logo-section h2 { font-size: 18px; margin: 0; color: white; }
        
        .nav-actions { display: flex; align-items: center; gap: 20px; }
        .notification-link { position: relative; color: white; text-decoration: none; font-size: 14px; font-weight: 500; display: inline-flex; align-items: center; transition: 0.3s; }
        .notification-link:hover { color: #dff8ff; }
        .notification-badge { position: absolute; top: -8px; right: -12px; background: #e63946; color: white; border-radius: 50%; padding: 2px 6px; font-size: 10px; font-weight: bold; }

        .logout-form button { background: #e74c3c; color: white; border: none; padding: 9px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; transition: 0.3s; font-family: 'Poppins', sans-serif; }
        .logout-form button:hover { background: #c0392b; transform: translateY(-2px); }

        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }

        .welcome { background: white; padding: 35px; border-radius: 16px; margin-bottom: 30px; box-shadow: 0 8px 25px rgba(0,0,0,0.05); border-left: 6px solid #0f4c5c; }
        .welcome h1 { color: #0f4c5c; margin-bottom: 8px; font-size: 28px; }
        .welcome p { color: #666; font-size: 15px; font-weight: 300; }
        .portal-badge { display: inline-block; margin-top: 15px; background: #e8f6f8; color: #0f4c5c; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 700; letter-spacing: 1px; }

        /* NEW BUTTON STYLE */
        .btn-my-attendance {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
            background: #0f4c5c;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-family: 'Montserrat', sans-serif;
            transition: 0.3s;
            box-shadow: 0 4px 10px rgba(15, 76, 92, 0.2);
        }
        .btn-my-attendance:hover {
            background: #1a7287;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(15, 76, 92, 0.3);
        }

        .message { padding: 16px 20px; border-radius: 10px; margin-bottom: 25px; font-weight: 600; font-size: 14px; }
        .success { background: #ecfdf3; color: #166534; border: 1px solid #bbf7d0; }
        .error { background: #fff1f2; color: #991b1b; border: 1px solid #fecaca; }

        .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 25px; }
        .card { background: white; padding: 25px; border-radius: 16px; box-shadow: 0 8px 25px rgba(0,0,0,0.05); border: 1px solid #eef2f5; }
        .card h3 { color: #0f4c5c; margin-bottom: 15px; font-size: 16px; }
        .attendance-value { font-size: 24px; font-weight: 800; color: #1f2937; }
        .status { display: inline-block; margin-top: 12px; background: #fff4d8; color: #a36a00; padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 700; }

        .attendance-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top: 20px; }
        .attendance-button { width: 100%; border: none; color: white; padding: 15px; border-radius: 10px; cursor: pointer; font-size: 15px; font-weight: 700; font-family: 'Montserrat', sans-serif; transition: 0.3s; }
        .time-in-button { background: linear-gradient(135deg, #10b981, #059669); box-shadow: 0 4px 15px rgba(16, 185, 129, 0.25); }
        .time-in-button:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.35); }
        .time-out-button { background: linear-gradient(135deg, #f59e0b, #d97706); box-shadow: 0 4px 15px rgba(245, 158, 11, 0.25); }
        .time-out-button:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(245, 158, 11, 0.35); }

        .info-card { margin-bottom: 25px; }
        .info-card > p { color: #666; line-height: 1.6; margin-bottom: 20px; font-weight: 300; }
        
        .qr-placeholder { margin-top: 25px; padding: 30px; background: #f8fcfd; border: 1px dashed #bce0e8; border-radius: 16px; text-align: center; }
        .qr-title { font-size: 18px; font-weight: 800; color: #0f4c5c; margin-bottom: 8px; font-family: 'Montserrat', sans-serif; }
        .qr-description { font-size: 14px; color: #666; margin-bottom: 20px; font-weight: 300; }
        #employee-qr { display: flex; justify-content: center; align-items: center; margin: 15px auto; padding: 10px; background: white; border-radius: 12px; width: fit-content; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        .employee-qr-name { margin-top: 15px; font-size: 16px; font-weight: bold; color: #0f4c5c; }
        .qr-note { margin-top: 8px; font-size: 12px; color: #888; font-weight: 300; }

        .section-heading { color: #0f4c5c; margin-bottom: 10px; font-size: 20px; }
        .table-wrapper { width: 100%; overflow-x: auto; border-radius: 12px; border: 1px solid #eef2f5; }
        .requests-table { width: 100%; border-collapse: collapse; }
        .requests-table th, .requests-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eef2f5; font-size: 14px; white-space: nowrap; }
        .requests-table th { background: #f8fcfd; color: #0f4c5c; font-weight: 700; font-family: 'Montserrat', sans-serif; }
        .requests-table tr:last-child td { border-bottom: none; }
        .reason-cell { white-space: normal !important; min-width: 180px; }
        
        .request-status { display: inline-block; padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; }
        .status-pending { background: #fff4d8; color: #a36a00; }
        .status-confirmed, .status-approved, .status-available { background: #e6f7ef; color: #147a4b; }
        .status-rejected, .status-unavailable { background: #ffe8ec; color: #b52d43; }
        .status-cancelled { background: #e5e7eb; color: #4b5563; }

        .offer-actions { display: flex; gap: 8px; }
        .offer-btn { border: none; border-radius: 6px; padding: 8px 14px; font-size: 12px; font-weight: bold; cursor: pointer; color: white; transition: 0.2s; }
        .offer-btn.accept { background: #10b981; }
        .offer-btn.accept:hover { background: #059669; }
        .offer-btn.decline { background: #ef4444; }
        .offer-btn.decline:hover { background: #dc2626; }
        
        .offer-count { display: inline-block; margin-left: 8px; padding: 3px 10px; border-radius: 20px; background: #ef4444; color: white; font-size: 12px; vertical-align: middle; }
        .offer-note { color: #6b7280; font-size: 13px; font-style: italic; }
        .empty-state { padding: 25px; background: #f8fcfd; color: #6b7280; border-radius: 12px; text-align: center; border: 1px dashed #d1d5db; }

        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { color: #374151; font-size: 14px; font-weight: 600; }
        .form-group input, .form-group textarea { width: 100%; padding: 14px; border: 1px solid #d1d5db; border-radius: 10px; font-family: 'Poppins', sans-serif; font-size: 14px; background: #f9fafb; outline: none; transition: 0.3s; }
        .form-group input:focus, .form-group textarea:focus { border-color: #0f4c5c; background: white; box-shadow: 0 0 0 3px rgba(15, 76, 92, 0.1); }
        .form-group textarea { min-height: 120px; resize: vertical; }
        .submit-button { background: linear-gradient(135deg, #0f4c5c, #1a7287); color: white; border: none; border-radius: 10px; padding: 15px; font-weight: 700; font-size: 15px; font-family: 'Montserrat', sans-serif; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(15, 76, 92, 0.25); }
        .submit-button:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(15, 76, 92, 0.35); }

        @media (max-width: 768px) {
            .navbar { padding: 15px 20px; flex-direction: column; gap: 15px; }
            .nav-actions { width: 100%; justify-content: center; }
            .cards, .form-grid { grid-template-columns: 1fr; }
            .attendance-actions { grid-template-columns: 1fr; }
            .logo-section h2 { font-size: 16px; }
            .container { margin-top: 20px; }
            .form-group.full-width { grid-column: auto; }
            .welcome h1 { font-size: 24px; }
        }
    </style>
</head>

<body>

    @php
        $employee = auth()->user();
        $todayAttendance = \App\Models\Attendance::where('user_id', $employee->id)->whereDate('date', today())->first();
        $myExtraShiftRequests = \App\Models\ExtraShiftRequest::where('employee_id', $employee->id)->where('request_type', 'employee')->latest()->get();
        $shiftOffers = \App\Models\ExtraShiftRequest::where('employee_id', $employee->id)->where('request_type', 'admin')->latest()->get();
        $awaitingOfferCount = $shiftOffers->where('status', 'Pending')->where('employee_response', 'Pending')->count();
    @endphp

    <div class="navbar">
        <div class="logo-section">
            <img src="{{ asset('images/otirasor-logo.png') }}" alt="Otirasor Logo">
            <h2>Otirasor Beach and Resort</h2>
        </div>

        <div class="nav-actions">
            <a href="{{ route('employee.notifications') }}" class="notification-link">
                🔔 Notifications
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="notification-badge">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </a>

            <form method="POST" action="{{ route('logout') }}" class="logout-form" style="margin: 0;">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">

        <div class="welcome">
            <h1>Welcome, {{ $employee->name }}!</h1>
            <p>Welcome to the Otirasor Beach and Resort Employee Portal.</p>
            <span class="portal-badge">EMPLOYEE PORTAL</span>
            
            {{-- BAGONG BUTTON PARA SA MY ATTENDANCE --}}
            <div>
                <a href="{{ route('employee.my-attendance') }}" class="btn-my-attendance">
                    📅 View My Attendance History
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="message success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="message error">{{ session('error') }}</div>
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

        <div class="cards">
            <div class="card">
                <h3>Today's Attendance</h3>
                <div class="attendance-value">
                    @if($todayAttendance && $todayAttendance->time_in) Present @else Not yet recorded @endif
                </div>
                @if($todayAttendance && $todayAttendance->time_in)
                    <span class="status" style="background:#e6f7ef;color:#147a4b;">Present</span>
                @else
                    <span class="status">Pending</span>
                @endif
            </div>
            <div class="card">
                <h3>Time In</h3>
                <div class="attendance-value">
                    @if($todayAttendance && $todayAttendance->time_in)
                        {{ \Carbon\Carbon::parse($todayAttendance->time_in)->format('h:i A') }}
                    @else — @endif
                </div>
                <p style="margin-top:8px;color:#6b7280;font-size:14px;">
                    @if($todayAttendance && $todayAttendance->time_in) Time In recorded. @else No Time In recorded yet. @endif
                </p>
            </div>
            <div class="card">
                <h3>Time Out</h3>
                <div class="attendance-value">
                    @if($todayAttendance && $todayAttendance->time_out)
                        {{ \Carbon\Carbon::parse($todayAttendance->time_out)->format('h:i A') }}
                    @else — @endif
                </div>
                <p style="margin-top:8px;color:#6b7280;font-size:14px;">
                    @if($todayAttendance && $todayAttendance->time_out) Time Out recorded. @else No Time Out recorded yet. @endif
                </p>
            </div>
        </div>

        <div class="card info-card">
            <h3 class="section-heading">Attendance</h3>
            <p>Record your attendance for today using the buttons below.</p>
            
            <div class="attendance-actions">
                <form method="POST" action="{{ route('employee.attendance.time-in') }}">
                    @csrf
                    <button type="submit" class="attendance-button time-in-button">Time In</button>
                </form>
                <form method="POST" action="{{ route('employee.attendance.time-out') }}">
                    @csrf
                    <button type="submit" class="attendance-button time-out-button">Time Out</button>
                </form>
            </div>

            <div class="qr-placeholder">
                <div class="qr-title">My QR Code</div>
                <p class="qr-description">This is your personal QR code for attendance.</p>
                <div id="employee-qr"></div>
                <div class="employee-qr-name">{{ $employee->name }}</div>
                <div class="qr-note">Scan this QR code to open your attendance page.</div>
            </div>
        </div>

        <div class="card info-card" id="shift-offers">
            <h3 class="section-heading">
                Shift Offers from Admin
                @if($awaitingOfferCount > 0)
                    <span class="offer-count">{{ $awaitingOfferCount }} new</span>
                @endif
            </h3>
            <p class="section-description">The admin may offer you an extra shift. Choose Accept if you are available or Decline if you are not.</p>

            @if($shiftOffers->isEmpty())
                <div class="empty-state">You have no shift offers from the admin right now.</div>
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
                                    $canRespond = $offer->status === 'Pending' && $offer->employee_response === 'Pending';
                                @endphp
                                <tr>
                                    <td>{{ $offer->shift_date ? $offer->shift_date->format('M d, Y') : '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($offer->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($offer->end_time)->format('h:i A') }}</td>
                                    <td class="reason-cell">{{ $offer->reason ?: '—' }}</td>
                                    <td><span class="request-status {{ $responseClass }}">{{ $offer->employee_response === 'Pending' ? 'Awaiting response' : $offer->employee_response }}</span></td>
                                    <td><span class="request-status {{ $offerStatusClass }}">{{ $offer->status }}</span></td>
                                    <td>
                                        @if($canRespond)
                                            <div class="offer-actions">
                                                <form method="POST" action="{{ route('employee.extra-shift-requests.respond', $offer) }}" onsubmit="return confirm('Accept this extra shift?');">
                                                    @csrf
                                                    <input type="hidden" name="response" value="Available">
                                                    <button type="submit" class="offer-btn accept">✓ Accept</button>
                                                </form>
                                                <form method="POST" action="{{ route('employee.extra-shift-requests.respond', $offer) }}" onsubmit="return confirm('Decline this extra shift?');">
                                                    @csrf
                                                    <input type="hidden" name="response" value="Unavailable">
                                                    <button type="submit" class="offer-btn decline">✕ Decline</button>
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

        <div class="card info-card" id="extra-shift">
            <h3 class="section-heading">Request an Extra Shift</h3>
            <p class="section-description">Need to work an additional shift? Submit your preferred date and time.</p>
            <form method="POST" action="{{ route('employee.extra-shift-requests.store') }}">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label for="shift_date">Requested Date</label>
                        <input type="date" id="shift_date" name="shift_date" min="{{ today()->format('Y-m-d') }}" value="{{ old('shift_date') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time</label>
                        <input type="time" id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="end_time">End Time</label>
                        <input type="time" id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="reason">Reason for Extra Shift</label>
                        <textarea id="reason" name="reason" maxlength="1000" placeholder="Explain why you are requesting an extra shift." required>{{ old('reason') }}</textarea>
                    </div>
                    <div class="form-group full-width">
                        <button type="submit" class="submit-button">Submit Extra Shift Request</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card info-card" id="my-requests">
            <h3 class="section-heading">My Extra Shift Requests</h3>
            <p class="section-description">View the requests you have submitted and check their current status.</p>

            @if($myExtraShiftRequests->isEmpty())
                <div class="empty-state">You have not submitted any extra-shift requests yet.</div>
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
                                    <td>{{ $shiftRequest->shift_date ? \Carbon\Carbon::parse($shiftRequest->shift_date)->format('M d, Y') : '—' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($shiftRequest->start_time)->format('h:i A') }} – {{ \Carbon\Carbon::parse($shiftRequest->end_time)->format('h:i A') }}</td>
                                    <td class="reason-cell">{{ $shiftRequest->reason ?: '—' }}</td>
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
                                        <span class="request-status {{ $statusClass }}">{{ $shiftRequest->status }}</span>
                                    </td>
                                    <td>{{ $shiftRequest->created_at ? $shiftRequest->created_at->format('M d, Y') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        const employeeId = {{ (int) $employee->id }};
        const attendanceUrl = "{{ url('/employee/attendance/scan') }}/" + employeeId;
        if (typeof QRCode !== 'undefined') {
            new QRCode(document.getElementById("employee-qr"), { text: attendanceUrl, width: 180, height: 180 });
        } else {
            document.getElementById("employee-qr").textContent = "QR code could not load.";
        }
    </script>

</body>
</html>