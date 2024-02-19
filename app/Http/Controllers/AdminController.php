<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\SchoolAdmin;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use ReflectionClass;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $school_id = request()->user()->school_id;
        if(is_null($school_id)){
            $admins = Admin::all();
        }else{
            $admins = SchoolAdmin::all();
        }

        return $admins;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        // if the role is a non-school role, school id should be null
        if($request->role_id < 3){
            $request->merge(["school_id" => null]);
        }elseif(is_null(auth()->user()) && $request->role_id == 3){
            $request->merge(["school_id" => null]);
        }

        $admin = $request->validate($request->rules());

        $user = Admin::create($admin);

        return $user;
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return $admin;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        $validated = $request->validated();
        $admin->update($validated);

        return $admin;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();

        return response()->noContent();
    }
}
