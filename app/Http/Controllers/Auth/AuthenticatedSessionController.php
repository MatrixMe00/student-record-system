<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Traits\UserModelTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    use UserModelTrait;

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            "page_title" => "Student Login",
            "role_id" => 5,
            "login_icon" => "fas fa-user-graduate"
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // create a cookie to hold the login name
        $response = $this->create_cookie();
        $cookie = $response->headers->getCookies()[0];

        // add the school id as a session
        $this->add_school_id();

        return redirect()->intended(RouteServiceProvider::HOME)->withCookie($cookie);
    }

    /**
     * Creates a school id session
     */
    private function add_school_id(){
        $model = $this->user_model(auth()->user());
        session(["school_id" => $model->school_id]);
    }

    /**
     * Create a cookie for the login page
     */
    private function create_cookie() :Response{
        $response = new Response('Login page captured');

        // delete cookie when the browser is closed
        $cookie = Cookie::make("login_page", $this->get_login_route());
        $response->cookie($cookie);

        return $response;
    }

    /**
     * Get the route name for the previous page
     */
    private function get_login_route() :string|null{
        // Get the URL of the referring page
        $refererUrl = url()->previous();

        // Get the route name corresponding to the URL
        $refererRouteName = Route::getRoutes()->match(
            request()->create($refererUrl, 'GET')
        )->getName();

        return $refererRouteName;
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $login_page = $request->cookie('login_page');

        if($login_page && Route::has($login_page)){
            return redirect()->route($login_page);
        }

        return redirect('/');
    }
}
