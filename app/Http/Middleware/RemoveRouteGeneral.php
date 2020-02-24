<?php

namespace App\Http\Middleware;

use Closure;

class RemoveRouteGeneral
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
        return abort(404);
    }
}
