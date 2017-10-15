<?php

namespace App\Http\Middleware;
use Auth;

use Closure;

class BrokerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(Auth::guard($guard)->check() && Auth::user()->role_id == 2){
            return $next($request);
        }
        else
            return redirect()->back();
    }
}
