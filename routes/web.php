<?php

use App\Http\Controllers\ApproveresultsController;
use App\Http\Controllers\BECECandidateController;
use App\Http\Controllers\DebtorsListController;
use App\Http\Controllers\GradesController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentInformationController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RemarkOptionsController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentBillController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherClassController;
use App\Http\Controllers\TeacherRemarksController;
use App\Http\Controllers\TeachersRemarkController;
use App\Http\Controllers\UserController;
use App\Models\PaystackBank;
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

    // school settings
    Route::get("/my-school", [SchoolController::class, 'show'])->name('my-school');

    // results
    Route::get("/results", [GradesController::class, "index"])->name("result.all");
    Route::post("/results", [ApproveresultsController::class, "store"])->name("result.store");
    Route::get("/result/{result_token}/delete", [ApproveresultsController::class, "destroy"]);
    Route::get("/result/{result_token}/show", [ApproveresultsController::class, "show"]);
    Route::get("/result/{result_token}/edit", [ApproveresultsController::class, "edit"]);
    Route::put("/result/{result}/edit", [ApproveresultsController::class, "update"]);

    // student results
    Route::middleware(["student.payment-bill", "student.payment-result"])->group(function(){
        Route::get("/my-result/{program}", [ProgramController::class, "results"]);
        Route::get("/my-result/{program}/{semester}", [ProgramController::class, "results"]);
        Route::get("/my-result/{program}/{semester}/print", [ProgramController::class, "print"]);
    });

    // storing grades
    Route::post("/grades/store", [GradesController::class, 'store'])->name("grades.create");
    Route::put("/grades/update", [GradesController::class, 'update'])->name("grades.update");

    // teacher remarks
    Route::get("/remarks", [TeacherRemarksController::class, "index"])->name("remarks.all");
    Route::post("/remarks", [TeacherRemarksController::class, "store"])->name("remarks.store");
    Route::post("/remarks/slip", [TeachersRemarkController::class, "store"])->name("remarks-slip.store");
    Route::get("/remark/{token}/show", [TeachersRemarkController::class, "show"]);
    Route::get("/remark/options", [RemarkOptionsController::class, "index"])->name("remark-options");
    Route::post("/remark/options", [RemarkOptionsController::class, "store"])->name("remark-options.add");
    Route::get("/remark/options/delete/{option}", [RemarkOptionsController::class, "destroy"]);

    // payments
    Route::get("/payment/create/{type}", [PaymentController::class, 'create'])->name("payment.create");
    Route::post("/payment/store", [PaymentController::class, 'store'])->name("payment.store");

    // paystack processing
    Route::get("/paystack/callback", [PaystackController::class, "callback"])->name("paystack.callback");
    Route::get("/paystack/success", [PaystackController::class, "success"])->name("paystack.success");

    // payment detail entries
    Route::get("payment/accounts", [PaymentInformationController::class, "index"])->name("payment-account.all");
    Route::get("payment/my-account", [PaymentInformationController::class, "edit"])->name("payment-account.user");
    Route::post("payment/my-account", [PaymentInformationController::class, "store"])->name("payment-account.store");
    Route::put("payment/my-account/{paymentInformation}", [PaymentInformationController::class, "update"])->name("payment-account.update");

    // bece controls
    Route::get("/bece-menu", [DebtorsListController::class, "index"])->name("bece.all")->middleware("student.payment-debt");
});

// routes for any admin
Route::middleware(["auth", "school.check", "admin"])->group(function(){
    // users
    Route::get("/users", [UserController::class, 'index'])->name("users.all");
    Route::post('users/add', [UserController::class,  'multi_add'])->name("users.add");
    Route::get("/user/{username}/edit", [UserController::class, "edit"]);
    Route::put("/user/{username}/edit", [UserController::class, "update"]);

    // bece candidates
    Route::get("/bece-candidate/{beceCandidate}", [BECECandidateController::class, "show"])->name("school.candidate.show");
    Route::put("/bece-candidate/{beceCandidate}", [BECECandidateController::class, "update"])->name("school.candidate.update");
});

// routes for just school admins
Route::middleware(['auth','school.check','school.admin'])->group(function(){
    // programs
    Route::get("/classes", [ProgramController::class, 'index'])->name("program.all");
    Route::post("/class/add", [ProgramController::class, 'store'])->name("add-program");
    Route::post("/class/add/multiple", [ProgramController::class, 'multi_store'])->name("add-multiple-program");
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

    // debtors list
    Route::post("/debt-list/store", [DebtorsListController::class, "store"])->name("debtlist.store");

    // student debt bills
    Route::get("student-debt/", [StudentBillController::class, "index"])->name("bills.none");
    Route::get("student-debt/{academic_year}", [StudentBillController::class, "index"])->name("bills.index");
    Route::get("student-debt/{academic_year}/{program}", [StudentBillController::class, "show"])->name("bills.show");
    Route::get("student-debt/{academic_year}/{program}/debtors", [StudentBillController::class, "edit"])->name("bills.edit");
    Route::post("student-debt/{academic_year}/{program}/debtors", [StudentBillController::class, "store"])->name("bills.store");
    Route::delete("student-debt/{studentBill}/remove", [StudentBillController::class, "destroy"])->name("bills.remove");

    // bece candidates
    Route::post("/prepare-candidates", [BECECandidateController::class, "create_candidates"])->name("candidates.create");

    // promote students
    Route::post("/students/promote", [TeacherRemarksController::class, "promote"])->name("students.promote");

    // school history
    Route::group(['middleware' => 'school.id', 'prefix' => 'history'], function () {
        Route::get("/", [SchoolController::class, "menu"])->name("history.menu");

        // exam results
        Route::get("results", [SchoolController::class, "results"])->name("history.results");
        Route::get("results/{school_id?}/{academic_year?}", [SchoolController::class, "year_result_classes"])->name("history.results.programs");
        Route::get("results/{school_id?}/{academic_year?}/{program?}/{term?}", [SchoolController::class, "class_results"])->name("history.results.class");
        Route::get("student/{program}/{student}/{academic_year}/{term}", [SchoolController::class, "student_result"])->name("history.results.student");

        // subject results
        Route::get("subjects/", [SchoolController::class, "subjects"])->name("history.subjects");
        Route::get("subjects/{school_id?}/{academic_year?}", [SchoolController::class, "year_subject_classes"])->name("history.subjects.programs");
        Route::get("subjects/{school_id?}/{academic_year?}/{program?}", [SchoolController::class, "class_subjects"])->name("history.subjects.class");
        Route::get("subjects/{school_id?}/{academic_year?}/{program?}/{subject?}", [SchoolController::class, "subject_results"])->name("history.subjects.fresult");
        Route::get("subjects/{school_id?}/{academic_year?}/{program?}/{subject?}/{term?}", [SchoolController::class, "subject_results"])->name("history.subjects.results");
    });
});

// routes for only system admins
Route::middleware(['auth', 'system.admin'])->group(function(){
    // superadmin school assess pages
    Route::get("/admin-schools", [SchoolController::class, "index"])->name("admin.schools");
    Route::get("/school-menu/{school_id}", [SchoolController::class, "school_menu"])->name("school.menu");

    // BECE candidates
    Route::get("/bece-candidates/{school_id}", [BECECandidateController::class, "index"])->name("school.candidates");
    Route::post("/bece-candidates/{school_id}", [BECECandidateController::class, "candidates_update"])->name("school.candidates.update");

    // check school results
    Route::group(["prefix" => "school-results"], function(){
        Route::get("{school_id}", [SchoolController::class, "results"])->name("school-result.all");
        Route::get("{school_id}/{academic_year}", [SchoolController::class, "year_result_classes"])->name("school-result.programs");
        Route::get("{school_id}/{academic_year}/{program}/{term}", [SchoolController::class, "class_results"])->name("school-result.class");
    });
    Route::get("/student-result/{program}/{student}/{academic_year}/{term}", [SchoolController::class, "student_result"])->name("school-result.student");

    // check school subject results
    Route::group(["prefix" => "subject-results"], function(){
        Route::get("{school_id}", [SchoolController::class, "subjects"])->name("school-subject.all");
        Route::get("{school_id}/{academic_year}", [SchoolController::class, "year_subject_classes"])->name("school-subject.programs");
        Route::get("{school_id}/{academic_year}/{program}", [SchoolController::class, "class_subjects"])->name("school-subject.class");
        Route::get("{school_id}/{academic_year}/{program}/{subject}", [SchoolController::class, "subject_results"])->name("school-subject.fresult");
        Route::get("{school_id}/{academic_year}/{program}/{subject}/{term}", [SchoolController::class, "subject_results"])->name("school-subject.results");
    });

    // initialize paystack banks
    Route::get("paystack/banks", function(){
       $initialized = PaystackBank::initialize_banks();
       $message = $initialized === true ? "Banks have been initialized successfully" : "Unknown error detected";
       return back()->with(["success" => $initialized, "message" => $message]);
    })->name("banks.create");

    // Route::get("/student-result/{program}/{student}/{academic_year}/{term}", [SchoolController::class, "student_result"])->name("school-subject.student");
});

require __DIR__.'/auth.php';
