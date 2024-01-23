<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\User;

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
            $admins = Admin::where("school_id", $school_id)->get();
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
    public function store(StoreAdminRequest $request, User $user)
    {
        // if the role is a non-school role, school id should be null
        if($request->role_id < 3){
            $request->merge(["school_id" => null]);
        }

        $validated = $request->validated();
        $admin = [
            "lname" => $validated->lname,
            "oname" => $validated->oname,
            "phone_number" => $validated->phone_number,
            "secondary_number" => $validated->secondary_number,
            "school_id" => $validated->school_id
        ];

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
