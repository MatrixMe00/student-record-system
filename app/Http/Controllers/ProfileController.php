<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Admin;
use App\Models\deletedusers;
use App\Models\other;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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

        $a = Admin::find($user);
        $t = Teacher::find($user);
        $s = Student::find($user);
        $o = other::find($user);

        if(!$a->count() > 0){
            $user_det = $a;
        }elseif(!$t->count() > 0){
            $user_det = $t;
        }elseif(!$s->count() > 0){
            $user_det = $s;
        }elseif(!$o->count() > 0){
            $user_det = $o;
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
