<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\UserModelTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
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
        // secret key should be given
        $new_system = isset($request->setup_system) ? true : false;

        if($new_system){
            $this->verify_startup($request->admin_secret);
        }

        $email_required = "required";

        // exceptions for student role types
        $email_unique = "unique:".User::class;

        if($request->role_id == 5){
            $email_required = "nullable";
            $request->merge([
                "password" => "Password@1", "password_confirmation" => "Password@1"
            ]);
        }elseif($request->role_id == 4){
            $email_unique = "";
        }

        $email_check = $email_unique ?
                        [$email_required, 'string', 'lowercase', 'email', 'max:255', "unique:".User::class] :
                        [$email_required, 'string', 'lowercase', 'email', 'max:255'];

        $user = $request->validate([
            'username' => ['required', 'string', 'unique:'.User::class],
            'email' => $email_check,
            'role_id' => ['required', 'integer', Rule::exists("roles", "id")],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // create the user
        $user = new User($user);

        // based on user role determine which user data should be stored
        $this->store_user($request, $user);

        event(new Registered($user));

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
     * Used only once per system bootup
     * @param string $user_admin_secret The secret key provided
     */
    private function verify_startup(string $user_admin_secret){
        $admin_secret = password_hash(env('SYSTEM_SECRET'), PASSWORD_BCRYPT);
        if(password_verify($admin_secret, $user_admin_secret)){
            throw ValidationException::withMessages([
                "admin_secret" => "Invalid System Password provided"
            ]);
        }
    }

    /**
     * This function is used to determine which user type is selected
     */
    private function store_user(Request $request, User $user){
        // check for a developer
        $developer = User::where("role_id", 1)->get();
        if($developer->count() == 2 && $user->role_id == 1){
            return redirect()->back()->withErrors(['owner_error' => 'Current developer accounts cannot exceed 2']);
        }

        // make validation from specified user
        $user_class = $this->createController($request->role_id);
        $controller_request = $this->createStoreRequest($request->role_id, $request);

        $request->validate($controller_request->rules());

        // create the user
        $user->save();

        if($user->id){
            $controller_request->merge(["user_id" => $user->id]);
        }

        // call store for specified user
        return $user_class->store($controller_request);
    }
}
