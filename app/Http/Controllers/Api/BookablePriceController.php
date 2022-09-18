<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Bookable;

class BookablePriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  string   $id
     * @param  Request  $request
     * @return Response
     * 
     * @throws \Exception
     */
    public function __invoke($id, Request $request): Response
    {
        $validated = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to'   => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        $bookable = Bookable::findOrFail($id);

        return new Response([
            'data' => $bookable->calcPriceFor(
                $validated['from'], 
                $validated['to']
            )
        ]);
    }
}
