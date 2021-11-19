<?php

use App\Bookable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Ui\Presets\React;
use PhpParser\Builder\Function_;

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

//Route::get('bookables','Api\BookableController@index');
//Route::get('bookables/{id}','Api\BookableController@show');

Route::apiResource('bookables','Api\BookableController')->only(['index','show']);
//-- Is colling the Single controller just one action (invoke)
Route::get('bookables/{bookable}/availability','Api\BookableAvailabilityController') -> name('bookables.availability.show');
Route::get('bookables/{bookable}/reviews','Api\BookableReviewController')->name('bookables.reviews.index');

Route::get('bookables/{bookable}/price', 'Api\BookablePriceController')->name('bookables.price.show');

Route::apiResource('reviews','Api\ReviewController')->only(['show','store']);

Route::get('booking-by-review/{reviewKey}','Api\BookingByReviewController')->name('booking.by-review.show');



