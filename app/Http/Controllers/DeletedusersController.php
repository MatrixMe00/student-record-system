<?php

namespace App\Http\Controllers;

use App\Models\deletedusers;
use App\Models\Role;
use Illuminate\Http\Request;

class DeletedusersController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "user_id" => ["required", "integer", "exists:users,id"],
            "lname" => ["required", "string"],
            "oname" => ["required", "string"],
            "email" => ["nullable", "sometimes", "string"],
            "phone_number" => ["required", "string", "min:10", "max:13"],
            "secondary_number" => ["sometimes", "nullable", "string", "min:10", "max:13"],
            "role_id" => ["required", "integer", "exists:".Role::class]
        ]);
        deletedusers::create($validated);
    }

    public function index(){
        $users = deletedusers::all();
    }
}
