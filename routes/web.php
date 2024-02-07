<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolController;
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
});

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

Route::get("/register-school", [SchoolController::class, 'create']);
Route::post("/register-school", [SchoolController::class, 'store']);
Route::get("/schools", [SchoolController::class, 'index']);

// dashboards
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
