<?php

namespace App\Http\Controllers;

use App\Exports\ClassExport;
use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Grades;
use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherRemarks;
use App\Models\TeachersRemark;
use Illuminate\Validation\ValidationException;
use Spatie\LaravelPdf\Facades\Pdf;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.classes.index', [
            "programs" => Program::all(),
            "school_id" => session("school_id"),
            "teachers" => Teacher::where("program_id", null)->get()
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
     * Gets a class list
     */
    public function class_list(Program $program){
        return ExcelController::export(new ClassExport($program), "$program->name");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProgramRequest $request)
    {
        // check if the name already exists
        if(($message = $this->check_name_slug()) === true){
            $validated = $request->validate($request->rules());

            // check if class teacher hasn't been assigned a class
            $teacher = Teacher::find($validated["class_teacher"]);
            if($teacher->class_teacher == true){
                $success = false;
                $message = "Class could not be added. $teacher->lname has already been assigned a class";

                throw ValidationException::withMessages([
                    'class_teacher' => "Teacher already assigned ".$teacher->teacher_class->name
                ]);
            }else{
                $program = Program::create($validated);

                // store class details into teacher
                $teacher->class_teacher = true;
                $teacher->program_id = $program->id;
                $teacher->update();

                $success = true;
                $message = "$program->name has been created successfully";
            }

        }else{
            $success = false;
        }

        return redirect()->back()->with(["success" => $success, "message" => $message]);
    }

    public function multi_store(){
        $count = 0;
        $created = 0;

        // primary
        while(++$count <= 6){
            $class = "Class $count";

            // skip if class is already found
            $found = Program::where("name", $class)->where("school_id", session('school_id'))->exists();
            if(!$found){
                Program::create([
                    "name" => $class, "school_id" => session('school_id')
                ]);
                ++$created;
            }
        }

        // jhs
        $count = 0;

        while(++$count <= 3){
            $class = "JHS $count";

            // skip if class is already found
            $found = Program::where("name", $class)->where("school_id", session('school_id'))->exists();
            if(!$found){
                Program::create([
                    "name" => $class, "school_id" => session('school_id')
                ]);
                ++$created;
            }
        }

        return redirect()->back()->with(["success" => true, "message" => "$created classes added to your school"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Program $program)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Program $program)
    {
        return view('admin.classes.edit', [
            "program" => $program,
            "teachers" => Teacher::where("class_teacher", false)->orWhere("user_id", $program->class_teacher)->get(),
            "class_data" => $program->subjects
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProgramRequest $request, Program $program)
    {
        // check the name and slug
        if(($message = $this->check_name_slug(true, $program->id)) === true){
            $validated = $request->validate($request->rules());

            // check if class teacher hasn't been assigned a class
            $teacher = Teacher::find($validated["class_teacher"]);
            if($teacher->class_teacher == true && $teacher->program_id != $program->id){
                $success = false;
                $message = "Update not successful. $teacher->lname has already been assigned a class";

                throw ValidationException::withMessages([
                    'class_teacher' => "Teacher already assigned ".$teacher->teacher_class->name
                ]);
            }else{
                $program->update($validated);

                // store class details into teacher
                $teacher->class_teacher = true;
                $teacher->program_id = $program->id;
                $teacher->update();

                $success = true;
                $message = "Update for $program->name was successful";
            }
        }else{
            $success = false;
        }

        return redirect()->back()->with(["success" => $success, "message" => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Program $program)
    {
        $class_name = $program->name;
        $program->delete();

        return redirect()->back()->with(["success" => true, "message" => "$class_name has been deleted"]);
    }

    /**
     * Get student results
     */
    public function results(Program $program, ?Student $student = null, $semester = 1){
        if($program){
            $student = $student ?? Student::find(auth()->user()->id);

            if($student){
                $grade = new Grades(["student_id" => $student->user_id, "program_id" => $program->id, "semester" => $semester]);
                $results = $grade->my_results();
                $students = $grade->student_count();
                $remark = TeacherRemarks::where("student_id", $student->user_id)
                                        ->where("program_id", $program->id)
                                        ->where("semester", $semester)
                                        ->first();

                return view("student.my-result", [
                    "program" => $program,
                    "results" => $results,
                    "semester" => $semester,
                    "rows" => $students,
                    "remark" => $remark,
                    "remark_head" => $remark ? TeachersRemark::where("remark_token", $remark->remark_token)->first() : null
                ]);
            }

            abort(404, "Student Not Found");
        }

        abort(404, "Class Not Found");
    }

    /**
     * Print Student Results
     */
    public function print(Program $program, ?Student $student = null, $semester = 1){
        if($program){
            $student = $student ?? Student::find(auth()->user()->id);

            if($student){
                $grade = new Grades(["student_id" => $student->user_id, "program_id" => $program->id, "semester" => $semester]);
                $results = $grade->my_results();
                $students = $grade->student_count();
                $remark = TeacherRemarks::where("student_id", $student->user_id)
                                        ->where("program_id", $program->id)
                                        ->where("semester", $semester)
                                        ->first();
                $school = School::find(session('school_id'));

                // if no remark details were found, abort
                if(is_null($remark)){
                    abort(404, "User data not found");
                }

                return view("student.result-print", [
                    "program" => $program,
                    "results" => $results,
                    "semester" => $semester,
                    "rows" => $students,
                    "remark" => $remark,
                    "remark_head" => TeachersRemark::where("remark_token", $remark->remark_token)->first(),
                    "school" => $school,
                    "student" => $student
                ]);
            }

            abort(404, "Student Not Found");
        }

        abort(404, "Class Not Found");
    }

    /**
     * Checks if a program name for a school already exists
     */
    private function program_name_exists(bool $is_update, ?int $program_id){
        $name = request()->name;

        $exists = $is_update ?
            Program::where('name', $name)->where("id", "!=", $program_id)->exists() :
            Program::where('name', $name)->where("school_id", session('school_id'))->exists();

        return $exists;
    }

    /**
     * Checks if a slug exists
     */
    private function slug_exists(bool $is_update, ?int $program_id){
        $slug = request()->slug;
        $exists = false;

        if(!empty($slug)){
            $exists = $is_update ?
                Program::where('slug', $slug)->where("id", "!=", $program_id)->where('slug', "!=", "")->exists() :
                Program::where('slug', $slug)->where("school_id", session('school_id'))->exists();
        }

        return $exists;
    }

    private function check_name_slug(bool $is_update = false, ?int $program_id = null){
        if($this->program_name_exists($is_update, $program_id)){
            $message = request()->name." already exists";
            throw ValidationException::withMessages([
                'name' => $message,
            ]);
            return $message;
        }if($this->slug_exists($is_update, $program_id)){
            $message = request()->slug." already exists";
            throw ValidationException::withMessages([
                'slug' => $message,
            ]);
            return $message;
        }

        return true;
    }
}
