<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminRoomController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\AdminAccommodationController;
use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AdminEmployeeController;
use App\Http\Controllers\ExtraShiftRequestController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| About
|--------------------------------------------------------------------------
*/

Route::get('/about', function () {
    return view('about');
});

/*
|--------------------------------------------------------------------------
| Contact
|--------------------------------------------------------------------------
*/

Route::get('/contact', function () {
    return view('contact');
});

/*
|--------------------------------------------------------------------------
| Customer Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/accommodations',
    [AccommodationController::class, 'index']
);

/*
|--------------------------------------------------------------------------
| Customer Booking Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/booking', [BookingController::class, 'create']);

    Route::post('/booking', [BookingController::class, 'store']);

    Route::get('/my-bookings', [CustomerBookingController::class, 'index']);

    Route::post(
        '/my-bookings/{booking}/cancel',
        [CustomerBookingController::class, 'cancel']
    );

    Route::get(
        '/my-bookings/{booking}/receipt',
        [BookingController::class, 'receipt']
    );

    Route::post(
        '/my-bookings/{booking}/request-cancellation',
        [BookingController::class, 'requestCancellation']
    );
});

/*
|--------------------------------------------------------------------------
| Customer Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->name('admin.dashboard');

    Route::get('/admin/management', function () {
        return view('admin.management.index');
    });

    Route::get('/admin/booking-information', function () {
        return view('admin.booking-information.index');
    });

    Route::get(
        '/admin/booking-overview',
        [AdminDashboardController::class, 'bookingOverview']
    );

    Route::get(
        '/admin/recent-bookings',
        [AdminDashboardController::class, 'recentBookings']
    );

    Route::get(
        '/admin/room-booking-details',
        [AdminDashboardController::class, 'roomBookingDetails']
    );

    Route::get(
        '/admin/notifications',
        [AdminDashboardController::class, 'notifications']
    );

    Route::get(
        '/admin/notifications/{notification}/open',
        [AdminDashboardController::class, 'openNotification']
    );

    Route::get(
        '/admin/reports',
        [AdminReportController::class, 'index']
    );

    Route::resource(
        '/admin/accommodations',
        AdminAccommodationController::class
    );

    Route::get(
        '/admin/bookings',
        [AdminBookingController::class, 'index']
    );

    Route::match(
        ['GET', 'POST'],
        '/admin/bookings/{booking}/approve',
        [AdminBookingController::class, 'approve']
    );

    Route::post(
        '/admin/bookings/{booking}/reject',
        [AdminBookingController::class, 'reject']
    );

    Route::post(
        '/admin/bookings/{booking}/approve-cancellation',
        [BookingController::class, 'approveCancellation']
    );

    Route::post(
        '/admin/bookings/{booking}/reject-cancellation',
        [BookingController::class, 'rejectCancellation']
    );

    Route::post(
        '/admin/bookings/{booking}/verify-payment',
        [AdminBookingController::class, 'verifyPayment']
    );

    Route::post(
        '/admin/bookings/{booking}/reject-payment',
        [AdminBookingController::class, 'rejectPayment']
    );

    Route::get(
        '/admin/rooms/available',
        [AdminRoomController::class, 'available']
    );

    Route::get(
        '/admin/rooms/reserved',
        [AdminRoomController::class, 'reserved']
    );

    Route::get(
        '/admin/rooms/occupied',
        [AdminRoomController::class, 'occupied']
    );

    Route::get(
        '/admin/room-status',
        [AdminRoomController::class, 'status']
    );

    /*
    |--------------------------------------------------------------------------
    | Employee Management
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/employees',
        [AdminEmployeeController::class, 'index']
    )->name('admin.employees.index');

    Route::get(
        '/admin/employees/create',
        [AdminEmployeeController::class, 'create']
    )->name('admin.employees.create');

    Route::post(
        '/admin/employees',
        [AdminEmployeeController::class, 'store']
    )->name('admin.employees.store');

    Route::get(
        '/admin/employees/{employee}/edit',
        [AdminEmployeeController::class, 'edit']
    )->name('admin.employees.edit');

    Route::put(
        '/admin/employees/{employee}',
        [AdminEmployeeController::class, 'update']
    )->name('admin.employees.update');

    /*
    |--------------------------------------------------------------------------
    | Extra Shift Requests - Admin
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/employee-shift-requests',
        [ExtraShiftRequestController::class, 'adminEmployeeRequests']
    )->name('admin.extra-shift-requests.employee-index');

    Route::get(
        '/admin/shift-offers',
        [ExtraShiftRequestController::class, 'adminShiftOffers']
    )->name('admin.extra-shift-requests.offer-index');

    Route::post(
        '/admin/extra-shift-requests',
        [ExtraShiftRequestController::class, 'store']
    )->name('admin.extra-shift-requests.store');

    Route::post(
        '/admin/extra-shift-requests/{extraShiftRequest}/confirm',
        [ExtraShiftRequestController::class, 'confirm']
    )->name('admin.extra-shift-requests.confirm');

    Route::post(
        '/admin/extra-shift-requests/{extraShiftRequest}/reject',
        [ExtraShiftRequestController::class, 'reject']
    )->name('admin.extra-shift-requests.reject');

    /*
    |--------------------------------------------------------------------------
    | Employee Attendance - Admin View
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/admin/attendance',
        [AdminAttendanceController::class, 'index']
    )->name('admin.attendance.index');

    Route::post(
        '/admin/attendance/{attendance}/approve-overtime',
        [AdminAttendanceController::class, 'approveOvertime']
    )->name('admin.attendance.approve-overtime');

    Route::post(
        '/admin/attendance/{attendance}/reject-overtime',
        [AdminAttendanceController::class, 'rejectOvertime']
    )->name('admin.attendance.reject-overtime');
});

/*
|--------------------------------------------------------------------------
| QR Attendance Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/employee/attendance/scan/{employee}',
    [AttendanceController::class, 'scan']
)->name('employee.attendance.scan');

Route::post(
    '/employee/attendance/scan/{employee}/time-in',
    [AttendanceController::class, 'qrTimeIn']
)->name('employee.attendance.qr-time-in');

Route::post(
    '/employee/attendance/scan/{employee}/time-out',
    [AttendanceController::class, 'qrTimeOut']
)->name('employee.attendance.qr-time-out');

/*
|--------------------------------------------------------------------------
| Employee Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/employee/dashboard', function () {
        return view('employee.dashboard');
    })->name('employee.dashboard');

    Route::post(
        '/employee/attendance/time-in',
        [AttendanceController::class, 'timeIn']
    )->name('employee.attendance.time-in');

    Route::post(
        '/employee/attendance/time-out',
        [AttendanceController::class, 'timeOut']
    )->name('employee.attendance.time-out');

    Route::get(
        '/employee/my-shift-requests',
        [ExtraShiftRequestController::class, 'employeeMyRequests']
    )->name('employee.extra-shift-requests.index');

    Route::get(
        '/employee/shift-offers',
        [ExtraShiftRequestController::class, 'employeeShiftOffers']
    )->name('employee.extra-shift-requests.offers');

    Route::post(
        '/employee/extra-shift-requests',
        [ExtraShiftRequestController::class, 'employeeStore']
    )->name('employee.extra-shift-requests.store');

    Route::post(
        '/employee/extra-shift-requests/{extraShiftRequest}/respond',
        [ExtraShiftRequestController::class, 'respond']
    )->name('employee.extra-shift-requests.respond');
});

/*
|--------------------------------------------------------------------------
| Test Email
|--------------------------------------------------------------------------
*/

Route::get('/test-email', function () {

    Mail::raw(
        'Test email from Otirasor Beach and Resort.',
        function ($message) {
            $message
                ->to('georgeflores352@gmail.com')
                ->subject('Otirasor Email Test');
        }
    );

    return 'Test email sent!';
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';