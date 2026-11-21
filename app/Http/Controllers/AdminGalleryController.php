<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminGalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::latest();

        // Search across all gallery images
        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            if ($request->category === 'uncategorized') {
                $query->where(function ($q) {
                    $q->whereNull('category')
                      ->orWhere('category', '');
                });
            } else {
                $query->whereRaw(
                    'LOWER(category) = ?',
                    [strtolower($request->category)]
                );
            }
        }

        // Pagination
        $galleries = $query->paginate(8)->withQueryString();

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'html' => view(
                    'admin.gallery._grid',
                    compact('galleries')
                )->render(),

                'pagination' => $galleries->hasPages()
                    ? $galleries->links()->render()
                    : '',

                'count' => $galleries->total(),
            ]);
        }

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

        // Trigger Real-Time Event
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