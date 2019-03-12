<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Service::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'country' => $faker->country,
        'zip_code' => $faker->postcode,
        'location' => [
            'lat' => $faker->latitude,
            'lng' => $faker->latitude
        ]
    ];
});
