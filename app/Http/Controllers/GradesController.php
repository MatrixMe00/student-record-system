<?php

namespace App\Http\Controllers;

use App\Models\ApproveResults;
use App\Models\Grades;
use App\Models\Program;
use App\Traits\UserModelTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GradesController extends Controller
{
    use UserModelTrait;

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
                $options = [];
                break;
            case 4:
                $app_results = new ApproveResults(["teacher_id" => auth()->user()->id]);
                $options = [
                    "result_slips" => $app_results::all(),
                    "result_id" => $this->create_id(),
                    "classes" => Program::all(["id", "name"])->toArray()
                    // "classes" => $model->classes()->get()->toArray()
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
