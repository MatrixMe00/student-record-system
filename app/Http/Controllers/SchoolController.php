<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\Admin;
use App\Models\Grades;
use App\Models\Program;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\TeacherRemarks;
use App\Models\TeachersRemark;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schools = School::all();

        if(request()->routeIs("admin.schools")){
            return view('superadmin.schools', ["schools" => $schools]);
        }else{
            return view('home.schools', ["schools" => $schools]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // without an admin id, redirect to admin register
        $admin_id = session('admin_id') != null ? session('admin_id') : false;

        if(!$admin_id){
            $admin_id = auth()->user()?->id ?? false;

            if(!$admin_id || $admin_id == null)
                return redirect("/register");
        }

        return view('auth.register', [
            "admin_id" => $admin_id,
            "school_register" => true,
            "page_title" => "Add Your School"
        ]);
    }

    /**
     * Get the results menu. This shows the various academic year results available
     */
    public function results($school_id){
        $school = $this->decrypt_school_id($school_id);

        return view("superadmin.results.index", [
            "academic_years" => $school->remarks
                                       ->unique("academic_year")->pluck("academic_year"),
            "school" => $school,
            "school_id" => $school_id
        ]);
    }

    /**
     * This shows the programs uploaded for a specified academic year
     */
    public function year_results($school_id, $academic_year){
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);

        return view("superadmin.results.classes", [
            "academic_year" => $academic_year,
            "classes" => $school->remarks->where("academic_year", $academic_year)->unique("program_id"),
            "school_id" => $school_id
        ]);
    }

    /**
     * This shows the data of information for a class
     */
    public function class_results($school_id, $academic_year, Program $program, $term = 1){
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);

        return view("superadmin.results.class", [
            "school_id" => $school_id,
            "academic_year" => $academic_year,
            "term" => $term,
            "program" => $program,
            "results" => $school->remarks->where("academic_year", $academic_year)->where("semester", $term)
        ]);
    }

    /**
     * This shows the results for a student
     */
    public function student_result(Program $program, Student $student, $academic_year, $term){
        $academic_year = year_link($academic_year, false);
        $remark = TeacherRemarks::where("student_id", $student->user_id)
                                ->where("academic_year", $academic_year)
                                ->where("program_id", $program->id)
                                ->where("semester", $term)->first();

        return view("superadmin.results.student", [
            "results" => Grades::where("student_id", $student->user_id)
                               ->where("academic_year", $academic_year)
                               ->where("program_id", $program->id)
                               ->where("semester", $term)->get(),
            "student" => $student,
            "program" => $program,
            "term" => $term,
            "academic_year" => $academic_year,
            "remark" => $remark,
            "remark_head" => TeachersRemark::where("remark_token", $remark->remark_token)?->first()
        ]);
    }

    /**
     * Decrypts school id
     */
    private function decrypt_school_id($school_id) :School|null{
        $school = School::findOrFail(Crypt::decryptString($school_id));

        if(!$school){
            abort(404);
        }

        return $school;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSchoolRequest $request)
    {
        // get the logo path
        $logo_path = $this->store_logo();

        $validated = $request->validated();
        $validated["logo_path"] = $logo_path;
        $school = School::create($validated);

        // store school id into user school
        $this->update_user($school->id, $request->admin_id);

        if(auth()->user()){
            // update the session school id
            session(["school_id" => $school->id]);
            return redirect()->route('dashboard');
        }

        return redirect()->route("admin.login");
    }

    /**
     * Display the specified resource.
     */
    public function show(School $school)
    {
        //
    }

    /**
     * Made for superadmin to see a menu of a school
     */
    public function school_menu($school_id){
        $school = School::findOrFail(Crypt::decryptString($school_id));

        if(!$school){
            abort(404);
        }

        return view('superadmin.school', ["school"=>$school, "protected_id" => $school_id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(School $school)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $validated = $request->validated();
        $school->update($validated);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(School $school)
    {
        $school->delete();
    }

    /**
     * Stores the school id into the user
     */
    private function update_user(int $school_id, int $admin_id){
        $admin = Admin::find($admin_id);

        if(!$admin){
            $admin = SchoolAdmin::find($admin_id);
        }

        // admin would be found regardless
        $admin->school_id = $school_id;
        $admin->update();
    }

    /**
     * Saves a copy of the school logo on storage
     */
    private function store_logo(bool $store = true){
        if($store){

        }
        if(!empty(request()->logo_path)){
            $path = request()->file('logo_path')->store('images/school-logo');

            return $path;
        }

        return null;
    }
}
