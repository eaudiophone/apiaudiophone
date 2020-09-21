<?php

namespace App\Http\Middleware\ApiaudiophoneMiddlewares;

use App\Apiaudiophonemodels\ApiAudiophoneUser;
use Laravel\Passport\PersonalAccessTokenResult;
use Carbon\Carbon;
use Closure;

class ExpireTokenMiddleware
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
        // Pre-Middleware Action

        $response = $next($request);

        // Post-Middleware Action

        return $response;
    }
}
