<?php

namespace App\Http\Controllers;

use App\Models\ApproveResults;
use App\Models\Grades;
use App\Models\Program;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Traits\UserModelTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradesController extends Controller
{
    use UserModelTrait;

    /**
     * status for grades
     */
    protected array $statuses = [
        "pending", "submitted", "rejected", "accepted",
        "reject", "accept"
    ];

    /**
     * This formats properly the status to be sent
     */
    private function format_status(string $value){
        $response = $value;

        if($value == "rejected"){
            $response = "reject";
        }elseif($value == "accepted"){
            $response = "accept";
        }

        return $response;
    }

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
        $role_id = auth()->user()->role_id;
        $model = $this->user_model(auth()->user());

        switch($role_id){
            case 3:
                $options = [
                    "teachers" => Teacher::all(["user_id", "lname", "oname"])->toArray(),
                    "classes" => Program::all(["id", "name"])->toArray(),
                    "subjects" => Subject::all(["id", "name"])->toArray(),
                    "result_id" => $this->create_id(),
                    "result_slips" => ApproveResults::orderBy('status', 'desc')->orderBy('updated_at','desc')->get()
                                        ->groupBy('status')->map(function ($items, $key) {
                                            return [
                                                'title' => ucfirst($key) . ' Results',
                                                'id' => $key, 'data' => $items
                                            ];
                                        })
                ];

                break;
            case 4:
                $app_results = new ApproveResults(["teacher_id" => auth()->user()->id]);

                $options = [
                    "result_slips" => $app_results::all(),
                    "result_id" => $this->create_id(),
                    "teacher_id" => auth()->user()->id,
                    "subjects" => $model->subjects->unique('name')->toArray(),
                    "classes" => $model->classes->unique("program_id")
                ];
                break;
            case 5:
                $options = [
                    "results" => $model->grades
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
            "semester" => ["required", "integer", "max: 3", "min: 1"],
            "class_mark.*" => ["required", "numeric", "min:0", "max:50"],
            "exam_mark.*" => ["required", "numeric", "min:0", "max:50"]
        ]);

        $count = -1;
        $defaults = array_slice($validated, 0, 5);
        $stud_data = array_slice($validated, 5, 8);

        // save each entry
        while(++$count < count($validated["student_id"])){
            $grade = new Grades(array_merge($defaults, [
                "student_id" => $stud_data["student_id"][$count],
                "class_mark" => $stud_data["class_mark"][$count],
                "exam_mark" => $stud_data["exam_mark"][$count]
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
        }

        return redirect()->back()->with(["success" => true, "message" => $message]);
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
            "id.*" => ["required", "numeric"],
            "student_id.*" => ["required", "integer", Rule::exists("students", "user_id")],
            "class_mark.*" => ["required", "numeric", "min:0", "max:50"],
            "exam_mark.*" => ["required", "numeric", "min:0", "max:50"],
            "status" => ["sometimes", "required", Rule::in($this->statuses)]
        ]);

        $count = -1;
        $defaults = array_slice($validated, 0, 2);
        $stud_data = array_slice($validated, 2, 6);

        while(++$count < count($validated["student_id"])){
            $data = $this->format_update_data($defaults, $stud_data, $count, $is_admin);

            $grade = Grades::find($stud_data["id"][$count]);
            $grade->update($data);
        }

        if($request->submit == "save"){
            $message = "Result updates have been saved";
        }else{
            $record = ApproveResults::where("result_token", $validated["result_token"])->first();
            $record->status = $this->format_status($request->status) ?? "submitted";
            $record->update();
            $message = "Results have been {$request->status}";

            if($record->status == "submitted"){
                $message .= " for review";
            }
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
                "exam_mark" => $stud_data["exam_mark"][$count],
                "id" => $stud_data["id"][$count]
            ]);
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

    /**
     * Create a result id
     */
    private function create_id() :string{
        $token = "";

        //generate three random values
        for($i = 1; $i <= 3; $i++){
            $token .= chr(rand(65,90));
        }

        //add teacher id
        $token .= str_pad(strval(auth()->user()->id), 3, "0", STR_PAD_LEFT);

        $token = str_shuffle($token);

        //random characters
        $token .= chr(rand(65,90)). str_pad(auth()->user()->school->id,2,"0",STR_PAD_LEFT);
        $token = substr(str_shuffle($token.uniqid()), 0, 8);
        $token .= date("y");

        return strtolower($token);
    }
}
