<?php

namespace App\Http\Controllers;

use App\Models\ApproveResults;
use App\Models\Program;
use App\Models\Teacher;
use App\Models\TeacherClass;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ApproveresultsController extends Controller
{
    public function index()
    {
        return ApproveResults::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "result_token" => ["required", "string", Rule::unique("approveresults", "result_token")],
            "school_id" => ["required", "integer", Rule::exists('schools', 'id')],
            "program_id" => ["required", "integer", Rule::exists('programs', 'id')],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "semester" => ["required", "integer", "min:1", "max:3"],
            "subject_id" => ["required", "integer", Rule::exists("subjects", "id")]
        ]);

        // prevent teacher from creating a result slip if he does not teach the desired class
        if(!$this->teacher_program_validation($validated["teacher_id"], $validated["program_id"])){
            throw ValidationException::withMessages([
                "program_id" => "Invalid subject class was chosen"
            ]);
        }

        // same slip cannot be created for the same academic year
        if($this->check_slip_exist($validated)){
            throw ValidationException::withMessages([
                "semester" => "Similar result slip for this year has already been created"
            ]);
        }else{
            $validated["academic_year"] = get_academic_year(now());
            ApproveResults::create($validated);
        }

        return redirect()->back()->with(["success" => true, "message" => "Result data has been added"]);
    }

    /**
     * This makes sure the same result slip is not created for the same year
     * @param array $validated The validated data
     * @return bool
     */
    private function check_slip_exist($validated){
        $cur_year = get_academic_year(now());
        return ApproveResults::where("program_id", $validated["program_id"])
                             ->where("semester", $validated["semester"])
                             ->where("academic_year", $cur_year)
                             ->where("teacher_id", $validated["teacher_id"])
                             ->exists();
    }

    /**
     * This validates if the teacher teaches the desired class
     * @param int $teacher_id The id of the teacher
     * @param int $program_id The id of the program
     * @return bool
     */
    private function teacher_program_validation($teacher_id, $program_id) :bool{
        return TeacherClass::where("teacher_id", $teacher_id)
                           ->where("program_id", $program_id)
                           ->exists();
    }

    public function update(Request $request, ApproveResults $result)
    {
        $validated = $request->validate([
            "semester" => ["required", "integer", "min:1", "max:3"],
            "subject_id" => ["required", "integer", Rule::exists("subjects","id")],
            "admin_id" => ["sometimes", "required", "integer", Rule::exists("admins", "user_id")],
            "status" => ["sometimes", "required", "string"]
        ]);

        $result->update($validated);

        return redirect()->back()->with(["success" => true, "message" => "Result data has been modified successfully"]);
    }

    public function destroy($result_token)
    {
        $approveResults = ApproveResults::where("result_token",$result_token)->first();
        $approveResults->delete();

        return redirect()->back()->with(["success" => true, "message" => "Result Data Deleted"]);
    }

    public function edit($result_token){
        $approveResults = ApproveResults::where("result_token", $result_token)->first();
        $teacher_id = auth()->user()->role_id == 4 ? auth()->user()->id : $approveResults->teacher_id;
        $program = Program::find($approveResults->program_id);
        $students = $program->count() > 0 ? $program->students : null;
        $teacher = Teacher::find($teacher_id);
        $is_admin = auth()->user()->role_id == 3;

        return view("results.edit", [
            "result" => $approveResults,
            "program" => $program,
            "students" => $students,
            "grades" => $approveResults->grades?->sortByDesc("total"),
            "subject" => $approveResults->subject,
            "academic_year" => get_academic_year($approveResults->created_at),
            "edit_all" => in_array($approveResults->status, ["pending", "rejected", "reject"]) && !$is_admin,
            "edit_once" => $approveResults->status == "pending",
            "is_admin" => $is_admin,
            "unsaved" => $this->unsaved_students($students, $approveResults->grades)
        ]);
    }

    /**
     * Get unsaved students
     */
    private function unsaved_students(Collection $students, Collection $grades) :Collection{
        $unsaved = new Collection();
        $founds = new Collection();
        foreach($students as $student){
            $found = false;

            foreach($grades as $grade){
                $g_student = $grade->student;

                if($g_student == $student){
                    $found = true; break;
                }
            }

            if(!$found){
                $unsaved->push($student);
            }
        }

        return $unsaved;
    }

    public function show($result_token){
        return $this->edit($result_token);
    }
}
