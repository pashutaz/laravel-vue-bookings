<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function __invoke(Request $request): Response
    {
        $validated = $request->validate([
            'price' => 'required|numeric',
            'from' => 'required|date_format:Y-m-d',
            'to'   => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        $pricePerDay = $validated['price'];
        $from = new Carbon($validated['from']);
        $to = new Carbon($validated['to']);
        $totalDays = $from->diffInDays($to) + 1;

        return new Response([
            'data' => [
                'total' => round($totalDays * $pricePerDay, 2),
                'breakdown' => [
                    $pricePerDay => $totalDays
                ]
            ]
        ]);
    }
}
