<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Apiaudiophonemodels\ApiAudiophoneUser;

class ApiaudiophoneUserTest extends TestCase
{
    /**
     * Verificar usuario en la base de datos.
     *
     * @return void
     * @test
     */
    public function create_user_in_apiaudiophoneuesr_table()
    {

    	/*$apiaudiophoneuser = factory(ApiAudiophoneUser::class)->make([

    		'apiaudiophoneusers_fullname' => $faker->name,
    		'apiaudiophoneusers_email' => $faker->unique()->freeEmail,
    		'apiaudiophoneusers_password' => app('hash')->make(Str::random(5))
    	]);

    	dd($apiaudiophoneuser);*/


    	//$response = $this->call('POST', 'user.show', ['stringsearch' => 'a@a.com']); 

    	//$this->assertEquals(200, $response->status());

    	//$this->seeInDatabase('apiaudiophoneusers', ['apiaudiophoneusers_email' => 'a@a.com']);
    }
}
