<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\FeeHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminFeeController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'all'); // all | entrance | swimming

        $query = Fee::query()->orderBy('type')->orderBy('applies_to');

        if (in_array($type, ['entrance', 'swimming'], true)) {
            $query->where('type', $type);
        }

        $fees = $query->get();

        return view('admin.fees.index', compact('fees', 'type'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'type'       => 'required|in:entrance,swimming',
            'applies_to' => 'required|in:adult,child,all',
            'amount'     => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated) {
            $fee = Fee::create($validated + ['is_active' => true]);

            FeeHistory::create([
                'fee_id'     => $fee->id,
                'user_id'    => auth()->id(),
                'action'     => 'created',
                'old_amount' => null,
                'new_amount' => $fee->amount,
                'changes'    => $fee->only(['name', 'type', 'applies_to', 'amount']),
                'ip_address' => request()->ip(),
            ]);
        });

        return back()->with('success', 'Fee added successfully.');
    }

    public function update(Request $request, Fee $fee)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'type'       => 'required|in:entrance,swimming',
            'applies_to' => 'required|in:adult,child,all',
            'amount'     => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($fee, $validated) {
            $old = $fee->only(['name', 'type', 'applies_to', 'amount']);
            $oldAmount = $fee->amount;

            $fee->update($validated);

            FeeHistory::create([
                'fee_id'     => $fee->id,
                'user_id'    => auth()->id(),
                'action'     => 'updated',
                'old_amount' => $oldAmount,
                'new_amount' => $fee->amount,
                'changes'    => [
                    'old' => $old,
                    'new' => $fee->only(['name', 'type', 'applies_to', 'amount']),
                ],
                'ip_address' => request()->ip(),
            ]);
        });

        return back()->with('success', 'Fee updated successfully.');
    }

    public function toggle(Fee $fee)
    {
        DB::transaction(function () use ($fee) {
            $fee->update(['is_active' => ! $fee->is_active]);

            FeeHistory::create([
                'fee_id'     => $fee->id,
                'user_id'    => auth()->id(),
                'action'     => 'toggled',
                'old_amount' => $fee->amount,
                'new_amount' => $fee->amount,
                'changes'    => ['is_active' => $fee->is_active],
                'ip_address' => request()->ip(),
            ]);
        });

        return back()->with('success', 'Fee status updated.');
    }

    public function destroy(Fee $fee)
    {
        DB::transaction(function () use ($fee) {
            FeeHistory::create([
                'fee_id'     => $fee->id,
                'user_id'    => auth()->id(),
                'action'     => 'deleted',
                'old_amount' => $fee->amount,
                'new_amount' => null,
                'changes'    => $fee->only(['name', 'type', 'applies_to', 'amount']),
                'ip_address' => request()->ip(),
            ]);

            $fee->delete();
        });

        return back()->with('success', 'Fee deleted successfully.');
    }

    public function history(Request $request)
    {
        $search = trim($request->query('search', ''));

        $query = FeeHistory::with(['fee', 'user'])->latest();

        if ($search !== '') {
            $query->whereHas('fee', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $histories = $query->paginate(20)->withQueryString();

        return view('admin.fees.history', compact('histories', 'search'));
    }
}