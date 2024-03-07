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
use App\Models\User;
use App\Traits\UserModelTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    use UserModelTrait;

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
        $email_required = $request->role_id == 5 ? "nullable" : "required";
        $user = $request->validate([
            'username' => ['required', 'string', 'unique:'.User::class],
            'email' => [$email_required, 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'role_id' => ['required', 'integer', Rule::exists("roles", "id")],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // create the user
        // $user = User::create($user);
        $user = new User($user);

        // based on user role determine which user data should be stored
        $this->store_user($request, $user);

        event(new Registered($user));

        $new_system = isset($request->setup_system) ? true : false;
        $new_school = isset($request->new_school) ? true : false;
        $non_submit = isset($request->non_submit) ? true : false;

        if($non_submit){
            return redirect()->route('users.all');
        }elseif(intval($user->role_id) == 2 && $new_system){
            return redirect('/');
        }elseif(intval($user->role_id) == 3 && $new_school){
            return redirect()->route("school.create")->with(["admin_id" => $user->id, "ignore_school_check" => true]);
        }else{
            return redirect()->back(200);
        }
    }

    /**
     * This function is used to determine which user type is selected
     */
    private function store_user(Request $request, User $user){
        // check for a developer
        $developer = User::where("role_id", 1)->exists();
        if($developer && $user->role_id == 1){
            return redirect()->back()->withErrors(['owner_error' => 'System cannot have two owners']);
        }

        // create the user
        $user->save();

        if($user->id){
            $request->merge(["user_id" => $user->id]);
        }

        $user_class = $this->createController($request->role_id);
        $controller_request = $this->createStoreRequest($request->role_id, $request);

        // call store on each
        return $user_class->store($controller_request);
    }
}
