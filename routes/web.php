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


$router->get('/', function () use ($router) {
    return $router->app->version();
});

*/

//$router->post('/apiaudiophoneuser/store', 'Apiaudiophonecontrollers\ApiAudiophoneUserController@storeApiAudiophoneUser');

$router->post('/apiaudiophoneuser/store', [

	'as' => 'user.store',
	'uses' => 'Apiaudiophonecontrollers\ApiAudiophoneUserController@storeApiAudiophoneUser'
]);

/*$router->post('/apiaudiophoneuser/store', function (Illuminate\Http\Request $request)
{
    if ($request->isJson()) {
        $data = $request->json()->all();
    } else {
        $data = $request->all();
    }

    dd($data);
});*/

