<?php

namespace App\Http\Controllers;

use App\Models\TeacherClass;
use App\Http\Requests\StoreTeacherClassRequest;
use App\Http\Requests\UpdateTeacherClassRequest;

class TeacherClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = TeacherClass::all();
        //
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
    public function store(StoreTeacherClassRequest $request)
    {
        $validated = $request->validated();
        TeacherClass::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherClass $teacherClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherClass $teacherClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherClassRequest $request, TeacherClass $teacherClass)
    {
        $validated = $request->validated();
        $teacherClass->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherClass $teacherClass)
    {
        $teacherClass->delete();
    }
}