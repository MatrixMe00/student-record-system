<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Validation\ValidationException;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("admin.subjects.index", [
            "subjects" => Subject::all(),
            "school_id" => auth()->user()?->school?->id
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
    public function store(StoreSubjectRequest $request)
    {
        // check if the name already exists
        if(($message = $this->check_name_slug()) === true){
            $validated = $request->validate($request->rules());
            $subject = Subject::create($validated);

            $success = true;
            $message = "$subject->name has been created successfully";
        }else{
            $success = false;
        }

        return redirect()->back()->with(["success" => $success, "message" => $message]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subject $subject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return view('admin.subjects.edit', [
            "subject" => $subject
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        // check if the name already exists
        if(($message = $this->check_name_slug(true, $subject->id)) === true){
            $validated = $request->validate($request->rules());
            $subject->update($validated);

            $success = true;
            $message = "Update for $subject->name has been successful";
        }else{
            $success = false;
        }

        return redirect()->back()->with(["success" => $success, "message" => $message]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subject $subject)
    {
        $subject_name = $subject->name;
        $subject->delete();

        return redirect()->back()->with(["success" => true, "message" => "$subject_name has been deleted"]);
    }

    /**
     * Checks if a subject name for a school already exists
     */
    private function name_exists(bool $is_update, ?int $subject_id){
        $name = request()->name;
        // dd(Subject::where('name', $name)->where("id", ">", $subject_id)->get(), $subject_id);

        $exists = $is_update ?
            Subject::where('name', $name)->where("id", "!=", $subject_id)->exists() :
            Subject::where('name', $name)->where("school_id", auth()->user()->school->id)->exists();

        return $exists;
    }

    /**
     * Checks if a slug exists
     */
    private function slug_exists(bool $is_update, ?int $subject_id){
        $slug = request()->slug;
        $exists = false;

        if(!empty($slug)){
            $exists = $is_update ?
                Subject::where('slug', $slug)->where("id", "!=", $subject_id)->where('slug', "!=", "")->exists() :
                Subject::where('slug', $slug)->where("school_id", auth()->user()->school->id)->exists();
        }

        return $exists;
    }

    private function check_name_slug(bool $is_update = false, ?int $subject_id = null){
        if($this->name_exists($is_update, $subject_id)){
            $message = request()->name." already exists";
            throw ValidationException::withMessages([
                'name' => $message,
            ]);
            return $message;
        }if($this->slug_exists($is_update, $subject_id)){
            $message = request()->slug." already exists";
            throw ValidationException::withMessages([
                'slug' => $message,
            ]);
            return $message;
        }

        return true;
    }
}
