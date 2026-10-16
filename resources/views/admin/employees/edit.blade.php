<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee - Otirasor Beach and Resort</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #2c3e50;
        }

        .navbar {
            background: #2c3e50;
            color: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .navbar h2 {
            margin: 0;
            font-size: 21px;
        }

        .navbar-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .back-btn,
        .dashboard-btn {
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
        }

        .back-btn {
            background: #3498db;
        }

        .back-btn:hover {
            background: #2980b9;
        }

        .dashboard-btn {
            background: #6c757d;
        }

        .dashboard-btn:hover {
            background: #5a6268;
        }

        .container {
            max-width: 700px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 8px;
            font-size: 28px;
        }

        .description {
            color: #6c757d;
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 19px;
            margin: 30px 0 8px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .section-description {
            color: #6c757d;
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="time"],
        input[type="number"],
        input[type="password"],
        select {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            background: white;
            color: #2c3e50;
        }

        input:focus,
        select:focus {
            border-color: #3498db;
        }

        .note {
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 12px 14px;
            margin-bottom: 25px;
            color: #555;
            font-size: 13px;
            line-height: 1.6;
        }

        .error-box {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 14px 18px;
            margin-bottom: 20px;
        }

        .error-box ul {
            margin: 0;
            padding-left: 20px;
        }

        .field-note {
            color: #777;
            font-size: 12px;
            line-height: 1.5;
            margin-top: 6px;
        }

        /* WORKDAY CHECKBOXES */

        .workdays-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 12px;
        }

        .workday-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px;
            border: 1px solid #dbe2ea;
            border-radius: 8px;
            background: #f8fafc;
            cursor: pointer;
            margin: 0;
            font-weight: normal;
        }

        .workday-option:has(input:checked) {
            border-color: #3498db;
            background: #eff8ff;
        }

        .workday-option input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin: 0;
            accent-color: #3498db;
            flex-shrink: 0;
        }

        .workday-option span {
            font-size: 14px;
        }

        .rest-day-note {
            margin-top: 12px;
            padding: 12px;
            background: #fff8e7;
            border-left: 4px solid #e0a126;
            border-radius: 4px;
            color: #76551a;
            font-size: 13px;
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .cancel-btn,
        .update-btn {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .cancel-btn {
            background: #6c757d;
            color: white;
        }

        .cancel-btn:hover {
            background: #5a6268;
        }

        .update-btn {
            background: #3498db;
            color: white;
        }

        .update-btn:hover {
            background: #2980b9;
        }

        .password-note {
            color: #777;
            font-size: 12px;
            margin-top: 6px;
        }

        @media (max-width: 600px) {
            .navbar {
                padding: 15px;
                flex-direction: column;
                align-items: stretch;
            }

            .navbar h2 {
                font-size: 17px;
            }

            .navbar-actions {
                flex-direction: column;
                align-items: stretch;
            }

            .back-btn,
            .dashboard-btn {
                text-align: center;
                width: 100%;
            }

            .container {
                margin: 25px auto;
                padding: 0 15px;
            }

            .card {
                padding: 22px;
            }

            h1 {
                font-size: 24px;
            }

            .workdays-grid {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
            }

            .cancel-btn,
            .update-btn {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Otirasor Beach and Resort</h2>

        <div class="navbar-actions">
            <a
                href="{{ route('admin.employees.index') }}"
                class="back-btn"
            >
                ← Back to Employee Management
            </a>

            <a
                href="{{ url('/admin/dashboard') }}"
                class="dashboard-btn"
            >
                Admin Dashboard
            </a>
        </div>
    </div>

    <div class="container">
        <div class="card">

            <h1>Edit Employee</h1>

            <p class="description">
                Update the employee account information and work schedule.
            </p>

            @if($errors->any())
                <div class="error-box">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="note">
                Employee accounts can be set to
                <strong>Active</strong> or <strong>Inactive</strong>.
                Inactive employees can be disabled without deleting their account.
            </div>

            <form
                method="POST"
                action="{{ route('admin.employees.update', $employee) }}"
            >
                @csrf
                @method('PUT')

                <h3 class="section-title">Employee Information</h3>

                <div class="form-group">
                    <label for="name">Employee Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $employee->name) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $employee->email) }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="status">Employee Status</label>

                    <select id="status" name="status" required>
                        <option
                            value="Active"
                            {{ old('status', $employee->status) === 'Active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="Inactive"
                            {{ old('status', $employee->status) === 'Inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>
                    </select>
                </div>

                <h3 class="section-title">Employee Work Schedule</h3>

                <p class="section-description">
                    Select the days this employee is scheduled to work.
                    Unselected days are treated as rest days in the schedule settings.
                </p>

                @php
                    $daysOfWeek = [
                        'Monday',
                        'Tuesday',
                        'Wednesday',
                        'Thursday',
                        'Friday',
                        'Saturday',
                        'Sunday',
                    ];

                    $selectedWorkDays = old(
                        'work_days',
                        $employee->work_days ?? []
                    );

                    if (!is_array($selectedWorkDays)) {
                        $selectedWorkDays = [];
                    }
                @endphp

                <input
                    type="hidden"
                    name="work_days_submitted"
                    value="1"
                >

                <div class="form-group">
                    <label>Scheduled Workdays</label>

                    <div class="workdays-grid">
                        @foreach($daysOfWeek as $day)
                            <label class="workday-option">
                                <input
                                    type="checkbox"
                                    name="work_days[]"
                                    value="{{ $day }}"
                                    {{ in_array($day, $selectedWorkDays, true) ? 'checked' : '' }}
                                >

                                <span>{{ $day }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="rest-day-note">
                        <strong>Important:</strong>
                        Unchecked days will be treated as rest days.
                        If no days are selected, the employee will have no scheduled workdays.
                    </div>
                </div>

                <div class="form-group">
                    <label for="regular_time_in">Regular Time In</label>

                    <input
                        type="time"
                        id="regular_time_in"
                        name="regular_time_in"
                        value="{{ old('regular_time_in', $employee->regular_time_in ? substr($employee->regular_time_in, 0, 5) : '') }}"
                    >

                    <div class="field-note">
                        The employee's scheduled start time.
                    </div>
                </div>

                <div class="form-group">
                    <label for="regular_time_out">Regular Time Out</label>

                    <input
                        type="time"
                        id="regular_time_out"
                        name="regular_time_out"
                        value="{{ old('regular_time_out', $employee->regular_time_out ? substr($employee->regular_time_out, 0, 5) : '') }}"
                    >

                    <div class="field-note">
                        The employee's scheduled end time.
                    </div>
                </div>

                <div class="form-group">
                    <label for="unpaid_break_minutes">
                        Unpaid Break (Minutes)
                    </label>

                    <input
                        type="number"
                        id="unpaid_break_minutes"
                        name="unpaid_break_minutes"
                        min="0"
                        max="1440"
                        value="{{ old('unpaid_break_minutes', $employee->unpaid_break_minutes ?? 60) }}"
                        required
                    >

                    <div class="field-note">
                        Default: 60 minutes. This break duration is excluded from paid working time.
                    </div>
                </div>

                <div class="form-group">
                    <label for="grace_period_minutes">
                        Late Grace Period (Minutes)
                    </label>

                    <input
                        type="number"
                        id="grace_period_minutes"
                        name="grace_period_minutes"
                        min="0"
                        max="1440"
                        value="{{ old('grace_period_minutes', $employee->grace_period_minutes ?? 0) }}"
                        required
                    >

                    <div class="field-note">
                        The allowed minutes after scheduled Time In before late minutes are counted.
                    </div>
                </div>

                <h3 class="section-title">Change Password</h3>

                <p class="section-description">
                    Leave the password fields blank if you do not want to change
                    this employee's password.
                </p>

                <div class="form-group">
                    <label for="password">New Password</label>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="new-password"
                    >

                    <div class="password-note">
                        Enter a new password only when needed.
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">
                        Confirm New Password
                    </label>

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        autocomplete="new-password"
                    >
                </div>

                <div class="actions">
                    <a
                        href="{{ route('admin.employees.index') }}"
                        class="cancel-btn"
                    >
                        Cancel
                    </a>

                    <button type="submit" class="update-btn">
                        Update Employee
                    </button>
                </div>

            </form>

        </div>
    </div>

</body>
</html>