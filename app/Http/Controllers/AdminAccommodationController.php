<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminAccommodationController extends Controller
{
    public function index()
    {
        $accommodations = Accommodation::orderBy('type')
            ->orderBy('name')
            ->get();

        return view(
            'admin.accommodations.index',
            compact('accommodations')
        );
    }


    public function create()
    {
        return view('admin.accommodations.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:Room,Cottage,Function Hall',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'status' => [
                'required',
                'in:available,unavailable',
            ],
        ]);


        $imagePath = null;


        // UPLOAD PHOTO
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')
                ->store('accommodations', 'public');
        }


        Accommodation::create([
            'name' => $request->name,

            'type' => $request->type,

            'description' => $request->description,

            'price' => $request->price,

            'capacity' => $request->capacity,

            'image' => $imagePath,

            'status' => $request->status,
        ]);


        return redirect(
            '/admin/accommodations'
        )->with(
            'success',
            'Accommodation added successfully.'
        );
    }


    public function show(Accommodation $accommodation)
    {
        return redirect(
            '/admin/accommodations/' .
            $accommodation->id .
            '/edit'
        );
    }


    public function edit(Accommodation $accommodation)
    {
        return view(
            'admin.accommodations.edit',
            compact('accommodation')
        );
    }


    public function update(
        Request $request,
        Accommodation $accommodation
    ) {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'required',
                'in:Room,Cottage,Function Hall',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'capacity' => [
                'required',
                'integer',
                'min:1',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'status' => [
                'required',
                'in:available,unavailable',
            ],
        ]);


        // Keep current photo
        $imagePath = $accommodation->image;


        // =========================================
        // REMOVE CURRENT PHOTO
        // =========================================

        if ($request->remove_image) {

            if (
                $accommodation->image &&
                Storage::disk('public')->exists(
                    $accommodation->image
                )
            ) {
                Storage::disk('public')->delete(
                    $accommodation->image
                );
            }

            $imagePath = null;
        }


        // =========================================
        // UPLOAD NEW PHOTO
        // =========================================

        elseif ($request->hasFile('image')) {

            // Delete old photo first
            if (
                $accommodation->image &&
                Storage::disk('public')->exists(
                    $accommodation->image
                )
            ) {
                Storage::disk('public')->delete(
                    $accommodation->image
                );
            }


            // Save new photo
            $imagePath = $request->file('image')
                ->store('accommodations', 'public');
        }


        // =========================================
        // UPDATE ACCOMMODATION
        // =========================================

        $accommodation->update([
            'name' => $request->name,

            'type' => $request->type,

            'description' => $request->description,

            'price' => $request->price,

            'capacity' => $request->capacity,

            'image' => $imagePath,

            'status' => $request->status,
        ]);


        return redirect(
            '/admin/accommodations'
        )->with(
            'success',
            'Accommodation updated successfully.'
        );
    }


    public function destroy(
        Accommodation $accommodation
    ) {
        // Delete photo before deleting accommodation
        if (
            $accommodation->image &&
            Storage::disk('public')->exists(
                $accommodation->image
            )
        ) {
            Storage::disk('public')->delete(
                $accommodation->image
            );
        }


        // Delete accommodation
        $accommodation->delete();


        return redirect(
            '/admin/accommodations'
        )->with(
            'success',
            'Accommodation deleted successfully.'
        );
    }
}