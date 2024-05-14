<?php

namespace App\Http\Controllers;

use App\Models\TeacherClass;
use App\Http\Requests\StoreTeacherClassRequest;
use App\Http\Requests\UpdateTeacherClassRequest;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    public function create(?Teacher $teacher = null)
    {
        $options = $this->create_options($teacher);
        return view("teacher.assign-class", $options);
    }

    /**
     * options for create
     */
    private function create_options(?Teacher $teacher){
        $options = [
            "teacher" => $teacher ?? false,
            "teacher_id" => $teacher?->user_id ?? "",
        ];

        if($teacher){
            $options += [
                "classes" => Program::all(["id", "name"])->toArray(),
                "subjects" => Subject::all(["id", "name"])->toArray()
            ];
        }else{
            $options["teachers"] = Teacher::all(["user_id", "lname", "oname"]);
        }

        return $options;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->proceed == 1){
            $validated = $request->validate([
                "teacher_id" => ["required", "numeric"]
            ]);

            return redirect("teacher/subject-assign/".$validated["teacher_id"]);
        }else{
            $request->merge(["school_id" => session('school_id')]);
            $req = new StoreTeacherClassRequest();
            $req = $req->createFrom($request);

            $validated = $request->validate($req->rules());
            $default = array_slice($validated, 0, 2);
            $dynamic = array_slice($validated, 2);
            $count = -1;
            $s_count = 0;   // checks for the current item number

            // update or store values
            while(++$count < count($validated["program_id"])){
                $data = array_merge($default, [
                    "subject_id" => $dynamic["subject_id"][$count],
                    "program_id" => $dynamic["program_id"][$count]
                ]);

                if($dynamic["id"][$count] > 0){
                    $tc = $this->check_teacher_class($data["subject_id"], $data["program_id"]);
                    if($tc && $dynamic["id"][$count] != $tc?->id){
                        throw ValidationException::withMessages([
                            "subject_id.$s_count" => $tc->subject->name." has already been assigned a teacher in ".$tc->program->name,
                            "row" => $s_count
                        ]);
                    }else{
                        dd($data);
                        $tc->update($data);
                    }
                }else{
                    $tc = $this->check_teacher_class($data["subject_id"], $data["program_id"]);
                    if($tc){
                        throw ValidationException::withMessages([
                            "subject_id.$s_count" => $tc->subject->name." has already been assigned a teacher in ".$tc->program->name,
                            "row" => $s_count
                        ]);
                    }else{
                        TeacherClass::create($data);
                    }
                }

                ++$s_count;
            }
        }

        return redirect()->back()->with(["success" => true, "message" => "Teacher data has been updated"]);
    }

    /**
     * Check if a teacher class exist
     * @param int $subject_id The subject
     * @param int $program_id The class in question
     * @return TeacherClass|bool
     */
    private function check_teacher_class(int $subject_id, int $program_id) :TeacherClass|bool|null{
        return TeacherClass::where("subject_id", $subject_id)
                           ->where("program_id", $program_id)
                           ->first();
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
    public function destroy(TeacherClass $subject)
    {
        return $subject->delete();
    }
}
