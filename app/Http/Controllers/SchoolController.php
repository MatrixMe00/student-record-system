<?php

namespace App\Http\Controllers;

use App\Constants\LogType;
use App\Models\School;
use App\Http\Requests\StoreSchoolRequest;
use App\Http\Requests\UpdateSchoolRequest;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Grades;
use App\Models\Payment;
use App\Models\Program;
use App\Models\SchoolAdmin;
use App\Models\Settings;
use App\Models\Student;
use App\Models\Subject;
use App\Models\TeacherRemarks;
use App\Models\TeachersRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SchoolController extends Controller
{
    /**
     * @var $exam_route The route for exam results menu
     */
    private ?string $exam_route = null;

    /**
     * @var $subject_route The route for subject results menu
     */
    private ?string $subject_route = null;

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
    public function results($school_id = null){
        $school_id = $school_id ?? session('school_id');
        $school = $this->decrypt_school_id($school_id);

        return view("history.results.index", [
            "academic_years" => $school->remarks
                                       ->unique("academic_year")->pluck("academic_year"),
            "school" => $school,
            "school_id" => $school_id,
            "route_head" => $this->exam_route,
            "tag_type" => "exam",
            "page" => 1
        ]);
    }

    /**
     * This shows the programs uploaded for a specified academic year
     */
    public function year_result_classes($school_id, $academic_year){
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);

        return view("history.results.classes", [
            "academic_year" => $academic_year,
            "classes" => $school->remarks->where("academic_year", $academic_year)->unique("program_id"),
            "school_id" => $school_id,
            "route_head" => $this->exam_route,
            "tag_type" => "exam",
            "page" => 2
        ]);
    }

    /**
     * This shows the data of information for a class
     */
    public function class_results($school_id, $academic_year, ?Program $program, $term = 1){
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);

        return view("history.results.class", [
            "school_id" => $school_id,
            "academic_year" => $academic_year,
            "term" => $term,
            "program" => $program,
            "results" => $school->remarks->where("academic_year", $academic_year)
                                         ->where("semester", $term)
                                         ->where("program_id", $program->id),
            "route_head" => $this->exam_route,
            "tag_type" => "exam",
            "page" => 3
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

        return view("history.results.student", [
            "results" => Grades::where("student_id", $student->user_id)
                               ->where("academic_year", $academic_year)
                               ->where("program_id", $program->id)
                               ->where("semester", $term)->get(),
            "student" => $student,
            "program" => $program,
            "term" => $term,
            "academic_year" => $academic_year,
            "remark" => $remark,
            "school_id" => $program->school->protected_id,
            "remark_head" => $remark ? TeachersRemark::where("remark_token", $remark->remark_token)?->first() : null,
            "route_head" => $this->exam_route,
            "tag_type" => "exam",
            "page" => 4
        ]);
    }

    /**
     * Shows the various academic years available
     */
    public function subjects($school_id = null){
        $school_id = $school_id ?? session('school_id');
        $school = $this->decrypt_school_id($school_id);

        return view("history.subjects.index", [
            "academic_years" => $school->results
                                       ->unique("academic_year")->pluck("academic_year"),
            "school" => $school,
            "school_id" => $school_id,
            "route_head" => $this->subject_route,
            "tag_type" => "subject",
            "page" => 1
        ]);
    }

    /**
     * The classes for that specified year
     */
    public function year_subject_classes($school_id, $academic_year){
        $school_id = $school_id ?? session('school_id');
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);

        return view("history.subjects.classes", [
            "academic_year" => $academic_year,
            "classes" => $school->results->where("academic_year", $academic_year)->unique("program_id"),
            "school_id" => $school_id,
            "route_head" => $this->subject_route,
            "tag_type" => "subject",
            "page" => 2
        ]);
    }

    /**
     * The subjects of the specified class for that year which were uploaded
     */
    public function class_subjects($school_id, $academic_year, Program $program){
        $school_id = $school_id ?? session('school_id');
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);

        return view("history.subjects.subjects", [
            "school_id" => $school_id,
            "academic_year" => $academic_year,
            "program" => $program,
            "records" => $school->results->where("academic_year", $academic_year)
                                         ->where("program_id", $program->id)->unique("subject_id"),
            "route_head" => $this->subject_route,
            "tag_type" => "subject",
            "page" => 3
        ]);
    }

    /**
     * Results of the subject for the specified period
     */
    public function subject_results($school_id, $academic_year, Program $program, Subject $subject, $term = 1){
        $school_id = $school_id ?? session('school_id');
        $school = $this->decrypt_school_id($school_id);
        $academic_year = year_link($academic_year, false);
        $results = Grades::where("program_id", $program->id)
                         ->where("subject_id", $subject->id)
                         ->where("semester", $term)->where("school_id", $school->id)
                         ->get();
        $result_head = $school->results->where("program_id", $program->id)
                                       ->where("subject_id", $subject->id)
                                       ->where("semester", $term);

        return view("history.subjects.subject", [
            "subject" => $subject,
            "term" => $term,
            "academic_year" => $academic_year,
            "school_id" => $school_id,
            "program" => $program,
            "results" => $results,
            "result_head" => $result_head->first(),
            "route_head" => $this->subject_route,
            "tag_type" => "subject",
            "page" => 4
        ]);
    }

    /**
     * Menu for admins to select history option type
     */
    public function menu(){
        return view("history.menu", [
            "page" => 0
        ]);
    }

    /**
     * Decrypts school id and sets the route heads
     */
    private function decrypt_school_id($school_id) :School|null{
        if(is_numeric($school_id)){
            if(session('school_id') && session('school_id') != $school_id){
                abort(401);
            }
        }else{
            $school_id = Crypt::decryptString($school_id);
        }

        $school = School::findOrFail($school_id);

        if(!$school){
            abort(404);
        }

        // set routes and route type
        $this->set_routes();

        return $school;
    }

    /**
     * Used to set the necessary route head for the pages
     * This is to help switch admin routes with superadmin routes for
     * pages that are served for both parties
     */
    private function set_routes(){
        $user = Auth::user();
        $this->exam_route = $user->role_id < 3 ? "school-result" : "history.results";
        $this->subject_route = $user->role_id < 3 ? "school-subject" : "history.subjects";
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

        if(Auth::check()){
            // update the session school id
            session(["school_id" => $school->id]);
            return redirect()->route('dashboard');
        }

        return redirect()->route("admin.login");
    }

    /**
     * Display the specified resource.
     */
    public function show(?School $school = null)
    {
        //
    }

    /**
     * This gets the current school settings
     * @param School $school The requested school
     * @return Collection
     */
    private function get_school_settings(School $school) :Collection{
        $response = new Collection();

        $system_settings = Settings::where("role_access", "like", "%3%")->get();
        $school_settings = $school->settings;

        $system_settings->each(function($settings) use ($school_settings, $response){
            $name = $settings["name"];
            $visual = $settings["visual_name"];
            $default_val = $settings["default_value"];
            $input_type = $settings["input_type"];
            $placeholder = $settings["placeholder"];
            $options = $settings["options"];

            // find match in school settings
            $match = $school_settings->firstWhere("settings_name", $name);
            $value = $match ? $match["value"] : $default_val;

            $value = $this->evaluate_value($value);

            $response->push([
                "name" => $name, "text" => $visual, "value" => $value,
                "input_type" => $input_type, "placeholder" => $placeholder,
                "options" => $options
            ]);
        });

        return $response;
    }

    /**
     * This is used to handle values with functions
     * @param ?string $value The value
     * @return mixed
     */
    function evaluate_value(?string $value){
        if(!empty($value) && str_contains($value, "func")){
            $value = str_replace("func ", "", $value);

            if($value = parse_function_call($value)){
                // check if parameters are functions and evaluate them
                foreach($value["params"] as $key => $param){
                    if($param = parse_function_call($param)){
                        $param["params"] = $this->format_param($param["params"]);
                        $value["params"][$key] = call_user_func_array($param["function"], array_values($param["params"]));
                    }
                }

                $value = call_user_func_array($value["function"], array_values($value["params"]));
            }else{
                $value = null;
            }
        }

        return $value;
    }

    /**
     * This formats params so that they have their proper values and datatype
     * @param array $params The parameters to format
     * @return array
     */
    private function format_param(array $params){
        if($params){
            foreach($params as $key => $param){
                $params[$key] = $this->parse_data_type($param);
            }
        }

        return $params;
    }

    /**
     * Parses the datatype
     */
    private function parse_data_type($data){
        if(is_integer($data)){
            return intval($data);
        }elseif(is_float($data)){
            return floatval($data);
        }elseif($data == "null" || empty($data)){
            return null;
        }

        return $data;
    }

    /**
     * Made for superadmin to see a menu of a school
     */
    public function school_menu($school_id){
        $school = $this->decrypt_school_id($school_id);
        return view('superadmin.school', ["school"=>$school, "protected_id" => $school_id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(?School $school = null)
    {
        if(!$school || is_null($school)){
            $school = School::find(session("school_id") ?? 0);
            if(!$school){
                abort(404);
            }
        }

        $school_settings = $this->get_school_settings($school);

        return view("admin.my-school", [
            "school" => $school, "school_admin" => $school->admin_id == Auth::user()->id,
            "school_settings" => $school_settings
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSchoolRequest $request, School $school)
    {
        $logo_path = $this->store_logo();
        $validated = $request->validated();
        $validated["logo_path"] = $logo_path ?? $request->logo_current;
        $school->update($validated);

        return redirect()->back()->with(["success" => true, "message" => "School Details have been updated"]);
    }

    /**
     * This is used to change the status of a school
     */
    public function status_change(School $school){
        $school->status = !$school->status;
        $school->update();

        return back()->with(["success" => true, "message" => "Status changed for ". (!empty($school->slug) ? $school->slug : $school->name)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        if(session("school_id") || $request->school_id){
            $school = School::find(session('school_id') ?? $request->school_id);
        }else{
            abort(401);
        }

        // prevent students from removing their accounts
        if(Auth::user()->role_id > 3){
            abort(401, "Cannot Remove Account");
        }

        // if school is not found, abort
        if(empty($school)){
            abort(404);
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $school_details = [
            "school" => $school->toArray(),
            "teacher_count" => $school->teachers->count(),
            "student_count" => $school->students->count(),
            "admin" => $school?->admin->toArray(),
            "amount" => Payment::school_total_transactions($school->id)
        ];

        // remove accounts
        PaymentInformationController::remove_accounts($school);

        ActivityLog::dev_success_log(LogType::SCHOOL_DELETE, $school->school_name." has been permanently deleted from the system, together with all the resources.", $school_details);
        $school->delete();

        // log user account out and
        return redirect()->route('logout');
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
        if(!empty(request()->logo_path)){
            $path = request()->file('logo_path')->store('images/school-logo');

            return $path;
        }

        return null;
    }
}
