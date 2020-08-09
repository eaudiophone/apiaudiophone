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

/*Ruta personalizada de la app para la obtencion de Tokens
$router->post('api/oauth/token', [

	'middleware' => [ 'cors'],
	'as' => 'api.token',
	'uses' => '\Dusterio\LumenPassport\Http\Controllers\AccessTokenController@issueToken'
]);*/




