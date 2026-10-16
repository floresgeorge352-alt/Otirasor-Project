<?php

namespace App\Http\Controllers;

use App\Mail\ExtraShiftRequestMail;
use App\Models\ExtraShiftRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ExtraShiftRequestController extends Controller
{
    /**
     * ADMIN: Create a shift offer for an employee.
     */
    public function store(Request $request)
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $validated = $request->validate([
            'employee_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')->where('role', 'employee'),
            ],
            'shift_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $employee = User::findOrFail($validated['employee_id']);

        $shiftRequest = ExtraShiftRequest::create([
            'employee_id' => $employee->id,
            'requested_by' => Auth::id(),
            'request_type' => 'admin',
            'shift_date' => $validated['shift_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'reason' => $validated['reason'] ?? null,
            'employee_response' => 'Pending',
            'status' => 'Pending',
        ]);

        try {
            Mail::to($employee->email)
                ->send(new ExtraShiftRequestMail($shiftRequest));
        } catch (\Throwable $e) {
            report($e);
        }

        return back()->with(
            'success',
            'Nagawa na ang shift offer.'
        );
    }

    /**
     * EMPLOYEE: Submit a personal extra-shift request.
     */
    public function employeeStore(Request $request)
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        $validated = $request->validate([
            'shift_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        ExtraShiftRequest::create([
            'employee_id' => Auth::id(),
            'requested_by' => Auth::id(),
            'request_type' => 'employee',
            'shift_date' => $validated['shift_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'reason' => $validated['reason'],
            'employee_response' => 'Pending',
            'status' => 'Pending',
        ]);

        return back()->with(
            'success',
            'Naipadala na ang request mo. Hintayin ang desisyon ng admin.'
        );
    }

    /**
     * EMPLOYEE: Respond to an admin-created offer.
     */
    public function respond(
        Request $request,
        ExtraShiftRequest $extraShiftRequest
    ) {
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
            return back()->with(
                'error',
                'Hindi na available ang offer na ito.'
            );
        }

        $validated = $request->validate([
            'response' => [
                'required',
                Rule::in(['Available', 'Unavailable']),
            ],
        ]);

        $extraShiftRequest->update([
            'employee_response' => $validated['response'],
            'responded_at' => now(),
        ]);

        return back()->with(
            'success',
            'Naipadala na ang sagot mo.'
        );
    }

    /**
     * ADMIN: Approve an employee request or confirm an available offer.
     */
    public function confirm(
        ExtraShiftRequest $extraShiftRequest
    ) {
        abort_unless(Auth::user()?->role === 'admin', 403);

        if ($extraShiftRequest->status !== 'Pending') {
            return back()->with(
                'error',
                'Hindi na Pending ang request na ito.'
            );
        }

        // Employee-created request: Approved.
        if ($extraShiftRequest->request_type === 'employee') {
            $extraShiftRequest->update([
                'status' => 'Approved',
                'confirmed_at' => now(),
            ]);

            return back()->with(
                'success',
                'Na-approve ang employee request.'
            );
        }

        // Admin-created offer: confirm only if employee is Available.
        if (
            $extraShiftRequest->request_type === 'admin' &&
            $extraShiftRequest->employee_response === 'Available'
        ) {
            $extraShiftRequest->update([
                'status' => 'Confirmed',
                'confirmed_at' => now(),
            ]);

            return back()->with(
                'success',
                'Na-confirm ang shift offer.'
            );
        }

        return back()->with(
            'error',
            'Hindi mako-confirm ang offer hangga’t hindi Available ang employee.'
        );
    }

    /**
     * ADMIN: Reject a pending request or offer.
     */
    public function reject(
        ExtraShiftRequest $extraShiftRequest
    ) {
        abort_unless(Auth::user()?->role === 'admin', 403);

        if ($extraShiftRequest->status !== 'Pending') {
            return back()->with(
                'error',
                'Hindi na Pending ang request na ito.'
            );
        }

        $extraShiftRequest->update([
            'status' => 'Rejected',
        ]);

        return back()->with(
            'success',
            'Na-reject ang request.'
        );
    }

    /**
     * ADMIN PAGE: Employee-created requests only.
     */
    public function adminEmployeeRequests()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $requests = ExtraShiftRequest::with([
            'employee',
            'requester',
        ])
            ->where('request_type', 'employee')
            ->latest()
            ->get();

        return view(
            'admin.employee-shift-requests',
            compact('requests')
        );
    }

    /**
     * ADMIN PAGE: Admin-created shift offers only.
     */
    public function adminShiftOffers()
    {
        abort_unless(Auth::user()?->role === 'admin', 403);

        $requests = ExtraShiftRequest::with([
            'employee',
            'requester',
        ])
            ->where('request_type', 'admin')
            ->latest()
            ->get();

        return view(
            'admin.shift-offers',
            compact('requests')
        );
    }

    /**
     * EMPLOYEE PAGE: Requests submitted by the logged-in employee.
     */
    public function employeeMyRequests()
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        $requests = ExtraShiftRequest::where(
            'employee_id',
            Auth::id()
        )
            ->where('request_type', 'employee')
            ->latest()
            ->get();

        return view(
            'employee.my-shift-requests',
            compact('requests')
        );
    }

    /**
     * EMPLOYEE PAGE: Admin offers assigned to the logged-in employee.
     */
    public function employeeShiftOffers()
    {
        abort_unless(Auth::user()?->role === 'employee', 403);

        $requests = ExtraShiftRequest::where(
            'employee_id',
            Auth::id()
        )
            ->where('request_type', 'admin')
            ->latest()
            ->get();

        return view(
            'employee.shift-offers',
            compact('requests')
        );
    }
}