<?php

namespace App\Http\Controllers;

use App\Models\RewardPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminRewardController extends Controller
{
    // Admin: list all customer rewards
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $query = User::where('role', 'customer')
            ->where('reward_points', '>', 0)
            ->orderByDesc('reward_points');

        if ($search !== '') {
            $query->where('name', 'like', "%{$search}%");
        }

        $customers = $query->paginate(15)->withQueryString();

        // Stats
        $totalPointsIssued = RewardPoint::where('points', '>', 0)->sum('points');
        $totalPointsRedeemed = abs(RewardPoint::where('points', '<', 0)->sum('points'));
        $activeCustomers = User::where('role', 'customer')->where('reward_points', '>', 0)->count();

        return view('admin.rewards.index', compact(
            'customers', 'search', 'totalPointsIssued', 'totalPointsRedeemed', 'activeCustomers'
        ));
    }

    // Admin: adjust points manually
    public function adjust(Request $request, User $user)
    {
        $request->validate([
            'points' => 'required|integer',
            'reason' => 'required|string|max:500',
        ]);

        $points = (int) $request->points;

        DB::transaction(function () use ($user, $points, $request) {
            $user->increment('reward_points', $points);

            RewardPoint::create([
                'user_id' => $user->id,
                'points' => $points,
                'type' => $points > 0 ? 'admin_bonus' : 'admin_deduction',
                'description' => $request->reason,
            ]);
        });

        $action = $points > 0 ? 'added' : 'deducted';
        return back()->with('success', "Successfully {$action} " . abs($points) . " points.");
    }

    // Admin: view history ng isang user
    public function history(User $user)
    {
        $history = RewardPoint::where('user_id', $user->id)->latest()->paginate(20);
        return view('admin.rewards.history', compact('user', 'history'));
    }
}