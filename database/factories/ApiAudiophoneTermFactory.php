<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Apiaudiophonemodels\ApiAudiophoneTerm;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(ApiAudiophoneTerm::class, function (Faker $faker) {
    return [
        
    	'id_apiaudiophoneusers' => $faker->randomDigit,
    	'apiaudiophoneterms_quantityeventsweekly' => $faker->randomDigit,
    	'apiaudiophoneterms_quantityeventsmonthly' => $faker->randomDigit,
    	'apiaudiophoneterms_rankevents' => $faker->text($maxNbChars = 20),
    	//originalmente el words manda un arreglo, pero se configuró para que mandara un string
    	'apiaudiophoneterms_daysevents' => $faker->words($nb = 7, $asText = false),
    	'apiaudiophoneterms_begintime' => $faker->time($format = 'H:i', $max = 'now'),
    	'apiaudiophoneterms_finaltime' => $faker->time($format = 'H:i', $max = 'now')
    ];
});
