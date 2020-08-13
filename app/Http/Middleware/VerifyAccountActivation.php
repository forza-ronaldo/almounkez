<?php

namespace App\Http\Middleware;

use Closure;

class VerifyAccountActivation
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
        if(! auth()->user()->verified())
        {
            return redirect()->route('accountDisabled');
        }
        return $next($request);
    }
}
