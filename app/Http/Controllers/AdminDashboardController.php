<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalBookings      = Booking::count();
        $pendingBookings    = Booking::where('status', 'Pending')->count();
        $confirmedBookings  = Booking::where('status', 'Confirmed')->count();
        $rejectedBookings   = Booking::where('status', 'Rejected')->count();
        $cancelledBookings  = Booking::where('status', 'Cancelled')->count();
        $checkedInBookings  = Booking::where('status', 'Checked In')->count();
        $checkedOutBookings = Booking::where('status', 'Checked Out')->count();
        $completedBookings  = Booking::where('status', 'Completed')->count();
        $noShowBookings     = Booking::where('status', 'No Show')->count();

        // BILANG PARA SA MGA BADGES
        $pendingRefundsCount = Booking::where('refund_status', 'Pending')->count();
        $pendingCancellationsCount = Booking::where('cancellation_status', 'Pending')->count();
        $pendingShiftRequestsCount = 0; // Extra Shift feature removed

        $totalGuests = Booking::whereIn('status', ['Pending', 'Confirmed', 'Checked In'])
            ->sum('number_of_guests');

        $recentBookings = Booking::where('status', 'Pending')
            ->latest()
            ->take(5)
            ->get();

        $today    = Carbon::today();
        $allRooms = Accommodation::where('type', 'Room')->orderBy('name')->pluck('name')->toArray();
        $totalRooms = count($allRooms);

        $occupiedRoomDetails = [];
        $activeRoomBookings = Booking::whereIn('status', ['Confirmed', 'Checked In'])
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->latest()
            ->get();

        foreach ($activeRoomBookings as $booking) {
            $accommodations = explode(',', $booking->accommodations);
            foreach ($accommodations as $accommodation) {
                $accommodation = trim($accommodation);
                if (str_starts_with($accommodation, 'Room ')) {
                    $occupiedRoomDetails[] = [
                        'room'       => $accommodation,
                        'guest_name' => $booking->guest_name,
                        'check_in'   => $booking->check_in,
                        'check_out'  => $booking->check_out,
                        'status'     => $booking->status,
                    ];
                }
            }
        }

        $reservedRoomDetails = [];
        $futureRoomBookings = Booking::whereIn('status', ['Pending', 'Confirmed'])
            ->where('check_in', '>', $today)
            ->orderBy('check_in')
            ->get();

        foreach ($futureRoomBookings as $booking) {
            $accommodations = explode(',', $booking->accommodations);
            foreach ($accommodations as $accommodation) {
                $accommodation = trim($accommodation);
                if (str_starts_with($accommodation, 'Room ')) {
                    $reservedRoomDetails[] = [
                        'room'       => $accommodation,
                        'guest_name' => $booking->guest_name,
                        'check_in'   => $booking->check_in,
                        'check_out'  => $booking->check_out,
                        'status'     => $booking->status,
                    ];
                }
            }
        }

        $occupiedRoomNames = [];
        foreach ($occupiedRoomDetails as $room) {
            $occupiedRoomNames[] = $room['room'];
        }

        $reservedRoomNames = [];
        foreach ($reservedRoomDetails as $room) {
            $reservedRoomNames[] = $room['room'];
        }

        $occupiedRooms = count(array_unique($occupiedRoomNames));
        $reservedRooms = count(array_unique($reservedRoomNames));

        $availableRooms = [];
        foreach ($allRooms as $roomName) {
            if (!in_array($roomName, $occupiedRoomNames, true)
                && !in_array($roomName, $reservedRoomNames, true)) {
                $availableRooms[] = $roomName;
            }
        }

        $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();

        \App\Events\DashboardStatsUpdated::dispatch();

        return view('admin.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'rejectedBookings',
            'cancelledBookings',
            'checkedInBookings',
            'checkedOutBookings',
            'completedBookings',
            'noShowBookings',
            'totalGuests',
            'recentBookings',
            'totalRooms',
            'occupiedRooms',
            'reservedRooms',
            'availableRooms',
            'unreadNotificationsCount',
            'pendingRefundsCount',
            'pendingCancellationsCount',
            'pendingShiftRequestsCount'
        ));
    }

    public function analytics(Request $request)
    {
        // Kunin ang year mula sa URL, default sa kasalukuyang taon
        $selectedYear = (int) $request->query('year', date('Y'));
        $search = trim($request->query('search', '')); // <-- IDINAGDAG PARA SA SEARCH

        $pendingBookings   = Booking::where('status', 'Pending')->count();
        $confirmedBookings = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed'])->count();
        $rejectedBookings  = Booking::where('status', 'Rejected')->count();
        $cancelledBookings = Booking::where('status', 'Cancelled')->count();

        $statusData = [
            'Pending'   => $pendingBookings,
            'Confirmed' => $confirmedBookings,
            'Rejected'  => $rejectedBookings,
            'Cancelled' => $cancelledBookings,
        ];

        $chartMonths          = [];
        $chartCounts          = [];
        $chartBookedRevenue   = [];
        $chartRealizedRevenue = [];
        $chartOccupancy       = [];

        $allRoomsCount = Accommodation::where('type', 'Room')->count();

        for ($i = 1; $i <= 12; $i++) {
            $chartMonths[] = date('M', mktime(0, 0, 0, $i, 1));

            $chartCounts[] = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed'])
                ->whereYear('check_in', $selectedYear)
                ->whereMonth('check_in', $i)
                ->count();

            // === FIXED: Gamit na ang net_total accessor (bawas discount) ===
            $bookedRevenueThisMonth = Booking::whereIn('status', ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Completed'])
                ->whereYear('check_in', $selectedYear)
                ->whereMonth('check_in', $i)
                ->get()
                ->sum(fn ($b) => $b->net_total);

            $chartBookedRevenue[] = (float) $bookedRevenueThisMonth;

            $realizedRevenueThisMonth = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed'])
                ->whereYear('check_in', $selectedYear)
                ->whereMonth('check_in', $i)
                ->get()
                ->sum(fn ($b) => $b->net_total);

            $chartRealizedRevenue[] = (float) $realizedRevenueThisMonth;
            // =================================================================

            // === FIXED: Occupancy = rooms booked / total rooms ===
            $occupiedRoomsThisMonth = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed'])
                ->whereYear('check_in', $selectedYear)
                ->whereMonth('check_in', $i)
                ->pluck('accommodations')
                ->flatMap(function ($accommodations) {
                    return collect(explode(',', $accommodations ?? ''))
                        ->map(fn ($name) => trim($name))
                        ->filter(fn ($name) => str_starts_with($name, 'Room '));
                })
                ->unique()
                ->count();

            $chartOccupancy[] = $allRoomsCount > 0
                ? round(($occupiedRoomsThisMonth / $allRoomsCount) * 100, 2)
                : 0;
            // ========================================================
        }

        $paymentMethodData = [
            'Cash'  => Booking::where('payment_method', 'Cash')->count(),
            'GCash' => Booking::where('payment_method', 'GCash')->count(),
        ];

        // === ATTENDANCE ANALYTICS (PER EMPLOYEE) ===
        $employeesQuery = \App\Models\User::where('role', 'employee')
            ->where('status', 'Active')
            ->orderBy('name');

        // I-filter ang employees base sa search
        if ($search !== '') {
            $employeesQuery->where('name', 'like', "%{$search}%");
        }

        $employees = $employeesQuery->get();

        $employeeStats = [];
        $totalLateMinutes = 0;
        $totalOvertimeMinutes = 0;
        $totalUndertimeMinutes = 0;
        $totalWorkedMinutes = 0;

        foreach ($employees as $employee) {
            $records = \App\Models\Attendance::where('user_id', $employee->id)
                ->whereYear('date', $selectedYear)
                ->get();

            $present = $records->whereNotNull('time_in')->count();
            $late = $records->filter(fn($r) => $r->late_minutes > 0)->count();
            $absent = $records->where('status', 'Absent')->count();
            
            $lateMins = (int) $records->sum('late_minutes');
            $otMins = (int) $records->sum('overtime_minutes');
            $utMins = (int) $records->sum('undertime_minutes');

            $workedMins = $records->filter(fn ($r) => $r->time_in && $r->time_out)
                ->sum(function ($r) {
                    return \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out));
                });

            // Accumulate totals for the top cards
            $totalLateMinutes += $lateMins;
            $totalOvertimeMinutes += $otMins;
            $totalUndertimeMinutes += $utMins;
            $totalWorkedMinutes += $workedMins;

            $employeeStats[] = [
                'name' => $employee->name,
                'present' => $present,
                'late_count' => $late,
                'absent_count' => $absent,
                'late_minutes' => $lateMins,
                'overtime_minutes' => $otMins,
                'undertime_minutes' => $utMins,
                'worked_hours' => round($workedMins / 60, 2),
            ];
        }

        // I-sort natin kung sino ang pinakamaraming late (descending)
        usort($employeeStats, fn($a, $b) => $b['late_minutes'] <=> $a['late_minutes']);

        $totalWorkedHours = round($totalWorkedMinutes / 60, 2);
        // =================================

        $unreadNotificationsCount = auth()->user()->unreadNotifications()->count();

        // === KUNG AJAX REQUEST, IBALIK LANG ANG TABLE PART ===
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.analytics._table', compact('employeeStats'))->render()
            ]);
        }

        return view('admin.analytics', compact(
            'statusData',
            'chartMonths',
            'chartCounts',
            'chartBookedRevenue',
            'chartRealizedRevenue',
            'chartOccupancy',
            'paymentMethodData',
            'unreadNotificationsCount',
            'selectedYear',
            'totalLateMinutes',
            'totalOvertimeMinutes',
            'totalUndertimeMinutes',
            'totalWorkedHours',
            'employeeStats',
            'search' // <-- Idinagdag para ma-maintain ang value sa search bar
        ));
    }

    public function printAnalytics(Request $request)
    {
        $selectedYear = (int) $request->query('year', date('Y'));
        $search = trim($request->query('search', ''));

        $employeesQuery = \App\Models\User::where('role', 'employee')
            ->where('status', 'Active')
            ->orderBy('name');

        if ($search !== '') {
            $employeesQuery->where('name', 'like', "%{$search}%");
        }

        $employees = $employeesQuery->get();
        $employeeStats = [];

        foreach ($employees as $employee) {
            $records = \App\Models\Attendance::where('user_id', $employee->id)
                ->whereYear('date', $selectedYear)
                ->get();

            $present = $records->whereNotNull('time_in')->count();
            $late = $records->filter(fn($r) => $r->late_minutes > 0)->count();
            $absent = $records->where('status', 'Absent')->count();
            
            $lateMins = (int) $records->sum('late_minutes');
            $otMins = (int) $records->sum('overtime_minutes');
            $utMins = (int) $records->sum('undertime_minutes');

            $workedMins = $records->filter(fn ($r) => $r->time_in && $r->time_out)
                ->sum(function ($r) {
                    return \Carbon\Carbon::parse($r->time_in)->diffInMinutes(\Carbon\Carbon::parse($r->time_out));
                });

            $employeeStats[] = [
                'name' => $employee->name,
                'present' => $present,
                'late_count' => $late,
                'absent_count' => $absent,
                'late_minutes' => $lateMins,
                'overtime_minutes' => $otMins,
                'undertime_minutes' => $utMins,
                'worked_hours' => round($workedMins / 60, 2),
            ];
        }

        usort($employeeStats, fn($a, $b) => $b['late_minutes'] <=> $a['late_minutes']);

        return view('admin.analytics.print', compact('employeeStats', 'selectedYear', 'search'));
    }

    public function recentBookings()
    {
        $recentBookings = Booking::latest()->take(5)->get();
        return view('admin.recent-bookings', compact('recentBookings'));
    }

    public function roomBookingDetails()
    {
        $today = Carbon::today();

        $occupiedRoomDetails = [];
        $activeRoomBookings = Booking::whereIn('status', ['Confirmed', 'Checked In'])
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->orderBy('check_in')
            ->get();

        foreach ($activeRoomBookings as $booking) {
            $accommodations = explode(',', $booking->accommodations);
            foreach ($accommodations as $accommodation) {
                $accommodation = trim($accommodation);
                if (str_starts_with($accommodation, 'Room ')) {
                    $occupiedRoomDetails[] = [
                        'room'       => $accommodation,
                        'guest_name' => $booking->guest_name,
                        'check_in'   => $booking->check_in,
                        'check_out'  => $booking->check_out,
                    ];
                }
            }
        }

        $reservedRoomDetails = [];
        $futureRoomBookings = Booking::whereIn('status', ['Pending', 'Confirmed'])
            ->where('check_in', '>', $today)
            ->orderBy('check_in')
            ->get();

        foreach ($futureRoomBookings as $booking) {
            $accommodations = explode(',', $booking->accommodations);
            foreach ($accommodations as $accommodation) {
                $accommodation = trim($accommodation);
                if (str_starts_with($accommodation, 'Room ')) {
                    $reservedRoomDetails[] = [
                        'room'       => $accommodation,
                        'guest_name' => $booking->guest_name,
                        'check_in'   => $booking->check_in,
                        'check_out'  => $booking->check_out,
                        'status'     => $booking->status,
                    ];
                }
            }
        }

        return view('admin.room-booking-details', compact('occupiedRoomDetails', 'reservedRoomDetails'));
    }

    public function bookingOverview()
    {
        $totalBookings     = Booking::count();
        $totalGuests       = Booking::whereIn('status', ['Pending', 'Confirmed', 'Checked In'])->sum('number_of_guests');
        $pendingBookings   = Booking::where('status', 'Pending')->count();
        $confirmedBookings = Booking::where('status', 'Confirmed')->count();
        $rejectedBookings  = Booking::where('status', 'Rejected')->count();
        $cancelledBookings = Booking::where('status', 'Cancelled')->count();

        return view('admin.booking-overview', compact(
            'totalBookings',
            'totalGuests',
            'pendingBookings',
            'confirmedBookings',
            'rejectedBookings',
            'cancelledBookings'
        ));
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return view('admin.notifications', compact('notifications'));
    }

    public function openNotification($notification)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        $bookingId = $notification->data['booking_id'] ?? null;
        if ($bookingId) {
            return redirect('/admin/bookings?booking_id=' . $bookingId);
        }

        return redirect('/admin/notifications');
    }
}