<?php

namespace App\Http\Middleware\ApiaudiophoneMiddlewares;

use Closure;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
        //url de origen para peticion al server
        ->header('Accesc-Control-Allow-Origin', 'http://localhost:3000/')
        //métodos http provenientes del origin server
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
        //headers permitidos en la peticion CORS
        ->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, X-Token-Auth, Authorization, Accept')
        //header para especificar que lo que recibe y debe decodificar es un json
        ->header('content-type: application/json; charset=utf-8');
    }
}