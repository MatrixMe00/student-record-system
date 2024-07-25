<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Grades;
use App\Models\Program;
use App\Models\RemarkOptions;
use App\Models\School;
use App\Models\Teacher;
use App\Models\TeacherRemarks;
use App\Models\TeachersRemark;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TeachersRemarkController extends Controller
{
    private function rules(){
        return [
            "remark_token" => ["required", "string"],
            "school_id" => ["sometimes", "required", "integer", "exists:schools,id"],
            "teacher_id" => ["sometimes", "required", "integer", "exists:teachers,user_id"],
            "program_id" => ["sometimes", "required", "integer", "exists:programs,id"],
            "semester" => ["sometimes", "required", "integer", "min:1", "max:3"],
            "reopening" => ["sometimes", "required", "date"],
            "academic_year" => ["required", "string"],
            "status" => ["sometimes", "required", "string", "in:pending,rejected,accepted"],
            "admin_id" => ["sometimes","required","integer", "exists:admins, user_id"]
        ];
    }

    // store the results
    public function store(Request $request){
        $validated = $request->validate($this->rules());

        if($this->result_exists($validated)){
            $status = false;
            $message = "Result already exists";
           throw ValidationException::withMessages([
                "error" => $message
           ]);
        }else{
            $status = true;
            $message = "Remark Slip has been activated";

            TeachersRemark::create($validated);
        }

        return redirect()->back()->with(["status" => $status, "message" => $message]);
    }

    public function show($token){
        $remarks = TeacherRemarks::where("remark_token", $token)->get();
        $this_remark = TeachersRemark::where("remark_token", $token)->first();
        $students = $this->get_student_marks($this_remark);
        $is_admin = auth()->user()->role_id == 3;

        if($this_remark->semester == 3){
            $programs = Program::where("id", "!=", $this_remark->program->id)->get();
        }else{
            $programs = null;
        }


        return view("remarks.edit",[
            "remarks" => $remarks,
            "remark_head" => $this_remark,
            "student_marks" => $students,
            "remark_options" => RemarkOptions::all(["id", "remark as name"]),
            "academic_year" => get_academic_year($this_remark->created_at),
            "is_admin" => $is_admin,
            "program" => $this_remark->program,
            "edit_all" => in_array($this_remark->status, ["pending", "rejected"]) && !$is_admin,
            "edit_once" => $this_remark->status == "pending",
            "programs" => $programs
        ]);
    }

    /**
     * Get the initial student marks
     */
    private function get_student_marks(TeachersRemark $remark){
        $grade = new Grades([
            "semester" => $remark->semester,
            "program_id" => $remark->program_id,
            "teacher_id" => $remark->teacher_id,
            "academic_year" => $remark->academic_year
        ]);

        return $grade->class_results();
    }

    // update results
    public function update(Request $request, TeachersRemark $remark){
        if($request->is_admin){
            $request->merge([
                "admin_id" => auth()->user()->id
            ]);
        }

        $validated = $request->validate($this->rules());
    }

    // this verifies that the result token has not been already provided
    private function result_exists(array $validated): bool{
        return TeachersRemark::where("school_id", session('school_id'))
                               ->where("program_id", $validated["program_id"])
                               ->where("semester", $validated["semester"])
                               ->where("academic_year", $validated["academic_year"])
                               ->exists();
    }
}
