<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class PublicReviewController extends Controller
{
    public function index(Request $request)
    {
        $ratingFilter = $request->query('rating');

        $query = Review::with(['user', 'booking']);

        if (in_array($ratingFilter, ['1', '2', '3', '4', '5'])) {
            $query->where('rating', $ratingFilter);
        }

        $reviews = $query->latest()->get();

        // Kunin ang average rating at total count para sa customers
        $averageRating = Review::avg('rating') ?? 0;
        $totalReviews = Review::count();

        // Bilangin ang bawat star para sa filter buttons
        $starCounts = [
            '5' => Review::where('rating', 5)->count(),
            '4' => Review::where('rating', 4)->count(),
            '3' => Review::where('rating', 3)->count(),
            '2' => Review::where('rating', 2)->count(),
            '1' => Review::where('rating', 1)->count(),
        ];

        return view('public-reviews', compact('reviews', 'ratingFilter', 'averageRating', 'totalReviews', 'starCounts'));
    }
}