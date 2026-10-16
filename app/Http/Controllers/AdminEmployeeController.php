<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ExtraShiftRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminEmployeeController extends Controller
{
    private function availableWorkDays(): array
    {
        return [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday',
        ];
    }

    // =========================================================
    // EMPLOYEE MANAGEMENT
    // =========================================================

    public function index(Request $request)
    {
        // SEARCH FILTER
        $search = trim($request->query('search', ''));

        // STATUS FILTER
        $status = $request->query('status', 'all');

        if (! in_array($status, ['all', 'Active', 'Inactive'], true)) {
            $status = 'all';
        }

        // EMPLOYEE QUERY
        $employeeQuery = User::query()
            ->where('role', 'employee');

        // SEARCH BY FULL OR PARTIAL NAME
        if ($search !== '') {
            $employeeQuery->where(
                'name',
                'like',
                '%' . $search . '%'
            );
        }

        // FILTER ACTIVE OR INACTIVE EMPLOYEES
        if ($status !== 'all') {
            $employeeQuery->whereRaw(
                'TRIM(status) = ?',
                [$status]
            );
        }

        // PAGINATION: 10 EMPLOYEES PER PAGE
        $employees = $employeeQuery
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        // ACTIVE EMPLOYEES FOR SHIFT-OFFER DROPDOWN
        $activeEmployees = User::query()
            ->where('role', 'employee')
            ->whereRaw('TRIM(status) = ?', ['Active'])
            ->orderBy('name')
            ->get();

        // EXISTING SHIFT REQUESTS
        $extraShiftRequests = ExtraShiftRequest::with([
            'employee',
            'requester',
        ])
            ->latest()
            ->get();

        return view(
            'admin.employees.index',
            compact(
                'employees',
                'activeEmployees',
                'extraShiftRequests',
                'search',
                'status'
            )
        );
    }

    // =========================================================
    // CREATE EMPLOYEE
    // =========================================================

    public function create()
    {
        return view('admin.employees.create');
    }

    // =========================================================
    // SAVE NEW EMPLOYEE
    // =========================================================

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'employee',
            'status' => 'Active',
        ]);

        return redirect()
            ->route('admin.employees.index')
            ->with(
                'success',
                'Employee account created successfully.'
            );
    }

    // =========================================================
    // EDIT EMPLOYEE
    // =========================================================

    public function edit(User $employee)
    {
        if ($employee->role !== 'employee') {
            abort(404);
        }

        return view(
            'admin.employees.edit',
            compact('employee')
        );
    }

    // =========================================================
    // UPDATE EMPLOYEE
    // =========================================================

    public function update(Request $request, User $employee)
    {
        if ($employee->role !== 'employee') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignore($employee->id),
            ],

            'status' => 'required|in:Active,Inactive',

            'password' => 'nullable|string|min:8|confirmed',

            'regular_time_in' => 'nullable|date_format:H:i',

            'regular_time_out' => 'nullable|date_format:H:i',

            'unpaid_break_minutes' => 'required|integer|min:0|max:1440',

            'grace_period_minutes' => 'required|integer|min:0|max:1440',

            'work_days_submitted' => 'required|in:1',

            'work_days' => 'sometimes|array',

            'work_days.*' => [
                'required',
                'string',
                Rule::in($this->availableWorkDays()),
            ],
        ]);

        // REMOVE DUPLICATE WORK DAYS
        $workDays = array_values(
            array_unique($validated['work_days'] ?? [])
        );

        // UPDATE BASIC INFORMATION
        $employee->name = $validated['name'];
        $employee->email = $validated['email'];
        $employee->status = $validated['status'];

        // UPDATE WORK SCHEDULE
        $employee->regular_time_in =
            $validated['regular_time_in'] ?? null;

        $employee->regular_time_out =
            $validated['regular_time_out'] ?? null;

        $employee->unpaid_break_minutes =
            $validated['unpaid_break_minutes'];

        $employee->grace_period_minutes =
            $validated['grace_period_minutes'];

        $employee->work_days = $workDays;

        // UPDATE PASSWORD ONLY IF PROVIDED
        if ($request->filled('password')) {
            $employee->password = Hash::make(
                $validated['password']
            );
        }

        $employee->save();

        return redirect()
            ->route('admin.employees.index')
            ->with(
                'success',
                'Employee account and work schedule updated successfully.'
            );
    }
}