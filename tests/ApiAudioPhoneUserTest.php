<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Apiaudiophonemodels\ApiAudiophoneUser;
use Illuminate\Support\Str;

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

        $parametros = [

            'apiaudiophoneusers_fullname' => /*'Nombre de prueba'*/,
            'apiaudiophoneusers_email' => /*'enail@prueba.com'*/,
            'apiaudiophoneusers_password' => app('hash')->make(Str::random(5))
        ];

        $this->post('api/apiaudiophoneuser/store', $parametros);

        $this->seeInDatabase('apiaudiophoneusers', [

            'apiaudiophoneusers_fullname' => /*'Nombre de prueba'*/,
            'apiaudiophoneusers_email' => /*'email@prueba.com'*/
        ]);
    }
}
