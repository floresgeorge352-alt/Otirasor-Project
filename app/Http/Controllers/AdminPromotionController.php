<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Illuminate\Http\Request;

class AdminPromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::latest()->get();
        return view('admin.promotions.index', compact('promotions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:promotions,code',
            'description' => 'nullable|string|max:255',
            'discount_percentage' => 'required|numeric|min:1|max:100',
            'valid_until' => 'required|date|after_or_equal:today',
        ]);

        Promotion::create([
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'valid_until' => $request->valid_until,
            'is_active' => true,
        ]);

        return back()->with('success', 'Promotion created successfully.');
    }

    public function toggle(Promotion $promotion)
    {
        $promotion->update(['is_active' => !$promotion->is_active]);
        $status = $promotion->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Promotion {$status} successfully.");
    }

    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return back()->with('success', 'Promotion deleted successfully.');
    }
}