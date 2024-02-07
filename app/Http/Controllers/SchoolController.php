<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // without an admin id, redirect to admin register
        $admin_id = session('admin_id') != null ? session('admin_id') : false;

        /*if(!$admin_id){
            return redirect("/register");
        }*/

        return view('auth.register', [
            "admin_id" => $admin_id,
            "school_register" => true,
            "page_title" => "Add Your School"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        $validated = $request->validate($request->rules());
        School::create($validated);

        return redirect("/admin-login");
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $validated = $request->validated();
        $school->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        $school->delete();
    }
}
