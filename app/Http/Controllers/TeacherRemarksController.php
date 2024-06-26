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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
        $remarks = collection_group($remarks, "status", [["title" => " remarks"], "id"]);
        $teacher = $user->role_id == 4 ? $this->user_model($user) : null;
        $program = $user->role_id == 4 ? $teacher->teacher_class : 0;

        return view("remarks.index", [
            "remarks" => $remarks,
            "is_admin" => $user->role_id == 3,
            "remark_options" => RemarkOptions::all(),
            "teacher" => $teacher,
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
        $validated = $request->validated();
        $default = array_slice($validated, 0, 5);
        $array = array_slice($validated, 5);

        $count = -1;
        $status = $request->submit == "save" ? "pending" : $request->submit;
        $message = $status == "save" || $status == "pending" ? "Entry has been saved for later" : "Entry has been $status";
        $is_admin = Auth::user()->role_id == 3;

        if(!$is_admin){
            $is_new = in_array("position", array_keys($validated));
            $academic_year = get_academic_year(now());
            while(++$count < count($validated["student_id"])){
                $merge_data = [
                    "student_id" => $array["student_id"][$count],
                    "total_marks" => $array["total_marks"][$count],
                    "attendance" => $array["attendance"][$count],
                    "interest" => $array["interest"][$count],
                    "conduct" => $array["conduct"][$count],
                    "attitude" => $array["attitude"][$count],
                    "status" => $status
                ];
                if($is_new){
                    $merge_data["position"] = $array["position"][$count];
                    $merge_data["remark"] = $array["remark"][$count];
                    $merge_data["academic_year"] = $academic_year;
                }
                $data = array_merge($default, $merge_data);

                $detail = TeacherRemarks::where("student_id", $data["student_id"])->where("remark_token", $data["remark_token"])->first();

                // update if exists or create if not exist
                if($detail){
                    $detail->total_marks = $data["total_marks"];
                    $detail->attendance = $data["attendance"];
                    $detail->interest = $data["interest"];
                    $detail->conduct = $data["conduct"];
                    $detail->attitude = $data["attitude"];
                    $detail->status = $data["status"];

                    if($is_new){
                        $detail->position = $data["position"];
                    }

                    $detail->update();
                }else{
                    TeacherRemarks::create($data);
                }
            }
        }else{
            $head_remark = in_array("h_remark", array_keys($validated));
            while(++$count < count($validated["student_id"])){
                $student_id = $array["student_id"][$count];

                $detail = TeacherRemarks::where("student_id", $student_id)->where("remark_token", $default["remark_token"])->first();

                // update if exists or create if not exist
                if($detail){
                    $detail->status = $status;

                    // attach headmaster remark
                    if($head_remark){
                        $detail->h_remark = $array["h_remark"][$count];
                    }

                    if($request->promotion_class > -1){
                        $detail->promoted = true;
                    }
                    $detail->update();
                }
            }
        }

        // change main token status
        $main_remark = TeachersRemark::where("remark_token", $validated["remark_token"])->first();
        $main_remark->status = $status;

        if($is_admin){
            $main_remark->admin_id = Auth::user()->id;

            if($request->is_promotion){
                $main_remark->is_promotion = $request->is_promotion;
                $main_remark->promotion_class = $request->promotion_class ?? -1;
            }
        }else{
            // maximum weeks in a term and maximum days in a week
            $max_weeks = 16; $max_days = 5;
            $maximum_attendance = $max_weeks * $max_days;
            if($request->total_attendance){
                if($request->total_attendance <= $maximum_attendance){
                    $main_remark->total_attendance = $request->total_attendance;
                }else{
                    throw ValidationException::withMessages([
                        "total_attendance" => "Total attendance cannot exceed $maximum_attendance"
                    ]);
                }
            }else{
                throw ValidationException::withMessages([
                    "total_attendance" => "Please provide the total attendance"
                ]);
            }

        }

        $main_remark->update();

        return redirect()->back()->with(["status" => true, "messages" => $message]);
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

    // promote students
    public function promote(Request $request){
        $remarks = TeachersRemark::where("academic_year", $request->academic_year)
                    ->where("semester", 3)->where("is_promotion", true)
                    ->where("transferred", false)->where("status", "accepted")
                    ->get();

        if($remarks->count() > 0){
            foreach($remarks as $program){
                $students = TeacherRemarks::where("remark_token", $program->remark_token)->get();
                $new_class = $program->promotion_class;

                if($students){
                    foreach($students as $student){
                        $student = $student->student;
                        $student->program_id = $new_class;

                        if($new_class == 0){
                            $student->completed = true;
                        }

                        $student->update();
                    }
                }

                // mark this program as been transferred
                $program->transferred = true;
                $program->update();
            }
            return redirect()->back()->with(["success" => true, "message" => "Promotion occured for ".$remarks->count()." classes"]);
        }else{
            return redirect()->back()->with(["success" => false, "message" => "No promotion class record is available for this academic year"]);
        }
    }
}
