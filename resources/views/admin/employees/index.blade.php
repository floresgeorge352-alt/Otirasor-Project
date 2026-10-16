<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management - Otirasor Beach and Resort</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, sans-serif;
            background: #f6f8fb;
            color: #1f2937;
        }

        nav {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 14px 35px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .brand { display: flex; align-items: center; gap: 12px; min-width: 0; }
        .brand img { width: 48px; height: 48px; object-fit: contain; }
        .brand-text { display: flex; flex-direction: column; }
        .brand-title { color: #023e8a; font-size: 18px; font-weight: bold; }
        .brand-subtitle { color: #6b7280; font-size: 12px; margin-top: 2px; }
        .nav-links { display: flex; align-items: center; gap: 8px; }

        .nav-links a, .logout-btn {
            border: none;
            background: transparent;
            color: #374151;
            text-decoration: none;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            font-family: Arial, sans-serif;
        }

        .nav-links a:hover, .logout-btn:hover {
            background: #eff6ff;
            color: #0077b6;
        }

        .container { max-width: 1180px; margin: 32px auto; padding: 0 20px; }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 24px;
        }

        .page-header h1 { color: #023e8a; font-size: 28px; margin-bottom: 7px; }
        .page-header p { color: #6b7280; font-size: 14px; line-height: 1.5; }
        .header-actions { display: flex; gap: 9px; flex-wrap: wrap; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 16px;
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
            border: none;
            cursor: pointer;
        }

        .back-btn { background: #e5e7eb; color: #374151; }
        .back-btn:hover { background: #d1d5db; }
        .add-btn { background: #0077b6; color: white; }
        .add-btn:hover { background: #023e8a; }
        .submit-btn { margin-top: 18px; background: #166534; color: white; }
        .submit-btn:hover { background: #14532d; }

        .message {
            padding: 13px 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .success-message { background: #ecfdf3; border: 1px solid #86efac; color: #166534; }
        .error-message { background: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; }

        .validation-errors {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            color: #9a3412;
            padding: 13px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .management-cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .management-card {
            width: 100%;
            min-width: 0;
            text-align: left;
            border: 1px solid #e5e7eb;
            background: #fff;
            border-radius: 14px;
            padding: 24px;
            cursor: pointer;
            transition: border-color .2s, box-shadow .2s, transform .2s;
            font-family: Arial, sans-serif;
            color: #1f2937;
        }

        .management-card:hover, .management-card.active {
            border-color: #0077b6;
            box-shadow: 0 8px 22px rgba(2, 62, 138, .09);
        }

        .management-card:hover { transform: translateY(-2px); }
        .management-card:focus-visible { outline: 3px solid #93c5fd; outline-offset: 3px; }
        .management-card .card-icon { font-size: 32px; margin-bottom: 14px; }
        .management-card h2 { color: #023e8a; font-size: 19px; margin-bottom: 8px; }
        .management-card p { color: #6b7280; font-size: 13px; line-height: 1.6; margin-bottom: 16px; }

        .management-card .card-count {
            display: inline-block;
            background: #eff6ff;
            color: #0369a1;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
        }

        .management-section[hidden] { display: none !important; }

        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            margin-bottom: 24px;
        }

        .card-header {
            padding: 18px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .card-header h2 { color: #023e8a; font-size: 18px; }
        .card-header p { color: #6b7280; font-size: 12px; margin-top: 4px; line-height: 1.5; }
        .form-body { padding: 20px; }

        .employee-count {
            background: #eff6ff;
            color: #0369a1;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group { min-width: 0; }
        .form-group.full-width { grid-column: 1 / -1; }
        .form-group label { display: block; font-size: 13px; font-weight: bold; color: #374151; margin-bottom: 7px; }

        .form-group input, .form-group select, .form-group textarea {
            display: block;
            width: 100%;
            min-height: 43px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            color: #1f2937;
            font: inherit;
            font-size: 14px;
        }

        .form-group textarea { min-height: 90px; resize: vertical; }
        .help-text { display: inline-block; color: #6b7280; font-size: 12px; line-height: 1.5; margin-top: 6px; }
        .table-wrapper { overflow-x: auto; }

        .employee-tools {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .employee-filter-form {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) 180px auto auto;
            gap: 10px;
            align-items: end;
        }

        .employee-filter-form label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 7px;
            color: #374151;
        }

        .employee-filter-form input,
        .employee-filter-form select {
            width: 100%;
            min-height: 43px;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #fff;
            font-size: 14px;
        }

        .filter-btn, .clear-filter-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 43px;
            padding: 10px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .filter-btn { background: #0077b6; color: #fff; }
        .clear-filter-btn { background: #e5e7eb; color: #374151; }

        .employee-results {
            padding: 14px 20px;
            color: #6b7280;
            font-size: 13px;
            border-bottom: 1px solid #eef0f3;
        }

        .employee-pagination {
            padding: 18px 20px;
            border-top: 1px solid #e5e7eb;
        }

        .employee-pagination nav > div:first-child { margin-bottom: 12px; }

        .employee-pagination nav p {
            font-size: 13px;
            color: #6b7280;
        }

        .employee-pagination nav a,
        .employee-pagination nav span[aria-current="page"] span {
            display: inline-block;
            padding: 8px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            margin: 2px;
            text-decoration: none;
            font-size: 13px;
        }

        .employee-pagination nav a { color: #0369a1; background: #fff; }

        .employee-pagination nav span[aria-current="page"] span {
            background: #0077b6;
            color: #fff;
            border-color: #0077b6;
        }

        table { width: 100%; border-collapse: collapse; min-width: 850px; }

        th {
            background: #f8fafc;
            color: #374151;
            padding: 13px 16px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .3px;
            border-bottom: 1px solid #e5e7eb;
        }

        td { padding: 15px 16px; border-bottom: 1px solid #eef0f3; font-size: 14px; vertical-align: middle; }
        tbody tr:hover { background: #f8fbff; }
        tbody tr:last-child td { border-bottom: none; }
        .number { color: #9ca3af; font-size: 13px; font-weight: bold; }
        .employee-name { color: #111827; font-weight: bold; }
        .email { color: #6b7280; overflow-wrap: anywhere; }

        .role, .request-type, .status, .request-status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .role, .type-employee { background: #eff6ff; color: #0369a1; }
        .type-admin { background: #f3e8ff; color: #6b21a8; }
        .status-active, .request-confirmed { background: #dcfce7; color: #166534; }
        .status-inactive, .request-rejected, .request-unavailable { background: #fee2e2; color: #991b1b; }
        .request-pending { background: #fef3c7; color: #92400e; }
        .request-available { background: #dbeafe; color: #1d4ed8; }

        .actions, .request-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 7px; }

        .edit-btn, .qr-btn, .confirm-btn, .reject-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            padding: 8px 11px;
            border-radius: 7px;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            white-space: nowrap;
        }

        .edit-btn { background: #e0f2fe; color: #0369a1; }
        .edit-btn:hover { background: #bae6fd; }
        .qr-btn { background: #f0fdf4; color: #15803d; }
        .qr-btn:hover { background: #dcfce7; }
        .confirm-btn { background: #dcfce7; color: #166534; }
        .confirm-btn:hover { background: #bbf7d0; }
        .reject-btn { background: #fee2e2; color: #991b1b; }
        .reject-btn:hover { background: #fecaca; }

        .empty { text-align: center; padding: 55px 20px; color: #6b7280; }
        .empty-icon { font-size: 42px; margin-bottom: 12px; }
        .empty strong { display: block; color: #374151; font-size: 18px; margin-bottom: 7px; }
        .empty p { font-size: 13px; line-height: 1.5; }

        footer { text-align: center; color: #9ca3af; font-size: 12px; padding: 30px 20px; }

        @media (max-width: 800px) {
            nav { padding: 13px 18px; flex-direction: column; align-items: stretch; }
            .brand { justify-content: center; }
            .nav-links { justify-content: center; flex-wrap: wrap; }
            .page-header { flex-direction: column; align-items: stretch; }
            .header-actions { display: grid; grid-template-columns: 1fr 1fr; }
            .btn { width: 100%; }
        }

        @media (max-width: 700px) {
            .employee-filter-form { grid-template-columns: 1fr; }
            .filter-btn, .clear-filter-btn { width: 100%; }
        }

        @media (max-width: 550px) {
            .container { margin: 22px auto; padding: 0 12px; }
            .page-header h1 { font-size: 24px; }
            .header-actions, .management-cards, .form-grid { grid-template-columns: 1fr; }
            .management-card { padding: 20px; }
            .card-header { align-items: flex-start; flex-direction: column; }
            .brand-title { font-size: 16px; }
            .brand-subtitle { font-size: 11px; }
            .nav-links a, .logout-btn { font-size: 12px; padding: 8px 9px; }
            .form-group.full-width { grid-column: auto; }
        }
    </style>
</head>

<body>

<nav>
    <div class="brand">
        <img
            src="{{ asset('images/otirasor-logo.png') }}?v={{ file_exists(public_path('images/otirasor-logo.png')) ? filemtime(public_path('images/otirasor-logo.png')) : 1 }}"
            alt="Otirasor Beach and Resort Logo"
        >
        <div class="brand-text">
            <div class="brand-title">Otirasor Beach and Resort</div>
            <div class="brand-subtitle">Admin Panel</div>
        </div>
    </div>

    <div class="nav-links">
        <a href="/admin/dashboard">🏠 Dashboard</a>
        <a href="/admin/bookings">📋 Bookings</a>
        <a href="/admin/notifications">🔔 Notifications</a>

        <form method="POST" action="/logout" style="display:inline;">
            @csrf
            <button type="submit" class="logout-btn">🚪 Logout</button>
        </form>
    </div>
</nav>

<div class="container">

    <div class="page-header">
        <div>
            <h1>👥 Employee Management</h1>
            <p>Manage employee accounts and both types of extra-shift requests.</p>
        </div>

        <div class="header-actions">
            <a href="{{ url('/admin/management') }}" class="btn back-btn">← Management</a>
            <a href="{{ route('admin.employees.create') }}" class="btn add-btn">+ Add Employee</a>
        </div>
    </div>

    @if(session('success'))
        <div class="message success-message">✓ {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="message error-message">✕ {{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="validation-errors">
            <strong>Please check the following:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="management-cards">

        <button
            type="button"
            class="management-card"
            id="extraShiftCard"
            aria-controls="extraShiftSection"
            aria-expanded="false"
            onclick="toggleManagementSection('extraShiftSection')"
        >
            <div class="card-icon">🗓️</div>
            <h2>Extra Shift Requests</h2>
            <p>Send shift offers to employees and review employee-submitted requests.</p>
            <span class="card-count">
                {{ $extraShiftRequests->where('status', 'Pending')->count() }} Pending
            </span>
        </button>

        <button
            type="button"
            class="management-card"
            id="employeeAccountsCard"
            aria-controls="employeeAccountsSection"
            aria-expanded="false"
            onclick="toggleManagementSection('employeeAccountsSection')"
        >
            <div class="card-icon">👥</div>
            <h2>Employee Accounts</h2>
            <p>Search accounts, filter by status, edit details, and open attendance QR codes.</p>
            <span class="card-count">
                {{ $employees->total() }}
                {{ $employees->total() === 1 ? 'Employee' : 'Employees' }}
            </span>
        </button>

    </div>

    <div id="extraShiftSection" class="management-section" hidden>

        <div class="card">
            <div class="card-header">
                <div>
                    <h2>➕ Send Extra-Shift Offer</h2>
                    <p>The employee must respond Available before you can confirm this offer.</p>
                </div>
            </div>

            <div class="form-body">
                <form method="POST" action="{{ route('admin.extra-shift-requests.store') }}">
                    @csrf

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="employee_id">Select Employee *</label>
                            <select name="employee_id" id="employee_id" required>
                                <option value="">-- Choose Employee --</option>
                                @foreach($activeEmployees as $employee)
                                    <option
                                        value="{{ $employee->id }}"
                                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                    >
                                        {{ $employee->name }} ({{ $employee->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="shift_date">Shift Date *</label>
                            <input
                                type="date"
                                name="shift_date"
                                id="shift_date"
                                min="{{ now()->toDateString() }}"
                                value="{{ old('shift_date') }}"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="start_time">Start Time *</label>
                            <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="end_time">End Time *</label>
                            <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}" required>
                        </div>

                        <div class="form-group full-width">
                            <label for="reason">Reason / Work Details</label>
                            <textarea name="reason" id="reason" maxlength="1000" placeholder="Explain why the extra shift is needed...">{{ old('reason') }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn submit-btn">📨 Send Shift Offer</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div>
                    <h2>📋 All Extra-Shift Requests</h2>
                    <p>Admin offers require an employee response; employee requests can be approved directly.</p>
                </div>

                <div class="employee-count">
                    {{ $extraShiftRequests->count() }}
                    {{ $extraShiftRequests->count() === 1 ? 'Request' : 'Requests' }}
                </div>
            </div>

            @if($extraShiftRequests->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Request Type</th>
                                <th>Shift Date</th>
                                <th>Schedule</th>
                                <th>Reason</th>
                                <th>Employee Response</th>
                                <th>Request Status</th>
                                <th>Admin Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($extraShiftRequests as $shiftRequest)
                                <tr>
                                    <td>
                                        <strong>{{ $shiftRequest->employee->name ?? 'Employee account deleted' }}</strong>
                                        <br>
                                        <span class="email">{{ $shiftRequest->employee->email ?? '' }}</span>
                                    </td>

                                    <td>
                                        @if(($shiftRequest->request_type ?? 'admin') === 'employee')
                                            <span class="request-type type-employee">Employee Request</span>
                                        @else
                                            <span class="request-type type-admin">Admin Offer</span>
                                        @endif
                                    </td>

                                    <td>{{ $shiftRequest->shift_date->format('M d, Y') }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($shiftRequest->start_time)->format('h:i A') }}
                                        –
                                        {{ \Carbon\Carbon::parse($shiftRequest->end_time)->format('h:i A') }}
                                    </td>

                                    <td>{{ $shiftRequest->reason ?: '—' }}</td>

                                    <td>
                                        @if(($shiftRequest->request_type ?? 'admin') === 'employee')
                                            <span class="help-text">Not required</span>
                                        @elseif($shiftRequest->employee_response === 'Available')
                                            <span class="request-status request-available">✓ Available</span>
                                        @elseif($shiftRequest->employee_response === 'Unavailable')
                                            <span class="request-status request-unavailable">✕ Unavailable</span>
                                        @else
                                            <span class="request-status request-pending">Awaiting Response</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($shiftRequest->status === 'Confirmed')
                                            <span class="request-status request-confirmed">✓ Confirmed</span>
                                        @elseif($shiftRequest->status === 'Approved')
                                            <span class="request-status request-confirmed">✓ Approved</span>
                                        @elseif($shiftRequest->status === 'Rejected')
                                            <span class="request-status request-rejected">✕ Rejected</span>
                                        @elseif($shiftRequest->status === 'Cancelled')
                                            <span class="request-status request-rejected">Cancelled</span>
                                        @else
                                            <span class="request-status request-pending">Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($shiftRequest->status === 'Pending')
                                            <div class="request-actions">
                                                @if(($shiftRequest->request_type ?? 'admin') === 'employee')
                                                    <form method="POST" action="{{ route('admin.extra-shift-requests.confirm', $shiftRequest) }}" onsubmit="return confirm('Approve this employee extra-shift request?');">
                                                        @csrf
                                                        <button type="submit" class="confirm-btn">✓ Approve</button>
                                                    </form>
                                                @elseif($shiftRequest->employee_response === 'Available')
                                                    <form method="POST" action="{{ route('admin.extra-shift-requests.confirm', $shiftRequest) }}" onsubmit="return confirm('Confirm this shift after the employee accepted?');">
                                                        @csrf
                                                        <button type="submit" class="confirm-btn">✓ Confirm</button>
                                                    </form>
                                                @elseif($shiftRequest->employee_response === 'Unavailable')
                                                    <span class="help-text">Employee unavailable</span>
                                                @else
                                                    <span class="help-text">Waiting for employee</span>
                                                @endif

                                                @if(($shiftRequest->request_type ?? 'admin') === 'employee' || $shiftRequest->employee_response !== 'Unavailable')
                                                    <form method="POST" action="{{ route('admin.extra-shift-requests.reject', $shiftRequest) }}" onsubmit="return confirm('Reject this extra-shift request?');">
                                                        @csrf
                                                        <button type="submit" class="reject-btn">✕ Reject</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @else
                                            <span class="help-text">No action needed</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty">
                    <div class="empty-icon">🗓️</div>
                    <strong>No extra-shift requests yet.</strong>
                    <p>Send a shift offer above or wait for employees to submit their own requests.</p>
                </div>
            @endif
        </div>
    </div>

    <div id="employeeAccountsSection" class="management-section" hidden>

        <div class="card">
            <div class="card-header">
                <div>
                    <h2>👥 Employee Accounts</h2>
                    <p>Search employee names, filter by status, and view attendance QR codes.</p>
                </div>

                <div class="employee-count">
                    {{ $employees->total() }}
                    {{ $employees->total() === 1 ? 'Employee' : 'Employees' }}
                </div>
            </div>

            <div class="employee-tools">
                <form
                    method="GET"
                    action="{{ route('admin.employees.index') }}"
                    class="employee-filter-form"
                    id="employeeFilterForm"
                >
                    <div>
                        <label for="search">Search by employee name</label>
                        <input
                            type="search"
                            name="search"
                            id="search"
                            value="{{ $search }}"
                            placeholder="Enter full or partial name..."
                            autocomplete="off"
                        >
                    </div>

                    <div>
                        <label for="status">Employee Status</label>
                        <select name="status" id="status">
                            <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Employees</option>
                            <option value="Active" {{ $status === 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="Inactive" {{ $status === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="filter-btn">🔎 Search / Filter</button>

                    <a href="{{ route('admin.employees.index') }}" class="clear-filter-btn">
                        Clear
                    </a>
                </form>
            </div>

            <div class="employee-results">
                @if($employees->total() > 0)
                    Showing {{ $employees->firstItem() }}–{{ $employees->lastItem() }}
                    of {{ $employees->total() }} employees
                @else
                    No employees match your search or filter.
                @endif
            </div>

            @if($employees->count() > 0)
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>QR Code</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>
                                        <span class="number">
                                            {{ $employees->firstItem() + $loop->index }}
                                        </span>
                                    </td>

                                    <td><span class="employee-name">{{ $employee->name }}</span></td>
                                    <td><span class="email">{{ $employee->email }}</span></td>
                                    <td><span class="role">👤 Employee</span></td>

                                    <td>
                                        @if($employee->status === 'Active')
                                            <span class="status status-active">● Active</span>
                                        @else
                                            <span class="status status-inactive">● Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <button
                                            type="button"
                                            class="qr-btn"
                                            onclick="showQrCode(
                                                {{ Js::from((string) $employee->id) }},
                                                {{ Js::from($employee->name) }}
                                            )"
                                        >
                                            📱 QR Code
                                        </button>
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <a
                                                href="{{ route('admin.employees.edit', $employee) }}"
                                                class="edit-btn"
                                            >
                                                ✏️ Edit
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($employees->hasPages())
                    <div class="employee-pagination">
                        {{ $employees->links() }}
                    </div>
                @endif
            @else
                <div class="empty">
                    <div class="empty-icon">👥</div>
                    <strong>No employees found.</strong>
                    <p>Try another name or choose a different status filter.</p>
                </div>
            @endif
        </div>
    </div>

</div>

<footer>© 2026 Otirasor Beach and Resort. All Rights Reserved.</footer>

<script>
    function toggleManagementSection(sectionId) {
        const sectionIds = [
            'extraShiftSection',
            'employeeAccountsSection'
        ];

        const cardIds = {
            extraShiftSection: 'extraShiftCard',
            employeeAccountsSection: 'employeeAccountsCard'
        };

        sectionIds.forEach(function (id) {
            const section = document.getElementById(id);
            const card = document.getElementById(cardIds[id]);

            if (!section || !card) return;

            const shouldOpen = id === sectionId && section.hidden;

            section.hidden = !shouldOpen;
            card.classList.toggle('active', shouldOpen);
            card.setAttribute('aria-expanded', String(shouldOpen));
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const statusFilter = document.getElementById('status');
        const searchInput = document.getElementById('search');
        const employeeFilterForm = document.getElementById('employeeFilterForm');

        let employeeSearchTimer;

        // Automatically search after typing pauses for 350 milliseconds.
        if (searchInput && employeeFilterForm) {
            searchInput.addEventListener('input', function () {
                clearTimeout(employeeSearchTimer);

                employeeSearchTimer = setTimeout(function () {
                    if (typeof employeeFilterForm.requestSubmit === 'function') {
                        employeeFilterForm.requestSubmit();
                    } else {
                        employeeFilterForm.submit();
                    }
                }, 350);
            });

            // Submit immediately when Enter is pressed.
            searchInput.addEventListener('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    clearTimeout(employeeSearchTimer);

                    if (typeof employeeFilterForm.requestSubmit === 'function') {
                        employeeFilterForm.requestSubmit();
                    } else {
                        employeeFilterForm.submit();
                    }
                }
            });
        }

        // Automatically apply the status filter when changed.
        if (statusFilter && employeeFilterForm) {
            statusFilter.addEventListener('change', function () {
                clearTimeout(employeeSearchTimer);

                if (typeof employeeFilterForm.requestSubmit === 'function') {
                    employeeFilterForm.requestSubmit();
                } else {
                    employeeFilterForm.submit();
                }
            });
        }

        // Open the relevant section after an action or page load.
        @if($errors->any() || session('success') || session('error'))
            toggleManagementSection('extraShiftSection');
        @else
            toggleManagementSection('employeeAccountsSection');
        @endif
    });

    function showQrCode(employeeId, employeeName) {
        const attendanceUrl =
            window.location.origin +
            "/employee/attendance/scan/" +
            encodeURIComponent(employeeId);

        const qrWindow = window.open('', '_blank', 'width=500,height=700');

        if (!qrWindow) {
            alert('Please allow pop-ups for this website.');
            return;
        }

        const safeName = String(employeeName)
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');

        qrWindow.document.write(`
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Employee Attendance QR Code</title>

                <style>
                    * { box-sizing: border-box; }

                    body {
                        margin: 0;
                        font-family: Arial, sans-serif;
                        background: #f6f8fb;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        min-height: 100vh;
                        text-align: center;
                    }

                    .qr-card {
                        background: white;
                        width: 90%;
                        max-width: 400px;
                        padding: 35px;
                        border-radius: 16px;
                        border: 1px solid #e5e7eb;
                    }

                    h2 { color: #023e8a; margin-bottom: 10px; }
                    h3 { color: #0077b6; margin-bottom: 10px; overflow-wrap: anywhere; }
                    p { color: #555; overflow-wrap: anywhere; line-height: 1.5; }

                    #qrcode {
                        width: 256px;
                        min-height: 256px;
                        margin: 25px auto;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }

                    #qrcode img, #qrcode canvas { max-width: 100%; height: auto; }

                    .print-btn {
                        padding: 12px 22px;
                        background: #0077b6;
                        color: white;
                        border: none;
                        border-radius: 8px;
                        cursor: pointer;
                        font-weight: bold;
                        font-size: 14px;
                        margin-top: 10px;
                    }

                    @media print {
                        .print-btn { display: none; }
                        body { background: white; }
                        .qr-card { border: none; }
                    }
                </style>
            </head>

            <body>
                <div class="qr-card">
                    <h2>Otirasor Beach and Resort</h2>
                    <h3>${safeName}</h3>
                    <p>Employee Attendance QR Code</p>
                    <div id="qrcode">Generating QR Code...</div>
                    <p>Scan this QR Code for attendance.</p>
                    <button class="print-btn" onclick="window.print()">Print QR Code</button>
                </div>

                <script>
                    const attendanceUrl = ${JSON.stringify(attendanceUrl)};
                    const script = document.createElement('script');

                    script.src = 'https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js';

                    script.onload = function () {
                        const target = document.getElementById('qrcode');
                        target.innerHTML = '';

                        new QRCode(target, {
                            text: attendanceUrl,
                            width: 256,
                            height: 256
                        });
                    };

                    script.onerror = function () {
                        document.getElementById('qrcode').textContent =
                            'QR library failed to load. Please check your internet connection.';
                    };

                    document.head.appendChild(script);
                <\/script>
            </body>
            </html>
        `);

        qrWindow.document.close();
    }
</script>

</body>
</html>