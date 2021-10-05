<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableReviewIndexResource;
use App\Models\Bookable;

class BookableReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param $id
     * @param Request $request
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);

        return BookableReviewIndexResource::collection(
            $bookable->reviews()->latest()->orderBy('rating', 'desc')->get()
        );
    }
}
