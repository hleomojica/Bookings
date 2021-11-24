<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Bookable;
use App\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        //dd($request);
        $data = $request->validate([
            'bookings' => 'required|array|min:1',
            'bookings.*.bookable_id' => 'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.street' => 'required|min:3',
            'customer.city' => 'required|min:2',
            'customer.email' => 'required|min:2',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip' => 'required|min:2',
        ]);

        $addressData = $data['customer'];
       
        //  Second custom validation
        $data = array_merge($request->validate([
            'bookings.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    $bookable = Bookable::findOrFail($value['bookable_id']);
                    if (!$bookable->availableFor($value['from'],  $value['to'])) {
                        $fail("The Object is not available in given dates!");
                    }
                }
            ]
        ]));

        

        $bookingsData = $data['bookings'];
        

        //Laraver Helper for create collections from arrays 
        $bookings = collect($bookingsData)->map(function ($bookingsData) use ($addressData) {
            $bookable = Bookable::findOrFail($bookingsData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingsData['from'];
            $booking->to = $bookingsData['to'];
            $totalPrice =$bookable->priceFor($booking->from, $booking->to);

            //dd($totalPrice);
            $booking->price = $totalPrice['total'];
            

            $booking->bookable()->associate($bookable);

            $booking->address()->associate(Address::create($addressData));
            $booking ->save();
            return $booking;
        });

        return $bookings;
    }
}
