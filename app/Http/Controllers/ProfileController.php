<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\deletedusers;
use App\Models\other;
use App\Models\Student;
use App\Models\Teacher;
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
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // get the user data to be saved
        $deleted_user = $this->deletedUser($user);

        // add deleted user to deleted user table
        deletedusers::create($deleted_user);

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    private function deletedUser($user){
        $deleted_user = [
            "user_id" => $user->id,
            "email" => $user->email,
            "role_id" => $user->role_id
        ];

        switch($user->role_id){
            case 1:
            case 2:
            case 3:
                $user_det = Admin::find($user);
                break;
            case 4:
                $user_det = Teacher::find($user);
                break;
            case 5:
                $user_det = Student::fund($user);
                break;
            default:
                $user_det = other::find($user);
        }

        $deleted_user += [
            "lname" => $user_det["lname"],
            "oname" => $user_det["oname"],
            "primary_phone" => $user_det["primary_phone"],
            "secondary_phone" => $user_det["secondary_phone"]
        ];

        return $deleted_user;
    }
}
