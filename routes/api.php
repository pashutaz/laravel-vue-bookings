<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    BookableController,
    BookableAvailabilityController,
    BookablePriceController,
    BookableReviewController,
    BookingByReviewController,
    ReviewController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'bookables'], function () {
    // Route::get('bookables', [BookableController::class, 'index']);
    // Route::get('bookables/{id}', [BookableController::class, 'show']);
    Route::get('/price', BookablePriceController::class);
    Route::get('/{bookable}/availability', BookableAvailabilityController::class)->name('bookables.availability.show');
    Route::get('/{bookable}/reviews', BookableReviewController::class)->name('bookables.reviews.index');
});
Route::apiResource('bookables', BookableController::class)->only(['index', 'show']);

Route::resource('reviews', ReviewController::class)->only(['show', 'store']);
Route::get('booking-by-review/{id}', BookingByReviewController::class)->name('booking.by-review.show');
