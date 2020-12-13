<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Apiaudiophonemodels\ApiAudiophoneItem;
use Faker\Generator as Faker;

$factory->define(ApiAudiophoneItem::class, function (Faker $faker) {
    return [
        
        'apiaudiophoneitems_name' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'apiaudiophoneitems_description' => $faker->sentences($nb = 1, $asText = true), 
        'apiaudiophoneitems_price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 1, $max = NULL)
    ];
});
