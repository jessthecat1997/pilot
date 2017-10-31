<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class TruckingMiddleware
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
        $user = Auth::user();
        if($user == null)
        {
            return redirect('/login');
        } 
        else
        {
            if(Auth::guard($guard)->check() && Auth::user()->role_id == 3 || Auth::user()->role_id == 1){
                return $next($request);
            }
            else
                return redirect()->back();
        }
    }
}
