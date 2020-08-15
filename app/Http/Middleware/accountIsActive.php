<?php

namespace App\Http\Middleware;

use Closure;

class accountIsActive
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
        if(auth()->user()->verified())
        {
            return  redirect(route('home'));
        }
        return $next($request);
    }
}
