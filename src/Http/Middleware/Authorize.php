<?php

namespace EagleDevelopers\NovaRouteViewer\Http\Middleware;

use EagleDevelopers\NovaRouteViewer\RouteViewer;

class Authorize
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, $next)
    {
        return resolve(RouteViewer::class)->authorize($request) ? $next($request) : abort(403);
    }
}
