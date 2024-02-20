<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\deletedusers;
use App\Models\other;
use App\Models\School;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", function(){
    return view("welcome");
})->name("index");

Route::get("/contact-us", function(){
    return view("home.contact");
})->name("contact");

// logins
Route::get('/admin-login', function () {
    return view("auth.login", [
        "page_title" => "Admin Login",
        "role_id" => 3,
        "login_icon" => "fas fa-user-clock",
    ]);
})->name("admin.login");

Route::get("/teacher-login", function(){
    return view("auth.login", [
        "page_title" => "Teacher Login",
        "role_id" => 4,
        "login_icon" => "fas fa-person-chalkboard"
    ]);
})->name("teacher.login");

// registrations
Route::get("/setup", function(){
    return view("auth.register", [
        "role_id" => 2,
        "page_title" => "Activate System"
    ]);
})->name('setup');

Route::get("/register-school", [SchoolController::class, 'create'])->middleware('school.check')->name("school.create");
Route::post("/register-school", [SchoolController::class, 'store'])->name("school.store");
Route::get("/schools", [SchoolController::class, 'index'])->name("school.index");

// dashboards
Route::get('/dashboard', function () {
    $role_id = auth()->user()->role_id;
    $options = [];

    switch($role_id){
        case 1:
            $options["developer_count"] = User::where("role_id", 1)->get()->count();
        case 2:
            $options = [
                "school_count" => School::all()->count(),
                "admin_count" => User::where('role_id', 3)->orWhere('role_id', '>', 5)->get()->count(),
                "superadmin_count" => Admin::all()->count(),
                "student_count" => Student::all()->count(),
                "teacher_count" => Teacher::all()->count(),
                "delete_count" => deletedusers::all()->count()
            ];
            break;
        case 4:
        case 5:
            break;
        default:
            $options = [
                "admin_count" => User::where('role_id', 3)->orWhere('role_id', '>', 5)->get()->count(),
                "student_count" => Student::all()->count(),
                "teacher_count" => Teacher::all()->count(),
                "delete_count" => deletedusers::all()->count()
            ];
    }

    return view('dashboard', $options);
})->middleware(['auth', 'verified', 'school.check'])->name('dashboard');

Route::middleware(['auth', 'school.check'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // users
    Route::get("/users", [UserController::class, 'index'])->name("users.all");
    Route::get("/users/add", [UserController::class, 'index'])->name("user.add");
    Route::get("/user/{username}/edit", [UserController::class, "edit"]);
});

require __DIR__.'/auth.php';
