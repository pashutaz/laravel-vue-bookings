<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function show($id)
    {
        return Review::findOrFail($id)->only(['created_at', 'rating', 'content']);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'id' => 'required|size:36|unique:reviews',
            'content' => 'required|min:3',
            'rating' => 'required|in:1,2,3,4,5'
        ]);

        $booking = Booking::findByReviewKey($validated['id']);

        if ($booking === null) {
            abort(404);
        }

        $booking->review_key = null;
        $booking->save();

        $review = Review::make($validated);
        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return $review->only(['created_at', 'rating', 'content']);
    }
}
