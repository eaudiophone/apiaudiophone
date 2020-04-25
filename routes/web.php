<?php

use App\Apiaudiophonemodels\ApiAudiophoneUser;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|


$router->get('/', function () use ($router) {
    return $router->app->version();
});

CREAR UN GRUPO DE RUTAS PARA CADA PERFIL DE USUARIO
APLICAR REGEX A PARAMETROS

*prueba obtención de usuario
$router->get('api/apiaudiophoneuser/show/{apiaudiophoneusers_id}', function($apiaudiophoneusers_id){

	return ApiAudiophoneUser::findOrFail($apiaudiophoneusers_id);
});

*/

$router->get('api/apiaudiophoneuser/show', [

	'as' => 'user.show',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@showApiAudiophoneUser'
]);

$router->post('api/apiaudiophoneuser/store', [

	'as' => 'user.store',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@storeApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/update/{apiaudiophoneusers_id:[0-9]+}', [

	'as' => 'user.update',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@updateApiAudiophoneUser'
]);

$router->delete('api/apiaudiophoneuser/destroy/{apiaudiophoneusers_id:[0-9]+}', [

	'as' => 'user.destroy',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@destroyApiAudiophoneUser'
]);





