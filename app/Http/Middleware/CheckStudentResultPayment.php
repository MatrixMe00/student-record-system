<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentResultPayment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if user is student
        if(Auth::user()?->role_id == 5){
            // check result payment status
            if(!session('payment_result')){
                return redirect()->route('payment.create', ["type" => "results"]);
            }
        }
        return $next($request);
    }
}
