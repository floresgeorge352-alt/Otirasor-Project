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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminGalleryController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PublicReviewController;
use App\Http\Controllers\AdminPromotionController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\ReservationHoldController;
use App\Http\Controllers\EmployeeNotificationController;
use App\Http\Controllers\AdminBackupController;
use App\Http\Controllers\TwoFactorController;
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
| Real-time Availability & Reservation Holds
|--------------------------------------------------------------------------
*/

Route::get('/api/availability', [AvailabilityController::class, 'index'])
    ->name('api.availability');

Route::post('/reservation-holds', [ReservationHoldController::class, 'store'])
    ->name('reservation-holds.store');

Route::delete('/reservation-holds/{hold}', [ReservationHoldController::class, 'release'])
    ->name('reservation-holds.release');

// === BAGONG ROUTE PARA SA ACTIVE HOLD ===
Route::get('/api/active-hold', function () {
    $hold = \App\Models\ReservationHold::active()
        ->where('session_id', session()->getId())
        ->latest()
        ->first();

    if ($hold) {
        return response()->json([
            'active' => true,
            'hold' => [
                'id' => $hold->id,
                'expires_at' => $hold->expires_at->toIso8601String(),
                'accommodation_ids' => $hold->accommodation_ids,
            ]
        ]);
    }

    return response()->json(['active' => false]);
})->name('api.active-hold');
// =========================================

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

    Route::get('/check-promo', [BookingController::class, 'checkPromo']);

    Route::get(
        '/booking/confirmation/{booking}',
        [BookingController::class, 'confirmation']
    )->name('booking.confirmation');

    Route::get('/my-bookings', [CustomerBookingController::class, 'index']);

    Route::get('/my-requests', [\App\Http\Controllers\CustomerRequestController::class, 'index'])->name('customer.requests');

    Route::get('/my-rewards', [\App\Http\Controllers\RewardController::class, 'index'])->name('customer.rewards.index');
    Route::post('/my-bookings/{booking}/apply-rewards', [\App\Http\Controllers\RewardController::class, 'apply'])->name('customer.rewards.apply');

    // === CANCELLATION REQUEST ===
    Route::post(
        '/my-bookings/{booking}/request-cancellation',
        [CustomerBookingController::class, 'requestCancellation']
    )->name('customer.bookings.request-cancellation');
    // =============================

    Route::get(
        '/my-bookings/{booking}/receipt',
        [BookingController::class, 'receipt']
    );

    Route::get(
        '/my-bookings/{booking}/invoice',
        [BookingController::class, 'invoice']
    );

    Route::post(
        '/my-bookings/{booking}/request-refund',
        [CustomerBookingController::class, 'requestRefund']
    )->name('customer.bookings.request-refund');

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
| Customer Dashboard (WITH ROLE REDIRECT FIX)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect('/admin/dashboard');
    }
    if (auth()->check() && auth()->user()->role === 'employee') {
        return redirect('/employee/dashboard');
    }
    
    return view('customer.dashboard'); 
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

    // === TWO-FACTOR AUTHENTICATION ===
    Route::get('/profile/two-factor', [TwoFactorController::class, 'index'])->name('two-factor.show');
    Route::post('/profile/two-factor/enable', [TwoFactorController::class, 'enable'])->name('two-factor.enable');
    Route::post('/profile/two-factor/confirm', [TwoFactorController::class, 'confirm'])->name('two-factor.confirm');
    Route::post('/profile/two-factor/recovery-codes', [TwoFactorController::class, 'regenerateRecoveryCodes'])->name('two-factor.regenerate-codes');
    Route::post('/profile/two-factor/disable', [TwoFactorController::class, 'disable'])->name('two-factor.disable');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get(
        '/admin/dashboard',
        [AdminDashboardController::class, 'index']
    )->name('admin.dashboard');

    Route::get(
        '/admin/analytics',
        [AdminDashboardController::class, 'analytics']
    )->name('admin.analytics');

    Route::get(
        '/admin/analytics/print',
        [AdminDashboardController::class, 'printAnalytics']
    )->name('admin.analytics.print');

    Route::get('/admin/audit-logs', [\App\Http\Controllers\AdminAuditLogController::class, 'index'])->name('admin.audit-logs');

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
        '/admin/weekly-schedule',
        [AdminDashboardController::class, 'weeklySchedule']
    )->name('admin.weekly-schedule');

    Route::get(
        '/admin/notifications',
        [AdminDashboardController::class, 'notifications']
    );

    Route::get(
        '/admin/notifications/{notification}/open',
        [AdminDashboardController::class, 'openNotification']
    );

    // === MARK ALL AS READ ===
    Route::post('/admin/notifications/mark-all-read', [AdminDashboardController::class, 'markAllAsRead'])->name('admin.notifications.mark-all-read');
    // ==================================

    Route::get(
        '/admin/reports',
        [AdminReportController::class, 'index']
    );

    // === PROMOTIONS ===
    Route::get('/admin/promotions', [AdminPromotionController::class, 'index']);
    Route::post('/admin/promotions', [AdminPromotionController::class, 'store']);
    Route::post('/admin/promotions/{promotion}/toggle', [AdminPromotionController::class, 'toggle']);
    Route::delete('/admin/promotions/{promotion}', [AdminPromotionController::class, 'destroy']);

    // === PROMOTIONS TRASH ===
    Route::get('/admin/promotions-trash', [AdminPromotionController::class, 'trash'])->name('admin.promotions.trash');
    Route::post('/admin/promotions/{id}/restore', [AdminPromotionController::class, 'restore'])->name('admin.promotions.restore');
    Route::delete('/admin/promotions/{id}/force-delete', [AdminPromotionController::class, 'forceDelete'])->name('admin.promotions.force-delete');
    // ========================

    Route::get('/admin/transactions', [\App\Http\Controllers\AdminTransactionController::class, 'index'])->name('admin.transactions');
    Route::get('/admin/transactions/export', [\App\Http\Controllers\AdminTransactionController::class, 'exportCsv'])->name('admin.transactions.export');
    Route::get('/admin/transactions/export-pdf', [\App\Http\Controllers\AdminTransactionController::class, 'exportPdf'])->name('admin.transactions.export-pdf');

    Route::get('/admin/refund-history', [\App\Http\Controllers\AdminRefundController::class, 'index'])->name('admin.refunds.history');

    Route::get('/admin/rewards', [\App\Http\Controllers\AdminRewardController::class, 'index'])->name('admin.rewards.index');
    Route::post('/admin/rewards/{user}/adjust', [\App\Http\Controllers\AdminRewardController::class, 'adjust'])->name('admin.rewards.adjust');
    Route::get('/admin/rewards/{user}/history', [\App\Http\Controllers\AdminRewardController::class, 'history'])->name('admin.rewards.history');

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

    // === ACCOMMODATIONS + SOFT DELETE ===
    Route::resource(
        '/admin/accommodations',
        AdminAccommodationController::class
    );

    Route::get('/admin/accommodations-trash', [AdminAccommodationController::class, 'trash'])->name('admin.accommodations.trash');
    Route::post('/admin/accommodations/{id}/restore', [AdminAccommodationController::class, 'restore'])->name('admin.accommodations.restore');
    Route::delete('/admin/accommodations/{id}/force-delete', [AdminAccommodationController::class, 'forceDelete'])->name('admin.accommodations.force-delete');
    // =====================================

    // === BOOKINGS ===
    Route::get(
        '/admin/bookings',
        [AdminBookingController::class, 'index']
    );

    Route::get('/admin/bookings/export-csv', [AdminBookingController::class, 'exportCsv'])->name('admin.bookings.export-csv');
    Route::get('/admin/bookings/export-pdf', [AdminBookingController::class, 'exportPdf'])->name('admin.bookings.export-pdf');

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
        [AdminBookingController::class, 'approveCancellation']
    )->name('admin.bookings.approve-cancellation');

    Route::post(
        '/admin/bookings/{booking}/reject-cancellation',
        [AdminBookingController::class, 'rejectCancellation']
    )->name('admin.bookings.reject-cancellation');

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

    Route::post(
        '/admin/bookings/{booking}/approve-refund',
        [AdminBookingController::class, 'approveRefund']
    )->name('admin.bookings.approve-refund');

    Route::post(
        '/admin/bookings/{booking}/reject-refund',
        [AdminBookingController::class, 'rejectRefund']
    )->name('admin.bookings.reject-refund');

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
        '/admin/employees/search',
        [AdminEmployeeController::class, 'search']
    )->name('admin.employees.search');

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

    Route::get('/admin/attendance/search-summary', [AdminAttendanceController::class, 'searchSummary'])->name('admin.attendance.search-summary');
    Route::get('/admin/attendance/search-daily', [AdminAttendanceController::class, 'searchDaily'])->name('admin.attendance.search-daily');

    Route::get('/admin/backups', [AdminBackupController::class, 'index'])->name('admin.backups.index');
    Route::post('/admin/backups', [AdminBackupController::class, 'create'])->name('admin.backups.create');
    Route::get('/admin/backups/{backup}/download', [AdminBackupController::class, 'download'])->name('admin.backups.download');
    Route::post('/admin/backups/{backup}/restore', [AdminBackupController::class, 'restore'])->name('admin.backups.restore');
    Route::delete('/admin/backups/{backup}', [AdminBackupController::class, 'destroy'])->name('admin.backups.destroy');
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

Route::middleware(['auth', 'role:employee'])->group(function () {

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
        '/employee/notifications',
        [EmployeeNotificationController::class, 'notifications']
    )->name('employee.notifications');

    Route::get(
        '/employee/notifications/{notification}/open',
        [EmployeeNotificationController::class, 'openNotification']
    );
});

/*
|--------------------------------------------------------------------------
| Custom 2FA Challenge Routes
|--------------------------------------------------------------------------
*/

Route::get('/two-factor-challenge', function () {
    return view('auth.two-factor-challenge');
})->middleware('guest')->name('two-factor.login');

Route::post('/two-factor-challenge', function (\Illuminate\Http\Request $request) {
    $userId = $request->session()->get('login.id');
    $user = \App\Models\User::find($userId);

    if (!$user) {
        return redirect('/login');
    }

    // 1. KUNG MAY RECOVERY CODE
    if ($request->filled('recovery_code')) {
        $request->validate(['recovery_code' => 'required']);
        
        $recoveryCode = $request->input('recovery_code');
        
        if (in_array($recoveryCode, $user->recoveryCodes())) {
            $user->replaceRecoveryCode($recoveryCode);
            
            auth()->login($user);
            $request->session()->forget('login.id');
            
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'employee') {
                return redirect('/employee/dashboard');
            }
            return redirect('/dashboard');
        }
        
        return back()->withErrors(['recovery_code' => 'Invalid recovery code.']);
    }

    // 2. KUNG AUTHENTICATOR CODE ANG GINAMIT
    $request->validate(['code' => 'required']);
    
    $google2fa = new \PragmaRX\Google2FA\Google2FA();
    $secret = decrypt($user->two_factor_secret);
    
    if ($google2fa->verifyKey($secret, $request->code)) {
        auth()->login($user);
        $request->session()->forget('login.id');
        
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'employee') {
            return redirect('/employee/dashboard');
        }
        return redirect('/dashboard');
    }

    return back()->withErrors(['code' => 'The provided two factor authentication code was invalid.']);
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';