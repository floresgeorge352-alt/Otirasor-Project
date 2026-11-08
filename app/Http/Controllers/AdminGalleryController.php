<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'title' => 'nullable|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('gallery', 'public');

        $gallery = Gallery::create([
            'title' => $request->title,
            'image_path' => $imagePath,
            'category' => $request->category,
        ]);

        // I-trigger ang Real-Time Event
        \App\Events\GalleryImageAdded::dispatch($gallery);

        return back()->with('success', 'Image uploaded successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        if (Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}