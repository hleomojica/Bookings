<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bookable;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$suffix=[
    'Villa',
    'House',
    'Cottage',
    'Luxury Villas',
    'Cheap hause',
    'Rooms',
    'Cheap Rooms',
    'Luxury Rooms',
    'Fany Rooms'
];

$factory->define(Bookable::class, function (Faker $faker) use ($suffix) {
    return [
        'tittle'=> $faker->city.' '. Arr::random($suffix),
        'description' => $faker->text(191)
    ];
});
