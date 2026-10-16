<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;

class AdminRoomController extends Controller
{
    public function getRoomData()
    {
        $today = Carbon::today();

        $totalRooms = 8;

        $occupiedRoomDetails = [];

        $reservedRoomDetails = [];


        /*
        |--------------------------------------------------------------------------
        | CURRENTLY OCCUPIED ROOMS
        |--------------------------------------------------------------------------
        */

        $activeBookings = Booking::where(
                'status',
                'Confirmed'
            )
            ->where('check_in', '<=', $today)
            ->where('check_out', '>', $today)
            ->latest()
            ->get();


        foreach ($activeBookings as $booking) {

            $accommodations = explode(
                ',',
                $booking->accommodations
            );


            foreach ($accommodations as $accommodation) {

                $accommodation = trim($accommodation);


                if (str_starts_with($accommodation, 'Room ')) {

                    $occupiedRoomDetails[] = [
                        'room' => $accommodation,
                        'guest_name' => $booking->guest_name,
                        'check_in' => $booking->check_in,
                        'check_out' => $booking->check_out,
                        'status' => $booking->status,
                    ];
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FUTURE RESERVED ROOMS
        |--------------------------------------------------------------------------
        */

        $futureBookings = Booking::whereIn(
                'status',
                ['Pending', 'Confirmed']
            )
            ->where('check_in', '>', $today)
            ->orderBy('check_in')
            ->get();


        foreach ($futureBookings as $booking) {

            $accommodations = explode(
                ',',
                $booking->accommodations
            );


            foreach ($accommodations as $accommodation) {

                $accommodation = trim($accommodation);


                if (str_starts_with($accommodation, 'Room ')) {

                    $reservedRoomDetails[] = [
                        'room' => $accommodation,
                        'guest_name' => $booking->guest_name,
                        'check_in' => $booking->check_in,
                        'check_out' => $booking->check_out,
                        'status' => $booking->status,
                    ];
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | AVAILABLE ROOMS
        |--------------------------------------------------------------------------
        */

        $occupiedRoomNames = [];


        foreach ($occupiedRoomDetails as $room) {

            $occupiedRoomNames[] = $room['room'];
        }


        $availableRooms = [];


        for ($i = 1; $i <= $totalRooms; $i++) {

            $roomName = 'Room ' . $i;


            if (!in_array(
                $roomName,
                $occupiedRoomNames
            )) {

                $availableRooms[] = $roomName;
            }
        }


        return [
            'availableRooms' => $availableRooms,
            'occupiedRooms' => $occupiedRoomDetails,
            'reservedRooms' => $reservedRoomDetails,
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | AVAILABLE ROOMS
    |--------------------------------------------------------------------------
    */

    public function available()
    {
        $data = $this->getRoomData();

        return view(
            'admin.rooms.status',
            [
                'title' => 'Available Rooms',
                'rooms' => $data['availableRooms'],
                'type' => 'available',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RESERVED ROOMS
    |--------------------------------------------------------------------------
    */

    public function reserved()
    {
        $data = $this->getRoomData();

        return view(
            'admin.rooms.status',
            [
                'title' => 'Reserved Rooms',
                'rooms' => $data['reservedRooms'],
                'type' => 'reserved',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | OCCUPIED ROOMS
    |--------------------------------------------------------------------------
    */

    public function occupied()
    {
        $data = $this->getRoomData();

        return view(
            'admin.rooms.status',
            [
                'title' => 'Occupied Rooms',
                'rooms' => $data['occupiedRooms'],
                'type' => 'occupied',
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ROOM STATUS SUMMARY
    |--------------------------------------------------------------------------
    */

    public function status()
    {
        $data = $this->getRoomData();

        return view(
            'admin.rooms.room-status',
            [
                'availableRooms' => $data['availableRooms'],
                'reservedRooms' => $data['reservedRooms'],
                'occupiedRooms' => $data['occupiedRooms'],
            ]
        );
    }
}