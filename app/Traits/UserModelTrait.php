<?php

namespace App\Traits;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OtherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\StoreotherRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\UpdateotherRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Admin;
use App\Models\other;
use App\Models\SchoolAdmin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

trait UserModelTrait
{
    private function createModel(int $role_id, array $attributes = []) :Model{
        $model = null;
        switch($role_id){
            case 1:
            case 2:
                $model = new Admin($attributes);
                break;
            case 3:
                $model = new SchoolAdmin($attributes);
                break;
            case 4:
                $model = new Teacher($attributes);
                break;
            case 5:
                $model = new Student($attributes);
                break;
            default:
                $model = new other($attributes);
        }

        return $model;
    }

    private function createStoreRequest(int $role_id, Request $request) :FormRequest|Request{
        $new_request = null;
        switch($role_id){
            case 1:
            case 2:
            case 3:
                $new_request = new StoreAdminRequest();
                break;
            case 4:
                $new_request = new StoreTeacherRequest();
                break;
            case 5:
                $new_request = new StoreStudentRequest();
                break;
            default:
                $new_request = new StoreotherRequest();
        }

        return $new_request->createFrom($request);
    }

    private function createUpdateRequest(int $role_id, Request $request) :FormRequest|Request{
        $new_request = null;
        switch($role_id){
            case 1:
            case 2:
            case 3:
                $new_request = new UpdateAdminRequest();
                break;
            case 4:
                $new_request = new UpdateTeacherRequest();
                break;
            case 5:
                $new_request = new UpdateStudentRequest();
                break;
            default:
                $new_request = new UpdateotherRequest();
        }

        return $new_request->createFrom($request);
    }

    private function createController(int $role_id) :Controller{
        $controller = null;

        switch($role_id){
            case 1:
            case 2:
            case 3:
                $controller = new AdminController;
                break;
            case 4:
                $controller = new TeacherController;
                break;
            case 5:
                $controller = new StudentController;
                break;
            default:
                $controller = new OtherController;
        }

        return $controller;
    }

    /**
     * Returns the model of the user
     */
    private function user_model(User $user) :Model|null{
        $model = null;
        switch($user->role_id){
            case 1:
            case 2:
                $model = Admin::find($user->id);
                break;
            case 3:
                $model = SchoolAdmin::find($user->id);

                if(is_null($model)){
                    // user is in admin state
                    $admin = Admin::find($user->id);
                    if($admin){
                        $model = new SchoolAdmin();
                        $model->fill($admin->toArray());
                    }
                }
                break;
            case 4:
                $model = Teacher::find($user->id);
                break;
            case 5:
                $model = Student::find($user->id);
                break;
            default:
                $model = other::find($user->id);
        }

        return $model;
    }
}
