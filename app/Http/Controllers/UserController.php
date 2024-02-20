<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\other;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = [];
        $user = Auth::user();

        switch($user->role_id){
            case 1:
            case 2:
                $options = [
                    "superadmins" => Admin::all(),
                    "admins" => SchoolAdmin::all(),
                    "teachers" => Teacher::all(),
                    "students" => Student::all(),
                    "others" => other::all()
                ];
                $roles = Role::where("school_id", 0)->get()->toArray();
                $school_id[] = ["id" => 0, "name" => "No school"];
                $school_id = array_merge($school_id, School::all(["id", "school_name as name"])->toArray());
                break;
            case 3:
                $options = [
                    "admins" => SchoolAdmin::all(),
                    "teachers" => Teacher::all(),
                    "students" => Student::all(),
                    "others" => other::all()
                ];
                $school_id = $user->school->id;
                $roles = Role::where("id", ">", "2")->where("school_id", 0)->orWhere("school_id", $school_id)->get()->toArray();
                break;
            default:
        }

        //

        return view("users", ["options" => $options, "roles" => $roles, "school_id" => $school_id]);
    }

    /**
     * Display an edit form
     */
    public function edit(User $username){

    }
}
