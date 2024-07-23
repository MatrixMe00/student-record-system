<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\deletedusers;
use App\Models\other;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\UserModelTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use UserModelTrait;

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            "model" => $this->user_model($request->user())
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->role_id != 5 && $request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // update corresponding model
        UserController::updateModel($request, $request->user());

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // prevent students from removing their accounts
        if(Auth::user()->role_id > 3){
            abort(401, "Cannot Remove Account");
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $this->save_deleted_user($user);

        // save deleted user information
        $user->update([
            "is_deleted" => true
        ]);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Delete a user by admin
     */
    public function delete_user($username){
        $user = User::where("username", $username)->first();

        if($user->role_id > 2){
            $user->update([
                "is_deleted" => true
            ]);

            // update model
            $user_m = $this->user_model($user);

            if($user->role_id == 4){
                $classes = $user_m->classes;

                // remove all classes for this teacher
                if($classes){
                    foreach($classes as $class){
                        $class->delete();
                    }
                }

                // remove class
                if($user_m->class){
                    $user_m->class->update([
                        "class_teacher" => null
                    ]);
                }
            }

            $user_m->update([
                "is_deleted" => true
            ]);

            // save deleted user records
            $this->save_deleted_user($user_m);

            $message_tail = session('school_id') ? "on your account" : "from the system";

            $status = true; $message = "$username has been removed $message_tail";
        }else{
            $status = false; $message = "$username is a system admin, hence cannot be deleted from the system";
        }


        return redirect()->back()->with(["success" => $status, "message" => $message]);
    }

    /**
     * Change status of a user by admin
     */
    public function status_change($username){
        $user = User::where("username", $username)->first();

        if($user->role_id > 2){
            $user->update([
                "is_active" => !$user->is_active
            ]);

            // update model
            $user_m = $this->user_model($user);
            $user_m->update([
                "is_active" => !$user_m->is_active
            ]);

            $message_tail = session('school_id') ? "your account" : "the system";

            $status = true; $message = "$username has been deactivated from $message_tail";
        }else{
            $status = false; $message = "$username is a system admin, hence cannot be deactivated externally from the system";
        }


        return redirect()->back()->with(["success" => $status, "message" => $message]);
    }

    private function save_deleted_user($user){
        // get the user data to be saved
        $deleted_user = $this->deletedUser($user);

        // add deleted user to deleted user table
        deletedusers::create($deleted_user);
    }

    private function deletedUser($user){
        $deleted_user = [
            "user_id" => $user->user->id,
            "email" => $user->user->email,
            "role_id" => $user->user->role_id,
            "lname" => $user->lname,
            "oname" => $user->oname,
            "primary_phone" => $user->primary_phone,
            "secondary_phone" => $user->secondary_phone,
            "school_id" => $user->school_id
        ];

        return $deleted_user;
    }
}
