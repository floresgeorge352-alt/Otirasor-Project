<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAccommodationController extends Controller
{
    public function index()
    {
        // Auto-revert sa "available" kapag tapos na ang maintenance_end date
        Accommodation::where('status', 'maintenance')
            ->whereNotNull('maintenance_end')
            ->where('maintenance_end', '<', now()->toDateString())
            ->update([
                'status' => 'available',
                'maintenance_start' => null,
                'maintenance_end' => null,
                'maintenance_reason' => null,
            ]);

        $accommodations = Accommodation::orderBy('type')->orderBy('name')->get();
        return view('admin.accommodations.index', compact('accommodations'));
    }

    public function create()
    {
        return view('admin.accommodations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:Room,Cottage,Function Hall'],
            'room_type' => ['nullable', 'in:day_use,overnight'],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'status' => ['required', 'in:available,unavailable,maintenance'],
            'maintenance_start' => ['nullable', 'date'],
            'maintenance_end' => ['nullable', 'date', 'after_or_equal:maintenance_start'],
            'maintenance_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('accommodations', 'public');
        }

        Accommodation::create([
            'name' => $request->name,
            'type' => $request->type,
            'room_type' => $request->room_type,
            'description' => $request->description,
            'amenities' => $request->filled('amenities')
                ? array_map('trim', explode(',', $request->amenities))
                : null,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'image' => $imagePath,
            'status' => $request->status,
            'maintenance_start' => $request->maintenance_start,
            'maintenance_end' => $request->maintenance_end,
            'maintenance_reason' => $request->maintenance_reason,
        ]);

        return redirect('/admin/accommodations')->with('success', 'Accommodation added successfully.');
    }

    public function show(Accommodation $accommodation)
    {
        return redirect('/admin/accommodations/' . $accommodation->id . '/edit');
    }

    public function edit(Accommodation $accommodation)
    {
        return view('admin.accommodations.edit', compact('accommodation'));
    }

    public function update(Request $request, Accommodation $accommodation)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:Room,Cottage,Function Hall'],
            'room_type' => ['nullable', 'in:day_use,overnight'],
            'description' => ['nullable', 'string'],
            'amenities' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', 'min:0'],
            'capacity' => ['required', 'integer', 'min:1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'status' => ['required', 'in:available,unavailable,maintenance'],
            'maintenance_start' => ['nullable', 'date'],
            'maintenance_end' => ['nullable', 'date', 'after_or_equal:maintenance_start'],
            'maintenance_reason' => ['nullable', 'string', 'max:255'],
        ]);

        $imagePath = $accommodation->image;

        if ($request->remove_image) {
            if ($accommodation->image && Storage::disk('public')->exists($accommodation->image)) {
                Storage::disk('public')->delete($accommodation->image);
            }
            $imagePath = null;
        } elseif ($request->hasFile('image')) {
            if ($accommodation->image && Storage::disk('public')->exists($accommodation->image)) {
                Storage::disk('public')->delete($accommodation->image);
            }
            $imagePath = $request->file('image')->store('accommodations', 'public');
        }

        $accommodation->update([
            'name' => $request->name,
            'type' => $request->type,
            'room_type' => $request->room_type,
            'description' => $request->description,
            'amenities' => $request->filled('amenities')
                ? array_map('trim', explode(',', $request->amenities))
                : null,
            'price' => $request->price,
            'capacity' => $request->capacity,
            'image' => $imagePath,
            'status' => $request->status,
            'maintenance_start' => $request->maintenance_start,
            'maintenance_end' => $request->maintenance_end,
            'maintenance_reason' => $request->maintenance_reason,
        ]);

        return redirect('/admin/accommodations')->with('success', 'Accommodation updated successfully.');
    }

    public function destroy(Accommodation $accommodation)
    {
        if ($accommodation->image && Storage::disk('public')->exists($accommodation->image)) {
            Storage::disk('public')->delete($accommodation->image);
        }

        $accommodation->delete();

        return redirect('/admin/accommodations')->with('success', 'Accommodation deleted successfully.');
    }
}