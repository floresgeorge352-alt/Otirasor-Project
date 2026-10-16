<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // =====================================================
        // BOOKING SUMMARY
        // =====================================================

        $totalBookings = Booking::count();

        $pendingBookings = Booking::where(
            'status',
            'Pending'
        )->count();

        $confirmedBookings = Booking::where(
            'status',
            'Confirmed'
        )->count();

        $rejectedBookings = Booking::where(
            'status',
            'Rejected'
        )->count();

        $cancelledBookings = Booking::where(
            'status',
            'Cancelled'
        )->count();


        // =====================================================
        // GUEST COUNT
        // =====================================================

        $totalGuests = Booking::whereIn(
            'status',
            ['Pending', 'Confirmed']
        )->sum('number_of_guests');


        // =====================================================
        // RECENT BOOKINGS
        // PENDING BOOKINGS ONLY
        // =====================================================

        $recentBookings = Booking::where(
            'status',
            'Pending'
        )
        ->latest()
        ->take(5)
        ->get();


        // =====================================================
        // ROOM SETTINGS
        // =====================================================

        $today = Carbon::today();

        $totalRooms = 8;


        // =====================================================
        // OCCUPIED ROOMS
        // =====================================================

        $occupiedRoomDetails = [];

        $activeRoomBookings = Booking::where(
            'status',
            'Confirmed'
        )
        ->where(
            'check_in',
            '<=',
            $today
        )
        ->where(
            'check_out',
            '>',
            $today
        )
        ->latest()
        ->get();


        foreach ($activeRoomBookings as $booking) {

            $accommodations = explode(
                ',',
                $booking->accommodations
            );


            foreach ($accommodations as $accommodation) {

                $accommodation = trim(
                    $accommodation
                );


                if (
                    str_starts_with(
                        $accommodation,
                        'Room '
                    )
                ) {

                    $occupiedRoomDetails[] = [

                        'room' =>
                            $accommodation,

                        'guest_name' =>
                            $booking->guest_name,

                        'check_in' =>
                            $booking->check_in,

                        'check_out' =>
                            $booking->check_out,

                        'status' =>
                            $booking->status,

                    ];
                }
            }
        }


        // =====================================================
        // RESERVED ROOMS
        // =====================================================

        $reservedRoomDetails = [];

        $futureRoomBookings = Booking::whereIn(
            'status',
            ['Pending', 'Confirmed']
        )
        ->where(
            'check_in',
            '>',
            $today
        )
        ->orderBy('check_in')
        ->get();


        foreach ($futureRoomBookings as $booking) {

            $accommodations = explode(
                ',',
                $booking->accommodations
            );


            foreach ($accommodations as $accommodation) {

                $accommodation = trim(
                    $accommodation
                );


                if (
                    str_starts_with(
                        $accommodation,
                        'Room '
                    )
                ) {

                    $reservedRoomDetails[] = [

                        'room' =>
                            $accommodation,

                        'guest_name' =>
                            $booking->guest_name,

                        'check_in' =>
                            $booking->check_in,

                        'check_out' =>
                            $booking->check_out,

                        'status' =>
                            $booking->status,

                    ];
                }
            }
        }


        // =====================================================
        // ROOM NAMES
        // =====================================================

        $occupiedRoomNames = [];

        foreach (
            $occupiedRoomDetails as $room
        ) {

            $occupiedRoomNames[] =
                $room['room'];
        }


        $reservedRoomNames = [];

        foreach (
            $reservedRoomDetails as $room
        ) {

            $reservedRoomNames[] =
                $room['room'];
        }


        // =====================================================
        // ROOM COUNTS
        // =====================================================

        $occupiedRooms = count(
            array_unique(
                $occupiedRoomNames
            )
        );


        $reservedRooms = count(
            array_unique(
                $reservedRoomNames
            )
        );


        // =====================================================
        // AVAILABLE ROOMS TODAY
        // =====================================================

        $availableRooms = [];

        for (
            $i = 1;
            $i <= $totalRooms;
            $i++
        ) {

            $roomName =
                'Room ' . $i;


            if (
                !in_array(
                    $roomName,
                    $occupiedRoomNames
                )
            ) {

                $availableRooms[] =
                    $roomName;
            }
        }


        // =====================================================
        // UNREAD NOTIFICATIONS
        // =====================================================

        $unreadNotificationsCount = auth()->user()
            ->unreadNotifications()
            ->count();


        // =====================================================
        // RETURN DASHBOARD
        // =====================================================

        return view(
            'admin.dashboard',
            compact(
                'totalBookings',
                'pendingBookings',
                'confirmedBookings',
                'rejectedBookings',
                'cancelledBookings',
                'totalGuests',
                'recentBookings',
                'totalRooms',
                'occupiedRooms',
                'reservedRooms',
                'availableRooms',
                'unreadNotificationsCount'
            )
        );
    }


    // =========================================================
    // RECENT BOOKINGS PAGE
    // =========================================================

    public function recentBookings()
    {
        $recentBookings = Booking::latest()
            ->take(5)
            ->get();


        return view(
            'admin.recent-bookings',
            compact('recentBookings')
        );
    }


    // =========================================================
    // ROOM BOOKING DETAILS PAGE
    // =========================================================

    public function roomBookingDetails()
    {
        $today = Carbon::today();


        // =====================================================
        // CURRENTLY OCCUPIED ROOMS
        // =====================================================

        $occupiedRoomDetails = [];

        $activeRoomBookings = Booking::where(
            'status',
            'Confirmed'
        )
        ->where(
            'check_in',
            '<=',
            $today
        )
        ->where(
            'check_out',
            '>',
            $today
        )
        ->orderBy('check_in')
        ->get();


        foreach ($activeRoomBookings as $booking) {

            $accommodations = explode(
                ',',
                $booking->accommodations
            );


            foreach ($accommodations as $accommodation) {

                $accommodation = trim(
                    $accommodation
                );


                if (
                    str_starts_with(
                        $accommodation,
                        'Room '
                    )
                ) {

                    $occupiedRoomDetails[] = [

                        'room' =>
                            $accommodation,

                        'guest_name' =>
                            $booking->guest_name,

                        'check_in' =>
                            $booking->check_in,

                        'check_out' =>
                            $booking->check_out,

                    ];
                }
            }
        }


        // =====================================================
        // UPCOMING ROOM RESERVATIONS
        // =====================================================

        $reservedRoomDetails = [];

        $futureRoomBookings = Booking::whereIn(
            'status',
            ['Pending', 'Confirmed']
        )
        ->where(
            'check_in',
            '>',
            $today
        )
        ->orderBy('check_in')
        ->get();


        foreach ($futureRoomBookings as $booking) {

            $accommodations = explode(
                ',',
                $booking->accommodations
            );


            foreach ($accommodations as $accommodation) {

                $accommodation = trim(
                    $accommodation
                );


                if (
                    str_starts_with(
                        $accommodation,
                        'Room '
                    )
                ) {

                    $reservedRoomDetails[] = [

                        'room' =>
                            $accommodation,

                        'guest_name' =>
                            $booking->guest_name,

                        'check_in' =>
                            $booking->check_in,

                        'check_out' =>
                            $booking->check_out,

                        'status' =>
                            $booking->status,

                    ];
                }
            }
        }


        // =====================================================
        // ROOM BOOKING DETAILS VIEW
        // =====================================================

        return view(
            'admin.room-booking-details',
            compact(
                'occupiedRoomDetails',
                'reservedRoomDetails'
            )
        );
    }


    // =========================================================
    // BOOKING OVERVIEW PAGE
    // =========================================================

    public function bookingOverview()
    {
        $totalBookings = Booking::count();


        $totalGuests = Booking::whereIn(
            'status',
            [
                'Pending',
                'Confirmed'
            ]
        )->sum('number_of_guests');


        $pendingBookings = Booking::where(
            'status',
            'Pending'
        )->count();


        $confirmedBookings = Booking::where(
            'status',
            'Confirmed'
        )->count();


        $rejectedBookings = Booking::where(
            'status',
            'Rejected'
        )->count();


        $cancelledBookings = Booking::where(
            'status',
            'Cancelled'
        )->count();


        return view(
            'admin.booking-overview',
            compact(
                'totalBookings',
                'totalGuests',
                'pendingBookings',
                'confirmedBookings',
                'rejectedBookings',
                'cancelledBookings'
            )
        );
    }


    // =========================================================
    // NOTIFICATIONS PAGE
    // =========================================================

    public function notifications()
    {
        $notifications = auth()->user()
            ->notifications()
            ->latest()
            ->get();


        return view(
            'admin.notifications',
            compact('notifications')
        );
    }


    // =========================================================
    // OPEN NOTIFICATION
    // =========================================================

    public function openNotification($notification)
    {
        // Find ONLY the notification belonging
        // to the currently logged-in admin

        $notification = auth()->user()
            ->notifications()
            ->findOrFail($notification);


        // Mark ONLY this clicked notification as read

        $notification->markAsRead();


        // Get the booking ID connected to the notification

        $bookingId =
            $notification->data['booking_id'] ?? null;


        // Redirect to the exact booking

        if ($bookingId) {

            return redirect(
                '/admin/bookings?booking_id=' . $bookingId
            );
        }


        // If there is no booking ID,
        // return to notifications page

        return redirect(
            '/admin/notifications'
        );
    }
}