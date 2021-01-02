<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Apiaudiophonemodels\ApiAudiophoneBudget;
use Faker\Generator as Faker;

$factory->define(ApiAudiophoneBudget::class, function (Faker $faker) {
    return [
        
        'id_apiaudiophoneusers' => $faker->randomDigit,
        'id_apiaudiophoneservices' => $faker->randomElement([1, 2]), 
        'apiaudiophonebudgets_nameservice' => $faker->randomElement(['alquiler', 'grabacion']),
        'apiaudiophonebudgets_client_name' => $faker->name,
        'apiaudiophonebudgets_client_email' => $faker->unique()->freeEmail,
        'apiaudiophonebudgets_client_phone' => $faker->tollFreePhoneNumber,
        'apiaudiophonebudgets_client_social' => 'IG: @foncho',
        'apiaudiophonebudgets_total_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = NULL) 
    ];
});
