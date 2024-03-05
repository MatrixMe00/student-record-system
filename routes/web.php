<?php

use App\Http\Controllers\ApproveresultsController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\UserController;
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
Route::get('/dashboard', [UserController::class, 'dashboard'])->middleware(['auth', 'verified', 'school.check'])->name('dashboard');

Route::middleware(['auth', 'school.check'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // users
    Route::get("/users", [UserController::class, 'index'])->name("users.all");
    Route::get("/user/{username}/edit", [UserController::class, "edit"]);
    Route::put("/user/{username}/edit", [UserController::class, "update"]);

    // programs
    Route::get("/classes", [ProgramController::class, 'index'])->name("program.all");
    Route::post("/class/add", [ProgramController::class, 'store'])->name("add-program");
    Route::get("/class/{program}/delete", [ProgramController::class, 'destroy']);
    Route::get("/class/{program}/edit", [ProgramController::class, 'edit']);
    Route::put("/class/{program}/edit", [ProgramController::class, 'update']);

    // subjects
    Route::get("/subjects", [SubjectController::class, 'index'])->name('subject.all');
    Route::post("/subject/add", [SubjectController::class, 'store'])->name("add-subject");
    Route::get("/subject/{subject}/edit", [SubjectController::class, 'edit']);
    Route::put("/subject/{subject}/edit", [SubjectController::class, 'update']);
    Route::get("/subject/{subject}/delete", [SubjectController::class, 'destroy']);
    Route::get("/teacher/subject-assign", [TeacherClassController::class, "create"])->name("subject.assign");
    Route::get("/teacher/subject-assign/{teacher}", [TeacherClassController::class, "create"]);
    Route::get("/teacher/assign-delete/{subject}", [TeacherClassController::class, "destroy"]);
    Route::post("/teacher/subject-assign", [TeacherClassController::class, "store"])->name("teacher.assign-subject");

    // school settings
    Route::get("/my-school", [SchoolController::class, 'show'])->name('my-school');

    // results
    Route::get("/results", [GradesController::class, "index"])->name("result.all");
    Route::post("/results", [ApproveresultsController::class, "store"])->name("result.store");
    Route::get("/result/{result_token}/delete", [ApproveresultsController::class, "destroy"]);
    Route::get("/result/{result_token}/edit", [ApproveresultsController::class, "edit"]);

    // storing grades
    Route::post("/grades/store", [GradesController::class, 'store'])->name("grades.create");
    Route::put("/grades/update", [GradesController::class, 'update'])->name("grades.update");
});

require __DIR__.'/auth.php';
