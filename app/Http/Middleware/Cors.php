<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
            ->header('Access-Control-Allow-Origin', 'https://www.fyltravel.it:4200')
            ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS, FILES')
            ->header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept, Authorization, If-Modified-Since, Cache-Control, Pragma');

//            ->header('Access-Control-Allow-Origin: *')
//            ->header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS, FILES')
//            ->header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token')
//            ;
    }
}
