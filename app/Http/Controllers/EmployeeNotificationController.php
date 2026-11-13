<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeNotificationController extends Controller
{
    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return view('employee.notifications', compact('notifications'));
    }

    public function openNotification($notification)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        // Kung Attendance Reminder, i-redirect sa My Attendance page
        if (isset($notification->data['type']) && $notification->data['type'] === 'attendance_reminder') {
            return redirect('/employee/my-attendance');
        }

        return redirect('/employee/dashboard');
    }
}