<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(ApiAudiophoneUser::class, function (Faker $faker) {
    return [
        'apiaudiophoneusers_fullname' => $faker->name,
    	'apiaudiophoneusers_email' => $faker->unique()->freeEmail,
    	'apiaudiophoneusers_password' => app('hash')->make(Str::random(5)),
    	'apiaudiophoneusers_role' => $faker->randomElement(['USER_ROLE', 'ADMIN_ROLE'])
    ];
});