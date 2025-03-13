<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HRMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if(!$request->user() || !$request->user()->hasRole('hr'))
        {
            return response() -> json([
                'status' => false,
                'message' => "You don't have permission to access this resource",
                'data' => []
            ], 403);
        }

        return $next($request);
    }
}
