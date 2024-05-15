<?php

namespace App\Http\Controllers;

use App\Models\ApproveResults;
use App\Models\Grades;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Traits\UserModelTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GradesController extends Controller
{
    use UserModelTrait;

    /**
     * status for grades
     */
    protected array $statuses = [
        "pending", "submitted", "rejected", "accepted"
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = $this->create_options();

        return view('results.index', $options);
    }

    /**
     * Used to get the necessary options for a user
     */
    private function create_options(){
        $user = Auth::user();
        $role_id = $user->role_id;
        $model = $this->user_model($user);

        switch($role_id){
            case 3:
                $result_slips = ApproveResults::orderBy('status', 'desc')->orderBy('updated_at','desc')->get();
                $options = [
                    "teachers" => Teacher::all(["user_id", "lname", "oname"])->toArray(),
                    "classes" => Program::all(["id", "name"])->toArray(),
                    "subjects" => Subject::all(["id", "name"])->toArray(),
                    "result_id" => create_id(),
                    "result_slips" => collection_group($result_slips, "status", [["title" => " Results"], "id"])
                ];

                break;
            case 4:
                $app_results = new ApproveResults(["teacher_id" => $user->id]);

                $options = [
                    "result_slips" => $app_results->orderBy("updated_at", "desc")->get(),
                    "result_id" => create_id(),
                    "teacher_id" => auth()->user()->id,
                    "subjects" => $model->subjects->unique('name')->toArray(),
                    "classes" => $model->classes->unique("program_id")
                ];
                dd($options);
                break;
            case 5:
                $options = [
                    // "results" => $model->results->where("status","accepted")
                    "results" => $model->results->unique('program_id'),
                    "active_payment" => session('payment_result'),
                    "payments" => Payment::where("student_id", Auth::user()->id)
                                         ->where("payment_type", "results")
                                         ->get()->sortByDesc('expiry_date')
                ];
                break;
        }
        $options["role_id"] = $role_id;

        return $options;
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
            "result_token" => ["required", "string", Rule::exists("approveresults", "result_token")],
            "student_id.*" => ["required", "integer", Rule::exists("students", "user_id")],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "program_id" => ["required", "integer", Rule::exists("programs", "id")],
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "subject_id" => ["required", "integer", Rule::exists("subjects", "id")],
            "semester" => ["required", "integer", "max: 3", "min: 1"],
            "class_mark.*" => ["required", "numeric", "min:0", "max:50"],
            "exam_mark.*" => ["required", "numeric", "min:0", "max:50"]
        ]);

        $count = -1;
        $defaults = array_slice($validated, 0, 6);
        $stud_data = array_slice($validated, 6, 9);
        $academic_year = get_academic_year(date("d-m-Y"));

        // save each entry
        while(++$count < count($validated["student_id"])){
            $grade = new Grades(array_merge($defaults, [
                "student_id" => $stud_data["student_id"][$count],
                "class_mark" => $stud_data["class_mark"][$count],
                "exam_mark" => $stud_data["exam_mark"][$count],
                "academic_year" => $academic_year
            ]));

            $grade->save();
        }

        if($request->submit == "save"){
            $message = "Result entry have been saved";
        }else{
            $record = ApproveResults::where("result_token", $validated["result_token"])->first();
            $record->status = "submitted";
            $record->update();
            $message = "Results have been submitted for review";

            // work on the positions
            $this->arrange_grades($validated["result_token"]);
        }

        return redirect()->back()->with(["success" => true, "message" => $message]);
    }

    /**
     * Arrange the grades in descending order
     */
    private function arrange_grades(string $result_token){
        $results = Grades::where("result_token", $result_token)->get();
        $totals = new Collection();

        foreach($results as $result){
            $totals->push([
                "grade_id" => $result->id,
                "student_id" => $result->student_id,
                "total" => ($result->class_mark + $result->exam_mark)
            ]);
        }

        $this->enter_positions($totals->sortByDesc("total")->toArray(), $result_token);
    }

    /**
     * This enters the positions into the database
     */
    private function enter_positions($students, $result_token){
        $cur_pos = 0;
        $last_total = 0;

        foreach($students as $count => $student){
            $grade = Grades::find($student["grade_id"]);
            $cur_pos = $last_total == $student["total"] ? $cur_pos : ($count + 1);
            $last_total = $student["total"];

            $grade->position = $cur_pos;
            $grade->update();
        }
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
    public function update(Request $request)
    {
        $is_admin = false;

        // set status
        if(auth()->user()->role_id == 3){
            $is_admin = true;
            $request->merge(["status" => $request->submit]);
        }

        $validated = $request->validate([
            "semester" => ["required", "integer", "max: 3", "min: 1"],
            "result_token" => ["required", "string", Rule::exists("approveresults", "result_token")],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "program_id" => ["required", "integer", Rule::exists("programs", "id")],
            "school_id" => ["required", "integer", Rule::exists("schools", "id")],
            "subject_id" => ["required", "integer", Rule::exists("subjects", "id")],
            "id.*" => ["required", "numeric"],
            "student_id.*" => ["required", "integer", Rule::exists("students", "user_id")],
            "class_mark.*" => ["required", "numeric", "min:0", "max:50"],
            "exam_mark.*" => ["required", "numeric", "min:0", "max:50"],
            "status" => ["sometimes", "required", Rule::in($this->statuses)]
        ]);

        $count = -1;
        $defaults = array_slice($validated, 0, 6);

        // used to update student status by admin
        if(isset($validated["status"]) && $is_admin){
            $defaults["status"] = $validated["status"];
        }

        $stud_data = array_slice($validated, 6, 10);

        while(++$count < count($validated["student_id"])){
            $data = $this->format_update_data($defaults, $stud_data, $count, $is_admin);

            $grade = Grades::find($stud_data["id"][$count] ?? 0);
            !is_null($grade) ? $grade->update($data) : Grades::create($data);
        }

        if($request->submit == "save"){
            $message = "Result updates have been saved";
        }else{
            $record = ApproveResults::where("result_token", $validated["result_token"])->first();
            $record->status = $request->submit ?? "submitted";

            // update the admin id
            if($is_admin){
                $record->admin_id = auth()->user()->id;
            }

            $record->update();
            $message = $record->status != 'pending' ? "Results have been {$record->status}" : 'Results has been enabled for modification';

            if($record->status == "submitted"){
                $message .= " for review";
            }

            // update grade positions
            $this->arrange_grades($validated["result_token"]);
        }

        return redirect()->back()->with(["success" => true, "message" => $message]);
    }

    /**
     * This is used to help with the update of records, sets the kind of data to be parsed
     */
    private function format_update_data($defaults, $stud_data, $count, $is_admin) :array{
        $data = [];
        if($is_admin){
            $data = [
                "id" => $stud_data["id"][$count],
                "status" => request()->status
            ];
        }else{
            $data = array_merge($defaults, [
                "student_id" => $stud_data["student_id"][$count],
                "class_mark" => $stud_data["class_mark"][$count],
                "exam_mark" => $stud_data["exam_mark"][$count]
            ]);

            if(isset($stud_data["id"][$count])){
                $data["id"] = $stud_data["id"][$count];
            }
        }

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grades $grades)
    {
        $grades->delete();
    }
}
