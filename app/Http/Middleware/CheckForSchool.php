<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForSchool
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(($user = auth()->user()) !== null){
            if($user->role_id == 3){
                if($user->school?->id){
                    if($request->routeIs('school.create')){
                        return redirect()->route('dashboard');
                    }
                    return $next($request);
                }else{
                    return redirect()->route('school.create')->with(["admin_id" => $user->id]);
                }
            }

            return $next($request);
        }
        return redirect()->route('index');
    }
}
