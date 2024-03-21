<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\RemarkOptions;
use App\Models\School;
use Illuminate\Http\Request;

class RemarkOptionsController extends Controller
{
    private function rules(){
        return [
            "school_id" => ["sometimes", "required", "integer", "exists:schools,id"],
            "admin_id" => ["required", "integer", "exists:admins,user_id"],
            "remark.*" => ["required", "string"],
            "id.*" => ["numeric"]
        ];
    }

    public function index(){
        return view("admin.remark-options",[
            "remarks" => RemarkOptions::all()
        ]);
    }

    public function destroy(RemarkOptions $option){
        $option->delete();

        return true;
    }

    public function store(Request $request){
        $validated = $request->validate($this->rules());
        $defaults = array_slice($validated, 0, 2);
        $array = array_slice($validated, 2);

        $count = 0;
        while($count < count($validated["id"])){
            // create new data if id is 0
            if($array["id"][$count] < 1){
                RemarkOptions::create(array_merge($defaults, ["remark" => $array["remark"][$count]]));
            }else{
                if($remark = RemarkOptions::find($array["id"][$count])){
                    $remark->remark = $array["remark"][$count];
                    $remark->update();
                }
            }
            $count++;
        }

        return redirect()->back()->with(["success" => true, "message" => "Remark Options for your school updated"]);
    }
}
