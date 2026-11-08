<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminRoomController extends Controller
{
    public function getRoomData($search = null)
    {
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $allRooms = Accommodation::where('type', 'Room')->orderBy('name')->get();

        $occupiedRoomDetails = [];
        $reservedRoomDetails = [];
        $needsCleaningRooms = [];

        // CURRENTLY OCCUPIED ROOMS
        $activeBookingsQuery = Booking::whereIn('status', ['Confirmed', 'Checked In'])
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today);

        if ($search) {
            $activeBookingsQuery->where('guest_name', 'like', "%{$search}%");
        }

        $activeBookings = $activeBookingsQuery->latest()->get();

        foreach ($activeBookings as $booking) {
            $accommodations = $booking->accommodations()->get();
            if ($accommodations->isEmpty()) continue;

            foreach ($accommodations as $accommodation) {
                if ($accommodation->room_type === 'day_use' && $booking->check_in == $today && $now->hour >= 17) {
                    continue;
                }

                $occupiedRoomDetails[] = [
                    'room' => $accommodation->name,
                    'guest_name' => $booking->guest_name,
                    'check_in' => $booking->check_in,
                    'check_out' => $booking->check_out,
                    'status' => $booking->status,
                ];
            }
        }

        // FUTURE RESERVED ROOMS
        $futureBookingsQuery = Booking::whereIn('status', ['Pending', 'Confirmed'])
            ->where('check_in', '>', $today)
            ->orderBy('check_in');

        if ($search) {
            $futureBookingsQuery->where('guest_name', 'like', "%{$search}%");
        }

        $futureBookings = $futureBookingsQuery->get();

        foreach ($futureBookings as $booking) {
            $accommodations = $booking->accommodations()->get();
            if ($accommodations->isEmpty()) continue;

            foreach ($accommodations as $accommodation) {
                $reservedRoomDetails[] = [
                    'room' => $accommodation->name,
                    'guest_name' => $booking->guest_name,
                    'check_in' => $booking->check_in,
                    'check_out' => $booking->check_out,
                    'status' => $booking->status,
                ];
            }
        }

        // AVAILABLE & NEEDS CLEANING ROOMS
        $occupiedRoomNames = array_column($occupiedRoomDetails, 'room');
        $reservedRoomNames = array_column($reservedRoomDetails, 'room');

        $availableRooms = [];
        
        foreach ($allRooms as $room) {
            // Skip kung occupied o reserved
            if (in_array($room->name, $occupiedRoomNames) || in_array($room->name, $reservedRoomNames)) {
                continue;
            }

            if ($room->status === 'needs_cleaning') {
                $needsCleaningRooms[] = $room;
            } elseif ($room->status === 'available') {
                $availableRooms[] = $room;
            }
        }

        return [
            'availableRooms' => collect($availableRooms),
            'needsCleaningRooms' => collect($needsCleaningRooms),
            'occupiedRooms' => $occupiedRoomDetails,
            'reservedRooms' => $reservedRoomDetails,
        ];
    }

    public function available(Request $request)
    {
        $search = $request->query('search');
        $data = $this->getRoomData($search);
        $rooms = $data['availableRooms'];
        $page = $request->query('page', 1);
        $perPage = 10;

        $paginated = new LengthAwarePaginator(
            $rooms->forPage($page, $perPage),
            $rooms->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.rooms.status', [
            'title' => 'Available Rooms',
            'rooms' => $paginated,
            'type' => 'available',
            'search' => $search,
        ]);
    }

    public function needsCleaning(Request $request)
    {
        $search = $request->query('search');
        $data = $this->getRoomData($search);
        $rooms = $data['needsCleaningRooms'];
        $page = $request->query('page', 1);
        $perPage = 10;

        $paginated = new LengthAwarePaginator(
            $rooms->forPage($page, $perPage),
            $rooms->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.rooms.status', [
            'title' => 'Needs Cleaning',
            'rooms' => $paginated,
            'type' => 'needs_cleaning',
            'search' => $search,
        ]);
    }

    public function reserved(Request $request)
    {
        $search = $request->query('search');
        $data = $this->getRoomData($search);
        $rooms = collect($data['reservedRooms']);
        $page = $request->query('page', 1);
        $perPage = 10;

        $paginated = new LengthAwarePaginator(
            $rooms->forPage($page, $perPage),
            $rooms->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.rooms.status', [
            'title' => 'Reserved Rooms',
            'rooms' => $paginated,
            'type' => 'reserved',
            'search' => $search,
        ]);
    }

    public function occupied(Request $request)
    {
        $search = $request->query('search');
        $data = $this->getRoomData($search);
        $rooms = collect($data['occupiedRooms']);
        $page = $request->query('page', 1);
        $perPage = 10;

        $paginated = new LengthAwarePaginator(
            $rooms->forPage($page, $perPage),
            $rooms->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.rooms.status', [
            'title' => 'Occupied Rooms',
            'rooms' => $paginated,
            'type' => 'occupied',
            'search' => $search,
        ]);
    }

    public function status()
    {
        $data = $this->getRoomData();

        return view('admin.rooms.room-status', [
            'availableRooms' => $data['availableRooms'],
            'needsCleaningRooms' => $data['needsCleaningRooms'],
            'reservedRooms' => $data['reservedRooms'],
            'occupiedRooms' => $data['occupiedRooms'],
        ]);
    }

    public function markCleaned($id)
    {
        $room = Accommodation::findOrFail($id);

        if ($room->status === 'needs_cleaning') {
            $room->update(['status' => 'available']);

            \App\Events\DashboardStatsUpdated::dispatch();

            return back()->with('success', 'Room ' . $room->name . ' is now available.');
        }

        return back()->with('error', 'This room does not need cleaning.');
    }
}