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
                if(!is_null($user->school()) && $user->school->id){
                    if($request->routeIs('school.create')){
                        return redirect()->route('dashboard');
                    }
                }else{
                    if(!$request->routeIs('school.create')){
                        return redirect()->route('school.create')->with(["admin_id" => $user->id]);
                    }
                }
            }

            return $next($request);
        }elseif(session('ignore_school_check')){
            return $next($request);
        }

        // move to homepage if there is no user login or form submission
        return redirect()->route('index');
    }
}
