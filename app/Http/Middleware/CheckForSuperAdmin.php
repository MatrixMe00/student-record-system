<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CheckForSuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if local file exists
        $file = Storage::disk(env("FILESYSTEM_DISK"))->exists('super.txt');
        $setup_route = url()->current() == url()->route('setup');

        if($file){
            // skip non get requests
            if(request()->method() != "GET"){
                return $next($request);
            }

            if(str_contains($file = Storage::disk(env("FILESYSTEM_DISK"))->get('super.txt'), 'system-ready')){
                $super = explode(":", $file);
                $super = trim($super[1]);

                if($super == "true"){
                    if ($setup_route) {
                        return redirect('/');
                    }
                    return $next($request);
                }else{
                    $has_super = User::where("role_id", "<=", 2)->where("id", "!=", 1)->exists();
                    if ($has_super) {
                        // write that the system is setup
                        Storage::disk(env("FILESYSTEM_DISK"))->put('super.txt', 'system-ready:true');

                        // Allow access to the requested route
                        return $next($request);
                    }
                }
            }else{
                Storage::disk(env('FILESYSTEM_DISK'))->put('super.txt', 'system-ready:false');
                http_response_code(404);
            }
        }else{
            Storage::disk(env('FILESYSTEM_DISK'))->put('super.txt', 'system-ready:false');
        }

        // If no user with role_id less than or equal to 2 exists
        // Redirect to the 'setup' route if the requested route is not 'setup'
        if (!$setup_route) {
            return redirect()->route('setup');
        }

        // If the requested route is 'setup', continue to the route
        return $next($request);
    }
}
