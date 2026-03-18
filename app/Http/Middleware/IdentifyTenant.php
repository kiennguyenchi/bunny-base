<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            // We bind the ID so the Trait can find it
            app()->singleton('tenant_id', function () {
                return auth()->user()->tenant_id;
            });
        }

        return $next($request);
    }
}
