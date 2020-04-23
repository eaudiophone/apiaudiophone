<?php

use App\Apiaudiophonemodels\ApiAudiophoneUser;

class ApiAudioPhoneUserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     *
     * Anotacion para no colocar el prefijo tes en el nombre de las funciones.
     * @test
    */
    public function enviar_datos_de_usuario_desde_el_formulario_de_registro_en_formato_json()
    {
        //con el make() creas instancias de la clase pero no se graban en la base de datos, para grabar usas el create()
        $apiaudiophoneuserfactory = factory(ApiAudiophoneUser::class)->make();

        //envío del JSON vía post al controlador
        $requestjson = $this->json('post', route('user.store'), ['apiaudiophoneuserfactory' => $apiaudiophoneuserfactory]);

        /*
         * para poder validar que en realidad viaja el json, es necesario hacer un dd($request->all) del lado del controlador
         * en este caso la prueba fue satiscatoria.
        */
    }

    /**
     * A basic feature test example.
     *
     * @return void
     *
     * Anotacion para no colocar el prefijo tes en el nombre de las funciones.
     * @test
    */
    public function crear_apiaudiophoneuser()
    {

        /*
         * para que se logre la aserción el responde del controlador debe devolver lo que espera la prueba
         * en este caso es una prueba puntual, para pruebas dinamicas, usar postman
        */
        $this->json('post', route('user.store'), [
            'apiaudiophoneusers_fullname' => 'Alfonso Martinez',
            'apiaudiophoneusers_email' => 'a@a.com',
            'apiaudiophoneusers_password' => '123456'
        ])->seeJson([
            'ok' => true
        ]);
    }
}