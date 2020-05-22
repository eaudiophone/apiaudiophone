<?php

//use App\Apiaudiophonemodels\ApiAudiophoneUser;
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
	[/{paginationstart:[0-9]+}][/{paginationend:[0-9]+}]
});



$router->group(['middleware' => 'auth'], function () use ($router){
		::::: INCLUIR DENTRO LAS RUTAS PARA USUARIOS AUTORIZADOS O AUTENTICADOS
});
ejemplo de utilizar middlewares en grupo de rutas
$router->group(['middleware' => ['auth', 'client.credentials']], function () use ($router){

	$router->post('api/apiaudiophoneuser/show', [

		'as' => 'user.show',
		'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@showApiAudiophoneUser'
	]);
});*/

//parametros opcionales para el show
$router->post('api/apiaudiophoneuser/show', [

	//'middleware' => 'client.credentials', //para probar la obtencion de recursos vía client crredentials y funciona
	'middleware' => 'auth:api',
	'as' => 'user.show',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@showApiAudiophoneUser'
]);


/*$router->post('api/apiaudiophoneuser/show', [

	'as' => 'user.show',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@showApiAudiophoneUser'
]);*/

$router->post('api/apiaudiophoneuser/store', [

	'as' => 'user.store',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@storeApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/update/{apiaudiophoneusers_id:[0-9]+}', [

	'as' => 'user.update',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@updateApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/inactivate/{apiaudiophoneusers_id:[0-9]+}', [

	'as' => 'user.inactivate',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@inactiveApiAudiophoneUser'
]);

$router->put('api/apiaudiophoneuser/activate/{apiaudiophoneusers_id:[0-9]+}', [

	'as' => 'user.activate',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@activateApiAudiophoneUser'
]);

$router->delete('api/apiaudiophoneuser/destroy/{apiaudiophoneusers_id:[0-9]+}', [

	'as' => 'user.destroy',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@destroyApiAudiophoneUser'
]);

/*Ruta personalizada de la app para la obtencion de Tokens
$router->post('api/oauth/token', [

	'uses' => '\Dusterio\LumenPassport\Http\Controllers\AccessTokenController@issueToken'
]);*/





