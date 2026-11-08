<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function publicIndex()
    {
        $galleries = Gallery::latest()->get();
        
        // Kunin lahat ng unique categories na may images
        $categories = Gallery::select('category')->distinct()->pluck('category');

        return view('gallery', compact('galleries', 'categories'));
    }
}