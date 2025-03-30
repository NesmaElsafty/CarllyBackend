<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkshopMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()) {
            // if (!auth()->user() || auth()->user()->usertype!=='workshop') {
            return response()->json([
                "status" => false,
                "message" => "Sorry, You cannot access this. Login as Workshop Provider",
            ], 401);
        }
        return $next($request);
    }
}
