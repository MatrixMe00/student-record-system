<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // allow only admins
        if(auth()->user()->role_id <= 3){
            return $next($request);
        }
        else{
            abort(403, 'You are not authorized to view this page');
        }
    }
}
