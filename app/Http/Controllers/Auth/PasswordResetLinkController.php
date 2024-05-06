<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        // $is_student = request()->cookie("login_page") == "login";
        $is_student = request()->pl == 5;
        return view('auth.forgot-password', ["is_student" => $is_student]);
    }

    private function previous_route(){
        $previousUrl = url()->previous();
        if ($previousUrl) {
            $route = Route::getRoutes()->match(Request::create($previousUrl));
            if ($route) {
                $previousRouteName = $route->getName();
                return session(["login_page" => $previousRouteName]);

            } else {
                $previousRouteName = null;
            }
        }
        return $previousRouteName;
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }

    /**
     * Password reset for student
     */
    public function student(Request $request){
        $data = $request->validate([
            "username" => ["required", "string", Rule::exists("users", "username")->where("role_id", 5)],
            "password" => ["required", "confirmed", "min:8", "max:255"]
        ]);

        // after the validation, the user would always be found
        $user = User::where("username", $request->username)->first();
        $user->update($data);

        return redirect()->route('login')->with(["status" => "Password reset was successful"]);
    }
}
