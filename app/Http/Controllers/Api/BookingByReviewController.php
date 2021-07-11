<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $id
     * @param Request $request
     * @return array|void
     */
    public function __invoke($id, Request $request)
    {
        $booking = Booking::findByReviewKey($id);
        return $booking ? $booking->toArray() : abort(404);
    }
}
