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
        $audiophoneuserfactory = factory(ApiAudiophoneUser::class)->make();

        //envío del JSON vía post al controlador
        $requestjson = $this->json('post', route('user.store'), ['apiaudiophoneuser' => $audiophoneuserfactory]);
    }
}