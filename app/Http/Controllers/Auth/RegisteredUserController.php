<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StoreotherRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\StoreTeacherRequest;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            "role_id" => 3,
            "page_title" => "Create an Account"
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role_id' => ['required', 'integer', Rule::exists("roles")],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // create the user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role_id' => $request->role_id,
            'password' => $request->password,
        ]);

        // based on user role determine which user data should be stored
        $this->store_user($request, $user);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * This function is used to determine which user type is selected
     */
    private function store_user(Request $request, User $user){
        // check for a developer
        $developer = User::where("role_id", 1)->first();
        if($developer && $user->role_id == 1){
            ddd(["message" => "System cannot have two owners"]);
        }

        switch($request->role_id){
            case 1:
            case 2:
            case 3:
                $user_class = new AdminController;
                $request = new StoreAdminRequest(request: $request->toArray());
                break;
            case 4:
                $user_class = new TeacherController;
                $request = new StoreTeacherRequest(request: $request->toArray());
                break;
            case 5:
                $user_class = new StudentController;
                $request = new StoreStudentRequest(request: $request->toArray());
                break;
            default:{
                $user_class = new OtherController;
                $request = new StoreotherRequest(request: $request->toArray());
            }

            // call store on each
            return $user_class->store($request, $user);
        }
    }
}
