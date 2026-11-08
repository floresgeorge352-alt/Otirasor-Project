<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RewardPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    // Customer: view points history at balance
    public function index()
    {
        $user = Auth::user();
        $balance = $user->reward_points ?? 0;

        $history = RewardPoint::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        // Total earned at redeemed
        $totalEarned = RewardPoint::where('user_id', $user->id)
            ->where('points', '>', 0)
            ->sum('points');

        $totalRedeemed = RewardPoint::where('user_id', $user->id)
            ->where('points', '<', 0)
            ->sum('points');

        return view('customer.rewards.index', compact('balance', 'history', 'totalEarned', 'totalRedeemed'));
    }

    // Customer: apply rewards sa checkout
    public function apply(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'Pending') {
            return back()->with('error', 'Rewards can only be applied to pending bookings.');
        }

        if ($booking->reward_points_used > 0) {
            return back()->with('error', 'Rewards already applied to this booking.');
        }

        $request->validate([
            'points_to_use' => 'required|integer|min:100|max:' . (Auth::user()->reward_points ?? 0),
        ]);

        $pointsToUse = (int) $request->points_to_use;
        $user = Auth::user();

        // Check if enough points
        if ($pointsToUse > ($user->reward_points ?? 0)) {
            return back()->with('error', 'You do not have enough reward points.');
        }

        // Conversion: 100 points = ₱5 (business rule)
        $rewardDiscount = ($pointsToUse / 100) * 5;

        DB::transaction(function () use ($booking, $user, $pointsToUse, $rewardDiscount) {
            // Deduct points
            $user->decrement('reward_points', $pointsToUse);

            // Update booking
            $booking->update([
                'reward_points_used' => $pointsToUse,
                'reward_discount' => $rewardDiscount,
            ]);

            // Log history
            RewardPoint::create([
                'user_id' => $user->id,
                'booking_id' => $booking->id,
                'points' => -$pointsToUse,
                'type' => 'redeemed_discount',
                'description' => 'Applied ₱' . number_format($rewardDiscount, 2) . ' discount to Booking #' . $booking->id,
            ]);
        });

        return back()->with('success', "Successfully applied {$pointsToUse} points (₱" . number_format($rewardDiscount, 2) . " discount).");
    }
}