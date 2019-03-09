<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Service::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'description' => $faker->text,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip_code' => $faker->postcode,
        'lat' => $faker->latitude,
        'long' => $faker->latitude,
    ];
});
