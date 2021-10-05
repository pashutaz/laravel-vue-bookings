<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $id
     * @param Request $request
     * @return array
     */
    public function __invoke($id, Request $request): array
    {
        $booking = Booking::findByReviewKey($id);

        if (!$booking) {
            abort(404);
        }

        return $booking->toArray();
    }
}
