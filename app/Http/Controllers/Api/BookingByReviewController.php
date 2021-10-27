<?php

namespace App\Http\Controllers\Api;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewBookableShowResource;
use Illuminate\Http\Request;

class BookingByReviewController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($revireKey,Request $request)
    {
        return new BookingByReviewBookableShowResource(Booking::findByReview($revireKey))??abort(404);
    }
}
