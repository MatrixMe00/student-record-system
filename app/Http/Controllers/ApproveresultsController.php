<?php

namespace App\Http\Controllers;

use App\Models\ApproveResults;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApproveresultsController extends Controller
{
    public function index()
    {
        $user = request()->user();

        return ApproveResults::where("school_id", $user->school_id)->get();
    }

    public function store(Request $request)
    {
        if(empty($request->worked_by)){
            $user = $request->user();
            // check if user is admin
            if($user->role_id < 4){
                $request->merge(["worked_by" => $user->id,
                    "result_token" => $this->createToken(
                        $request->teacher_token, $request->school_id
                    )
                ]);
            }
        }

        $validated = $request->validate([
            "result_token" => ["required", "string", Rule::unique("approveresults", "result_token")],
            "school_id" => ["required", "integer", Rule::exists('schools')],
            "program_id" => ["required", "integer", Rule::exists('programs')],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "semester" => ["required", "integer", "min:1", "max:3"],
            "worked_by" => ["required", "integer", Rule::exists("admins", "user_id")]
        ]);

        ApproveResults::create($validated);
    }

    public function update(Request $request, ApproveResults $approveResults)
    {
        $validated = $request->validate([
            "result_token" => ["required", "string", Rule::unique("approveresults", "result_token")],
            "school_id" => ["required", "integer", Rule::exists('schools')],
            "program_id" => ["required", "integer", Rule::exists('programs')],
            "teacher_id" => ["required", "integer", Rule::exists("teachers", "user_id")],
            "semester" => ["required", "integer", "min:1", "max:3"],
            "worked_by" => ["required", "integer", Rule::exists("admins", "user_id")]
        ]);

        $approveResults->update($validated);
    }

    public function destroy(ApproveResults $approveResults)
    {
        $approveResults->delete();
    }

    /**
     * Generate a random token for a result
     */
    private function createToken($teacher_id, $school_id) : string
    {
        $token = "";

        //generate three random values
        for($i = 1; $i <= 3; $i++){
            $token .= chr(rand(65,90));
        }

        //add teacher id
        $token .= str_pad(strval($teacher_id), 3, "0", STR_PAD_LEFT);

        $token = str_shuffle($token);

        //random characters
        $token .= chr(rand(65,90)). str_pad($school_id,2,"0",STR_PAD_LEFT);
        $token = substr(str_shuffle($token.uniqid()), 0, 8);
        $token .= date("y");

        return strtolower($token);
    }
}
