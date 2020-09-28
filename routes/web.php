<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*
	
	RUTAS DEL MODELO USUARIOS - LOGIN

*/

$router->post('api/login', [

	'middleware' => ['cors'],
	'as' => 'login.apiaudiophoneuser',
	'uses' => 'Apiaudiophonecontrollers\LoginAudiophoneUserController@loginApiaudiophoneUser'
]);

$router->post('api/login/refresh', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'login.apiaudiophoneuser',
	'uses' => 'Apiaudiophonecontrollers\LoginAudiophoneUserController@refreshTokenApiaudiophoneUser'
]);

$router->post('api/logout', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'logout.apiaudiophoneuser',
	'uses' => 'Apiaudiophonecontrollers\LoginAudiophoneUserController@logoutApiaudiophoneUser'
]);

//parametros opcionales para el show
$router->post('api/apiaudiophoneuser/show', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'user.show',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@showApiAudiophoneUser'
]);

$router->post('api/apiaudiophoneuser/store', [

	'middleware' => ['cors'],
	'as' => 'user.store',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@storeApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/update/{apiaudiophoneusers_id:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'user.update',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@updateApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/inactivate/{apiaudiophoneusers_id:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'user.inactivate',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@inactiveApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/activate/{apiaudiophoneusers_id:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'user.activate',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@activateApiAudiophoneUser'
]);

$router->delete('api/apiaudiophoneuser/destroy/{apiaudiophoneusers_id:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'user.destroy',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@destroyApiAudiophoneUser'
]);



/*
	
	RUTAS DEL MODELO DE TERMINO Y CONDICIONES

*/

$router->post('api/apiaudiophoneterm/show/{id_apiaudiophoneusers:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'/*,'expire.token'*/],
	'as' => 'term.show',
	'uses' => 'Apiaudiophonecontrollers\ApiAudioPhoneTermController@showApiAudiophoneTerm'
]);


$router->post('api/apiaudiophoneterm/store/{id_apiaudiophoneusers:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'term.store',
	'uses' => 'Apiaudiophonecontrollers\ApiAudioPhoneTermController@storeApiAudiophoneTerm'
]);



/*$router->post('api/apiaudiophoneuser/token/show/{id_apiaudiophoneusers:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'token.user.show',
	'uses' => 'Apiaudiophonecontrollers\ApiAudioPhoneTermController@showExpireTimeToken'
]);

$router->put('api/apiaudiophoneterm/update/{id_apiaudiophoneusers:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'term.update',
	'uses' => 'Apiaudiophonecontrollers\ApiAudioPhoneTermController@updateApiAudiophoneTerm'
]);



$router->delete('api/apiaudiophoneterm/destroy/{id_apiaudiophoneusers:[0-9]+}', [

	'middleware' => ['cors', 'client.credentials', 'auth:api'],
	'as' => 'term.destroy',
	'uses' => 'Apiaudiophonecontrollers\ApiAudioPhoneTermController@destroyApiAudiophoneTerm'
]);*/





