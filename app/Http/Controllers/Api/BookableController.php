<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Bookable;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;

class BookableController extends Controller
{
    public function index()
    {
        return BookableIndexResource::collection(Bookable::all());
    }

    public function show($bookableId)
    {
        return new BookableShowResource(Bookable::findOrFail($bookableId));
    }
}
