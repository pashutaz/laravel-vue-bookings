<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookableController;
use App\Http\Controllers\Api\BookableAvailabilityController;
use App\Http\Controllers\Api\BookableReviewController;
use App\Http\Controllers\Api\ReviewController;

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

// Route::get('bookables', [BookableController::class, 'index']);
// Route::get('bookables/{id}', [BookableController::class, 'show']);
Route::apiResource('bookables', BookableController::class)->only(['index', 'show']);
Route::get('bookables/{bookable}/availability', BookableAvailabilityController::class)
    ->name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews', BookableReviewController::class)
    ->name('bookables.reviews.index');
Route::get('reviews/{id}', [ReviewController::class, 'show']);
