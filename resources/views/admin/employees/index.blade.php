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

        .employee-count {
            background: #eff6ff;
            color: #0369a1;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

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

        .role, .status {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 9px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .role { background: #eff6ff; color: #0369a1; }
        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #fee2e2; color: #991b1b; }

        .actions { display: flex; align-items: center; flex-wrap: wrap; gap: 7px; }

        .edit-btn, .qr-btn {
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
            .header-actions { grid-template-columns: 1fr; }
            .card-header { align-items: flex-start; flex-direction: column; }
            .brand-title { font-size: 16px; }
            .brand-subtitle { font-size: 11px; }
            .nav-links a, .logout-btn { font-size: 12px; padding: 8px 9px; }
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
            <p>Manage employee accounts, schedules, and attendance QR codes.</p>
        </div>

        <div class="header-actions">
            <a href="{{ route('admin.dashboard') }}" class="btn back-btn">← Dashboard</a>
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

    <!-- EMPLOYEE ACCOUNTS TABLE -->
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
            <div class="table-wrapper" id="employee-table-wrapper">
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

                    @include('admin.employees._employee_table', ['employees' => $employees])
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

    <!-- ======================================================= -->
    <!-- WEEKLY SCHEDULE SECTION -->
    <!-- ======================================================= -->
    <div style="margin-top: 40px;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 15px;">
            <div>
                <h2 style="color: #023e8a; font-size: 22px; margin: 0;">📅 Weekly Schedule</h2>
                <p style="color: #6b7280; font-size: 14px; margin-top: 5px;">View the shift calendar for all employees.</p>
            </div>
            
            <div style="display: flex; gap: 8px; align-items: center;">
                <a href="{{ route('admin.employees.index', ['week' => $startOfWeek->copy()->subWeek()->toDateString()]) }}" class="btn" style="background: #0077b6; color: white; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 13px;">← Prev</a>
                <a href="{{ route('admin.employees.index') }}" class="btn" style="background: #10b981; color: white; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 13px;">This Week</a>
                <a href="{{ route('admin.employees.index', ['week' => $startOfWeek->copy()->addWeek()->toDateString()]) }}" class="btn" style="background: #0077b6; color: white; text-decoration: none; padding: 8px 15px; border-radius: 8px; font-weight: 600; font-size: 13px;">Next →</a>
            </div>
        </div>

        <div style="background: white; border-radius: 12px; border: 1px solid #e5e7eb; overflow-x: auto; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
            <table style="width: 100%; border-collapse: collapse; min-width: 1000px;">
                <thead>
                    <tr>
                        <th style="background: #f8fafc; color: #023e8a; padding: 15px; border: 1px solid #e5e7eb; text-align: left; width: 150px; font-size: 12px; text-transform: uppercase;">Employee</th>
                        @foreach(range(0, 6) as $day)
                            @php $currentDate = $startOfWeek->copy()->addDays($day); @endphp
                            <th style="background: {{ $currentDate->isToday() ? '#f0fdf4' : '#f8fafc' }}; color: #023e8a; padding: 15px; border: 1px solid #e5e7eb; text-align: center; font-size: 12px;">
                                <div>{{ $currentDate->format('l') }}</div>
                                <div style="font-size: 11px; color: #6b7280; font-weight: 400; text-transform: none;">{{ $currentDate->format('M d') }}</div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeEmployees as $emp)
                        <tr>
                            <td style="padding: 15px; border: 1px solid #e5e7eb; font-weight: 600; color: #333; background: #fafbfc; font-size: 14px;">
                                <a href="{{ route('admin.employees.edit', $emp->id) }}" style="color: #023e8a; text-decoration: underline;">
                                    {{ $emp->name }} ✏️
                                </a>
                            </td>
                            @foreach(range(0, 6) as $day)
                                @php $currentDate = $startOfWeek->copy()->addDays($day); @endphp
                                <td style="padding: 10px; border: 1px solid #e5e7eb; text-align: center; {{ $currentDate->isToday() ? 'background: #f0fdf4;' : '' }}">
                                    @if(in_array($currentDate->format('l'), $emp->work_days ?? []))
                                        <div style="background: #e0f2fe; color: #0369a1; padding: 8px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                            {{ \Carbon\Carbon::parse($emp->regular_time_in)->format('g:i A') }}<br>-<br>
                                            {{ \Carbon\Carbon::parse($emp->regular_time_out)->format('g:i A') }}
                                        </div>
                                    @else
                                        <span style="color: #9ca3af; font-style: italic; font-size: 12px;">Rest Day</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px; color: #6b7280;">No active employees found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<footer>© 2026 Otirasor Beach and Resort. All Rights Reserved.</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('status');
        const tableWrapper = document.getElementById('employee-table-wrapper');
        const resultsContainer = document.querySelector('.employee-results');
        const paginationContainer = document.querySelector('.employee-pagination');
        let debounceTimer;

        function fetchEmployees() {
            const search = searchInput ? searchInput.value : '';
            const status = statusFilter ? statusFilter.value : 'all';

            fetch(`{{ route('admin.employees.search') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                // Update table body
                if (tableWrapper) {
                    const table = tableWrapper.querySelector('table');
                    if (table) {
                        const tbody = table.querySelector('tbody');
                        if (tbody) tbody.outerHTML = data.html;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(fetchEmployees, 300);
            });
        }

        if (statusFilter) {
            statusFilter.addEventListener('change', fetchEmployees);
        }
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