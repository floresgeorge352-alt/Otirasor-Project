<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\RewardPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function store(Request $request, Booking $booking)
    {
        // 1. Check if the booking belongs to the user
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // 2. Check if booking is confirmed
        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'You can only review confirmed bookings.');
        }

        // 3. Check if already reviewed
        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        // 4. Validate the input
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        DB::transaction(function () use ($request, $booking) {
            // 5. Save the review
            $review = Review::create([
                'user_id' => Auth::id(),
                'booking_id' => $booking->id,
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);

            // I-trigger ang Real-Time Event
            \App\Events\ReviewCreated::dispatch($review);

            // 6. Add Reward Points to the user (5 points per review)
            $user = Auth::user();
            $user->increment('reward_points', 5);

            // 7. Log the points history para lumabas sa My Rewards page
            RewardPoint::create([
                'user_id' => $user->id,
                'booking_id' => $booking->id,
                'points' => 5,
                'type' => 'earned_review',
                'description' => 'Earned 5 points for reviewing Booking #' . $booking->id,
            ]);
        });

        return back()->with('success', 'Thank you for your review! You earned 5 reward points.');
    }
}