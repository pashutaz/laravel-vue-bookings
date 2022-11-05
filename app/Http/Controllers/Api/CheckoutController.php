<?php

namespace App\Http\Controllers\Api;

use App\Models\{Booking, Bookable};
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request): Response
    {
        $userData = $request->validate([
            'email'   => 'required|email',
            'name'    => 'required|string',
            'address' => 'required|min:5',
            'zip'     => 'number|min:5|max:6',
            'county'  => 'min:2',
            'city'    => 'min:3',
        ]);
        $bookingsData = $request->validate([
            'bookings'               => 'required|array|min:1',
            'bookings.*.bookable-id' => 'required|string',
            'bookings.*.from'        => 'required|date|after:today',
            'bookings.*.to'          => 'required|date|after:bookings.*.from',
        ]);

        $bookings = collect($bookingsData)->map(function($bookingData) use ($userData) {
            $from = $bookingData['from'];
            $to   = $bookingData['to'];
            $bookable = Bookable::findOrFail($bookingData['bookable-id']);
            $bookable->availableFor($from, $to);

            return Booking::create([
                'from'        => $from,
                'to'          => $to,
                'bookable_id' => $bookable->id,
                'price'       => $bookable->calcPriceFor($from, $to)
            ]);
        });

        return response($bookings);
    }
}
