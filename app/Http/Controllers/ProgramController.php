<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;
use App\Models\Teacher;
use App\Models\TeacherClass;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.classes.index', [
            "programs" => Program::all(),
            "school_id" => auth()->user()?->school->id,
            "teachers" => Teacher::all(["user_id", "lname", "oname"])
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
    public function store(StoreProgramRequest $request)
    {
        // check if the name already exists
        if(($message = $this->check_name_slug()) === true){
            $validated = $request->validate($request->rules());
            $program = Program::create($validated);

            $success = true;
            $message = "$program->name has been created successfully";
        }else{
            $success = false;
        }

        return redirect()->back()->with(["success" => $success, "message" => $message]);
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
            "teachers" => Teacher::all(["user_id", "lname", "oname"]),
            "class_data" => $program->subjects()
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
            $program->update($validated);

            $success = true;
            $message = "Update for $program->name was successful";
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
     * Checks if a program name for a school already exists
     */
    private function program_name_exists(bool $is_update, ?int $program_id){
        $name = request()->name;

        $exists = $is_update ?
            Program::where('name', $name)->where("id", "!=", $program_id)->exists() :
            Program::where('name', $name)->where("school_id", auth()->user()->school->id)->exists();

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
                Program::where('slug', $slug)->where("school_id", auth()->user()->school->id)->exists();
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
