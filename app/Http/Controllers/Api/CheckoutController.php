<?php

namespace App\Http\Controllers\Api;

use App\Models\{Booking, Bookable};
use App\Http\Controllers\Controller;
use Illuminate\Http\{Request, Response};

class CheckoutController extends Controller
{
    /**
     * Handle the shopping cart checkout request
     *
     * @param  Request  $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $userData = $request->validate([
            'email'   => 'required|email',
            'name'    => 'required|string',
            'phone'   => 'required|string|min:5|max:11',
            'country' => 'min:2',
        ]);
        $bookingsData = current($request->validate([
            'bookings'               => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|numeric',
            'bookings.*.from'        => 'required|date|after:today',
            'bookings.*.to'          => 'required|date|after:bookings.*.from',
        ]));

        $bookings = collect($bookingsData)->map(function(array $item) {
            $from = $item['from'];
            $to   = $item['to'];
            $bookable = Bookable::findOrFail($item['bookable_id']);

            if ($bookable->availableFor($from, $to)) {
                $totalCost = $bookable->calcPriceFor($from, $to)['total'];

                return Booking::create([
                    'from'        => $from,
                    'to'          => $to,
                    'bookable_id' => $bookable->getKey(),
                    'cost'        => $totalCost
                ]);
            }

            throw new \Exception('Not available');
        });

        return response($bookings);
    }
}
