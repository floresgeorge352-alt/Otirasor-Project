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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublicReviewController;
use App\Http\Controllers\AdminPromotionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/contact', function () {
    return view('contact');
});

/*
|--------------------------------------------------------------------------
| Public Gallery & Reviews (Customer Side)
|--------------------------------------------------------------------------
*/

Route::get('/gallery', [GalleryController::class, 'publicIndex'])->name('public.gallery');
Route::get('/reviews', [PublicReviewController::class, 'index'])->name('public.reviews');

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

    // === NEW: Promo Code Check Route ===
    Route::get('/check-promo', [BookingController::class, 'checkPromo']);
    // ===================================

    Route::get(
        '/booking/confirmation/{booking}',
        [BookingController::class, 'confirmation']
    )->name('booking.confirmation');

    Route::get('/my-bookings', [CustomerBookingController::class, 'index']);

    // === NEW: My Requests Page ===
    Route::get('/my-requests', [\App\Http\Controllers\CustomerRequestController::class, 'index'])->name('customer.requests');
    // =============================

    // === REWARDS (CUSTOMER) ===
    Route::get('/my-rewards', [\App\Http\Controllers\RewardController::class, 'index'])->name('customer.rewards.index');
    Route::post('/my-bookings/{booking}/apply-rewards', [\App\Http\Controllers\RewardController::class, 'apply'])->name('customer.rewards.apply');
    // =========================

    Route::post(
        '/my-bookings/{booking}/cancel',
        [CustomerBookingController::class, 'cancel']
    );

    Route::get(
        '/my-bookings/{booking}/receipt',
        [BookingController::class, 'receipt']
    );

    Route::get(
        '/my-bookings/{booking}/invoice',
        [BookingController::class, 'invoice']
    );

    Route::post(
        '/my-bookings/{booking}/request-cancellation',
        [BookingController::class, 'requestCancellation']
    );

    // === NEW: Refund Request Route ===
    Route::post(
        '/my-bookings/{booking}/request-refund',
        [CustomerBookingController::class, 'requestRefund']
    )->name('customer.bookings.request-refund');
    // =================================

    Route::post(
        '/my-bookings/{booking}/review',
        [ReviewController::class, 'store']
    )->name('reviews.store');

    Route::get(
        '/notifications',
        [CustomerBookingController::class, 'notifications']
    )->name('customer.notifications');

    Route::get(
        '/notifications/{notification}/open',
        [CustomerBookingController::class, 'openNotification']
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

    Route::get(
        '/admin/analytics',
        [AdminDashboardController::class, 'analytics']
    )->name('admin.analytics');

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

    // === BAGONG PROMOTION ROUTES ===
    Route::get('/admin/promotions', [AdminPromotionController::class, 'index']);
    Route::post('/admin/promotions', [AdminPromotionController::class, 'store']);
    Route::post('/admin/promotions/{promotion}/toggle', [AdminPromotionController::class, 'toggle']);
    Route::delete('/admin/promotions/{promotion}', [AdminPromotionController::class, 'destroy']);
    // ===============================

    // === TRANSACTION RECORDS ===
    Route::get('/admin/transactions', [\App\Http\Controllers\AdminTransactionController::class, 'index'])->name('admin.transactions');
    Route::get('/admin/transactions/export', [\App\Http\Controllers\AdminTransactionController::class, 'exportCsv'])->name('admin.transactions.export');
    Route::get('/admin/transactions/export-pdf', [\App\Http\Controllers\AdminTransactionController::class, 'exportPdf'])->name('admin.transactions.export-pdf');
    // ===========================

    // === REWARDS (ADMIN) ===
    Route::get('/admin/rewards', [\App\Http\Controllers\AdminRewardController::class, 'index'])->name('admin.rewards.index');
    Route::post('/admin/rewards/{user}/adjust', [\App\Http\Controllers\AdminRewardController::class, 'adjust'])->name('admin.rewards.adjust');
    Route::get('/admin/rewards/{user}/history', [\App\Http\Controllers\AdminRewardController::class, 'history'])->name('admin.rewards.history');
    // ======================

    Route::get(
        '/admin/payments',
        [AdminReportController::class, 'payments']
    )->name('admin.payments');

    Route::get(
        '/admin/reviews',
        [AdminReportController::class, 'reviews']
    )->name('admin.reviews');

    Route::get(
        '/admin/gallery',
        [AdminGalleryController::class, 'index']
    )->name('admin.gallery.index');

    Route::post(
        '/admin/gallery',
        [AdminGalleryController::class, 'store']
    )->name('admin.gallery.store');

    Route::delete(
        '/admin/gallery/{gallery}',
        [AdminGalleryController::class, 'destroy']
    )->name('admin.gallery.destroy');

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

    // =========================================================
    // CANCELLATION APPROVAL (FIXED — now on AdminBookingController)
    // =========================================================
    Route::post(
        '/admin/bookings/{booking}/approve-cancellation',
        [AdminBookingController::class, 'approveCancellation']
    )->name('admin.bookings.approve-cancellation');

    Route::post(
        '/admin/bookings/{booking}/reject-cancellation',
        [AdminBookingController::class, 'rejectCancellation']
    )->name('admin.bookings.reject-cancellation');
    // =========================================================

    Route::post(
        '/admin/bookings/{booking}/verify-payment',
        [AdminBookingController::class, 'verifyPayment']
    );

    Route::post(
        '/admin/bookings/{booking}/reject-payment',
        [AdminBookingController::class, 'rejectPayment']
    );

    Route::post(
        '/admin/bookings/{booking}/refund',
        [AdminBookingController::class, 'refund']
    )->name('admin.bookings.refund');

    // === NEW: ADMIN REFUND APPROVAL ROUTES ===
    Route::post(
        '/admin/bookings/{booking}/approve-refund',
        [AdminBookingController::class, 'approveRefund']
    )->name('admin.bookings.approve-refund');

    Route::post(
        '/admin/bookings/{booking}/reject-refund',
        [AdminBookingController::class, 'rejectRefund']
    )->name('admin.bookings.reject-refund');
    // ==========================================

    Route::post(
        '/admin/bookings/{booking}/check-in',
        [AdminBookingController::class, 'checkIn']
    )->name('admin.bookings.checkIn');

    Route::post(
        '/admin/bookings/{booking}/check-out',
        [AdminBookingController::class, 'checkOut']
    )->name('admin.bookings.checkOut');

    Route::post(
        '/admin/bookings/{booking}/mark-cleaned',
        [AdminBookingController::class, 'markCleaned']
    )->name('admin.bookings.markCleaned');

    Route::post(
        '/admin/bookings/{booking}/complete',
        [AdminBookingController::class, 'complete']
    )->name('admin.bookings.complete');

    Route::post(
        '/admin/bookings/{booking}/no-show',
        [AdminBookingController::class, 'noShow']
    )->name('admin.bookings.noShow');

    Route::get(
        '/admin/rooms/available',
        [AdminRoomController::class, 'available']
    );

    Route::get(
        '/admin/rooms/needs-cleaning',
        [AdminRoomController::class, 'needsCleaning']
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

    Route::post(
        '/admin/room/{room}/mark-cleaned',
        [AdminRoomController::class, 'markCleaned']
    )->name('admin.rooms.mark-cleaned');

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

    Route::get(
        '/admin/attendance',
        [AdminAttendanceController::class, 'index']
    )->name('admin.attendance.index');

    Route::get(
        '/admin/attendance/download-csv',
        [AdminAttendanceController::class, 'downloadCsv']
    )->name('admin.attendance.download-csv');

    Route::get(
        '/admin/attendance/download-pdf',
        [AdminAttendanceController::class, 'downloadPdf']
    )->name('admin.attendance.download-pdf');

    // === ADMIN CORRECTION ROUTES ===
    Route::get(
        '/admin/attendance/corrections',
        [AdminAttendanceController::class, 'corrections']
    )->name('admin.attendance.corrections');

    Route::post(
        '/admin/attendance/corrections/{correction}/approve',
        [AdminAttendanceController::class, 'approveCorrection']
    )->name('admin.attendance.corrections.approve');

    Route::post(
        '/admin/attendance/corrections/{correction}/reject',
        [AdminAttendanceController::class, 'rejectCorrection']
    )->name('admin.attendance.corrections.reject');

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
        '/employee/my-attendance',
        [AttendanceController::class, 'myAttendance']
    )->name('employee.my-attendance');

    Route::get(
        '/employee/my-attendance/download-csv',
        [AttendanceController::class, 'downloadMyCsv']
    )->name('employee.my-attendance.download-csv');

    Route::post(
        '/employee/my-attendance/correction',
        [AttendanceController::class, 'storeCorrection']
    )->name('employee.my-attendance.correction');

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

    Route::get(
        '/employee/notifications',
        [ExtraShiftRequestController::class, 'notifications']
    )->name('employee.notifications');

    Route::get(
        '/employee/notifications/{notification}/open',
        [ExtraShiftRequestController::class, 'openNotification']
    );
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';