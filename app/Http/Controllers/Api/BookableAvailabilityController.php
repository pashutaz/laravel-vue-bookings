<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Bookable;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke($id, Request $request): JsonResponse
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:today',
            'to'   => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        $bookable = Bookable::findOrFail($id);

        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json(['msg' => 'Available'])
            : response()->json(['mgs' => 'Not available'], 404);
    }
}
