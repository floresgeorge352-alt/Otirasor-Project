<?php

namespace App\Http\Controllers;

use App\Mail\ExtraShiftRequestMail;
use App\Models\ExtraShiftRequest;
use App\Models\User;
use App\Notifications\ShiftOfferNotification;
use App\Notifications\ShiftResponseNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ExtraShiftRequestController extends Controller
{
    public function store(Request $request)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $validated = $request->validate([
            'employee_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'employee'),
            ],
            'shift_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'reason'     => ['nullable', 'string', 'max:1000'],
        ]);

        $employee = User::findOrFail($validated['employee_id']);

        $shiftRequest = ExtraShiftRequest::create([
            'employee_id'       => $employee->id,
            'requested_by'      => Auth::id(),
            'request_type'      => 'admin',
            'shift_date'        => $validated['shift_date'],
            'start_time'        => $validated['start_time'],
            'end_time'          => $validated['end_time'],
            'reason'            => $validated['reason'] ?? null,
            'employee_response' => 'Pending',
            'status'            => 'Pending',
        ]);

        try {
            Mail::to($employee->email)->send(new ExtraShiftRequestMail($shiftRequest));
        } catch (\Throwable $e) {
            report($e);
        }

        $employee->notify(new ShiftOfferNotification($shiftRequest));

        return back()->with('success', 'Shift offer has been created successfully.');
    }

    public function employeeStore(Request $request)
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        $validated = $request->validate([
            'shift_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', 'after:start_time'],
            'reason'     => ['required', 'string', 'max:1000'],
        ]);

        ExtraShiftRequest::create([
            'employee_id'       => Auth::id(),
            'requested_by'      => Auth::id(),
            'request_type'      => 'employee',
            'shift_date'        => $validated['shift_date'],
            'start_time'        => $validated['start_time'],
            'end_time'          => $validated['end_time'],
            'reason'            => $validated['reason'],
            'employee_response' => 'Pending',
            'status'            => 'Pending',
        ]);

        return back()->with('success', 'Your request has been submitted. Please wait for admin approval.');
    }

    public function respond(Request $request, ExtraShiftRequest $extraShiftRequest)
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        abort_unless(
            (int) $extraShiftRequest->employee_id === (int) Auth::id(),
            403
        );

        if (
            $extraShiftRequest->request_type !== 'admin' ||
            $extraShiftRequest->status !== 'Pending' ||
            $extraShiftRequest->employee_response !== 'Pending'
        ) {
            return back()->with('error', 'This offer is no longer available.');
        }

        $validated = $request->validate([
            'response' => ['required', Rule::in(['Available', 'Unavailable'])],
        ]);

        $extraShiftRequest->update([
            'employee_response' => $validated['response'],
            'responded_at'      => now(),
        ]);

        $extraShiftRequest->load('employee');

        User::where('role', 'admin')->get()->each(function ($admin) use ($extraShiftRequest) {
            $admin->notify(new ShiftResponseNotification($extraShiftRequest));
        });

        return back()->with('success', 'Your response has been sent. Admin has been notified.');
    }

    public function confirm(ExtraShiftRequest $extraShiftRequest)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        if ($extraShiftRequest->status !== 'Pending') {
            return back()->with('error', 'This request is no longer pending.');
        }

        if ($extraShiftRequest->request_type === 'employee') {
            $extraShiftRequest->update([
                'status'       => 'Approved',
                'confirmed_at' => now(),
            ]);

            $extraShiftRequest->employee->notify(new ShiftOfferNotification($extraShiftRequest));

            return back()->with('success', 'Employee request has been approved.');
        }

        if (
            $extraShiftRequest->request_type === 'admin' &&
            $extraShiftRequest->employee_response === 'Available'
        ) {
            $extraShiftRequest->update([
                'status'       => 'Confirmed',
                'confirmed_at' => now(),
            ]);

            $extraShiftRequest->employee->notify(new ShiftOfferNotification($extraShiftRequest));

            return back()->with('success', 'Shift offer has been confirmed.');
        }

        return back()->with('error', 'Cannot confirm the offer until the employee is available.');
    }

    public function reject(ExtraShiftRequest $extraShiftRequest)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        if ($extraShiftRequest->status !== 'Pending') {
            return back()->with('error', 'This request is no longer pending.');
        }

        $extraShiftRequest->update(['status' => 'Rejected']);

        $extraShiftRequest->employee->notify(new ShiftOfferNotification($extraShiftRequest));

        return back()->with('success', 'Request has been rejected.');
    }

    public function adminEmployeeRequests()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $requests = ExtraShiftRequest::with(['employee', 'requester'])
            ->where('request_type', 'employee')
            ->latest()
            ->get();

        return view('admin.employee-shift-requests', compact('requests'));
    }

    public function adminShiftOffers()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $requests = ExtraShiftRequest::with(['employee', 'requester'])
            ->where('request_type', 'admin')
            ->orderByRaw("CASE 
                WHEN employee_response != 'Pending' AND status = 'Pending' THEN 0 
                WHEN employee_response = 'Pending' AND status = 'Pending' THEN 1
                ELSE 2 
            END")
            ->latest()
            ->get();

        return view('admin.shift-offers', compact('requests'));
    }

    public function employeeMyRequests()
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        $requests = ExtraShiftRequest::where('employee_id', Auth::id())
            ->where('request_type', 'employee')
            ->latest()
            ->get();

        return view('employee.my-shift-requests', compact('requests'));
    }

    public function employeeShiftOffers()
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        $requests = ExtraShiftRequest::where('employee_id', Auth::id())
            ->where('request_type', 'admin')
            ->latest()
            ->get();

        return view('employee.shift-offers', compact('requests'));
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return view('employee.notifications', compact('notifications'));
    }

    public function openNotification($notification)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        return redirect('/employee/dashboard');
    }
}