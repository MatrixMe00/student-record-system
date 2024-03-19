<?php

namespace App\Http\Controllers;

use App\Models\TeacherRemarks;
use App\Http\Requests\StoreTeacherRemarksRequest;
use App\Http\Requests\UpdateTeacherRemarksRequest;
use App\Models\Program;
use App\Models\RemarkOptions;
use App\Models\Teacher;
use App\Models\TeachersRemark;
use App\Traits\UserModelTrait;

class TeacherRemarksController extends Controller
{
    use UserModelTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $remarks = $user->role_id == 4 ? TeachersRemark::where("teacher_id", $user->id)->orderBy('updated_at', "desc")->get() : TeachersRemark::orderBy('updated_at', "desc")->get();
        $teacher = $user->role_id == 4 ? $user->id : Teacher::where("class_teacher", true)->get();
        $model = $this->user_model($user);
        $program = $user->role_id == 4 ? $model->teacher_class : 0;

        $remarks = $remarks->groupBy('status')->map(function ($items, $key) {
            return [
                'title' => ucfirst($key) . ' Remarks',
                'id' => $key, 'data' => $items
            ];
        });

        return view("remarks.index", [
            "remarks" => $remarks,
            "is_admin" => $user->role_id == 3,
            "remark_options" => RemarkOptions::all(),
            "teachers" => $teacher,
            "program" => $program,
            "remark_id" => create_id()
        ]);
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
    public function store(StoreTeacherRemarksRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherRemarks $teacherRemarks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherRemarks $teacherRemarks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTeacherRemarksRequest $request, TeacherRemarks $teacherRemarks)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeacherRemarks $teacherRemarks)
    {
        //
    }
}
