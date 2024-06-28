<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\deletedusers;
use App\Models\other;
use App\Models\Payment;
use App\Models\PaymentInformation;
use App\Models\Program;
use App\Models\Role;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherClass;
use App\Models\User;
use App\Traits\UserModelTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    use UserModelTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = [];
        $user = Auth::user();

        switch($user->role_id){
            case 1:
            case 2:
                $options = [
                    "superadmins" => Admin::all(),
                    "admins" => SchoolAdmin::all(),
                    "deleted" => deletedusers::all()
                ];
                $roles = Role::where("school_id", 0)->where("id", "<", 5)->get()->toArray();
                $school_id[] = ["id" => 0, "name" => "No school"];
                $school_id = array_merge($school_id, School::all(["id", "school_name as name"])->toArray());
                break;
            case 3:
                $options = [
                    "admins" => SchoolAdmin::all(),
                    "teachers" => Teacher::all(),
                    "students" => Student::all(),
                    "deleted" => deletedusers::all()
                ];
                $school_id = session('school_id');
                $roles = Role::where("id", ">", "2")->where("school_id", 0)->orWhere("school_id", $school_id)->get()->toArray();
                break;
            default:
        }

        //

        return view("users", [
            "options" => $options,
            "roles" => $roles, "school_id" => $school_id,
            "programs" => $user->role_id == 3 ?
                Program::all(["id", "name"])->toArray() : [],
            "index_number" => generateIndexNumber(session('school_id'))
        ]);
    }

    /**
     * Display an edit form
     */
    public function edit($username){
        $user = User::where("username", $username)->first();
        return view('auth.partials._edit_user',[
            "user" => $user,
            "model" => $this->user_model($user),
            "programs" => Program::all(["id", "name"])->toArray()
        ]);
    }

    /**
     * Update user details
     */
    public function update(Request $request, $username){
        $user = User::where("username", $username)->first();
        $email_required = $user->role_id == 5 ? "nullable" : "required";
        $validated = $request->validate([
            "email" => [$email_required, "string", "email", "lowercase"],
            "username" => ["required", "string", Rule::unique("users", "id")->ignore($user->id)]
        ]);

        $user->update($validated);

        // update corresponding model
        $this->update_model($request, $user);

        return redirect()->back();
    }

    /**
     * This is used with the help of the update to update the user
     */
    private function update_model(Request $request, User $user){
        // merge the user id
        $request->merge([
            "user_id" => $user->id
        ]);

        //get controller and update request
        $controller = $this->createController($user->role_id);
        $request = $this->createUpdateRequest($user->role_id, $request);
        $model = $this->user_model($user);

        return $controller->update($request, $model);
    }

    /**
     * This function is used to add multiple users
     */
    public function multi_add(Request $request){
        $types = [
            "student" => [
                "head" => true, "head_rows" => 1, "head_cols" => 6
            ]
        ];
        $error = ""; $message = ""; $success = false;
        $type = $types[$request->user_type] ?? false;

        if($type){
            if(empty($request->program_id)){
                $error = "No Class type was specified";
            }else{
                $file_data = ExcelController::file_data("upload_file", $type["head"], $type["head_rows"]);

                if(count($file_data[0]) == $type["head_cols"]){
                    switch($request->user_type){
                        case "student":
                            $response = $this->students_create($file_data, $type);
                            break;
                        default:
                            $response = "User role specified is invalid";
                    }

                    $error = is_int($response) ? "" : $response;
                    $success = is_int($response) ? true : false;
                    $message = "$response {$request->user_type}s added";
                }else{
                    $error = "Document provided does not match user type";
                }
            }
        }else{
            $error = "";
        }

        if(!empty($error)){
            throw ValidationException::withMessages([
                "upload_error" => $error
            ]);
            $success = false; $message = $error;
        }

        return redirect()->back()->with(["success" => $success, "message" => $message]);

    }

    /**
     * This gets the program id
     */
    public function get_program_id(string $program_name) :int|false{
        $program = Program::where("name", $program_name)->where("school_id", session('school_id'))->first();

        return $program ? $program->id : false;
    }

    /**
     * This function is used in the multi create to prevent students of exactly the same name in the same class to be added
     * @param array $student
     * @return bool
     */
    private function student_in_class(array $student) :bool{
        return Student::where("lname", $student["lname"])
                      ->where("oname", $student["oname"])
                      ->where("program_id", $student["program_id"])
                      ->where("school_id", $student["school_id"])
                      ->exists();
    }

    /**
     * This is used to create multiple students
     * @param Collection|false $file_data The data from the file
     * @param array $type array serving as a header
     */
    private function students_create($file_data, $type){
        $keys = ["lname","oname","primary_phone","secondary_phone","next_of_kin", "program_id"];
        $programs = [];
        $count = 0; $total = $file_data->count();

        if(request()->program_id == "mixed"){
            foreach($file_data as $data){
                $student = [];

                foreach($keys as $pos => $key){
                    if($pos == 5){
                        if(in_array(strtolower($data[$pos]), array_keys($programs))){
                            $program_id = $programs[strtolower($data[$pos])];
                        }else{
                            $program_id = $this->get_program_id($data[$pos]);
                            $programs[strtolower($data[$pos])] = $program_id;
                        }

                        if($program_id === false){
                            return "{The class name '$data[$pos]}' for '{$data[0]} {$data[1]}' is not recognized in your school";
                        }

                        $data[$pos] = $program_id;
                    }

                    $student[$key] = $data[$pos];
                }

                // defaults
                $student["school_id"] = session('school_id');

                // create user if it doesnt exist
                if(!$this->student_in_class($student)){
                    $user = User::create([
                        "username" => generateIndexNumber(session('school_id')),
                        "role_id" => 5,
                        "password" => "Password@1"
                    ]);

                    $student["user_id"] = $user->id;

                    Student::create($student);
                    ++$count;
                }
            }
        }else{
            $program_id = request()->program_id;
            foreach($file_data as $data){
                $student = [];

                foreach($keys as $pos => $key){
                    if($pos == 5){
                        $data[$pos] = $program_id;
                    }

                    $student[$key] = $data[$pos];
                }

                // defaults
                $student["school_id"] = session('school_id');

                // create user
                if(!$this->student_in_class($student)){
                    $user = User::create([
                        "username" => generateIndexNumber(session('school_id')),
                        "role_id" => 5,
                        "password" => "Password@1"
                    ]);

                    $student["user_id"] = $user->id;

                    Student::create($student);
                    ++$count;
                }
            }
        }
        return $count;
    }

    /**
     * This is used to help update other user modals
     */
    public static function updateModel(Request $request, User $user){
        $uc = new static;
        $uc->update_model($request, $user);
    }

    /**
     * Get the dashboard of the user
     */
    public function dashboard(){
        $user = auth()->user();
        $options = [];

        switch($user->role_id){
            case 1:
                $options["developer_count"] = User::where("role_id", 1)->get()->count();
            case 2:
                $options = [
                    "school_count" => School::all()->count(),
                    "admin_count" => User::where('role_id', 3)->get()->count(),
                    "superadmin_count" => Admin::all()->count(),
                    "student_count" => Student::all()->count(),
                    "teacher_count" => Teacher::all()->count(),
                    "delete_count" => deletedusers::all()->count(),
                    "activity_logs" => ActivityLog::get_logs(limit: 5),
                    "system_logs" => ActivityLog::get_logs(0, limit: 5)
                ];
                break;
            case 4:
                $teacher = $this->user_model(auth()->user());
                $options = [
                    "teacher" => $teacher,
                    "activity_logs" => ActivityLog::get_logs(limit: 5),
                ];
                break;
            case 5:
                $student = $this->user_model(auth()->user());
                $options = [
                    "current_class" => $student->program->name,
                    "average_grade" => $student->average_grade(),
                    "grade_value" => $student->grade_value(),
                    "grade_description" => $student->grade_description(),
                    "activity_logs" => ActivityLog::get_logs(limit: 5),
                ];
                break;
            default:
                $options = [
                    "admin_count" => SchoolAdmin::all()->count(),
                    "students" => Student::all(),
                    "teacher_count" => Teacher::all()->count(),
                    "subject_count" => Subject::all()->count(),
                    "class_count" => Program::all()->count(),
                    "delete_count" => deletedusers::all()->count(),
                    "activity_logs" => ActivityLog::get_logs(limit: 5),
                    "school_logs" => ActivityLog::get_logs(0, limit: 10),
                    "amount_sum" => Payment::where("school_id", session('school_id'))->sum("amount"),
                    "deduction_sum" => Payment::where("school_id", session('school_id'))->sum("deduction")
                ];

                $options["tasks"] = [
                    "add_teacher" => $options["teacher_count"],
                    "add_class" => $options["class_count"],
                    "add_subject" => $options["subject_count"],
                    "add_student" => $options["students"]->count(),
                    "teach_subj" => TeacherClass::where("school_id", session('school_id'))->get()->count(),
                    "payment_info_self" => PaymentInformation::where("user_id", $user->id)->where("split_key", null)->exists(),
                    "payment_info_school" => PaymentInformation::where("user_id", $user->id)->where("split_key", "!=", null)->exists()
                ];
        }

        return view('dashboard', $options);
    }
}
