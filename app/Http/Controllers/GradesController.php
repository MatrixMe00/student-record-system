<?php

namespace App\Http\Controllers;

use App\Models\Grades;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradesController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "student_id" => ["required", "integer", Rule::exists("students", "user_id")],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "program_id" => ["required", "integer", Rule::exists("programs", "id")],
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "semester" => ["required", "integer", "max: 3", "min: 1"],
            "class_mark" => ["required", "float", "min:0"],
            "exam_mark" => ["required", "float", "min:0"]
        ]);

        Grades::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Grades $grades)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grades $grades)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grades $grades)
    {
        $validated = $request->validate([
            "id" => ["required", "integer", Rule::exists("grades")],
            "student_id" => ["required", "integer", Rule::exists("students", "user_id")],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "program_id" => ["required", "integer", Rule::exists("programs", "id")],
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "semester" => ["required", "integer", "max: 3", "min: 1"],
            "class_mark" => ["required", "float", "min:0"],
            "exam_mark" => ["required", "float", "min:0"]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grades $grades)
    {
        $grades->delete();
    }
}
