<?php

namespace Leslie\Http\Middleware;

use Closure;
use Tracker;

class TrackSession
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
        Tracker::track();

        return $next($request);
    }
}
